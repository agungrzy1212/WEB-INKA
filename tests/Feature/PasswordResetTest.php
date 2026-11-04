<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi');
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        $user = User::factory()->create([
            'email' => 'peserta@example.com',
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'peserta@example.com',
        ]);

        $response->assertSessionHas('status');
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create([
            'email' => 'peserta@example.com',
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->get('/reset-password/' . $token . '?email=' . urlencode($user->email));

        $response->assertStatus(200);
        $response->assertSee('Kata Sandi Baru');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'peserta@example.com',
            'password' => Hash::make('password-lama123'),
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => 'peserta@example.com',
            'password' => 'password-baru123',
            'password_confirmation' => 'password-baru123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('toast_success');

        $this->assertTrue(Hash::check('password-baru123', $user->fresh()->password));
    }
}
