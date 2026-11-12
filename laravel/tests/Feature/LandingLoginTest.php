<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_invitado_ve_boton_y_modal_de_login(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Iniciar sesión')
            ->assertSee('abrir-login', false)
            ->assertSee('id="modal-username"', false)
            ->assertSee(route('admin.login.enviar'), false);
    }

    public function test_usuario_autenticado_ve_ir_al_panel_y_no_el_modal(): void
    {
        $admin = User::factory()->create(['username' => 'admin1', 'es_admin' => true]);

        $this->actingAs($admin)->get('/')
            ->assertOk()
            ->assertSee('Ir al panel')
            ->assertDontSee('id="modal-username"', false);
    }

    public function test_error_en_el_modal_vuelve_a_la_landing_con_el_modal_abierto(): void
    {
        $this->from('/')->post('/admin/login', ['username' => 'nadie', 'password' => 'mala'])
            ->assertRedirect('/')
            ->assertSessionHasErrors('username');

        // Como un navegador: sigue la redirección y comprueba que el modal arranca abierto con el error.
        $this->flushSession();
        $this->followingRedirects()
            ->from('/')
            ->post('/admin/login', ['username' => 'nadie', 'password' => 'mala'])
            ->assertSee('Usuario o contraseña incorrectos.')
            ->assertSee('abierto: true', false);
    }

    public function test_login_desde_el_modal_lleva_al_panel(): void
    {
        User::factory()->create(['username' => 'admin1', 'es_admin' => true]);

        $this->from('/')->post('/admin/login', ['username' => 'admin1', 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_url_inexistente_muestra_el_404_del_sitio_y_no_un_error(): void
    {
        $this->get('/esta-pagina-no-existe')->assertNotFound()->assertSee('Iniciar sesión');
        $this->get('/images/no-existe.png')->assertNotFound();
    }

    public function test_paginas_publicas_incluyen_favicon_e_isotipo(): void
    {
        $this->get('/')
            ->assertSee('favicon-32x32.png', false)
            ->assertSee('apple-touch-icon.png', false)
            ->assertSee('images/marca/isotipo.png', false);

        foreach (['favicon.ico', 'favicon-32x32.png', 'favicon-16x16.png', 'apple-touch-icon.png', 'images/marca/isotipo.png'] as $archivo) {
            $this->assertFileExists(public_path($archivo));
        }
    }
}
