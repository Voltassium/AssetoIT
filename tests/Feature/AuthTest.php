<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_dapat_melihat_halaman_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_user_dapat_login_dengan_data_benar()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => 'test@.com',
            'password' => 'password',
        ];

        if (empty($loginData['email']) || empty($loginData['password'])) {
            $this->fail("Testing gagal: Username atau password tidak boleh kosong.");
            return;
        }

        $response = $this->post('/login', $loginData);

        if(url('/dashboard') === $response->headers->get('Location')){
            $this->assertAuthenticatedAs($user);
            return;
        }else{
            $this->fail("Testing gagal: Username atau password salah.");
            $this->assertGuest();
        }
    }
}
