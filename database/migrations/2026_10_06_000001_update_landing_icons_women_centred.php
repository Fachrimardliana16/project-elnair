<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $featureIcons = [
            'Layanan Premium' => 'fas fa-hotel',
            'Bimbingan Khusyuk' => 'fas fa-person-praying',
            'Keamanan Elite' => 'fas fa-person-dress',
            'Pelayanan Sepenuh Hati' => 'fas fa-hand-holding-heart',
            'Maskapai Terbaik' => 'fas fa-person-walking-luggage',
            'Harga Jujur' => 'fas fa-file-invoice-dollar',
        ];

        foreach ($featureIcons as $title => $icon) {
            DB::table('features')->where('title', $title)->update(['icon' => $icon]);
        }

        $workflowIcons = [
            'Pilih Layanan' => 'fa-person-praying',
            'Pesan melalui Whatsapp' => 'fa-headset',
            'Konfirmasi Layanan' => 'fa-file-circle-check',
            'Pembayaran' => 'fa-hand-holding-dollar',
            'Ibadah Aman dan Lancar' => 'fa-hand-holding-heart',
        ];

        foreach ($workflowIcons as $title => $icon) {
            DB::table('workflows')->where('title', $title)->update(['icon' => $icon]);
        }
    }

    public function down(): void
    {
        $featureIcons = [
            'Layanan Premium' => 'fas fa-crown',
            'Bimbingan Khusyuk' => 'fas fa-kaaba',
            'Keamanan Elite' => 'fas fa-shield-halved',
            'Pelayanan Sepenuh Hati' => 'fas fa-hand-holding-heart',
            'Maskapai Terbaik' => 'fas fa-plane-departure',
            'Harga Jujur' => 'fas fa-file-signature',
        ];

        foreach ($featureIcons as $title => $icon) {
            DB::table('features')->where('title', $title)->update(['icon' => $icon]);
        }

        $workflowIcons = [
            'Pilih Layanan' => 'fa-kaaba',
            'Pesan melalui Whatsapp' => 'fa-brands fa-whatsapp',
            'Konfirmasi Layanan' => 'fa-clipboard-check',
            'Pembayaran' => 'fa-credit-card',
            'Ibadah Aman dan Lancar' => 'fa-heart',
        ];

        foreach ($workflowIcons as $title => $icon) {
            DB::table('workflows')->where('title', $title)->update(['icon' => $icon]);
        }
    }
};
