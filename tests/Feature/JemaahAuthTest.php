<?php

namespace Tests\Feature;

use App\Models\Jamaah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class JemaahAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_jemaah_can_login_and_session_is_set(): void
    {
        $jemaah = Jamaah::create([
            'name' => 'Jemaah Test',
            'nik' => '3171010101010001',
            'whatsapp' => '081234567890',
            'status' => 'Approved',
        ]);

        $this->post(route('jemaah.login.post'), [
            'nik' => '3171010101010001',
            'whatsapp' => '081234567890',
        ])->assertRedirect(route('jemaah.dashboard'));

        $this->assertSame($jemaah->id, session('jemaah_id'));
    }

    public function test_jemaah_login_route_is_throttled(): void
    {
        RateLimiter::clear('127.0.0.1|jemaah.login');

        for ($i = 0; $i < 5; $i++) {
            $this->from(route('jemaah.login'))->post(route('jemaah.login.post'), [
                'nik' => 'invalid',
                'whatsapp' => 'invalid',
            ])->assertRedirect(route('jemaah.login'));
        }

        $this->from(route('jemaah.login'))->post(route('jemaah.login.post'), [
            'nik' => 'invalid',
            'whatsapp' => 'invalid',
        ])->assertTooManyRequests();
    }
}
