@extends('landing.jemaah.layout')

@section('portal-content')
<!-- Dashboard Grid -->
<div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">

    <!-- 1. Banner Ringkasan & Hitung Mundur -->
    <div class="portal-card dashboard-banner-padding" style="background: linear-gradient(135deg, var(--brand-dark) 0%, #062b30 100%); color: #fff; position: relative; overflow: hidden; border: none;">
        <!-- Islamic aesthetic background element -->
        <div style="position: absolute; right: -50px; bottom: -50px; font-size: 15rem; color: rgba(255,255,255,0.03); font-weight: 900; line-height: 1; pointer-events: none; font-family: 'Font Awesome 6 Free';">
            &#xf689;
        </div>
        
        <div class="dashboard-banner-grid" style="position: relative; z-index: 2;">
            <div>
                <span style="letter-spacing: 2px; color: var(--brand-gold); text-transform: uppercase; font-weight: 700; font-size: 0.8rem; display: block; margin-bottom: 0.5rem;">Informasi Perjalanan</span>
                <h3 style="font-family: 'Playfair Display', serif; font-size: 1.75rem; font-weight: 800; margin-bottom: 0.75rem;">Ibadah Umrah Eksklusif Elnair</h3>
                <p style="color: rgba(255,255,255,0.85); font-size: 0.95rem; max-width: 500px; line-height: 1.6;">
                    Semoga Allah mempermudah dan menerima ibadah umrah Anda. Pantau terus halaman portal ini untuk melihat informasi mutakhir terkait kloter, rombongan, penerbangan, kamar hotel, dan penyelesaian administrasi.
                </p>
            </div>
            
            @if(isset($countdown))
                <div style="text-align: center; background: rgba(255,255,255,0.08); padding: 1.5rem 2rem; border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); min-width: 180px;">
                    @if($countdown > 0)
                        <span style="font-size: 2.75rem; font-weight: 900; color: var(--brand-gold); display: block; line-height: 1;">{{ $countdown }}</span>
                        <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; display: block; margin-top: 5px;">Hari Menuju Rihlah</span>
                    @elseif($countdown === 0)
                        <span style="font-size: 1.5rem; font-weight: 900; color: #2ecc71; display: block;">Hari Keberangkatan!</span>
                        <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; display: block; margin-top: 5px;">Semoga Selamat Sampai Tujuan</span>
                    @else
                        <span style="font-size: 1.3rem; font-weight: 900; color: rgba(255,255,255,0.6); display: block;">Sudah Berangkat</span>
                        <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; display: block; margin-top: 5px;">Ibadah Sedang Berlangsung</span>
                    @endif
                </div>
            @else
                <div style="text-align: center; background: rgba(255,255,255,0.08); padding: 1.5rem 2rem; border-radius: 20px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); min-width: 180px;">
                    <span style="font-size: 1.2rem; font-weight: 700; color: var(--brand-gold); display: block;">Jadwal Belum Rilis</span>
                    <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; display: block; margin-top: 5px;">Menunggu Konfirmasi Admin</span>
                </div>
            @endif
        </div>
    </div>

    <!-- 2. Rincian Rombongan & Penerbangan (Grid) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
        
        <!-- Rombongan, Bus & Muthowif -->
        <div class="portal-card dashboard-card-padding">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.5rem;">
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-users-cog" style="color: var(--brand-gold);"></i> Info Rombongan & Muthowif
                </h4>
            </div>

            @if($jemaah->group)
                <div style="display: grid; gap: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Nama Rombongan</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $jemaah->group->name }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Muthowif</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $jemaah->group->muthowif ?? 'Menunggu Rilis' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Pembimbing</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $jemaah->group->pembimbing ?? 'Menunggu Rilis' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Nomor Bus</span>
                        <strong style="font-size: 0.95rem; color: #fff; background: var(--brand-gold); padding: 2px 10px; border-radius: 6px;">{{ $jemaah->group->bus_number ?? 'Menunggu Rilis' }}</strong>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 2rem 0; color: var(--text-muted);">
                    <i class="fas fa-bus-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p style="font-size: 0.85rem; line-height: 1.5;">Anda belum dimasukkan ke rombongan manapun. Pembagian bus & Muthowif akan rilis menjelang keberangkatan.</p>
                </div>
            @endif
        </div>

        <!-- Penerbangan (Flight Manifest) -->
        <div class="portal-card dashboard-card-padding">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.5rem;">
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-plane-departure" style="color: var(--brand-gold);"></i> Rincian Penerbangan
                </h4>
            </div>

            @if($jemaah->group && ($jemaah->group->flight_code || $jemaah->group->booking_code))
                <div style="display: grid; gap: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Kode Maskapai & Flight</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $jemaah->group->flight_code ?? '-' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Waktu Keberangkatan</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">
                            {{ $jemaah->group->flight_departure_time ? \Carbon\Carbon::parse($jemaah->group->flight_departure_time)->format('d F Y, H:i') : '-' }} WIB
                        </strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Rute Transit</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $jemaah->group->flight_transit ?? 'Direct / Langsung' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Terminal Keberangkatan</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $jemaah->group->flight_terminal ?? 'Terminal 3 Bandara Soekarno Hatta' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 5px; border-top: 1px dashed var(--border-dashed);">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Kode Booking / PNR</span>
                        <span style="font-size: 0.9rem; font-weight: 800; font-family: monospace; color: var(--brand-gold); background: rgba(139,94,60,0.08); padding: 2px 8px; border-radius: 4px;">{{ $jemaah->group->booking_code ?? '-' }}</span>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 2rem 0; color: var(--text-muted);">
                    <i class="fas fa-ticket-alt" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p style="font-size: 0.85rem; line-height: 1.5;">Rincian penerbangan & tiket PNR akan dirilis secara kolektif maksimal 7 hari sebelum tanggal keberangkatan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- 3 Rooming List (Penempatan Kamar Hotel) -->
    <div class="portal-card dashboard-card-padding">
        <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border-muted); padding-bottom: 1.25rem; margin-bottom: 1.5rem;">
            <h4 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 800; color: var(--portal-title-color); display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-hotel" style="color: var(--brand-gold);"></i> Penempatan Kamar Hotel
            </h4>
            @if($jemaah->room_type)
                <span style="background: rgba(139,94,60,0.1); color: var(--brand-gold); font-size: 0.75rem; padding: 4px 12px; border-radius: 50px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                    Tipe Pilihan: Kamar {{ $jemaah->room_type }}
                </span>
            @endif
        </div>

        @if(isset($room) && $room)
            <div class="room-grid">
                <div style="background: var(--card-sub-bg); border: 1px solid var(--card-sub-border); padding: 1.5rem; border-radius: 16px;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem;">
                        <i class="fas fa-bed" style="font-size: 1.5rem; color: var(--brand-gold);"></i>
                        <div>
                            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; font-weight: 600;">Nomor Kamar Anda</span>
                            <strong style="font-size: 1.25rem; color: var(--portal-title-color);">{{ $room->room_number }}</strong>
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px; border-top: 1px solid var(--border-muted); padding-top: 1rem;">
                        <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">Nama Hotel Penempatan</span>
                        <strong style="font-size: 0.95rem; color: var(--portal-title-color);">{{ $room->hotel_name }}</strong>
                    </div>
                </div>

                <div>
                    <h5 style="font-size: 0.85rem; font-weight: 800; color: var(--brand-gold); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;">
                        <i class="fas fa-user-friends" style="margin-right: 6px;"></i> Teman Sekamar
                    </h5>
                    @if($roommates->isNotEmpty())
                        <div style="display: grid; gap: 0.75rem;">
                            @foreach($roommates as $rm)
                                <div style="display: flex; align-items: center; gap: 12px; background: var(--bg-muted); border: 1px solid var(--border-muted); padding: 0.75rem 1rem; border-radius: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--brand-gold); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800;">
                                        {{ strtoupper(substr($rm->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span style="font-size: 0.9rem; font-weight: 700; color: var(--portal-title-color); display: block;">{{ $rm->name }}</span>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $rm->city }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="background: var(--bg-muted); padding: 1.25rem; border-radius: 10px; border: 1px dashed var(--border-dashed); text-align: center; color: var(--text-muted); font-size: 0.85rem;">
                            Tidak ada jemaah lain di kamar ini / Single Room.
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 2.5rem 0; color: var(--text-muted);">
                <i class="fas fa-hotel" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p style="font-size: 0.85rem; line-height: 1.5; max-width: 480px; margin: 0 auto;">Distribusi & pembagian kamar hotel di Makkah & Madinah sedang digodok oleh tim manifest Elnair. Rincian penempatan nomor kamar akan rilis otomatis di sini.</p>
            </div>
        @endif
    </div>

</div>
@endsection
