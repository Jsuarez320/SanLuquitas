<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    private function admin(array $attrs = []): User
    {
        return User::factory()->create($attrs + ['username' => 'admin1', 'es_admin' => true]);
    }

    public function test_invitado_es_redirigido_al_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_login_correcto_guarda_ultimo_login(): void
    {
        $u = $this->admin();

        $this->post('/admin/login', ['username' => 'admin1', 'password' => 'password'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($u);
        $this->assertNotNull($u->fresh()->ultimo_login);
    }

    public function test_credenciales_incorrectas(): void
    {
        $this->admin();

        $this->post('/admin/login', ['username' => 'admin1', 'password' => 'mala'])
            ->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_usuario_inactivo_no_puede_entrar(): void
    {
        $this->admin(['activo' => false]);

        $this->post('/admin/login', ['username' => 'admin1', 'password' => 'password'])
            ->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_no_admin_recibe_403(): void
    {
        $u = User::factory()->create(['username' => 'emp', 'es_admin' => false]);

        $this->actingAs($u)->get('/admin')->assertForbidden();
    }

    public function test_limite_de_intentos(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['username' => 'x', 'password' => 'y']);
        }

        $this->post('/admin/login', ['username' => 'x', 'password' => 'y'])->assertStatus(429);
    }

    public function test_logout(): void
    {
        $this->actingAs($this->admin())->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_admin_registra_usuario(): void
    {
        $this->actingAs($this->admin())->post('/admin/usuarios', [
            'name' => 'Ana', 'apellido' => 'Gómez', 'email' => 'ana@example.com',
            'username' => 'ana', 'password' => 'Secreta123', 'password_confirmation' => 'Secreta123',
        ])->assertRedirect(route('admin.usuarios.index'));

        $this->assertDatabaseHas('users', ['username' => 'ana', 'es_admin' => false, 'activo' => true]);
    }

    public function test_registro_rechaza_username_duplicado_y_password_debil(): void
    {
        $this->actingAs($this->admin())->post('/admin/usuarios', [
            'name' => 'Ana', 'apellido' => 'G', 'email' => 'ana@example.com',
            'username' => 'admin1', 'password' => 'corta', 'password_confirmation' => 'corta',
        ])->assertSessionHasErrors(['username', 'password']);
    }

    public function test_no_puede_desactivarse_a_si_mismo(): void
    {
        $u = $this->admin();

        $this->actingAs($u)->patch("/admin/usuarios/{$u->id}/activo")->assertSessionHas('error');
        $this->assertTrue($u->fresh()->activo);
    }
}
