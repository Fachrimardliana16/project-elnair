<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            [
                'title' => 'Fasilitas Personal Kit Jamaah Wanita & Keluarga',
                'slug' => Str::slug('Fasilitas Personal Kit Jamaah Wanita & Keluarga'),
                'badge' => 'Exclusive Woman Kit Benefit',
                'description' => 'Setiap pendaftaran paket Umrah & Haji di Elnair Tour & Travel berhak mendapatkan Personal Kit eksklusif yang didesain ramah jamaah wanita untuk kenyamanan ibadah prima.',
                'details' => json_encode([
                    'Tas Koper Elegant & Handbag Travel khusus wanita',
                    'Tumbler Stainless Thermos pengatur suhu air minum',
                    'HT Wireless Audio Receiver khusus bimbingan tawaf/sa\'i',
                    'Mukena & Kain Ihram Seragam Silk Premium',
                    'Buku Panduan Doa & Kit Kenyamanan Personal',
                ]),
                'image' => 'assets/img/hero-premium.webp',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Pendampingan Khusus Mutawwifah (Pembimbing Wanita)',
                'slug' => Str::slug('Pendampingan Khusus Mutawwifah Pembimbing Wanita'),
                'badge' => 'Woman-Centered Care',
                'description' => 'Bimbingan ibadah khusus jamaah wanita dibimbing langsung oleh Mutawwifah berpengalaman dan paham fikih wanita saat di Haramain.',
                'details' => json_encode([
                    'Bimbingan Ibadah Khusus Fikih Wanita',
                    'Kunjungan Khusus Raudhah Jamaah Wanita',
                    'Layanan Bantuan Kesehatan & Kebersihan Wanita',
                    'Pendampingan Grup Khusus Akhwat & Keluarga',
                ]),
                'image' => 'assets/img/hero-premium-mobile.webp',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($promos as $p) {
            Promo::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
