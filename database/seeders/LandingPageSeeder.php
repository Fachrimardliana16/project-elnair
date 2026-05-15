<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPage;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        LandingPage::create([
            'title' => 'Layanan Haji Plus & Furoda',
            'slug' => 'haji',
            'content' => '<h2>Perjalanan Suci Tanpa Antre</h2><p>Nikmati kemudahan beribadah Haji dengan fasilitas bintang lima dan pembimbing berpengalaman. Kami memastikan setiap detail perjalanan Anda ditangani dengan profesionalisme tertinggi.</p><ul><li>Viza Furoda Resmi</li><li>Hotel Bintang 5 di Makkah & Madinah</li><li>Tenda AC di Arafah & Mina</li><li>Konsumsi Menu Indonesia</li></ul>',
        ]);

        LandingPage::create([
            'title' => 'Paket Umrah Premium',
            'slug' => 'umroh',
            'content' => '<h2>Umrah dengan Kenyamanan Maksimal</h2><p>Hadirkan ketenangan dalam ibadah Umrah Anda bersama Elnair. Kami menyediakan berbagai pilihan paket yang dapat disesuaikan dengan kebutuhan Anda dan keluarga.</p><ul><li>Penerbangan Direct</li><li>Handling Professional</li><li>Manasik Eksklusif</li><li>Perlengkapan Premium</li></ul>',
        ]);
    }
}
