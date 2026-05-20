@if(isset($isDummyActive) && $isDummyActive)
    <!-- Premium Presentation/Demo Mode Alert Badge (NEW!) -->
    <div style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 4px solid #d97706; padding: 12px 20px; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 4px 6px rgba(217, 119, 6, 0.05);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-magic" style="color: #d97706; font-size: 1.25rem;"></i>
            <div>
                <strong style="color: #78350f; font-size: 0.85rem; display: block;">Mode Presentasi & Simulasi Aktif</strong>
                <span style="color: #92400e; font-size: 0.78rem; line-height: 1.4; display: block;">Kami mendeteksi basis data Anda masih kosong. Elnair otomatis menyajikan **High-Fidelity Dummy Data** agar visual presentasi Anda terlihat sangat matang dan interaktif. Data ini akan **hilang secara otomatis** begitu data nyata (prospek atau spent API) masuk.</span>
            </div>
        </div>
        <span style="font-size: 0.65rem; background-color: #d97706; color: #ffffff; padding: 3px 8px; border-radius: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;"><i class="fas fa-play-circle"></i> Live Demo</span>
    </div>
@endif

<!-- Top Global Filters Bar -->
<div class="filter-card">
    <form action="{{ route('admin.landing-pages.leads.index') }}" method="GET" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
        <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
            <div class="form-group mb-0">
                <label style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 5px; display: block;">Landing Page</label>
                <select name="landing_page_id" class="form-control" style="width: 220px; padding: 6px 12px;" onchange="this.form.submit()">
                    <option value="">Semua Landing Page</option>
                    @foreach($landingPages as $page)
                        <option value="{{ $page->id }}" {{ $landingPageId == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-0">
                <label style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 5px; display: block;">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" onchange="this.form.submit()">
            </div>
            <div class="form-group mb-0">
                <label style="font-size: 0.8rem; font-weight: 700; color: #64748b; margin-bottom: 5px; display: block;">Hingga Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" onchange="this.form.submit()">
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.landing-pages.leads.export-pdf', ['landing_page_id' => $landingPageId, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn-admin" style="background-color: #dc2626; padding: 10px 20px; font-weight: 600; border-radius: 8px;">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="{{ route('admin.landing-pages.leads.export-csv', ['landing_page_id' => $landingPageId, 'start_date' => $startDate, 'end_date' => $endDate, 'status' => request('status'), 'search' => request('search')]) }}" class="btn-admin" style="background-color: #16a34a; padding: 10px 20px; font-weight: 600; border-radius: 8px;">
                <i class="fas fa-file-csv"></i> Export CSV (FB Audience)
            </a>
            @if(request()->filled('landing_page_id') || request()->filled('start_date') || request()->filled('end_date'))
                <a href="{{ route('admin.landing-pages.leads.index') }}" class="btn-admin" style="background-color: #64748b; padding: 10px 20px; font-weight: 600; border-radius: 8px;">
                    <i class="fas fa-undo"></i> Reset Filters
                </a>
            @endif
        </div>
    </form>
</div>
