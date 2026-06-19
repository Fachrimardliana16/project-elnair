@extends('landing.jemaah.layout')

@section('portal-content')
<div class="portal-card" style="padding: 2.5rem;">
    <div style="border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 2rem;">
        <h4 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-folder-open" style="color: var(--brand-gold);"></i> Kelola Dokumen Wajib
        </h4>
        <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px;">Unggah dan lengkapi berkas persyaratan administrasi keberangkatan Umrah Anda di bawah ini.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="background: rgba(231, 76, 60, 0.12); border: 1px solid rgba(231, 76, 60, 0.2); color: #c0392b; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; font-size: 0.9rem;">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display: grid; gap: 2rem;">

        @php
            $docs = [
                [
                    'key' => 'ktp_file',
                    'name' => 'Kartu Tanda Penduduk (KTP)',
                    'desc' => 'Foto KTP asli berwarna dengan pencahayaan terang dan tulisan terbaca jelas.',
                    'icon' => 'far fa-id-card',
                ],
                [
                    'key' => 'kk_file',
                    'name' => 'Kartu Keluarga (KK)',
                    'desc' => 'Foto/Scan KK berwarna untuk memverifikasi hubungan keluarga dan manifest rombongan.',
                    'icon' => 'fas fa-users',
                ],
                [
                    'key' => 'passport_file',
                    'name' => 'Dokumen Passport',
                    'desc' => 'Scan halaman pertama paspor yang menampilkan foto diri dan masa berlaku secara utuh.',
                    'icon' => 'fas fa-passport',
                ],
                [
                    'key' => 'vaccine_file',
                    'name' => 'Sertifikat Vaksin Meningitis',
                    'desc' => 'Sertifikat resmi vaksin meningitis (Buku Kuning / ICV) yang masih berlaku.',
                    'icon' => 'fas fa-syringe',
                ],
                [
                    'key' => 'photo_file',
                    'name' => 'Pasfoto Ukuran 4x6',
                    'desc' => 'Pasfoto background putih, fokus wajah 80% tanpa kacamata.',
                    'icon' => 'far fa-image',
                ],
            ];
        @endphp

        @foreach($docs as $doc)
            @php
                $filePath = $jemaah->{$doc['key']};
                $isUploaded = !empty($filePath);
                $fileUrl = $isUploaded ? asset('storage/' . $filePath) : null;
                $ext = $isUploaded ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : '';
                $isPdf = $ext === 'pdf';
            @endphp
            <div style="background: var(--bg-muted); border: 1px solid {{ $isUploaded ? 'rgba(46,204,113,0.25)' : 'var(--border-muted)' }}; padding: 1.5rem; border-radius: 16px;">

                {{-- Top Row: Icon, Title, Status, Upload Button --}}
                <div style="display: flex; gap: 18px; align-items: flex-start; flex-wrap: wrap;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ $isUploaded ? 'rgba(46,204,113,0.12)' : 'var(--card-sub-bg)' }}; border: 1px solid {{ $isUploaded ? 'rgba(46,204,113,0.2)' : 'var(--card-sub-border)' }}; color: {{ $isUploaded ? '#27ae60' : 'var(--portal-title-color)' }}; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0;">
                        <i class="{{ $doc['icon'] }}"></i>
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            <strong style="font-size: 1.05rem; color: var(--portal-title-color);">{{ $doc['name'] }}</strong>
                            @if($isUploaded)
                                <span style="background: rgba(46, 204, 113, 0.12); color: #27ae60; font-size: 0.7rem; padding: 2px 10px; border-radius: 50px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-check"></i> Lengkap
                                </span>
                            @else
                                <span style="background: rgba(230, 126, 34, 0.12); color: #e67e22; font-size: 0.7rem; padding: 2px 10px; border-radius: 50px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-exclamation-triangle"></i> Belum Lengkap
                                </span>
                            @endif
                        </div>
                        <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 4px; line-height: 1.5; max-width: 500px;">{{ $doc['desc'] }}</p>
                    </div>
                    {{-- Upload Form --}}
                    <div style="flex-shrink: 0;">
                        <form action="{{ route('jemaah.documents.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="document_type" value="{{ $doc['key'] }}">
                            <label style="border: 1px solid var(--portal-title-color); color: var(--portal-title-color); padding: 0.6rem 1.2rem; font-size: 0.8rem; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; background: transparent; transition: all 0.2s; margin: 0; box-shadow: none; font-weight: 600;">
                                <i class="fas fa-{{ $isUploaded ? 'sync-alt' : 'file-upload' }}"></i> {{ $isUploaded ? 'Ganti File' : 'Pilih File' }}
                                <input type="file" name="file" onchange="this.form.submit()" style="display: none;" required>
                            </label>
                        </form>
                        <small style="display: block; color: var(--text-muted); font-size: 0.72rem; margin-top: 5px; text-align: right;">Format: JPG, PNG, PDF (Maks. 5MB)</small>
                    </div>
                </div>

                {{-- Inline Document Preview --}}
                @if($isUploaded)
                    <div style="margin-top: 1.25rem; border-top: 1px dashed rgba(0,0,0,0.08); padding-top: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <span style="font-size: 0.78rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="fas fa-eye" style="margin-right: 4px; color: var(--brand-gold);"></i> Pratinjau Berkas Terunggah
                            </span>
                            <a href="{{ $fileUrl }}" target="_blank" style="font-size: 0.78rem; font-weight: 700; color: var(--brand-gold); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                            </a>
                        </div>

                        @if($isPdf)
                            {{-- PDF Inline Viewer using iframe --}}
                            <div style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(0,0,0,0.08);">
                                <iframe
                                    src="{{ $fileUrl }}"
                                    style="width: 100%; height: 420px; border: none; display: block; background: #f9f9f9;"
                                    title="Pratinjau {{ $doc['name'] }}"
                                    loading="lazy">
                                    <p>Browser Anda tidak mendukung iframe untuk PDF.
                                        <a href="{{ $fileUrl }}" target="_blank">Klik untuk membuka PDF.</a>
                                    </p>
                                </iframe>
                            </div>
                        @else
                            {{-- Image inline preview --}}
                            <div style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(0,0,0,0.08); background: rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: center; min-height: 180px; max-height: 500px;">
                                <img
                                    src="{{ $fileUrl }}"
                                    alt="Pratinjau {{ $doc['name'] }}"
                                    style="max-width: 100%; max-height: 500px; object-fit: contain; display: block; border-radius: 10px;"
                                    loading="lazy">
                            </div>
                        @endif
                    </div>
                @endif

            </div>
        @endforeach

    </div>
</div>
@endsection
