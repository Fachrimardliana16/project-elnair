@extends('landing.layouts.app')

@section('content')
<!-- Hero About -->
<section class="hero-about" style="position: relative; height: 50vh; background-image: url('{{ asset('assets/img/hero-premium.webp') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(13, 76, 84, 0.8);"></div>
    <div class="container" style="position: relative; z-index: 2; text-align: center; color: white;">
        <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.9rem;">Company Profile</span>
        <h1 style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 6vw, 4rem); margin: 1rem 0;">Tentang Elnair</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Melayani tamu Allah dengan standar Spiritual Luxury.</p>
    </div>
</section>

<!-- Company Profile Tabs -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        
        <div class="custom-tabs">
            <div class="tab-nav centered">
                <button class="tab-btn active" data-target="profil">Profile Perusahaan</button>
                <button class="tab-btn" data-target="visi">Visi Misi</button>
                <button class="tab-btn" data-target="nilai">Nilai Utama (Core Values)</button>
            </div>
            
            <div class="tab-content active" id="profil">
                <div class="about-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                    <div class="about-text">
                        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--brand-dark); margin-bottom: 1rem;">Profil Perusahaan</h2>
                        <p style="line-height: 1.8; color: var(--text-dark); margin-bottom: 1rem;">Elnair Tour & Travel adalah perusahaan penyedia layanan perjalanan umrah yang berkomitmen menghadirkan pengalaman ibadah yang nyaman, aman, dan penuh makna bagi setiap jamaah. Berlandaskan nilai Excellence, Loyalty, Nurturing Care, Accountability, Integrity, dan Reliability, Elnair hadir sebagai mitra perjalanan yang mengutamakan kualitas layanan, kepercayaan, serta kepuasan pelanggan.</p>
                        <p style="line-height: 1.8; color: var(--text-dark); margin-bottom: 1rem;">Kami memahami bahwa perjalanan umrah bukan sekadar perjalanan menuju Tanah Suci, melainkan sebuah perjalanan spiritual yang berharga bagi setiap jamaah. Oleh karena itu, Elnair memberikan layanan yang menyeluruh, mulai dari konsultasi dan persiapan keberangkatan, pengurusan dokumen perjalanan, hingga pendampingan selama pelaksanaan ibadah, dengan perhatian dan kepedulian yang tulus.</p>
                        <p style="line-height: 1.8; color: var(--text-dark);">Dengan mengedepankan profesionalisme, transparansi, dan integritas dalam setiap layanan, Elnair terus berupaya membangun hubungan jangka panjang yang dilandasi oleh kepercayaan. Komitmen tersebut menjadi fondasi kami dalam menghadirkan pengalaman perjalanan ibadah yang berkualitas serta menjadi mitra yang dapat diandalkan bagi masyarakat.</p>
                    </div>
                    <div class="about-image">
                        <img src="{{ asset('assets/img/hero-premium.webp') }}" style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    </div>
                </div>
            </div>
            
            <div class="tab-content" id="visi">
                <div class="about-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                    <div class="about-image">
                        <img src="{{ asset('assets/img/hero-premium.webp') }}" style="width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                    </div>
                    <div class="about-text">
                        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--brand-dark); margin-bottom: 1.5rem;">Visi & Misi Kami</h2>
                        <div style="margin-bottom: 1.5rem;">
                            <h4 style="color: var(--brand-gold); font-size: 1.2rem; margin-bottom: 0.5rem;"><i class="fas fa-eye"></i> Visi</h4>
                            <p style="line-height: 1.6; color: var(--text-dark);">Menjadi perusahaan jasa wisata terpercaya yang memberikan layanan terbaik serta pengalaman yang aman, nyaman, dan penuh makna bagi setiap tamu perjalanan.</p>
                        </div>
                        <div>
                            <h4 style="color: var(--brand-gold); font-size: 1.2rem; margin-bottom: 0.5rem;"><i class="fas fa-bullseye"></i> Misi</h4>
                            <ul style="line-height: 1.6; color: var(--text-dark); padding-left: 1.2rem;">
                                <li style="margin-bottom: 0.5rem;">Menyediakan layanan perjalanan wisata yang profesional, aman, dan berkualitas sesuai kebutuhan tamu perjalanan.</li>
                                <li style="margin-bottom: 0.5rem;">Memberikan pelayanan yang ramah, responsif, dan berorientasi pada kepuasan pelanggan di setiap perjalanan.</li>
                                <li style="margin-bottom: 0.5rem;">Menghadirkan pengalaman wisata yang nyaman, berkesan, dan bernilai melalui pelayanan terbaik dan fasilitas terpercaya.</li>
                                <li style="margin-bottom: 0.5rem;">Menjalankan bisnis dengan menjunjung tinggi integritas, transparansi, dan tanggung jawab dalam setiap layanan.</li>
                                <li style="margin-bottom: 0.5rem;">Terus berinovasi dalam mengembangkan layanan wisata yang relevan, menarik, dan mudah diakses oleh masyarakat.</li>
                                <li>Membangun hubungan jangka panjang dengan pelanggan melalui kepercayaan, kualitas pelayanan, dan pengalaman perjalanan yang memuaskan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="nilai">
                <div style="text-align: center; max-width: 800px; margin: 0 auto;">
                    <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--brand-dark); margin-bottom: 2rem;">Nilai Utama (Core Values)</h2>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; text-align: left;">
                        <div style="background: rgba(13, 76, 84, 0.03); padding: 1.5rem; border-radius: 15px; border-left: 4px solid var(--brand-gold);">
                            <h3 style="color: var(--brand-dark); font-size: 1.2rem; margin-bottom: 0.5rem;">E <span style="font-weight: 400; opacity: 0.7;">– Excellence</span></h3>
                            <p style="color: var(--text-dark); font-size: 0.95rem; margin: 0; line-height: 1.5;">Memberikan layanan terbaik dalam setiap proses perjalanan.</p>
                        </div>
                        <div style="background: rgba(13, 76, 84, 0.03); padding: 1.5rem; border-radius: 15px; border-left: 4px solid var(--brand-gold);">
                            <h3 style="color: var(--brand-dark); font-size: 1.2rem; margin-bottom: 0.5rem;">L <span style="font-weight: 400; opacity: 0.7;">– Loyalty</span></h3>
                            <p style="color: var(--text-dark); font-size: 0.95rem; margin: 0; line-height: 1.5;">Membangun hubungan jangka panjang yang dilandasi kepercayaan dan kepuasan pelanggan.</p>
                        </div>
                        <div style="background: rgba(13, 76, 84, 0.03); padding: 1.5rem; border-radius: 15px; border-left: 4px solid var(--brand-gold);">
                            <h3 style="color: var(--brand-dark); font-size: 1.2rem; margin-bottom: 0.5rem;">N <span style="font-weight: 400; opacity: 0.7;">– Nurturing Care</span></h3>
                            <p style="color: var(--text-dark); font-size: 0.95rem; margin: 0; line-height: 1.5;">Memberikan perhatian dan pendampingan yang tulus kepada setiap jamaah.</p>
                        </div>
                        <div style="background: rgba(13, 76, 84, 0.03); padding: 1.5rem; border-radius: 15px; border-left: 4px solid var(--brand-gold);">
                            <h3 style="color: var(--brand-dark); font-size: 1.2rem; margin-bottom: 0.5rem;">A <span style="font-weight: 400; opacity: 0.7;">– Accountability</span></h3>
                            <p style="color: var(--text-dark); font-size: 0.95rem; margin: 0; line-height: 1.5;">Menjalankan bisnis secara profesional, transparan, dan bertanggung jawab.</p>
                        </div>
                        <div style="background: rgba(13, 76, 84, 0.03); padding: 1.5rem; border-radius: 15px; border-left: 4px solid var(--brand-gold);">
                            <h3 style="color: var(--brand-dark); font-size: 1.2rem; margin-bottom: 0.5rem;">I <span style="font-weight: 400; opacity: 0.7;">– Integrity</span></h3>
                            <p style="color: var(--text-dark); font-size: 0.95rem; margin: 0; line-height: 1.5;">Menjunjung tinggi kejujuran dan etika dalam setiap layanan.</p>
                        </div>
                        <div style="background: rgba(13, 76, 84, 0.03); padding: 1.5rem; border-radius: 15px; border-left: 4px solid var(--brand-gold);">
                            <h3 style="color: var(--brand-dark); font-size: 1.2rem; margin-bottom: 0.5rem;">R <span style="font-weight: 400; opacity: 0.7;">– Reliability</span></h3>
                            <p style="color: var(--text-dark); font-size: 0.95rem; margin: 0; line-height: 1.5;">Menjadi mitra perjalanan ibadah yang dapat diandalkan oleh masyarakat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Team Tabs -->
