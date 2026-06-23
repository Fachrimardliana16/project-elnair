<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa saja persyaratan dokumen untuk mendaftar Umroh?',
                'answer' => "Persyaratan dokumen standar untuk mendaftar Umroh meliputi:\n1. Paspor asli yang masih berlaku minimal 7 bulan sebelum keberangkatan dengan nama minimal 2 suku kata.\n2. Buku Kuning (Sertifikat Vaksin Meningitis).\n3. Pas foto berwarna (background putih, fokus wajah 80%) ukuran 4x6 (2 lembar).\n4. Fotokopi KTP dan Kartu Keluarga.\n5. Fotokopi Buku Nikah (bagi suami istri) atau Akta Kelahiran (bagi anak).",
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah harga paket sudah termasuk tiket penerbangan dan hotel?',
                'answer' => "Ya, semua paket Umroh Elnair Travel sudah bersifat All-In (kecuali pembuatan paspor dan vaksin meningitis). Harga sudah termasuk:\n- Tiket pesawat PP kelas ekonomi\n- Visa Umroh\n- Akomodasi Hotel di Makkah dan Madinah\n- Transportasi Bus Full AC selama di Tanah Suci\n- Makan 3x sehari sesuai program\n- Muthawwif (Pembimbing ibadah) yang berpengalaman\n- Air Zamzam (5 Liter) jika diizinkan maskapai\n- Perlengkapan Umroh (Koper, kain ihram/mukena, tas paspor, dll).",
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Bagaimana jika saya batal berangkat karena alasan kesehatan atau mendesak?',
                'answer' => "Jika terjadi pembatalan dari pihak jamaah, maka akan berlaku ketentuan pembatalan sebagai berikut (syarat dan ketentuan berlaku):\n- Pembatalan >30 hari sebelum keberangkatan: Dikenakan biaya administrasi.\n- Pembatalan 15-30 hari sebelum keberangkatan: Potongan 50% dari harga paket.\n- Pembatalan <15 hari sebelum keberangkatan: Potongan hingga 100% dari harga paket (tergantung tiket dan hotel yang sudah di-issued).\nKami sangat menyarankan jamaah untuk menjaga kesehatan dan berkoordinasi dengan tim kami jika ada kendala sedini mungkin.",
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada bimbingan (manasik) sebelum keberangkatan?',
                'answer' => "Tentu saja. Elnair Travel memberikan fasilitas Bimbingan Manasik Umroh secara komprehensif sebelum keberangkatan. Manasik ini meliputi tata cara ibadah (fiqih Umroh), persiapan mental dan fisik, hingga teknis perjalanan. Kami memastikan setiap jamaah memahami tata cara ibadah sesuai Sunnah agar ibadahnya mabrur.",
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa kapasitas maksimal dalam satu rombongan (grup)?',
                'answer' => "Untuk menjaga kenyamanan dan kekhusyukan ibadah, satu rombongan (grup) keberangkatan Umroh biasanya dibatasi maksimal 40 - 45 jamaah dalam satu bus. Setiap bus akan didampingi oleh 1 orang Tour Leader dari Indonesia dan 1 orang Muthawwif profesional di Tanah Suci.",
                'order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah anak-anak dan balita bisa ikut berangkat Umroh?',
                'answer' => "Bisa. Kami melayani keberangkatan untuk anak-anak dan balita. Tersedia diskon khusus untuk bayi (infant) di bawah 2 tahun yang belum membutuhkan kursi pesawat/bus sendiri, serta untuk anak-anak di bawah 12 tahun tanpa bed di hotel (child no bed). Syarat dokumennya meliputi Akta Kelahiran dan paspor anak.",
                'order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah ada layanan untuk jamaah lansia atau berkebutuhan khusus?',
                'answer' => "Tentu ada. Kami sangat memperhatikan kenyamanan jamaah lansia. Jika jamaah membutuhkan kursi roda, kami bisa membantu menyediakan penyewaan kursi roda lengkap dengan petugas pendorong (mutawwif khusus) selama pelaksanaan ibadah rukun (Tawaf dan Sa'i) dengan biaya tambahan sesuai tarif yang berlaku di Masjidil Haram.",
                'order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Berapa lama durasi perjalanan Umroh yang reguler?',
                'answer' => "Durasi paket reguler kami adalah 9 hari hingga 12 hari perjalanan (termasuk waktu tempuh di pesawat). Pembagian waktu standar biasanya 4 malam di Madinah dan 3 atau 4 malam di Makkah, tergantung jadwal penerbangan dan paket yang Anda pilih.",
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
