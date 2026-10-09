<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        Promo::truncate();

        $promos = [
            [
                'title' => 'Exclusive Woman Travel Essentials Kit',
                'slug' => Str::slug('Exclusive Woman Travel Essentials Kit'),
                'badge' => 'Elnair Travel Essentials Collection',
                'description' => 'Setiap pendaftaran paket Umrah & Haji di Elnair Tour & Travel berhak mendapatkan Woman Travel Essentials Kit eksklusif. Kotak koper velvet pink premium ini dirancang khusus dengan 3 kompartemen utama untuk memenuhi segala kebutuhan privasi, kebersihan, dan kenyamanan jamaah wanita selama di Tanah Suci.',
                'details' => json_encode([
                    'Personal Care: Body wash, lotion, & skincare halal ramah ihram (fragrance-free)',
                    'Period Care: Pembalut higienis, pantyliners lembut, & sanitary care pouch darurat',
                    'Essentials Kit: Sisir lipat travel, cermin mini gold Elnair, satin jewelry pouch & care kit',
                    'Luxury Vanity Case: Kotak koper velvet quilted pink eksklusif, ringkas & travel-friendly',
                ]),
                'image' => 'assets/img/woman_travel_essentials_kit.jpg',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pendampingan Khusus Muthawwifah & Fikih Ibadah Wanita',
                'slug' => Str::slug('Pendampingan Khusus Muthawwifah Fikih Ibadah Wanita'),
                'badge' => 'Woman-Centered Sisterhood',
                'description' => 'Bimbingan ibadah khusus jamaah wanita dibimbing langsung oleh Muthawwifah berpengalaman dan bersertifikat yang memahami fikih wanita, tata cara ziarah Raudhah, serta siap mendampingi kebutuhan jamaah perempuan selama di Haramain.',
                'details' => json_encode([
                    'Bimbingan Ibadah & Konsultasi Fikih Thaharah Wanita',
                    'Pendampingan Khusus Masuk Raudhah Jamaah Wanita',
                    'Layanan Bantuan Kesehatan & Privasi Jamaah Perempuan',
                    'Sisterhood Support & Pendampingan 24 Jam Penuh Perhatian',
                ]),
                'image' => 'assets/img/mutawwifah_sisterhood.jpg',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($promos as $p) {
            Promo::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}

