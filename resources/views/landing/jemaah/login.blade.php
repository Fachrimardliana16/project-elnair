@extends('landing.layouts.app')

@section('content')
<section class="jemaah-login-section" style="min-height: calc(100vh - 80px); display: flex; align-items: center; justify-content: center; padding: 4rem 1.5rem; background: radial-gradient(circle at 10% 20%, rgba(13, 76, 84, 0.95) 0%, rgba(12, 21, 23, 0.98) 90%); position: relative; overflow: hidden;">
    <!-- Elegant background decorative elements -->
    <div style="position: absolute; top: -10%; right: -10%; width: 400px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(139, 94, 60, 0.15) 0%, transparent 70%); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -10%; left: -10%; width: 450px; height: 450px; border-radius: 50%; background: radial-gradient(circle, rgba(102, 165, 173, 0.1) 0%, transparent 70%); pointer-events: none;"></div>

    <div style="width: 100%; max-width: 500px; z-index: 10;">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.85rem; display: block; margin-bottom: 0.75rem;">Portal Client</span>
            <h1 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem; text-shadow: 0 4px 10px rgba(0,0,0,0.3);">Portal Jemaah</h1>
            <p style="color: rgba(255,255,255,0.7); font-size: 0.95rem;">Akses status keberangkatan, penerbangan, rooming list, dan pembayaran Anda.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: rgba(37, 211, 102, 0.15); border: 1px solid rgba(37, 211, 102, 0.3); color: #25d366; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: center;">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem; text-align: center;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" style="background: rgba(231, 76, 60, 0.15); border: 1px solid rgba(231, 76, 60, 0.3); color: #e74c3c; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-card" style="background: rgba(20, 32, 31, 0.75); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; padding: 2.5rem; box-shadow: 0 30px 60px rgba(0,0,0,0.4);">
            <form action="{{ route('jemaah.login.post') }}" method="POST">
                @csrf

                <div class="form-group" style="margin-bottom: 1.75rem;">
                    <label for="whatsapp" style="display: block; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--brand-gold); margin-bottom: 0.75rem;">
                        <i class="fab fa-whatsapp" style="margin-right: 6px; font-size: 1.1rem; color: #25d366;"></i> Nomor WhatsApp <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="text" 
                           name="whatsapp" 
                           id="whatsapp" 
                           value="{{ old('whatsapp') }}" 
                           placeholder="Contoh: 081234567890" 
                           class="form-control" 
                           style="width: 100%; padding: 1rem 1.25rem; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.15); background: rgba(255, 255, 255, 0.05); color: #fff; font-size: 1rem; transition: all 0.3s;"
                           required>
                    <small style="display: block; color: rgba(255,255,255,0.4); margin-top: 0.5rem; font-size: 0.78rem;">Gunakan nomor WhatsApp aktif yang Anda isi saat mendaftar.</small>
                </div>

                <div class="form-group" style="margin-bottom: 2.25rem;">
                    <label for="nik" style="display: block; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--brand-gold); margin-bottom: 0.75rem;">
                        <i class="far fa-id-card" style="margin-right: 6px;"></i> NIK KTP <span style="color: #e74c3c;">*</span>
                    </label>
                    <input type="text" 
                           name="nik" 
                           id="nik" 
                           value="{{ old('nik') }}" 
                           placeholder="16 Digit Nomor NIK Anda" 
                           class="form-control" 
                           style="width: 100%; padding: 1rem 1.25rem; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.15); background: rgba(255, 255, 255, 0.05); color: #fff; font-size: 1rem; transition: all 0.3s;"
                           required>
                    <small style="display: block; color: rgba(255,255,255,0.4); margin-top: 0.5rem; font-size: 0.78rem;">Nomor Induk Kependudukan yang tercantum pada KTP Anda.</small>
                </div>

                <button type="submit" 
                        class="btn btn-gold" 
                        style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.75rem; padding: 1.1rem; border-radius: 12px; border: none; font-size: 0.95rem; cursor: pointer; transition: all 0.3s; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;">
                    Masuk Portal <i class="fas fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <p style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">
                Belum mendaftar sebagai jemaah? 
                <a href="{{ route('pendaftaran.create') }}" style="color: var(--brand-gold); font-weight: 700; text-decoration: none; margin-left: 5px; transition: color 0.3s;">
                    Daftar Sekarang <i class="fas fa-external-link-alt" style="font-size: 0.75rem; margin-left: 3px;"></i>
                </a>
            </p>
        </div>
    </div>
</section>

<style>
    /* Styling overrides for active inputs in dark card */
    .jemaah-login-section input:focus {
        outline: none;
        border-color: var(--brand-gold) !important;
        background: rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 0 15px rgba(139, 94, 60, 0.25);
    }
</style>
@endsection
