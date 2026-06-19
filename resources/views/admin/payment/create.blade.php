@extends('admin.layouts.app')

@section('title', 'Catat Transaksi Pembayaran')
@section('page_title', 'Catat Pembayaran Jemaah')

@section('content')
<div class="admin-card" style="max-width: 700px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.payments.index') }}" style="color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 4px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard Pembayaran
        </a>
    </div>

    <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--brand-dark); margin-bottom: 1.5rem;">Form Pencatatan Transaksi Pembayaran</h3>

    <form action="{{ route('admin.payments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="jamaah_id">Pilih Jemaah <span style="color: red;">*</span></label>
            <select name="jamaah_id" id="jamaah_id" class="form-control" required onchange="updateJemaahDetails(this)">
                <option value="" disabled selected>-- Pilih Jemaah --</option>
                @foreach($jamaahs as $j)
                    <option value="{{ $j->id }}" {{ ($selectedJamaah && $selectedJamaah->id == $j->id) ? 'selected' : '' }} data-price="{{ $j->package ? $j->package->price_numeric : 0 }}" data-package="{{ $j->package->title ?? 'Tanpa Paket' }}">
                        {{ $j->name }} (Paket: {{ $j->package->title ?? 'Tidak Ada' }} - Rp {{ number_format($j->package ? $j->package->price_numeric : 0, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div id="priceInfoBox" style="display: {{ $selectedJamaah ? 'block' : 'none' }}; background: #fdfcfa; border: 1px solid var(--brand-beige); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
            <table style="width: 100%; border: none;">
                <tr style="border: none;">
                    <td style="padding: 2px 0; font-size: 0.85rem; color: #666;">Paket Terpilih:</td>
                    <td style="padding: 2px 0; font-weight: 700; font-size: 0.85rem; color: var(--brand-dark);" id="pricePackageName">
                        {{ $selectedJamaah ? ($selectedJamaah->package->title ?? '') : '' }}
                    </td>
                </tr>
                <tr style="border: none;">
                    <td style="padding: 2px 0; font-size: 0.85rem; color: #666;">Total Tagihan Paket:</td>
                    <td style="padding: 2px 0; font-weight: 700; font-size: 0.85rem; color: var(--brand-gold);" id="pricePackageValue">
                        {{ $selectedJamaah ? ('Rp ' . number_format($selectedJamaah->package ? $selectedJamaah->package->price_numeric : 0, 0, ',', '.')) : '' }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="type">Tipe Pembayaran <span style="color: red;">*</span></label>
                <select name="type" id="type" class="form-control" required>
                    <option value="DP">Uang Muka (DP)</option>
                    <option value="Cicilan 1">Cicilan 1</option>
                    <option value="Cicilan 2">Cicilan 2</option>
                    <option value="Pelunasan">Pelunasan Akhir</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amount">Nominal Pembayaran (Rupiah) <span style="color: red;">*</span></label>
                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="Contoh: 5000000" min="0" value="{{ old('amount') }}" required>
                @error('amount')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group">
                <label for="payment_date">Tanggal Transaksi <span style="color: red;">*</span></label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ old('payment_date', date('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="payment_proof">Bukti Transfer / Pembayaran (Opsional)</label>
                <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*">
                <small style="color: #888;">Format JPG/PNG/WEBP, Maksimal 2MB</small>
            </div>
        </div>

        <div style="margin-top: 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="{{ route('admin.payments.index') }}" class="btn-admin-outline" style="text-decoration: none;">Batal</a>
            <button type="submit" class="btn-admin">
                <i class="fas fa-save"></i> Catat Pembayaran
            </button>
        </div>
    </form>
</div>

<script>
    function updateJemaahDetails(select) {
        var selectedOption = select.options[select.selectedIndex];
        var price = selectedOption.getAttribute('data-price');
        var packageName = selectedOption.getAttribute('data-package');
        
        var priceBox = document.getElementById('priceInfoBox');
        var txtPackage = document.getElementById('pricePackageName');
        var txtPrice = document.getElementById('pricePackageValue');
        
        if (price && packageName) {
            priceBox.style.display = 'block';
            txtPackage.innerText = packageName;
            txtPrice.innerText = 'Rp ' + parseInt(price).toLocaleString('id-ID');
        } else {
            priceBox.style.display = 'none';
        }
    }
</script>
@endsection
