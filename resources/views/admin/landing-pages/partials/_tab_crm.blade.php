<!-- ==========================================
     TAB 1: LEADS CRM
     ========================================== -->
<div id="tab-crm" class="tab-content active">
    <div class="admin-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: bold; color: #0f172a;">Campaign Leads Registry</h3>
            
            <form action="{{ route('admin.landing-pages.leads.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <input type="hidden" name="landing_page_id" value="{{ $landingPageId }}">
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari Nama / No WA..." style="width: 200px; padding: 6px 12px; font-size: 0.9rem;">
                
                <select name="status" class="form-control" style="width: 150px; padding: 6px 12px; font-size: 0.9rem;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="followed_up" {{ request('status') == 'followed_up' ? 'selected' : '' }}>Followed Up</option>
                    <option value="deal" {{ request('status') == 'deal' ? 'selected' : '' }}>Deal / Closing</option>
                    <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button type="submit" class="btn-admin" style="padding: 6px 15px;"><i class="fas fa-search"></i> Cari</button>
            </form>
        </div>

        @if($leads->isEmpty())
            <div style="text-align: center; padding: 3rem 0; color: #64748b;">
                <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p style="margin: 0; font-size: 1rem;">Belum ada leads masuk pada kriteria ini.</p>
            </div>
        @else
            <div class="table-responsive">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 10px;">
                <thead>
                    <tr style="background-color: #f8fafc;">
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Nama Calon</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Kontak WA</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Sumber Page</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: left;">Pilihan Paket</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Kualitas</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Status CS</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Tanggal Masuk</th>
                        <th style="padding: 12px 15px; border-bottom: 2px solid #e2e8f0; color: #475569; font-weight: 600; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr style="transition: all 0.2s ease; border-bottom: 1px solid #f1f5f9; hover { background-color: #f8fafc; }">
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; font-weight: 600; color: #0f172a; vertical-align: middle;">
                            {{ $lead->name }}
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle;">
                            @php
                                $defaultIntro = "Halo {name}, kami mendeteksi Anda tertarik dengan {package} di website Elnair. Apakah ada yang bisa kami bantu mengenai pendaftaran atau pilihan jadwalnya? 😊";
                                $defaultPromo = "Kabar Gembira {name}! Khusus pendaftaran {package} minggu ini, dapatkan potongan diskon Jumat Berkah sebesar Rp 1.500.000. Amankan seat Anda sekarang ya! 🕋";
                                $defaultClosing = "Assalamu'alaikum {name}, slot paket {package} kami untuk bulan ini sisa tinggal 3 kursi lagi. Apakah Anda ingin kami pesankan kursinya hari ini agar tidak kehabisan? ⚡";
                                $defaultBrosur = "Halo {name}, berikut kami lampirkan brosur lengkap berisi itinerary, hotel bintang 5, serta jadwal penerbangan untuk paket {package} Elnair Travel. 📄";
                            @endphp
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $lead->phone) }}&text={{ urlencode(str_replace(['{name}', '{package}'], [$lead->name, $lead->package ?? ($lead->landingPage ? $lead->landingPage->title : 'Layanan Elnair')], $defaultIntro)) }}" 
                                   target="_blank" 
                                   class="btn-wa-action" 
                                   id="wa_link_{{ $lead->id }}"
                                   data-phone="{{ preg_replace('/[^0-9]/', '', $lead->phone) }}"
                                   data-name="{{ $lead->name }}"
                                   data-package="{{ $lead->package ?? ($lead->landingPage ? $lead->landingPage->title : 'Layanan Elnair') }}"
                                   title="Hubungi WhatsApp">
                                    <i class="fab fa-whatsapp"></i> {{ $lead->phone }}
                                </a>
                                <select onchange="changeWaTemplate(this, {{ $lead->id }})" 
                                        style="padding: 3px 6px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.72rem; outline: none; cursor: pointer; color: #475569; background-color: #f8fafc; max-width: 160px;">
                                    <option value="intro" data-msg="{{ $defaultIntro }}">Sapaan Awal</option>
                                    <option value="promo" data-msg="{{ $defaultPromo }}">Promo Diskon</option>
                                    <option value="closing" data-msg="{{ $defaultClosing }}">Urgensi Closing</option>
                                    <option value="brosur" data-msg="{{ $defaultBrosur }}">Kirim Brosur</option>
                                </select>
                            </div>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #475569;">
                            @if($lead->landingPage)
                                <a href="{{ route('landing.page', $lead->landingPage->slug) }}" target="_blank" style="color: #0d4c54; font-weight: bold; text-decoration: underline;">
                                    {{ $lead->landingPage->title }}
                                </a>
                            @else
                                <span style="color: #94a3b8; font-style: italic;">Halaman Dihapus</span>
                            @endif
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; color: #0f172a; font-weight: bold;">
                            {{ $lead->package ?? '-' }}
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                            @if($lead->status == 'deal')
                                <span style="background-color: #d1fae5; color: #065f46; border: 1px solid #10b981; padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><i class="fas fa-bolt" style="color: #fbbf24;"></i>Hot Lead</span>
                            @elseif($lead->status == 'followed_up')
                                <span style="background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6; padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><i class="fas fa-fire" style="color: #f97316;"></i> Warm Lead</span>
                            @elseif($lead->status == 'pending')
                                <span style="background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b; padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><i class="fas fa-snowflake" style="color: #38bdf8;"></i> Cold Lead</span>
                            @else
                                <span style="background-color: #fee2e2; color: #991b1b; border: 1px solid #ef4444; padding: 4px 10px; border-radius: 12px; font-size: 0.72rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap;"><i class="fas fa-times-circle" style="color: #ef4444;"></i> Lost Lead</span>
                            @endif
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                            <form action="{{ route('admin.landing-pages.leads.status', $lead->id) }}" method="POST" style="margin: 0; display: inline-block;">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="status-select-badge status-{{ $lead->status }}">
                                    <option value="pending" {{ $lead->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="followed_up" {{ $lead->status == 'followed_up' ? 'selected' : '' }}>Followed Up</option>
                                    <option value="deal" {{ $lead->status == 'deal' ? 'selected' : '' }}>Deal / Closing</option>
                                    <option value="cancel" {{ $lead->status == 'cancel' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle; color: #64748b; font-size: 0.85rem;">
                            {{ $lead->created_at->format('d M Y H:i') }}
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 2px;">
                                {{ $lead->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td style="padding: 15px; border-bottom: 1px solid #f1f5f9; text-align: center; vertical-align: middle;">
                            <form action="{{ route('admin.landing-pages.leads.destroy', $lead->id) }}" method="POST" style="margin: 0; display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data lead ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin" style="background-color: #ef4444; padding: 6px 10px; border-radius: 4px;" title="Hapus Data">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $leads->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