<section class="pattern-bg" style="padding: 5rem 0; background: rgba(13, 76, 84, 0.02);">
    <div class="container">
        <div class="section-header reveal" style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 6vw, 3.5rem); margin: 1rem 0; color: var(--brand-dark);">Orang Di Balik Elnair</h2>
        </div>

        <div class="custom-tabs">
            <div class="tab-nav centered">
                <button class="tab-btn active" data-target="manajemen">Tim Manajemen</button>
                <button class="tab-btn" data-target="muthowwif">Muthowwif/Pembimbing</button>
            </div>
            
            <div class="tab-content active" id="manajemen">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2rem; margin-top: 2rem;">
                    @php
                        $managements = [
                            ['name' => 'Elmawan Tranggono', 'role' => 'Direktur Utama'],
                            ['name' => 'Irfan Matin Dewantara', 'role' => 'Direktur'],
                            ['name' => 'Amanda Tarisa Khairana', 'role' => 'Direktur'],
                            ['name' => 'Neltje', 'role' => 'Komisaris'],
                        ];
                    @endphp
                    @foreach($managements as $mgt)
                    <div class="guide-card reveal" style="background: var(--card-bg, #fff); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; padding-bottom: 2rem; border: 1px solid rgba(13, 76, 84, 0.05);">
                        <div style="height: 250px; background: #eee; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                            <i class="fas fa-user-tie" style="font-size: 5rem; color: #ccc;"></i>
                        </div>
                        <h4 style="font-size: 1.1rem; color: var(--brand-dark); margin-bottom: 0.3rem; padding: 0 1rem;">{{ $mgt['name'] }}</h4>
                        <span style="color: var(--brand-gold); font-size: 0.8rem; font-weight: 700; display: block; margin-bottom: 1rem;">{{ $mgt['role'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="tab-content" id="muthowwif">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 2rem;">
                    @forelse($guides as $guide)
                    <div class="guide-card reveal" style="background: var(--card-bg, #fff); border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; padding-bottom: 2rem; border: 1px solid rgba(13, 76, 84, 0.05);">
                        <div style="height: 250px; background-image: url('{{ $guide->image ? (str_starts_with($guide->image, 'http') ? $guide->image : asset($guide->image)) : asset('assets/img/hero-premium.webp') }}'); background-size: cover; background-position: center; margin-bottom: 1.5rem;"></div>
                        <h4 style="font-size: 1.2rem; color: var(--brand-dark); margin-bottom: 0.3rem; padding: 0 1rem;">{{ $guide->name }}</h4>
                        <span style="color: var(--brand-gold); font-size: 0.8rem; font-weight: 700; display: block; margin-bottom: 1rem;">{{ $guide->role }}</span>
                        @if($guide->description)
                        <p style="font-size: 0.9rem; color: var(--text-dark); padding: 0 1.5rem; line-height: 1.6;">{{ \Illuminate\Support\Str::limit($guide->description, 100) }}</p>
                        @endif
                    </div>
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: rgba(13, 76, 84, 0.02); border-radius: 15px; border: 1px dashed #ccc;">
                        <p style="opacity: 0.6; margin: 0;">Data pembimbing belum ditambahkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Info Data Legalitas -->
<section id="legalitas" class="info-legalitas" style="background: var(--brand-dark); color: white; padding: 4rem 0;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: white;">{{ $settings['company_legal_name'] ?? 'PT Elnair Sentra Wisata' }}</h2>
            <p style="opacity: 0.8; font-size: 1.1rem; max-width: 600px; margin: 0 auto;">{{ $settings['legal_description'] ?? 'Legalitas dan perizinan resmi perusahaan sebagai komitmen kami memberikan keamanan dan kenyamanan ibadah Anda.' }}</p>
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: space-around; align-items: stretch; gap: 2rem; text-align: center;">
            <div style="flex: 1; min-width: 250px; background: rgba(255,255,255,0.05); padding: 2.5rem 1.5rem; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-certificate" style="font-size: 3rem; color: var(--brand-gold); margin-bottom: 1rem;"></i>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 0.5rem;">Nomor PPIU</h3>
                <p style="font-size: 1.2rem; font-weight: 700; color: var(--brand-gold); margin: 0;">{{ $settings['ppiu_number'] ?? '(On Process)' }}</p>
            </div>
            <div style="flex: 1; min-width: 250px; background: rgba(255,255,255,0.05); padding: 2.5rem 1.5rem; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-file-signature" style="font-size: 3rem; color: var(--brand-gold); margin-bottom: 1rem;"></i>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 0.5rem;">Izin Kemenag</h3>
                <p style="font-size: 1.2rem; font-weight: 700; color: var(--brand-gold); margin: 0;">{{ $settings['kemenag_license'] ?? '(On Process)' }}</p>
            </div>
            <div style="flex: 1; min-width: 250px; background: rgba(255,255,255,0.05); padding: 2.5rem 1.5rem; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-id-card" style="font-size: 3rem; color: var(--brand-gold); margin-bottom: 1rem;"></i>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 0.5rem;">NIB</h3>
                <p style="font-size: 1.2rem; font-weight: 700; color: var(--brand-gold); margin: 0;">{{ $settings['nib_number'] ?? '1909240160665' }}</p>
                <span style="display: block; margin-top: 0.5rem; font-size: 0.85rem; opacity: 0.7;">{{ $settings['nib_date'] ?? 'Terbit: Jakarta, 19 September 2024' }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Documents Tabs -->
<section class="pattern-bg" style="padding: 5rem 0;">
    <div class="container">
        <div class="section-header reveal" style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: clamp(2rem, 6vw, 3.5rem); margin: 1rem 0; color: var(--brand-dark);">Dokumen & Sertifikat</h2>
        </div>

        <div class="custom-tabs">
            <div class="tab-nav centered">
                <button class="tab-btn active" data-target="scan-ppiu">Scan PPIU</button>
                <button class="tab-btn" data-target="sertifikat">Sertifikat</button>
                <button class="tab-btn" data-target="penghargaan">Penghargaan</button>
            </div>
            
            <div class="tab-content active" id="scan-ppiu">
                <div style="text-align: center; padding: 3rem; background: var(--card-bg, #f9f9f9); border-radius: 15px; border: 1px dashed #ddd; max-width: 600px; margin: 0 auto;">
                    <i class="fas fa-clock" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Scan Dokumen PPIU sedang dalam proses (On Process)</p>
                </div>
            </div>

            <div class="tab-content" id="sertifikat">
                <div style="text-align: center; padding: 3rem; background: var(--card-bg, #f9f9f9); border-radius: 15px; border: 1px dashed #ddd; max-width: 600px; margin: 0 auto;">
                    <i class="fas fa-certificate" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Sertifikat belum tersedia</p>
                </div>
            </div>

            <div class="tab-content" id="penghargaan">
                <div style="text-align: center; padding: 3rem; background: var(--card-bg, #f9f9f9); border-radius: 15px; border: 1px dashed #ddd; max-width: 600px; margin: 0 auto;">
                    <i class="fas fa-trophy" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Data penghargaan belum tersedia</p>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    /* Custom Tabs Styles */
    .custom-tabs {
        width: 100%;
    }
    
    .tab-nav {
        display: flex;
        border-bottom: 2px solid rgba(13, 76, 84, 0.1);
        margin-bottom: 2rem;
        overflow-x: auto;
        scrollbar-width: none; /* Firefox */
    }
    
    .tab-nav::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }

    .tab-nav.centered {
        justify-content: center;
    }
    
    .tab-btn {
        background: transparent;
        border: none;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--text-dark);
        opacity: 0.6;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    
    .tab-btn:hover {
        opacity: 0.9;
        color: var(--brand-dark);
    }
    
    .tab-btn.active {
        opacity: 1;
        color: var(--brand-dark);
        border-bottom-color: var(--brand-gold);
    }

    [data-theme="dark"] .tab-btn {
        color: var(--text-dark);
    }
    
    [data-theme="dark"] .tab-btn.active {
        color: var(--brand-teal);
    }
    
    .tab-content {
        display: none;
        animation: fadeIn 0.5s ease;
    }
    
    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .pattern-bg {
            padding: 3rem 0 !important;
        }
        .about-grid {
            gap: 2rem !important;
        }
        .about-text, .about-image {
            grid-column: span 2;
        }
        .about-image {
            order: -1;
        }
        .tab-btn {
            padding: 0.8rem 1.2rem;
            font-size: 0.95rem;
        }
        .tab-nav {
            margin-bottom: 1.5rem;
        }
        .tab-nav.centered {
            justify-content: flex-start;
        }
        .hero-about h1 {
            font-size: 2rem !important;
        }
        .info-legalitas {
            padding: 3rem 0 !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabGroups = document.querySelectorAll('.custom-tabs');
        
        tabGroups.forEach(group => {
            const btns = group.querySelectorAll('.tab-btn');
            const contents = group.querySelectorAll('.tab-content');
            
            btns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active from all btns in this group
                    btns.forEach(b => b.classList.remove('active'));
                    // Hide all contents in this group
                    contents.forEach(c => c.classList.remove('active'));
                    
                    // Add active to clicked btn
                    btn.classList.add('active');
                    // Show target content
                    const targetId = btn.getAttribute('data-target');
                    group.querySelector('#' + targetId).classList.add('active');
                });
            });
        });
    });
</script>
@endsection
