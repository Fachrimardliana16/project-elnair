@extends('admin.layouts.app')

@section('title', 'Detail Grup Keberangkatan')
@section('page_title', 'Detail Grup Keberangkatan')

@section('styles')
<style>
    .grid-left {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    @media (max-width: 992px) {
        .grid-left {
            grid-template-columns: 1fr;
        }
    }
    .badge-primary {
        background: rgba(13, 76, 84, 0.1);
        color: var(--brand-dark);
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-gold {
        background: rgba(139, 94, 60, 0.1);
        color: var(--brand-gold);
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>
@endsection

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.groups.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Grup
    </a>
</div>

@if(session('success'))
    <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(220, 38, 38, 0.1); color: #dc2626; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
        <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i> {{ session('error') }}
    </div>
@endif

<div class="grid-left">
    <!-- Left Column: Manifest & Rooms -->
    <div>
        <!-- Manifest Card -->
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);"><i class="fas fa-clipboard-list" style="color: var(--brand-gold);"></i> Manifest Rombongan Jemaah</h3>
                    <p style="color: #666; font-size: 0.85rem;">Daftar seluruh jemaah yang masuk dalam grup keberangkatan ini.</p>
                </div>
                <a href="{{ route('admin.groups.export-manifest', $group->id) }}" class="btn-admin" style="background: #16a34a; font-size: 0.85rem; padding: 0.6rem 1.2rem;">
                    <i class="fas fa-file-pdf"></i> Ekspor PDF Manifest
                </a>
            </div>

            <!-- Form Add Jamaah to Group (Bulk Enabled) -->
            <div style="background: #fdfcfa; border: 1px solid var(--brand-beige); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-users-cog" style="color: var(--brand-gold);"></i> Tambah Jemaah ke Rombongan (Bulk Add)
                </h4>
                <p style="color: #666; font-size: 0.82rem; margin-bottom: 0.75rem;">Centang beberapa jemaah terdaftar di tanggal keberangkatan ini untuk dimasukkan sekaligus.</p>
                
                @if($pendingJamaahsCount > 0)
                    <div style="background: rgba(234, 179, 8, 0.05); border: 1px solid rgba(234, 179, 8, 0.18); color: #ca8a04; padding: 0.65rem 0.85rem; border-radius: 8px; font-size: 0.78rem; font-weight: 500; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px; line-height: 1.4;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 0.9rem; flex-shrink: 0;"></i>
                        <span>Terdapat <strong>{{ $pendingJamaahsCount }} jemaah</strong> pada jadwal keberangkatan ini yang masih berstatus <em>Pending</em> (administrasi & pembayaran belum selesai) sehingga disembunyikan dari pilihan rombongan.</span>
                    </div>
                @endif

                @php
                    $unassignedList = $availableJamaahs->filter(fn($aj) => $aj->group_id != $group->id);
                @endphp

                @if($unassignedList->isNotEmpty())
                    <form action="{{ route('admin.groups.add-jamaah', $group->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 0.85rem; display: flex; align-items: center; gap: 8px;">
                            <input type="checkbox" id="checkAllJamaahs" style="cursor: pointer; width: 16px; height: 16px;">
                            <label for="checkAllJamaahs" style="font-weight: 700; font-size: 0.85rem; color: var(--brand-dark); cursor: pointer; margin-bottom: 0; user-select: none;">Centang Semua Jemaah</label>
                        </div>
                        
                        <div style="max-height: 180px; overflow-y: auto; border: 1px solid rgba(139,94,60,0.12); border-radius: 8px; padding: 0.75rem; background: #fff; margin-bottom: 1rem;">
                            @foreach($unassignedList as $aj)
                                <div style="display: flex; align-items: center; gap: 10px; padding: 0.45rem 0; border-bottom: 1px dashed rgba(0,0,0,0.03);">
                                    <input type="checkbox" name="jamaah_ids[]" value="{{ $aj->id }}" id="jamaah_chk_{{ $aj->id }}" class="jamaah-checkbox-item" style="cursor: pointer; width: 15px; height: 15px;">
                                    <label for="jamaah_chk_{{ $aj->id }}" style="font-size: 0.85rem; color: #333; cursor: pointer; margin-bottom: 0; font-weight: 600; user-select: none;">
                                        {{ $aj->name }} <span style="font-weight: 400; color: #777;">(Paspor: {{ $aj->passport_number ?? 'Belum ada' }} | Tipe Kamar: {{ $aj->room_type }} | {{ $aj->gender ?? 'Laki-laki' }})</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="submit" class="btn-admin" style="padding: 0.55rem 1.5rem; font-size: 0.85rem;">
                            <i class="fas fa-plus-circle"></i> Masukkan Jemaah Terpilih
                        </button>
                    </form>
                @else
                    <div style="background: rgba(139,94,60,0.04); padding: 1rem; border-radius: 8px; border: 1px dashed var(--brand-beige); text-align: center; color: #888; font-size: 0.85rem;">
                        <i class="fas fa-info-circle"></i> Tidak ada jemaah unassigned pada tanggal keberangkatan ini.
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Jemaah</th>
                            <th>No. Paspor / Kadaluwarsa</th>
                            <th>Tipe Kamar</th>
                            <th>No. WA</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($group->jamaahs as $jamaah)
                        <tr>
                            <td style="font-weight: 600; color: var(--brand-dark);">
                                {{ $jamaah->name }}
                                <br>
                                <small style="color: #666;">NIK: {{ $jamaah->nik ?? '-' }}</small>
                            </td>
                            <td>
                                @if($jamaah->passport_number)
                                    <code>{{ $jamaah->passport_number }}</code>
                                    <br>
                                    <small style="color: #888;">Exp: {{ \Carbon\Carbon::parse($jamaah->passport_expiry)->format('d M Y') }}</small>
                                @else
                                    <span style="color: #bbb;">Belum upload paspor</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-primary">{{ $jamaah->room_type }}</span>
                            </td>
                            <td>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $jamaah->whatsapp) }}" target="_blank" style="color: #16a34a; font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                                    <i class="fab fa-whatsapp"></i> {{ $jamaah->whatsapp }}
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.groups.remove-jamaah', [$group->id, $jamaah->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan jemaah ini dari rombongan?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #dc2626; background: rgba(220, 38, 38, 0.05); border: 1px solid rgba(220, 38, 38, 0.2); padding: 4px 8px; border-radius: 6px; cursor: pointer; font-size: 0.8rem; font-weight: 600;">
                                        <i class="fas fa-user-minus"></i> Keluarkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 2.5rem;">
                                Belum ada jemaah yang masuk dalam rombongan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rooming List Card -->
        <div class="admin-card">
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 0.5rem;"><i class="fas fa-hotel" style="color: var(--brand-gold);"></i> Rooming List Rombongan</h3>
            <p style="color: #666; font-size: 0.85rem; margin-bottom: 1.5rem;">Kelola pembagian penempatan kamar hotel Makkah & Madinah bagi jemaah rombongan ini.</p>

            <!-- Auto Room Allocation Panel -->
            <div style="background: rgba(13, 76, 84, 0.03); border: 1px solid var(--brand-beige); padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.98rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-magic" style="color: var(--brand-gold);"></i> Distribusi & Bagi Kamar Otomatis (Cerdas)
                </h4>
                <p style="color: #666; font-size: 0.82rem; margin-bottom: 1rem;">Algoritma sistem akan otomatis mempartisi jemaah berdasarkan gender dan tipe kamar pilihan, membuat kamar baru, dan menempatkan mereka secara instan.</p>
                
                <form action="{{ route('admin.groups.auto-rooms', $group->id) }}" method="POST" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                    @csrf
                    <div style="flex: 1; min-width: 250px;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 4px;">Nama Lokasi Hotel (Makkah / Madinah)</label>
                        <input type="text" name="hotel_name" class="form-control" placeholder="Contoh: Hotel Makkah atau Pullman Zamzam" required style="padding: 0.5rem 0.8rem; font-size: 0.88rem;">
                    </div>
                    <button type="submit" class="btn-admin" style="padding: 0.55rem 1.5rem; font-size: 0.88rem; background: var(--brand-gold);">
                        <i class="fas fa-wand-magic-sparkles"></i> Eksekusi Bagi Kamar Otomatis
                    </button>
                </form>
            </div>

            <div class="grid-2" style="margin-bottom: 2rem;">
                <!-- Add Room Form -->
                <div style="border: 1px solid #eee; padding: 1.2rem; border-radius: 12px; background: #fafafa;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1rem;"><i class="fas fa-plus"></i> Tambah Kamar Baru</h4>
                    <form action="{{ route('admin.groups.add-room', $group->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Lokasi Hotel / Nama Hotel</label>
                            <input type="text" name="hotel_name" class="form-control" placeholder="Contoh: Hotel Makkah / Hotel Madinah" required style="padding: 0.6rem 0.8rem;">
                        </div>
                        <div class="form-group">
                            <label>Nomor Kamar</label>
                            <input type="text" name="room_number" class="form-control" placeholder="Contoh: Room 101" required style="padding: 0.6rem 0.8rem;">
                        </div>
                        <button type="submit" class="btn-admin" style="width: 100%; justify-content: center; padding: 0.6rem 1rem;">
                            Simpan Kamar
                        </button>
                    </form>
                </div>

                <!-- Assign Jamaah to Room Form -->
                <div style="border: 1px solid #eee; padding: 1.2rem; border-radius: 12px; background: #fafafa;">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1rem;"><i class="fas fa-user-plus"></i> Tempatkan Jemaah ke Kamar</h4>
                    <form action="{{ route('admin.groups.assign-room', $group->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Pilih Kamar</label>
                            <select name="room_id" class="form-control" required style="padding: 0.6rem 0.8rem;">
                                <option value="" disabled selected>-- Pilih Kamar --</option>
                                @foreach($group->rooms as $r)
                                    <option value="{{ $r->id }}">{{ $r->hotel_name }} - {{ $r->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Jemaah</label>
                            <select name="jamaah_id" class="form-control" required style="padding: 0.6rem 0.8rem;">
                                <option value="" disabled selected>-- Pilih Jemaah --</option>
                                @foreach($group->jamaahs as $j)
                                    <option value="{{ $j->id }}">{{ $j->name }} ({{ $j->room_type }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn-admin" style="width: 100%; justify-content: center; padding: 0.6rem 1rem; background: var(--brand-gold);">
                            Tempatkan
                        </button>
                    </form>
                </div>
            </div>

            <!-- View Rooms List -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem;">
                @forelse($group->rooms as $room)
                    <div style="border: 1px solid var(--brand-beige); border-radius: 10px; overflow: hidden; background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                        <div style="background: var(--brand-dark); color: white; padding: 0.75rem 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h5 style="margin: 0; font-size: 0.95rem; font-weight: 700;">{{ $room->room_number }}</h5>
                                <small style="opacity: 0.8; font-size: 0.75rem;">{{ $room->hotel_name }}</small>
                            </div>
                            <form action="{{ route('admin.groups.destroy-room', [$group->id, $room->id]) }}" method="POST" onsubmit="return confirm('Hapus kamar ini? Jemaah di dalamnya akan dibebaskan kembali.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: rgba(255,255,255,0.7); cursor: pointer; font-size: 0.85rem;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                        <div style="padding: 1rem;">
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                @forelse($room->roomMembers as $member)
                                    <li style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; border-bottom: 1px dashed rgba(0,0,0,0.06); font-size: 0.85rem; gap: 8px;">
                                        <div style="display: flex; flex-direction: column; flex-grow: 1;">
                                            <span style="font-weight: 600; color: var(--brand-dark);"><i class="fas fa-user" style="color: var(--brand-gold); margin-right: 0.3rem;"></i> {{ $member->jamaah->name ?? 'Kosong' }}</span>
                                            @if($member->jamaah)
                                                <small style="color: #777; font-size: 0.72rem; margin-left: 1.1rem; font-weight: 500;">{{ $member->jamaah->room_type }} | {{ $member->jamaah->gender ?? 'Laki-laki' }}</small>
                                            @endif
                                        </div>
                                        
                                        <div style="display: flex; align-items: center; gap: 6px;">
                                            <!-- Inline Move Room Dropdown -->
                                            <form action="{{ route('admin.groups.move-room', $group->id) }}" method="POST" style="display: inline-flex; align-items: center; margin: 0;">
                                                @csrf
                                                <input type="hidden" name="jamaah_id" value="{{ $member->jamaah_id }}">
                                                <select name="room_id" onchange="this.form.submit()" style="padding: 2px 4px; font-size: 0.7rem; border-radius: 4px; border: 1px solid rgba(139,94,60,0.2); background: #fdfdfd; color: var(--brand-gold); cursor: pointer; max-width: 100px; font-weight: 600;">
                                                    <option value="" disabled selected>Pindah</option>
                                                    @foreach($group->rooms as $otherRoom)
                                                        @if($otherRoom->id != $room->id && $otherRoom->hotel_name == $room->hotel_name)
                                                            <option value="{{ $otherRoom->id }}">{{ $otherRoom->room_number }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </form>

                                            <!-- Remove from Room -->
                                            <form action="{{ route('admin.groups.remove-room-member', [$group->id, $member->id]) }}" method="POST" style="display: inline; margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.85rem;" title="Keluarkan dari Kamar"><i class="fas fa-times-circle"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li style="color: #bbb; text-align: center; font-size: 0.8rem; padding: 1rem 0;">Kamar ini kosong</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; color: #aaa; padding: 2rem; border: 1px dashed #ddd; border-radius: 8px;">
                        Kamar hotel belum dikonfigurasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Group Details & Flight Dashboard -->
    <div>
        <!-- Info Card -->
        <div class="admin-card" style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">Informasi Grup</h3>
            <table style="width: 100%; border: none;">
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666; width: 40%;">Nama Rombongan</td>
                    <td style="padding: 0.5rem 0; font-weight: 700; font-size: 0.85rem; color: var(--brand-dark);">{{ $group->name }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Jadwal Keberangkatan</td>
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem;">
                        {{ $group->departureSchedule?->departure_date->format('d M Y') ?? '-' }}
                    </td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Bus Rombongan</td>
                    <td style="padding: 0.5rem 0; font-weight: 700; font-size: 0.85rem; color: var(--brand-gold);">{{ $group->bus_number ?? 'Belum Ditentukan' }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Muthowif</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;">{{ $group->muthowif ?? '-' }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 0.5rem 0; font-weight: 600; font-size: 0.85rem; color: #666;">Pembimbing</td>
                    <td style="padding: 0.5rem 0; font-size: 0.85rem;">{{ $group->pembimbing ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Flight Dashboard Card -->
        <div class="admin-card">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem;">
                <i class="fas fa-plane" style="color: var(--brand-gold);"></i> Flight Dashboard
            </h3>

            @if($group->flight_code)
                <div style="background: rgba(13, 76, 84, 0.03); border: 1px solid var(--brand-beige); border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem;">
                    <table style="width: 100%;">
                        <tr style="border: none;">
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; color: #666;">Kode Penerbangan</td>
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; font-weight: 700; color: var(--brand-dark);">{{ $group->flight_code }}</td>
                        </tr>
                        <tr style="border: none;">
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; color: #666;">Jam Berangkat</td>
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; font-weight: 600; color: var(--brand-dark);">
                                {{ $group->flight_departure_time ? $group->flight_departure_time->format('d M Y H:i') : '-' }}
                            </td>
                        </tr>
                        <tr style="border: none;">
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; color: #666;">Transit</td>
                            <td style="padding: 0.25rem 0; font-size: 0.85rem;">{{ $group->flight_transit ?? 'Direct' }}</td>
                        </tr>
                        <tr style="border: none;">
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; color: #666;">Terminal Bandara</td>
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; font-weight: 600; color: var(--brand-gold);">{{ $group->flight_terminal ?? '-' }}</td>
                        </tr>
                        <tr style="border: none;">
                            <td style="padding: 0.25rem 0; font-size: 0.85rem; color: #666;">Kode PNR / Booking</td>
                            <td style="padding: 0.25rem 0; font-size: 0.85rem;"><code style="background: white; border: 1px solid #ccc; padding: 2px 6px; border-radius: 4px; font-weight: 700;">{{ $group->booking_code ?? '-' }}</code></td>
                        </tr>
                    </table>
                </div>
            @else
                <div style="background: rgba(234, 179, 8, 0.05); border: 1px solid rgba(234, 179, 8, 0.2); color: #ca8a04; padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; font-weight: 500;">
                    <i class="fas fa-exclamation-triangle"></i> Data penerbangan maskapai jemaah belum diisi.
                </div>
            @endif

            <!-- Edit Flight Form -->
            <form action="{{ route('admin.groups.update-flight', $group->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label style="font-size: 0.85rem;">Kode Penerbangan / Maskapai</label>
                    <input type="text" name="flight_code" class="form-control" placeholder="Contoh: Saudi Arabian SV-817" value="{{ $group->flight_code }}" required style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">
                </div>
                <div class="form-group">
                    <label style="font-size: 0.85rem;">Waktu Keberangkatan Pesawat</label>
                    <input type="datetime-local" name="flight_departure_time" class="form-control" value="{{ $group->flight_departure_time ? $group->flight_departure_time->format('Y-m-d\TH:i') : '' }}" required style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">
                </div>
                <div class="form-group">
                    <label style="font-size: 0.85rem;">Rute Transit (Kosongkan jika Direct)</label>
                    <input type="text" name="flight_transit" class="form-control" placeholder="Contoh: Jeddah (JED)" value="{{ $group->flight_transit }}" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">
                </div>
                <div class="form-group">
                    <label style="font-size: 0.85rem;">Terminal Keberangkatan</label>
                    <input type="text" name="flight_terminal" class="form-control" placeholder="Contoh: Terminal 3 Ultimate" value="{{ $group->flight_terminal }}" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">
                </div>
                <div class="form-group">
                    <label style="font-size: 0.85rem;">Kode Booking Maskapai (PNR)</label>
                    <input type="text" name="booking_code" class="form-control" placeholder="Contoh: KLM7WY" value="{{ $group->booking_code }}" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">
                </div>
                <button type="submit" class="btn-admin" style="width: 100%; justify-content: center; padding: 0.6rem 1rem;">
                    Perbarui Penerbangan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAllJamaahs');
        if (checkAll) {
            checkAll.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.jamaah-checkbox-item');
                checkboxes.forEach(chk => {
                    chk.checked = checkAll.checked;
                });
            });
        }
    });
</script>
@endsection
