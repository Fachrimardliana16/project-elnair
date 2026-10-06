<?php

namespace Database\Seeders;

use App\Models\Workflow;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            [
                'step_number' => 1,
                'title' => 'Pilih Layanan',
                'description' => 'Tentukan paket ibadah Umrah atau Haji pilihan Anda yang paling nyaman dan sesuai kebutuhan jamaah.',
                'tagline' => 'Kemudahan Pilihan',
                'icon' => 'fa-person-praying',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'step_number' => 2,
                'title' => 'Pesan melalui Whatsapp',
                'description' => 'Konsultasikan tanggal, kebutuhan khusus wanita & keluarga langsung dengan tim customer care kami.',
                'tagline' => 'Respon Cepat 24/7',
                'icon' => 'fa-headset',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'step_number' => 3,
                'title' => 'Konfirmasi Layanan',
                'description' => 'Verifikasi dokumen, tanggal keberangkatan, dan pemilihan perlengkapan ibadah personal eksklusif.',
                'tagline' => 'Layanan Personalisasi',
                'icon' => 'fa-file-circle-check',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'step_number' => 4,
                'title' => 'Pembayaran',
                'description' => 'Lakukan pembayaran DP atau pelunasan dengan transparan melalui rekening resmi PT Elnair Tour & Travel.',
                'tagline' => 'Transaksi Aman & Terverifikasi',
                'icon' => 'fa-hand-holding-dollar',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'step_number' => 5,
                'title' => 'Ibadah Aman dan Lancar',
                'description' => 'Nikmati perjalanan ibadah yang tenang didampingi mutawwifah & pembimbing berpengalaman sampai kembali ke tanah air.',
                'tagline' => 'Ibadah aman bersama kami',
                'icon' => 'fa-hand-holding-heart',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($steps as $step) {
            Workflow::updateOrCreate(['step_number' => $step['step_number']], $step);
        }
    }
}
