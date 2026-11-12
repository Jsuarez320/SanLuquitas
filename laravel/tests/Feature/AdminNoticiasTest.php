<?php

namespace Tests\Feature;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminNoticiasTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['username' => 'admin1', 'es_admin' => true]);
    }

    private function datos(array $extra = []): array
    {
        return $extra + [
            'titulo' => 'Reunión de padres',
            'tipo' => 'comunicado',
            'categoria' => 'Institucional',
            'extracto' => 'Citación general de padres de familia.',
            'cuerpo' => "Primer párrafo del comunicado.\n\nSegundo párrafo del comunicado.",
            'estado' => 'publicado',
            'publicada_en' => now()->subDay()->toDateString(),
        ];
    }

    public function test_invitado_y_no_admin_no_acceden(): void
    {
        $this->get('/admin/noticias')->assertRedirect(route('admin.login'));

        $emp = User::factory()->create(['es_admin' => false]);
        $this->actingAs($emp)->get('/admin/noticias')->assertForbidden();
    }

    public function test_crear_noticia_genera_slug_y_autor(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/noticias', $this->datos())
            ->assertRedirect(route('admin.noticias.index'));

        $this->assertDatabaseHas('noticias', ['slug' => 'reunion-de-padres', 'user_id' => $admin->id, 'tipo' => 'comunicado']);
    }

    public function test_slug_es_unico_para_titulos_repetidos(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/noticias', $this->datos());
        $this->post('/admin/noticias', $this->datos());

        $this->assertDatabaseHas('noticias', ['slug' => 'reunion-de-padres']);
        $this->assertDatabaseHas('noticias', ['slug' => 'reunion-de-padres-2']);
    }

    public function test_validacion(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/noticias', ['titulo' => '', 'tipo' => 'otro', 'extracto' => str_repeat('a', 300), 'cuerpo' => 'corto'])
            ->assertSessionHasErrors(['titulo', 'tipo', 'categoria', 'extracto', 'cuerpo', 'estado', 'publicada_en']);
    }

    public function test_actualizar_y_cambiar_estado(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/noticias', $this->datos());
        $n = Noticia::firstOrFail();

        $this->put("/admin/noticias/{$n->id}", $this->datos(['titulo' => 'Título nuevo', 'estado' => 'borrador']))
            ->assertRedirect(route('admin.noticias.index'));

        $n->refresh();
        $this->assertSame('Título nuevo', $n->titulo);
        $this->assertSame('reunion-de-padres', $n->slug, 'el slug no cambia al editar el título');
        $this->assertFalse($n->estaPublicada());

        $this->patch("/admin/noticias/{$n->id}/estado");
        $this->assertTrue($n->fresh()->estaPublicada());
    }

    public function test_subir_y_reemplazar_imagen(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());

        $this->post('/admin/noticias', $this->datos(['imagen' => UploadedFile::fake()->image('a.jpg')]));
        $n = Noticia::firstOrFail();
        Storage::disk('public')->assertExists($n->imagen_path);
        $vieja = $n->imagen_path;

        $this->put("/admin/noticias/{$n->id}", $this->datos(['imagen' => UploadedFile::fake()->image('b.png')]));
        Storage::disk('public')->assertMissing($vieja);
        Storage::disk('public')->assertExists($n->fresh()->imagen_path);
    }

    public function test_rechaza_archivo_que_no_es_imagen(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post('/admin/noticias', $this->datos(['imagen' => UploadedFile::fake()->create('x.pdf', 10, 'application/pdf')]))
            ->assertSessionHasErrors('imagen');
    }

    public function test_eliminar_borra_registro_e_imagen(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin());
        $this->post('/admin/noticias', $this->datos(['imagen' => UploadedFile::fake()->image('a.jpg')]));
        $n = Noticia::firstOrFail();

        $this->delete("/admin/noticias/{$n->id}")->assertRedirect(route('admin.noticias.index'));

        $this->assertModelMissing($n);
        Storage::disk('public')->assertMissing($n->imagen_path);
    }

    public function test_listado_filtra_por_texto_tipo_y_estado(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/noticias', $this->datos(['titulo' => 'Feria de ciencias', 'tipo' => 'noticia']));
        $this->post('/admin/noticias', $this->datos(['titulo' => 'Aviso de vacaciones', 'estado' => 'borrador']));

        $this->get('/admin/noticias'); // consume el aviso flash del último guardado

        $this->get('/admin/noticias?q=feria')->assertSee('Feria de ciencias')->assertDontSee('Aviso de vacaciones');
        $this->get('/admin/noticias?tipo=noticia')->assertSee('Feria de ciencias')->assertDontSee('Aviso de vacaciones');
        $this->get('/admin/noticias?estado=borrador')->assertSee('Aviso de vacaciones')->assertDontSee('Feria de ciencias');
        $this->get('/admin/noticias?q=zzz')->assertSee('No encontramos resultados');
    }

    public function test_sitio_publico_solo_muestra_publicadas_y_vigentes(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/noticias', $this->datos(['titulo' => 'Visible hoy']));
        $this->post('/admin/noticias', $this->datos(['titulo' => 'Es un borrador', 'estado' => 'borrador']));
        $this->post('/admin/noticias', $this->datos(['titulo' => 'Sale mañana', 'publicada_en' => now()->addDay()->toDateString()]));
        auth()->logout();

        $this->get('/noticias')->assertOk()->assertSee('Visible hoy')->assertDontSee('Es un borrador')->assertDontSee('Sale mañana');
        $this->get('/noticias/visible-hoy')->assertOk()->assertSee('Segundo párrafo del comunicado.');
        $this->get('/noticias/es-un-borrador')->assertNotFound();
        $this->get('/')->assertOk()->assertSee('Visible hoy');
    }

    public function test_panel_muestra_contadores(): void
    {
        $this->actingAs($this->admin());
        $this->post('/admin/noticias', $this->datos());

        $this->get('/admin')->assertOk()->assertSee('Últimas publicaciones')->assertSee('Reunión de padres');
    }
}
