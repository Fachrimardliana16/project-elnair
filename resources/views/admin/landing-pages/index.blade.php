@extends('admin.layouts.app')
@section('title', 'Landing Pages')
@section('page_title', 'Sales Landing Pages')

@section('content')
<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h3 style="margin: 0;">Landing Pages</h3>
        <a href="{{ route('admin.landing-pages.create') }}" class="btn-admin"><i class="fas fa-plus"></i> Create Landing Page</a>
    </div>

    <div class="table-responsive">
    <table style="width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px;">
        <thead>
            <tr style="background-color: #f8f9fc;">
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center; width: 60px;">Status</th>
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Info Halaman</th>
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Auto-URL for Ads</th>
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Koneksi WA</th>
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Status Pixel</th>
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Last Edited</th>
                <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; {{ !$page->is_active ? 'opacity: 0.75; background: #fafafa;' : '' }}">
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                    <form action="{{ route('admin.landing-pages.toggle', $page->id) }}" method="POST" style="margin: 0; display: flex; justify-content: center; align-items: center;" title="Toggle Aktif/Non-Aktif">
                        @csrf
                        <label style="position: relative; display: inline-block; width: 38px; height: 22px; margin: 0; cursor: pointer;">
                            <input type="checkbox" onchange="this.form.submit()" {{ $page->is_active ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0; position: absolute;">
                            <span style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: {{ $page->is_active ? '#22c55e' : '#cbd5e1' }}; transition: .3s; border-radius: 20px;">
                            <span style="position: absolute; height: 16px; width: 16px; left: 3px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%; transform: {{ $page->is_active ? 'translateX(16px)' : 'translateX(0)' }}; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"></span>
                            </span>
                        </label>
                    </form>
                </td>
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; gap: 15px; align-items: center;">
                        @if($page->hero_image)
                            <img src="{{ asset($page->hero_image) }}" alt="Preview" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #e2e8f0;">
                        @else
                            <div style="width: 70px; height: 70px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-size: 1.5rem; border: 1px dashed #cbd5e1;">
                                <i class="fas fa-image"></i>
                            </div>
                        @endif
                        <div>
                            <strong style="color: #0D4C54; font-size: 1.05rem; display: block; margin-bottom: 4px;">{{ $page->title }}</strong>
                            <span style="color: #64748b; font-size: 0.85rem;"><i class="fas fa-link" style="margin-right: 5px;"></i>/{{ $page->slug }}</span>
                        </div>
                    </div>
                </td>
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; background: #f8f9fc; padding: 5px; border-radius: 6px; border: 1px solid #e2e8f0;">
                        <input type="text" value="{{ route('landing.page', $page->slug) }}" style="font-size: 0.75rem; padding: 0.3rem; border: none; background: transparent; width: 100%; color: #475569; outline: none;" readonly>
                        <button onclick="copyToClipboard(this)" style="background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; cursor: pointer; color: #0D4C54; padding: 4px 8px; transition: all 0.2s;" title="Copy URL"><i class="fas fa-copy"></i></button>
                    </div>
                </td>
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                    @if($page->custom_wa_number)
                        <span style="background-color: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block;">
                            <i class="fab fa-whatsapp"></i> {{ $page->custom_wa_number }}
                        </span>
                    @else
                        <span style="color: #94a3b8; font-size: 0.8rem; font-style: italic;">Default (Pusat)</span>
                    @endif
                </td>
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: left; vertical-align: top;">
                    @if(is_array($page->fb_pixel_events) && count($page->fb_pixel_events) > 0)
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach($page->fb_pixel_events as $event)
                            @if(!empty($event['event_name']))
                                <div style="background-color: #eff6ff; padding: 6px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                    <div style="color: #1e40af; font-size: 0.8rem; font-weight: 700; margin-bottom: 3px;">
                                        <i class="fas fa-satellite-dish" style="margin-right: 3px;"></i> {{ $event['event_name'] }}
                                    </div>
                                    @if(!empty($event['params']))
                                        <div style="display: flex; flex-wrap: wrap; gap: 3px;">
                                            @foreach($event['params'] as $p)
                                                @if(!empty($p['key']) && isset($p['value']))
                                                    <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; border: 1px solid #93c5fd;">
                                                        <span style="opacity: 0.7;">{{ $p['key'] }}:</span> <strong>{{ $p['value'] }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span style="color: #94a3b8; font-size: 0.65rem; font-style: italic;">(Tanpa Parameter)</span>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        </div>
                    @elseif(!empty($page->ad_event_name))
                        <div style="text-align: left; margin-top: 5px;">
                            <div style="background-color: #eff6ff; padding: 6px; border-radius: 6px; border: 1px solid #bfdbfe;">
                                <div style="color: #1e40af; font-size: 0.8rem; font-weight: 700; margin-bottom: 3px;">
                                    <i class="fas fa-satellite-dish" style="margin-right: 3px;"></i> {{ $page->ad_event_name }}
                                </div>
                                <span style="color: #94a3b8; font-size: 0.65rem; font-style: italic;">(Legacy Tanpa Parameter)</span>
                            </div>
                        </div>
                    @else
                        <div style="text-align: center; margin-top: 10px;">
                            <span style="background-color: #f1f5f9; color: #64748b; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block;">
                                <i class="fas fa-eye-slash"></i> No Pixel
                            </span>
                        </div>
                    @endif
                </td>
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                    <span style="color: #475569; font-size: 0.85rem;">{{ $page->updated_at->diffForHumans() }}</span>
                </td>
                <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                    <div style="display: flex; gap: 0.8rem; align-items: center; justify-content: center;">
                        <a href="{{ route('landing.page', $page->slug) }}" target="_blank" style="color: #27ae60; background: #e6f6ec; padding: 6px 10px; border-radius: 6px; transition: all 0.2s;" title="Lihat Halaman" onmouseover="this.style.background='#ccece0'" onmouseout="this.style.background='#e6f6ec'"><i class="fas fa-external-link-alt"></i></a>
                        <button onclick="openEmbedModal('{{ $page->title }}', '{{ $page->slug }}', '{{ route('landing.store-lead', $page->slug) }}')" style="color: #8b5e3c; background: #fffbeb; padding: 6px 10px; border: none; border-radius: 6px; transition: all 0.2s; cursor: pointer;" title="Dapatkan HTML Embed Form" onmouseover="this.style.background='#fef3c7'" onmouseout="this.style.background='#fffbeb'"><i class="fas fa-code"></i></button>
                        <a href="{{ route('admin.landing-pages.edit', $page->id) }}" style="color: #4a90e2; background: #ebf4fc; padding: 6px 10px; border-radius: 6px; transition: all 0.2s;" title="Edit Halaman" onmouseover="this.style.background='#d6e8f9'" onmouseout="this.style.background='#ebf4fc'"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.landing-pages.destroy', $page->id) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #fce8e6; border: none; color: #e74c3c; cursor: pointer; padding: 6px 10px; border-radius: 6px; transition: all 0.2s;" title="Hapus Halaman" onmouseover="this.style.background='#fad1cd'" onmouseout="this.style.background='#fce8e6'" onclick="return confirm('Yakin ingin menghapus Landing Page ini?');"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<!-- HTML Form Embed Modal (NEW!) -->
<div id="embedModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px); align-items: center; justify-content: center;">
    <div style="background-color: #fff; border-radius: 12px; max-width: 600px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); border-top: 5px solid #0D4C54; animation: modalFadeIn 0.3s ease-out; margin: auto;">
        <!-- Header -->
        <div style="padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #0D4C54; font-size: 1.15rem; display: flex; align-items: center; gap: 8px;"><i class="fas fa-code"></i> Integrasi & Embed HTML Form</h3>
            <button onclick="closeEmbedModal()" style="background: transparent; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer; line-height: 1;"><i class="fas fa-times"></i></button>
        </div>
        <!-- Body -->
        <div style="padding: 24px;">
            <p style="font-size: 0.82rem; color: #475569; margin-top: 0; margin-bottom: 1.2rem; line-height: 1.5;">
                Gunakan kode HTML di bawah ini untuk disematkan (embed) pada website external Anda (Elementor, WordPress, atau custom HTML). Formulir ini secara otomatis akan mengirimkan prospek langsung ke database CRM Elnair!
            </p>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.8rem; font-weight: bold; color: #1e293b; margin-bottom: 6px;">Kode Integrasi HTML Form:</label>
                <textarea id="embedCodeArea" style="width: 100%; height: 180px; font-family: monospace; font-size: 0.72rem; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; background-color: #0f172a; color: #38bdf8; resize: none;" readonly></textarea>
            </div>

            <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; padding: 12px; border-radius: 8px; font-size: 0.75rem; color: #1e40af; line-height: 1.4; display: flex; gap: 8px;">
                <i class="fas fa-info-circle" style="font-size: 1.1rem; margin-top: 2px;"></i>
                <div>
                    <strong>Penting untuk Marketer:</strong>
                    <ul style="margin: 4px 0 0 0; padding-left: 1.2rem;">
                        <li>Input wajib memiliki atribut <code>name="name"</code> and <code>name="whatsapp"</code>.</li>
                        <li>Form akan mengarahkan user otomatis ke WhatsApp CRM setelah pengisian berhasil!</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div style="padding: 15px 20px; background-color: #f8fafc; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #f1f5f9;">
            <button onclick="closeEmbedModal()" style="background-color: #e2e8f0; color: #475569; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.8rem;">Tutup</button>
            <button onclick="copyEmbedCode()" style="background-color: #0D4C54; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.8rem; display: flex; align-items: center; gap: 6px;"><i class="fas fa-copy"></i> Salin Kode</button>
        </div>
    </div>
</div>

<style>
    /* Tambahan efek hover untuk tabel */
    tbody tr:hover {
        background-color: #f8fafc;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<script>
function copyToClipboard(btn) {
    const input = btn.previousElementSibling;
    input.select();
    document.execCommand('copy');
    alert('URL copied to clipboard!');
}

function openEmbedModal(title, slug, postUrl) {
    const embedCode = `<!-- Elnair Lead Capture Form Embed (Halaman: ${title}) -->
<form action="${postUrl}" method="POST" style="font-family: 'Outfit', sans-serif; max-width: 450px; margin: auto; padding: 25px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #ffffff; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
    <h3 style="margin-top: 0; margin-bottom: 20px; color: #0D4C54; text-align: center; font-size: 1.25rem;">Formulir Pendaftaran</h3>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: bold; color: #475569;">Nama Lengkap:</label>
        <input type="text" name="name" required placeholder="Contoh: Budi Santoso" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#0D4C54'">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: bold; color: #475569;">Nomor WhatsApp:</label>
        <input type="tel" name="whatsapp" required placeholder="Contoh: 08123456789" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#0D4C54'">
    </div>

    <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 6px; font-size: 0.85rem; font-weight: bold; color: #475569;">Pesan/Catatan (Opsional):</label>
        <textarea name="notes" placeholder="Tuliskan catatan atau pertanyaan..." style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; height: 80px; resize: vertical; outline: none; transition: border 0.2s;" onfocus="this.style.borderColor='#0D4C54'"></textarea>
    </div>
    
    <button type="submit" style="width: 100%; padding: 12px; background-color: #0D4C54; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#0a393e'" onmouseout="this.style.backgroundColor='#0D4C54'">Kirim ke WhatsApp CRM</button>
</form>`;

    document.getElementById('embedCodeArea').value = embedCode;
    const modal = document.getElementById('embedModal');
    modal.style.display = 'flex';
}

function closeEmbedModal() {
    document.getElementById('embedModal').style.display = 'none';
}

function copyEmbedCode() {
    const area = document.getElementById('embedCodeArea');
    area.select();
    document.execCommand('copy');
    alert('HTML Embed Code copied to clipboard!');
}
</script>
@endsection
