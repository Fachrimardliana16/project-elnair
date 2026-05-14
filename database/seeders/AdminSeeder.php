<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\HeroSetting;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to avoid duplicates
        User::truncate();
        SiteSetting::truncate();
        HeroSetting::truncate();
        Feature::truncate();
        Package::truncate();
        Testimonial::truncate();

        // Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Default Site Settings
        $settings = [
            'site_name' => 'Elnair Travel',
            'logo' => 'assets/img/logo-full.png',
            'favicon' => 'favicon.ico',
            'wa_number' => '628123456789',
            'instagram_url' => 'https://instagram.com/elnairtravel',
            'facebook_url' => 'https://facebook.com/elnairtravel',
            'email' => 'info@elnairtravel.com',
            'phone' => '(021) 1234 5678',
            'address' => 'Jl. Premium No. 123, SCBD, Jakarta Pusat',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::create(['key' => $key, 'value' => $value]);
        }

        // Hero Settings
        HeroSetting::create([
            'tagline' => 'Welcome to Elnair',
            'title' => 'Wujudkan Perjalanan Suci Impian Anda',
            'subtitle' => 'Menghadirkan harmoni antara ibadah yang khusyuk dan kenyamanan yang tak tertandingi di Tanah Suci.',
            'btn_primary_text' => 'Konsultasi Gratis',
            'btn_primary_url' => '#cta',
            'btn_secondary_text' => 'Eksplorasi Paket',
            'btn_secondary_url' => '#paket',
            'background_image' => 'assets/img/hero.png',
        ]);

        // Features (Why Choose Us)
        $features = [
            ['icon' => 'fas fa-crown', 'title' => 'Layanan Premium', 'description' => 'Fasilitas hotel bintang 5 di pelataran Masjidil Haram dan Masjid Nabawi untuk akses tanpa batas.', 'order' => 1],
            ['icon' => 'fas fa-kaaba', 'title' => 'Bimbingan Khusyuk', 'description' => 'Dibimbing langsung oleh asatidz ahli yang memastikan setiap rukun ibadah sesuai tuntunan sunnah.', 'order' => 2],
            ['icon' => 'fas fa-shield-halved', 'title' => 'Keamanan Elite', 'description' => 'Legalitas resmi Kemenag dengan jaminan keberangkatan dan kepulangan yang terorganisir sempurna.', 'order' => 3],
            ['icon' => 'fas fa-hand-holding-heart', 'title' => 'Pelayanan Sepenuh Hati', 'description' => 'Tim support yang sigap mendampingi kebutuhan jamaah kapan pun dan di mana pun.', 'order' => 4],
            ['icon' => 'fas fa-plane-departure', 'title' => 'Maskapai Terbaik', 'description' => 'Terbang dengan maskapai full-service untuk perjalanan yang lebih nyaman dan minim lelah.', 'order' => 5],
            ['icon' => 'fas fa-file-signature', 'title' => 'Harga Jujur', 'description' => 'Transparansi biaya tanpa ada tambahan tersembunyi selama perjalanan berlangsung.', 'order' => 6],
        ];

        foreach ($features as $f) {
            Feature::create($f);
        }

        // Packages
        $packages = [
            [
                'title' => 'Haji Furoda Luxury',
                'price_label' => 'IDR',
                'price_value' => '350jt',
                'description' => 'Haji tanpa antri dengan fasilitas tenda AC di Arafah dan hotel bintang 5 di Makkah.',
                'image' => 'assets/img/pkg1.png',
            ],
            [
                'title' => 'Umrah VIP Direct',
                'price_label' => 'IDR',
                'price_value' => '45jt',
                'description' => 'Penerbangan langsung Jakarta - Madinah dengan kenyamanan kelas utama selama perjalanan.',
                'image' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Umrah Plus Turki',
                'price_label' => 'IDR',
                'price_value' => '55jt',
                'description' => 'Ibadah umrah sekaligus menikmati keindahan sejarah Islam di Istanbul dan Cappadocia.',
                'image' => 'https://images.unsplash.com/photo-1580418827493-f2b22c0a76cb?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($packages as $p) {
            Package::create($p);
        }

        // Testimonials
        $testimonials = [
            [
                'name' => 'HJ. SITI AMINAH',
                'role_label' => 'Jamaah Haji Furoda 2023',
                'quote' => '"Sebuah perjalanan spiritual yang tak terlupakan. Elnair memberikan kenyamanan yang membuat kami bisa fokus sepenuhnya pada ibadah."',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=100',
                'thumbnail' => 'assets/img/hero.png',
            ],
            [
                'name' => 'BP. AHMAD ZAKY',
                'role_label' => 'Jamaah Umrah VIP 2023',
                'quote' => '"Pelayanan yang sangat profesional. Sejak pendaftaran hingga kepulangan, semuanya diatur dengan sangat rapi dan penuh perhatian."',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=100',
                'thumbnail' => 'assets/img/pkg1.png',
            ],
            [
                'name' => 'IBU SITI RAHMA',
                'role_label' => 'Jamaah Umrah Syawal 2023',
                'quote' => '"Merasakan kekhusyukan ibadah tanpa harus khawatir dengan fasilitas. Hotel yang sangat dekat dengan Masjidil Haram sangat membantu."',
                'avatar' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=100',
                'thumbnail' => 'assets/img/hero.png',
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }
    }
}
