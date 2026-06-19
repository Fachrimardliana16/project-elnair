@extends('admin.layouts.app')

@section('title', 'Pembayaran & Keuangan')
@section('page_title', 'Manajemen Keuangan Jemaah')

@section('styles')
<style>
    .tab-btn {
        padding: 0.6rem 1.2rem;
        background: none;
        border: none;
        font-weight: 600;
        font-family: inherit;
        font-size: 0.95rem;
        color: #666;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: 0.3s;
    }
    .tab-btn.active {
        color: var(--brand-dark);
        border-bottom: 2px solid var(--brand-gold);
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
</style>
@endsection

@section('content')
<div style="display: flex; gap: 1rem; border-bottom: 1px solid #ddd; margin-bottom: 2rem;">
    <button class="tab-btn active" onclick="switchTab(event, 'outstandingTab')">
        <i class="fas fa-hand-holding-usd"></i> Piutang Jemaah (Outstanding)
    </button>
    <button class="tab-btn" onclick="switchTab(event, 'historyTab')">
        <i class="fas fa-history"></i> Riwayat Transaksi Pembayaran
    </button>
</div>

@if(session('success'))
    <div style="background: rgba(22, 163, 74, 0.1); color: #16a34a; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; font-size: 0.9rem;">
        <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i> {{ session('success') }}
    </div>
@endif

<!-- Tab 1: Outstanding Payments -->
<div id="outstandingTab" class="tab-content active">
    <div class="admin-card">
        <div style="margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);">Tunggakan & Piutang Jemaah</h3>
            <p style="color: #666; font-size: 0.9rem;">Daftar jemaah aktif yang belum melunasi biaya paket keberangkatan mereka.</p>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Jemaah</th>
                        <th>Paket Terpilih</th>
                        <th>Total Harga Paket</th>
                        <th>Sudah Dibayar</th>
                        <th>Sisa Tunggakan</th>
                        <th>Jatuh Tempo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($outstandingList as $item)
                    <tr>
                        <td style="font-weight: 600; color: var(--brand-dark);">
                            {{ $item['jamaah']->name }}
                            <br>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item['jamaah']->whatsapp) }}" target="_blank" style="color: #16a34a; font-weight: 600; text-decoration: none; font-size: 0.8rem;">
                                <i class="fab fa-whatsapp"></i> WA: {{ $item['jamaah']->whatsapp }}
                            </a>
                        </td>
                        <td>
                            <span style="font-weight: 500; font-size: 0.9rem;">{{ $item['jamaah']->package->title ?? 'Tanpa Paket' }}</span>
                            <br>
                            <small style="color: #888;">{{ $item['jamaah']->departureSchedule ? $item['jamaah']->departureSchedule->departure_date->format('d M Y') : '' }}</small>
                        </td>
                        <td style="font-weight: 600;">Rp {{ number_format($item['package_price'], 0, ',', '.') }}</td>
                        <td style="color: #16a34a; font-weight: 600;">Rp {{ number_format($item['total_paid'], 0, ',', '.') }}</td>
                        <td style="color: #dc2626; font-weight: 700; font-size: 0.95rem;">
                            Rp {{ number_format($item['balance'], 0, ',', '.') }}
                        </td>
                        <td>
                            <span style="font-weight: 500; font-size: 0.85rem; color: {{ \Carbon\Carbon::parse($item['due_date'])->isPast() ? '#dc2626' : '#666' }};">
                                {{ \Carbon\Carbon::parse($item['due_date'])->format('d M Y') }}
                                @if(\Carbon\Carbon::parse($item['due_date'])->isPast())
                                    <br><small style="color: #dc2626; font-weight: 600;">(TERLEWAT)</small>
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.payments.create', ['jamaah_id' => $item['jamaah']->id]) }}" class="btn-admin" style="padding: 0.5rem 1rem; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="fas fa-plus-circle"></i> Catat Pembayaran
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 3rem;">
                            <i class="fas fa-smile" style="font-size: 2.5rem; color: var(--brand-gold); margin-bottom: 1rem; display: block;"></i>
                            Luar biasa! Semua jemaah telah melunasi pembayaran mereka.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tab 2: Payment History -->
<div id="historyTab" class="tab-content">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark);">Catatan Riwayat Pembayaran</h3>
                <p style="color: #666; font-size: 0.9rem;">Kelola konfirmasi bukti transfer cicilan jemaah dan cetak kuitansi PDF.</p>
            </div>
            <a href="{{ route('admin.payments.create') }}" class="btn-admin" style="background: var(--brand-gold);">
                <i class="fas fa-plus"></i> Tambah Transaksi Manual
            </a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Jemaah</th>
                        <th>Tipe Pembayaran</th>
                        <th>Nominal</th>
                        <th>Tanggal Bayar</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td style="font-weight: 600; color: var(--brand-dark);">
                            {{ $payment->jamaah->name ?? 'Jemaah Dihapus' }}
                            <br>
                            <small style="color: #666;">Paket: {{ $payment->jamaah->package->title ?? '' }}</small>
                        </td>
                        <td>
                            <code style="background: rgba(13, 76, 84, 0.08); color: var(--brand-dark); padding: 3px 8px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">
                                {{ $payment->type }}
                            </code>
                        </td>
                        <td style="font-weight: 700; color: #16a34a; font-size: 0.95rem;">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                        <td>
                            @if($payment->payment_proof)
                                <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" style="color: var(--brand-gold); font-weight: 600; text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 4px;">
                                    <i class="fas fa-image"></i> Lihat Bukti
                                </a>
                            @else
                                <span style="color: #bbb;">Bayar Tunai / Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;
                                @if($payment->status === 'Approved')
                                    background: rgba(22, 163, 74, 0.1); color: #16a34a;
                                @elseif($payment->status === 'Pending')
                                    background: rgba(234, 179, 8, 0.1); color: #ca8a04;
                                @else
                                    background: rgba(220, 38, 38, 0.1); color: #dc2626;
                                @endif
                            ">
                                {{ $payment->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 0.4rem; align-items: center;">
                                @if($payment->status === 'Pending')
                                    <form action="{{ route('admin.payments.status', $payment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" style="color: white; background: #16a34a; border: none; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payments.status', $payment->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" style="color: white; background: #dc2626; border: none; padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer;">
                                            Reject
                                        </button>
                                    </form>
                                @endif

                                @if($payment->status === 'Approved')
                                    <a href="{{ route('admin.payments.export-invoice', $payment->id) }}" style="color: var(--brand-dark); background: rgba(13, 76, 84, 0.08); border: 1px solid rgba(13, 76, 84, 0.2); padding: 4px 8px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                        <i class="fas fa-print"></i> Kuitansi
                                    </a>
                                @endif

                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan transaksi ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; font-size: 0.85rem;"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 2.5rem;">
                            Belum ada riwayat transaksi pembayaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.5rem;">
            {{ $payments->links() }}
        </div>
    </div>
</div>

<script>
    function switchTab(evt, tabId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active");
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
    }
</script>
@endsection
