<?php

namespace Tests\Feature\Public;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackagePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function active_package_detail_page_is_accessible(): void
    {
        Package::create([
            'title'       => 'Umrah Ramadhan',
            'slug'        => 'umrah-ramadhan',
            'price_label' => 'IDR',
            'price_value' => '35jt',
            'description' => 'Deskripsi paket umrah ramadhan.',
            'is_active'   => true,
        ]);

        $this->get('/paket/umrah-ramadhan')
             ->assertOk()
             ->assertSee('Umrah Ramadhan');
    }

    /** @test */
    public function inactive_package_returns_404(): void
    {
        Package::create([
            'title'       => 'Paket Nonaktif',
            'slug'        => 'paket-nonaktif',
            'price_label' => 'IDR',
            'price_value' => '25jt',
            'description' => 'Paket ini tidak aktif.',
            'is_active'   => false,
        ]);

        $this->get('/paket/paket-nonaktif')
             ->assertNotFound();
    }

    /** @test */
    public function nonexistent_package_returns_404(): void
    {
        $this->get('/paket/paket-tidak-ada')
             ->assertNotFound();
    }
}
