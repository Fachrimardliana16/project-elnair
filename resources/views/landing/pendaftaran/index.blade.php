@extends('landing.layouts.app')

@section('content')
<section class="registration-section">
    <div class="container registration-container">
        <div class="registration-header">
            <span style="letter-spacing: 5px; color: var(--brand-gold); text-transform: uppercase; font-weight: 800; font-size: 0.85rem; display: block; margin-bottom: 0.75rem;">Formulir Ibadah</span>
            <h1>Pendaftaran Jamaah</h1>
            <p>Lengkapi formulir di bawah ini untuk mendaftar secara online sebagai jamaah Elnair Travel.</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="registration-card">
            <form id="pendaftaranForm" action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <h3><span>1</span> Pilihan Paket</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Pilih Paket <span class="required">*</span></label>
                            <select name="package_id" id="package_id" class="form-control" required>
                                <option value="">-- Pilih Paket --</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>{{ $package->title }} ({{ $package->price_label }} {{ $package->price_value }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Jadwal Keberangkatan</label>
                            <select name="departure_schedule_id" id="departure_schedule_id" class="form-control">
                                <option value="">-- Pilih Jadwal (Opsional) --</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" data-package="{{ $schedule->package_id }}" {{ old('departure_schedule_id') == $schedule->id ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($schedule->departure_date)->format('d F Y') }} (Sisa {{ $schedule->available_seats }} seat)
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-hint">Jadwal akan diinfokan lebih lanjut jika dikosongkan.</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><span>2</span> Data Diri</h3>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                        <div class="form-group full-width">
                            <label>Nama Sesuai Passport</label>
                            <input type="text" name="passport_name" value="{{ old('passport_name') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin <span class="required">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nomor Induk Kependudukan (NIK) <span class="required">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir <span class="required">*</span></label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir <span class="required">*</span></label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Passport</label>
                            <input type="text" name="passport_number" value="{{ old('passport_number') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Masa Berlaku Passport</label>
                            <input type="date" name="passport_expiry" value="{{ old('passport_expiry') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Kota Domisili <span class="required">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor WhatsApp <span class="required">*</span></label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="form-control" required placeholder="08123456789">
                        </div>
                        <div class="form-group full-width">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><span>3</span> Upload Dokumen & Pembayaran</h3>
                    <div class="form-grid">
                        <div class="form-group file-group">
                            <label>Scan/Foto KTP</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="ktp_file" accept=".jpg,.jpeg,.png,.pdf" class="form-control-file">
                                <div class="file-upload-hint">Format JPG, PNG, PDF (Maks. 5MB)</div>
                            </div>
                        </div>
                        <div class="form-group file-group">
                            <label>Scan/Foto Passport</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="passport_file" accept=".jpg,.jpeg,.png,.pdf" class="form-control-file">
                                <div class="file-upload-hint">Format JPG, PNG, PDF (Maks. 5MB)</div>
                            </div>
                        </div>
                        <div class="form-group file-group">
                            <label>Scan/Foto Kartu Keluarga</label>
                            <div class="file-upload-wrapper">
                                <input type="file" name="kk_file" accept=".jpg,.jpeg,.png,.pdf" class="form-control-file">
                                <div class="file-upload-hint">Format JPG, PNG, PDF (Maks. 5MB)</div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn btn-gold submit-btn">
                        <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Kirim Pendaftaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Transitional Loading Screen Overlay -->
<div id="sacredLoader" class="sacred-loader-overlay" style="display: none;">
    <div class="sacred-loader-content">
        <!-- Elegant concentric pulsing rings -->
        <div class="sacred-spinner-container">
            <div class="sacred-ring outer"></div>
            <div class="sacred-ring middle"></div>
            <div class="sacred-ring inner"></div>
            <div class="sacred-icon-wrapper">
                <i class="fas fa-kaaba sacred-spinner-icon"></i>
            </div>
        </div>
        
        <h2 class="sacred-loader-title">Menyiapkan Perjalanan Suci</h2>
        <p class="sacred-loader-subtitle" id="sacredLoaderText">Memvalidasi data pendaftaran...</p>
        
        <div class="sacred-progress-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<style>
/* ── Registration Page Specific Styles ── */
.registration-section {
    padding: 140px 0 80px;
    background-color: var(--bg-silk);
    min-height: 100vh;
}

[data-theme="dark"] .registration-section {
    background-color: #0C1517;
}

.registration-container {
    max-width: 900px;
    margin: 0 auto;
}

.registration-header {
    text-align: center;
    margin-bottom: 3rem;
}

.registration-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem;
    color: var(--brand-dark);
    margin-bottom: 1rem;
    font-weight: 800;
}

[data-theme="dark"] .registration-header h1 {
    color: white;
}

.registration-header p {
    color: var(--text-dark);
    opacity: 0.8;
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.alert-success {
    background-color: #e8f5e9;
    color: #2e7d32;
    border-left: 5px solid #4caf50;
}

.alert-danger {
    background-color: #ffebee;
    color: #c62828;
    border-left: 5px solid #f44336;
}

.alert-danger ul {
    margin-top: 0.5rem;
    padding-left: 1.5rem;
}

.registration-card {
    background: var(--card-bg);
    color: var(--text-dark);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow-elite);
    border: 1px solid rgba(139,94,60,0.08);
}

.form-section {
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 1px dashed rgba(139,94,60,0.2);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 2rem;
    padding-bottom: 0;
}

.form-section h3 {
    font-size: 1.4rem;
    color: var(--brand-teal);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 12px;
    font-family: 'Playfair Display', serif;
}

.form-section h3 span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: var(--brand-teal);
    color: #fff;
    border-radius: 50%;
    font-size: 1rem;
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.required {
    color: #e74c3c;
}

.form-control {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    font-family: 'Outfit', sans-serif;
    font-size: 1rem;
    color: #333;
    transition: all 0.3s ease;
    background: #fdfdfd;
}

[data-theme="dark"] .form-control {
    border-color: rgba(255,255,255,0.1);
    background: #1a2c2b;
    color: #fff;
}

.form-control:focus {
    outline: none;
    border-color: var(--brand-teal);
    box-shadow: 0 0 0 3px rgba(102, 165, 173, 0.25);
    background: #fff;
}

[data-theme="dark"] .form-control:focus {
    background: #1c3230;
}

.form-control::placeholder {
    color: #aaa;
}

.form-hint {
    display: block;
    margin-top: 6px;
    font-size: 0.85rem;
    color: #777;
}

[data-theme="dark"] .form-hint {
    color: #8da4a6;
}

/* File Upload Styling */
.file-upload-wrapper {
    position: relative;
    border: 2px dashed #e0e0e0;
    border-radius: 12px;
    padding: 1.5rem 1rem;
    text-align: center;
    transition: all 0.3s ease;
    background: #fafafa;
}

[data-theme="dark"] .file-upload-wrapper {
    border-color: rgba(255,255,255,0.15);
    background: #182827;
}

.file-upload-wrapper:hover, .file-upload-wrapper:focus-within {
    border-color: var(--brand-teal);
    background: rgba(102, 165, 173, 0.02);
}

[data-theme="dark"] .file-upload-wrapper:hover, [data-theme="dark"] .file-upload-wrapper:focus-within {
    background: rgba(102, 165, 173, 0.05);
}

.form-control-file {
    width: 100%;
    cursor: pointer;
}

[data-theme="dark"] .form-control-file {
    color: #ccc;
}

.form-control-file::file-selector-button {
    background: var(--brand-dark);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    margin-right: 15px;
    transition: background 0.3s;
}

.form-control-file::file-selector-button:hover {
    background: var(--brand-gold);
}

.file-upload-hint {
    margin-top: 10px;
    font-size: 0.85rem;
    color: #666;
}

[data-theme="dark"] .file-upload-hint {
    color: #999;
}

.form-submit {
    text-align: center;
    margin-top: 1rem;
}

.submit-btn {
    font-size: 1.1rem;
    padding: 18px 40px;
    width: auto;
    min-width: 250px;
    justify-content: center;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .registration-card {
        padding: 2rem 1.25rem;
        border-radius: 15px;
    }
    .form-grid {
        grid-template-columns: 1fr;
        gap: 1.2rem;
    }
    .registration-header h1 {
        font-size: 2.2rem;
    }
    .registration-section {
        padding: 120px 0 60px !important;
    }
    .submit-btn {
        width: 100%;
    }
}

/* ── Sacred Loader Overlay Styles ── */
.sacred-loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: radial-gradient(circle, #0c2b2e 0%, #041214 100%);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.sacred-loader-overlay.active {
    opacity: 1;
}

.sacred-loader-content {
    text-align: center;
    max-width: 500px;
    padding: 2rem;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Concentric Rings Spinner */
.sacred-spinner-container {
    position: relative;
    width: 120px;
    height: 120px;
    margin-bottom: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sacred-ring {
    position: absolute;
    border-radius: 50%;
    border: 2.5px solid transparent;
}

.sacred-ring.outer {
    width: 120px;
    height: 120px;
    border-top-color: var(--brand-gold);
    animation: spin 2.5s linear infinite;
}

.sacred-ring.middle {
    width: 96px;
    height: 96px;
    border-bottom-color: var(--brand-teal);
    animation: spin-reverse 2s linear infinite;
}

.sacred-ring.inner {
    width: 72px;
    height: 72px;
    border-left-color: var(--brand-gold);
    animation: spin 1.2s linear infinite;
}

.sacred-icon-wrapper {
    position: absolute;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle, #153c3d 0%, #0d2122 100%);
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(139, 94, 60, 0.4);
}

.sacred-spinner-icon {
    font-size: 1.6rem;
    color: var(--brand-gold);
    animation: pulse-icon 1.8s ease-in-out infinite;
}

.sacred-loader-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    color: #fff;
    margin-bottom: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.sacred-loader-subtitle {
    font-family: 'Outfit', sans-serif;
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.75);
    margin-bottom: 2rem;
    font-weight: 400;
    letter-spacing: 0.5px;
    transition: opacity 0.2s ease;
    min-height: 24px;
}

/* Elegant Pulsing Dots */
.sacred-progress-dots {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.sacred-progress-dots span {
    width: 6px;
    height: 6px;
    background-color: var(--brand-gold);
    border-radius: 50%;
    opacity: 0.3;
    animation: dot-pulse 1.4s infinite ease-in-out both;
}

.sacred-progress-dots span:nth-child(1) {
    animation-delay: -0.32s;
}

.sacred-progress-dots span:nth-child(2) {
    animation-delay: -0.16s;
}

/* Animations */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes spin-reverse {
    0% { transform: rotate(360deg); }
    100% { transform: rotate(0deg); }
}

@keyframes pulse-icon {
    0%, 100% {
        transform: scale(1);
        text-shadow: 0 0 5px rgba(139, 94, 60, 0.5);
    }
    50% {
        transform: scale(1.15);
        text-shadow: 0 0 15px rgba(139, 94, 60, 0.9);
    }
}

@keyframes dot-pulse {
    0%, 80%, 100% { transform: scale(0.6); opacity: 0.3; }
    40% { transform: scale(1); opacity: 1; }
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .sacred-loader-title {
        font-size: 1.6rem;
    }
    .sacred-loader-subtitle {
        font-size: 0.95rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageSelect = document.getElementById('package_id');
    const scheduleSelect = document.getElementById('departure_schedule_id');
    
    if (packageSelect && scheduleSelect) {
        // Store original options
        const originalOptions = Array.from(scheduleSelect.options).filter(opt => opt.value !== "");

        function filterSchedules() {
            const selectedPackage = packageSelect.value;
            
            // Clear current options except the placeholder
            scheduleSelect.innerHTML = '<option value="">-- Pilih Jadwal (Opsional) --</option>';
            
            if (selectedPackage) {
                // Add options that match the selected package
                const matchingOptions = originalOptions.filter(opt => opt.dataset.package === selectedPackage);
                matchingOptions.forEach(opt => {
                    scheduleSelect.add(opt.cloneNode(true));
                });
                
                // Re-select if there was an old value that matches
                const oldScheduleId = "{{ old('departure_schedule_id') }}";
                if (oldScheduleId) {
                    const optionToSelect = Array.from(scheduleSelect.options).find(opt => opt.value === oldScheduleId);
                    if (optionToSelect) optionToSelect.selected = true;
                }
            } else {
                // If no package selected, show all (or could keep it empty)
                originalOptions.forEach(opt => {
                    scheduleSelect.add(opt.cloneNode(true));
                });
            }
        }

        // Run on load
        filterSchedules();

        // Run on change
        packageSelect.addEventListener('change', filterSchedules);
    }

    // Form submit transitional loader handler
    const regForm = document.getElementById('pendaftaranForm');
    if (regForm) {
        regForm.addEventListener('submit', function(e) {
            // Check HTML5 validity
            if (!regForm.checkValidity()) {
                return;
            }
            
            // Disable submit button to prevent duplicate-submitting
            const submitBtn = regForm.querySelector('.submit-btn');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin" style="margin-right: 8px;"></i> Memproses Pendaftaran...';
            }
            
            // Display full-screen loader overlay
            const loader = document.getElementById('sacredLoader');
            if (loader) {
                loader.style.display = 'flex';
                // Trigger reflow & fade in
                setTimeout(() => {
                    loader.classList.add('active');
                }, 10);
            }
            
            // Periodically cycle through beautiful, spiritual, progress messages
            const loaderText = document.getElementById('sacredLoaderText');
            const phases = [
                "Memvalidasi data pendaftaran...",
                "Mengunggah berkas identitas & dokumen...",
                "Membuat akun & mengamankan kredensial...",
                "Menyiapkan berkas pendaftaran...",
                "Menghubungkan ke Portal Jemaah Elnair...",
                "Hampir selesai, memuat Dashboard Jemaah..."
            ];
            let currentPhase = 0;
            const textInterval = setInterval(() => {
                currentPhase++;
                if (currentPhase < phases.length) {
                    if (loaderText) {
                        loaderText.style.opacity = 0;
                        setTimeout(() => {
                            loaderText.textContent = phases[currentPhase];
                            loaderText.style.opacity = 1;
                        }, 200);
                    }
                } else {
                    clearInterval(textInterval);
                }
            }, 1800);
        });
    }
});
</script>
@endsection
