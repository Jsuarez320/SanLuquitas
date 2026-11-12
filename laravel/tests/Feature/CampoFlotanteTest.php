<?php

namespace Tests\Feature;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** El componente <x-campo> (etiqueta dentro del campo) en los formularios del sitio. */
class CampoFlotanteTest extends TestCase
{
    use RefreshDatabase;

    public function test_contacto_usa_etiquetas_flotantes_asociadas_a_cada_campo(): void
    {
        $html = $this->get('/contacto')->assertOk()->getContent();

        foreach (['nombre', 'correo', 'asunto', 'mensaje'] as $campo) {
            $this->assertStringContainsString("<label for=\"$campo\"", $html);
            $this->assertStringContainsString("id=\"$campo\"", $html);
        }
        // placeholder=" " es lo que permite detectar "campo vacío" para mover la etiqueta.
        $this->assertStringContainsString('placeholder=" "', $html);
    }

    public function test_errores_de_validacion_marcan_el_campo_y_muestran_el_mensaje(): void
    {
        $this->followingRedirects()->from('/contacto')
            ->post('/contacto', ['nombre' => '', 'correo' => 'no-es-correo', 'asunto' => '', 'mensaje' => ''])
            ->assertSee('aria-invalid="true"', false)
            ->assertSee('id="correo-error"', false)
            ->assertSee('role="alert"', false);
    }

    public function test_formulario_de_noticia_precarga_valores_al_editar(): void
    {
        $admin = User::factory()->create(['es_admin' => true]);
        $n = Noticia::create([
            'titulo' => 'Título de prueba', 'tipo' => 'noticia', 'categoria' => 'Académico',
            'extracto' => 'Resumen de prueba', 'cuerpo' => 'Contenido de prueba para la noticia.',
            'estado' => 'borrador', 'publicada_en' => '2026-11-12',
        ]);

        $this->actingAs($admin)->get("/admin/noticias/{$n->id}/edit")
            ->assertOk()
            ->assertSee('value="Título de prueba"', false)
            ->assertSee('value="2026-11-12"', false)
            ->assertSee('Contenido de prueba para la noticia.')
            ->assertSee('<label for="publicada_en"', false);
    }

    public function test_filtros_del_listado_conservan_la_busqueda(): void
    {
        $admin = User::factory()->create(['es_admin' => true]);

        $this->actingAs($admin)->get('/admin/noticias?q=feria&tipo=comunicado')
            ->assertOk()
            ->assertSee('value="feria"', false)
            ->assertSee('<option value="comunicado" selected>', false);
    }
}
