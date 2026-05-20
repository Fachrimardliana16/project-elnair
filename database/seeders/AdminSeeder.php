<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\HeroSetting;
use App\Models\Feature;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\DepartureSchedule;
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
        DepartureSchedule::truncate();

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
                'slug' => 'haji-furoda-luxury',
                'price_label' => 'IDR',
                'price_value' => '350jt',
                'description' => 'Haji tanpa antri dengan fasilitas tenda AC di Arafah dan hotel bintang 5 di Makkah.',
                'image' => 'assets/img/pkg1.png',
            ],
            [
                'title' => 'Umrah VIP Direct',
                'slug' => 'umrah-vip-direct',
                'price_label' => 'IDR',
                'price_value' => '45jt',
                'description' => 'Penerbangan langsung Jakarta - Madinah dengan kenyamanan kelas utama selama perjalanan.',
                'image' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Umrah Plus Turki',
                'slug' => 'umrah-plus-turki',
                'price_label' => 'IDR',
                'price_value' => '55jt',
                'description' => 'Ibadah umrah sekaligus menikmati keindahan sejarah Islam di Istanbul dan Cappadocia.',
                'image' => 'https://images.unsplash.com/photo-1580418827493-f2b22c0a76cb?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($packages as $p) {
            Package::create($p);
        }

        // Departure Schedules
        $hajiPkg = Package::where('slug', 'haji-furoda-luxury')->first();
        $umrahVipPkg = Package::where('slug', 'umrah-vip-direct')->first();
        $umrahTurkiPkg = Package::where('slug', 'umrah-plus-turki')->first();

        if ($hajiPkg) {
            DepartureSchedule::create([
                'package_id' => $hajiPkg->id,
                'departure_date' => now()->addMonths(2)->setDate(now()->year, 6, 15),
                'available_seats' => 5,
                'status' => 'Tersedia',
                'is_active' => true,
            ]);
        }

        if ($umrahVipPkg) {
            DepartureSchedule::create([
                'package_id' => $umrahVipPkg->id,
                'departure_date' => now()->addMonths(1),
                'available_seats' => 12,
                'status' => 'Tersedia',
                'is_active' => true,
            ]);
            
            DepartureSchedule::create([
                'package_id' => $umrahVipPkg->id,
                'departure_date' => now()->addMonths(3),
                'available_seats' => 2,
                'status' => 'Hampir Penuh',
                'is_active' => true,
            ]);
        }

        if ($umrahTurkiPkg) {
            DepartureSchedule::create([
                'package_id' => $umrahTurkiPkg->id,
                'departure_date' => now()->addMonths(2),
                'available_seats' => 0,
                'status' => 'Penuh',
                'is_active' => true,
            ]);
            
            DepartureSchedule::create([
                'package_id' => $umrahTurkiPkg->id,
                'departure_date' => now()->addMonths(4),
                'available_seats' => 25,
                'status' => 'Tersedia',
                'is_active' => true,
            ]);
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

        // Dummy Articles & Kajian
        Article::truncate();
        $admin = User::where('role', 'admin')->first();
        $articles = [
            [
                'title' => 'Panduan Lengkap Tata Cara Umrah Sesuai Sunnah',
                'slug' => 'panduan-lengkap-tata-cara-umrah-sesuai-sunnah',
                'content' => '<h2>Panduan Umrah Sesuai Petunjuk Rasulullah SAW</h2><p>Melaksanakan ibadah umrah merupakan dambaan setiap Muslim. Agar ibadah kita diterima oleh Allah SWT, sangat penting untuk memahami tata cara pelaksanaannya yang sesuai dengan tuntunan sunnah Rasulullah SAW.</p><h3>1. Ihram dari Miqat</h3><p>Perjalanan ibadah dimulai dengan memakai pakaian ihram dan berniat untuk umrah dari batas tempat yang ditentukan (Miqat). Sebelum berniat, jamaah disunnahkan untuk mandi, memotong kuku, dan merapikan janggut.</p><h3>2. Tawaf mengelilingi Ka\'bah</h3><p>Tawaf adalah mengelilingi Ka\'bah sebanyak 7 kali putaran, dimulai dan diakhiri di sudut Hajar Aswad. Selama tawaf, jamaah dianjurkan memperbanyak doa dan dzikir.</p><h3>3. Sa\'i antara Shafa dan Marwah</h3><p>Berjalan kaki (dan berlari-lari kecil bagi laki-laki di batas lampu hijau) antara bukit Shafa dan Marwah sebanyak 7 kali perjalanan.</p><h3>4. Tahallul (Memotong Rambut)</h3><p>Mengakhiri ibadah umrah dengan mencukur atau memotong sebagian rambut kepala. Bagi laki-laki, mencukur gundul lebih utama.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1591604021695-0c69b7c05981?auto=format&fit=crop&q=80&w=800',
                'author_id' => $admin->id,
                'status' => 'published',
            ],
            [
                'title' => 'Keutamaan Haji Furoda: Ibadah Tanpa Waktu Tunggu',
                'slug' => 'keutamaan-haji-furoda-ibadah-tanpa-waktu-tunggu',
                'content' => '<h2>Mengenal Haji Furoda dan Fasilitas Eksklusifnya</h2><p>Haji Furoda adalah program ibadah haji yang menggunakan visa undangan resmi (Mujamalah) dari pemerintah Kerajaan Arab Saudi. Keunggulan utamanya adalah jamaah dapat langsung berangkat pada tahun yang sama tanpa perlu mengantre bertahun-tahun seperti program reguler atau haji khusus (Plus).</p><h3>Legalitas dan Kenyamanan</h3><p>Elnair Travel memastikan seluruh aspek legalitas visa Furoda terverifikasi secara resmi melalui e-Hajj Arab Saudi. Didukung dengan akomodasi hotel bintang 5 di Makkah dan Madinah, serta tenda AC eksklusif di Arafah dan Mina untuk menjamin kekhusyukan ibadah Anda.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&q=80&w=800',
                'author_id' => $admin->id,
                'status' => 'published',
            ],
            [
                'title' => 'Kajian: Menggapai Haji Mabrur dan Menjaga Kemabrurannya',
                'slug' => 'kajian-menggapai-haji-mabrur-dan-menjaga-kemabrurannya',
                'content' => '<h2>Kajian Ilmiah bersama Asatidz Pembimbing Elnair</h2><p>Haji mabrur tidak ada balasan lain baginya kecuali Surga. Namun, apa esensi sejati dari kemabruran tersebut? Dalam kajian subuh yang diselenggarakan di Makkah, Ustadz Pembimbing Elnair menjelaskan beberapa tanda haji mabrur:</p><ul><li>Adanya perubahan perilaku ke arah yang lebih baik setelah kembali dari Tanah Suci.</li><li>Meningkatnya kepedulian sosial terhadap sesama (It\'amuth Tha\'am).</li><li>Lisannya semakin terjaga dan santun dalam bertutur kata (Thiyabul Kalam).</li></ul><p>Semoga Allah senantiasa membimbing kita untuk terus istiqamah menjaga kualitas ibadah pasca berhaji.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1564121211835-e88c852648ab?auto=format&fit=crop&q=80&w=800',
                'author_id' => $admin->id,
                'status' => 'published',
            ],
            [
                'title' => 'Persiapan Fisik dan Mental Sebelum Keberangkatan Umrah Premium',
                'slug' => 'persiapan-fisik-dan-mental-sebelum-keberangkatan-umrah-premium',
                'content' => '<h2>Tips Penting Sebelum Menuju Dua Kota Suci</h2><p>Perjalanan ibadah Umrah memerlukan ketahanan fisik yang prima karena aktivitas Tawaf, Sa\'i, dan perjalanan antar kota suci menuntut energi yang cukup besar. Berikut beberapa persiapan penting bagi calon jamaah Elnair:</p><h3>1. Latihan Jalan Kaki</h3><p>Membiasakan jalan kaki ringan 15-30 menit setiap hari minimal dua minggu sebelum keberangkatan.</p><h3>2. Menjaga Pola Makan dan Hidrasi</h3><p>Perbanyak konsumsi air putih dan suplemen vitamin jika diperlukan.</p><h3>3. Persiapan Kejiwaan</h3><p>Perbanyak istighfar, bertaubat, dan meluruskan niat semata-mata mengharap ridha Allah SWT, bebas dari kesibukan duniawi.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80&w=800',
                'author_id' => $admin->id,
                'status' => 'published',
            ],
            [
                'title' => 'Tips Memilih Travel Umrah Berizin Resmi Kemenag',
                'slug' => 'tips-memilih-travel-umrah-berizin-resmi-kemenag',
                'content' => '<h2>Hindari Penipuan, Utamakan Legalitas dan Rekam Jejak</h2><p>Maraknya kasus penipuan berkedok umrah murah menuntut kita untuk ekstra waspada. Pastikan Anda memilih penyelenggara yang memiliki izin resmi Penyelenggara Perjalanan Ibadah Umrah (PPIU) dari Kementerian Agama RI.</p><h3>Rumus 5 Pasti Umrah:</h3><ul><li>Pasti Travelnya Berizin</li><li>Pasti Jadwalnya (Tiket PP jelas)</li><li>Pasti Terbangnya (Maskapai terpercaya)</li><li>Pasti Hotelnya (Akomodasi jelas)</li><li>Pasti Visanya (Legalitas visa terjamin)</li></ul><p>Elnair Travel bangga menjadi salah satu biro perjalanan dengan komitmen 100% amanah, resmi, dan transparan.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1609599006353-e629f1d40968?auto=format&fit=crop&q=80&w=800',
                'author_id' => $admin->id,
                'status' => 'published',
            ],
            [
                'title' => 'Kajian Parenting Islami: Membawa Anak Kecil Saat Ibadah Umrah',
                'slug' => 'kajian-parenting-islami-membawa-anak-kecil-saat-ibadah-umrah',
                'content' => '<h2>Menanamkan Rasa Cinta Masjidil Haram Sejak Dini</h2><p>Membawa buah hati tercinta ke Tanah Suci adalah pengalaman berharga yang dapat membekas indah di memori mereka. Ustadzah pendamping Elnair membagikan kiat agar ibadah tetap nyaman:</p><ul><li>Pilihlah paket Umrah VIP/Premium dengan hotel dekat pelataran agar mobilitas anak tidak melelahkan.</li><li>Siapkan mainan edukatif tanpa suara untuk menyibukkan anak di dalam masjid.</li><li>Ajarkan doa-doa pendek secara perlahan selama tawaf dan sa\'i.</li></ul><p>Jadikan perjalanan ini sebagai sarana tarbiyah (pendidikan) terbaik bagi putra-putri kita.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1591604466107-ec97de577aff?auto=format&fit=crop&q=80&w=800',
                'author_id' => $admin->id,
                'status' => 'published',
            ],
        ];

        foreach ($articles as $art) {
            Article::create($art);
        }
    }
}
