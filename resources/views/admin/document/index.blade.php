@extends('admin.layouts.app')

@section('title', 'Dokumen & Visa Jemaah')
@section('page_title', 'Manajemen Dokumen Jemaah')

@section('content')
<div class="admin-card">
    <div style="margin-bottom: 2rem;">
        <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);"><i class="fas fa-file-signature" style="color: var(--brand-gold);"></i> Dokumen Persyaratan & Visa</h3>
        <p style="color: #666; font-size: 0.9rem;">Verifikasi kelengkapan berkas jemaah (KTP, KK, Paspor, Vaksin, Pas Foto) serta pantau masa kadaluwarsa paspor.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
            <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Jemaah</th>
                    <th>No. Paspor / Kadaluwarsa</th>
                    <th>Kelengkapan Berkas</th>
                    <th>Status Visa</th>
                    <th>Status Jemaah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jamaahs as $jamaah)
                <tr>
                    <td style="font-weight: 600; color: var(--brand-dark);">
                        {{ $jamaah->name }}
                        <br>
                        <small style="color: #888;">Grup: {{ $jamaah->group->name ?? 'Belum Masuk Grup' }}</small>
                    </td>
                    <td>
                        @if($jamaah->passport_number)
                            <code>{{ $jamaah->passport_number }}</code>
                            <br>
                            <small style="color: #666;">Exp: {{ \Carbon\Carbon::parse($jamaah->passport_expiry)->format('d M Y') }}</small>
                            
                            @if($jamaah->passport_warning)
                                <div style="display: inline-flex; align-items: center; gap: 4px; background: rgba(220, 38, 38, 0.1); color: #dc2626; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 0.75rem; margin-top: 4px;">
                                    <i class="fas fa-exclamation-triangle"></i> Exp &lt; 6 Bulan (Sisa {{ $jamaah->days_until_expiry }} Hari)
                                </div>
                            @endif
                        @else
                            <span style="color: #bbb; font-style: italic;">Paspor Belum Diisi</span>
                        @endif
                    </td>
                    <td>
                        <!-- Document upload status icons -->
                        <div style="display: flex; gap: 0.4rem; font-size: 0.85rem; font-weight: 600; flex-wrap: wrap;">
                            <span style="padding: 2px 6px; border-radius: 4px; background: {{ $jamaah->ktp_file ? 'rgba(22, 163, 74, 0.1)' : '#eee' }}; color: {{ $jamaah->ktp_file ? '#16a34a' : '#888' }};">
                                KTP
                            </span>
                            <span style="padding: 2px 6px; border-radius: 4px; background: {{ $jamaah->passport_file ? 'rgba(22, 163, 74, 0.1)' : '#eee' }}; color: {{ $jamaah->passport_file ? '#16a34a' : '#888' }};">
                                Paspor
                            </span>
                            <span style="padding: 2px 6px; border-radius: 4px; background: {{ $jamaah->kk_file ? 'rgba(22, 163, 74, 0.1)' : '#eee' }}; color: {{ $jamaah->kk_file ? '#16a34a' : '#888' }};">
                                KK
                            </span>
                            <span style="padding: 2px 6px; border-radius: 4px; background: {{ $jamaah->vaccine_file ? 'rgba(22, 163, 74, 0.1)' : '#eee' }}; color: {{ $jamaah->vaccine_file ? '#16a34a' : '#888' }};">
                                Vaksin
                            </span>
                            <span style="padding: 2px 6px; border-radius: 4px; background: {{ $jamaah->photo_file ? 'rgba(22, 163, 74, 0.1)' : '#eee' }}; color: {{ $jamaah->photo_file ? '#16a34a' : '#888' }};">
                                Foto
                            </span>
                        </div>
                    </td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
                            @if($jamaah->visa_status === 'Issued')
                                background: rgba(22, 163, 74, 0.1); color: #16a34a;
                            @elseif($jamaah->visa_status === 'Visa Process')
                                background: rgba(234, 179, 8, 0.1); color: #ca8a04;
                            @else
                                background: #eee; color: #666;
                            @endif
                        ">
                            {{ $jamaah->visa_status }}
                        </span>
                    </td>
                    <td>
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; background: rgba(13, 76, 84, 0.08); color: var(--brand-dark);">
                            {{ $jamaah->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.documents.show', $jamaah->id) }}" class="btn-admin-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="fas fa-edit"></i> Kelola Berkas
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #888; padding: 2.5rem;">
                        Belum ada data jemaah terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $jamaahs->links() }}
    </div>
</div>
@endsection
