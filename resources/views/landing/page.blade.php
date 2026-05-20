<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->meta_title ?? $page->title }}</title>
    
    <meta name="description" content="{{ $page->meta_description ?? ($settings['meta_description'] ?? '') }}">
    <meta name="author" content="{{ $settings['site_name'] ?? 'Elnair Travel' }}">
    
    <!-- Base Styles (Inherit global theme styles for components) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @isset($settings['favicon'])
    <link rel="shortcut icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon">
    @endisset

    @php
        $activeFbPixelId = $page->fb_pixel_id ?? ($settings['facebook_pixel_id'] ?? null);
        $activeTikTokPixelId = $page->tiktok_pixel_id ?? ($settings['tiktok_pixel_id'] ?? null);
        $activeSnackPixelId = $page->snack_pixel_id ?? null;
        $activeGooglePixelId = $page->google_pixel_id ?? null;
    @endphp

    <!-- Global Marketing Scripts -->
    {!! $settings['google_analytics'] ?? '' !!}
    
    <!-- Google Tag Manager -->
    @if(!empty($settings['gtm_id']))
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $settings['gtm_id'] }}');</script>
    @endif

    <!-- Facebook Pixel (Meta) -->
    @if(!empty($activeFbPixelId))
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $activeFbPixelId }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $activeFbPixelId }}&ev=PageView&noscript=1"
    /></noscript>
    @else
    {!! $settings['facebook_pixel'] ?? '' !!}
    @endif

    <!-- TikTok Pixel -->
    @if(!empty($activeTikTokPixelId))
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndGet=function(t,e){return function(){var n=t[e];return n||function(){return ttq.push([e].concat(Array.prototype.slice.call(arguments,0)))}}};for(var e=0;e<ttq.methods.length;e++)ttq[e]=ttq.setAndGet(ttq,ttq.methods[e]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)e[ttq[methods[n]]]=e.setAndGet(e,ttq.methods[n]);return e},ttq.load=function(e,n){var o="https://analytics.tiktok.com/i18n/pixel/events.js",r=d.getElementsByTagName("script")[0];ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=o,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n;var i=d.createElement("script");i.type="text/javascript",i.async=!0,i.src=o;var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(i,s)};
      ttq.load('{{ $activeTikTokPixelId }}');
      ttq.page();
    }(window, document, 'ttq');
    </script>
    @endif

    <!-- Snack Video (Kwai) Pixel -->
    @if(!empty($activeSnackPixelId))
    <script>
    !function(w,d,t,s,p){p=w[t]=w[t]||[];p.methods=["track","page","identify"];p.load=function(e,n){var o=d.createElement("script");o.type="text/javascript",o.async=!0,o.src=s;var r=d.getElementsByTagName("script")[0];r.parentNode.insertBefore(o,r);p.instance=p.instance||[];p.instance.push({pixel_code:e,config:n})};for(var e=0;e<p.methods.length;e++)p[p.methods[e]]=function(t){return function(){p.push([t].concat(Array.prototype.slice.call(arguments,0)))}}(p.methods[e])
    }(window,document,"kwaiq","https://static.kwai.com/kp/pixel/events.js");
    kwaiq.load('{{ $activeSnackPixelId }}');
    kwaiq.page();
    </script>
    @endif

    <!-- Google Ads (gtag) Tracking -->
    @if(!empty($activeGooglePixelId))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $activeGooglePixelId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $activeGooglePixelId }}');
    </script>
    @endif
    @if(!empty($pageViewEventId))
    <script>
        // Server-Deduplicated PageView Event Match
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof fbq === 'function') {
                fbq('track', 'PageView', {}, {eventID: '{{ $pageViewEventId }}'});
            }
            if (typeof ttq === 'object') {
                ttq.page({event_id: '{{ $pageViewEventId }}'});
            }
            if (typeof kwaiq === 'object') {
                kwaiq.track('contentView');
            }
        });
    </script>
    @endif
    
    <!-- Specific Page Custom Pixel -->
    @if(!empty($page->pixel_script))
        {!! $page->pixel_script !!}
    @endif
    
    @if(!empty($page->fb_pixel_events) && is_array($page->fb_pixel_events))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if(typeof fbq === 'function') {
                    @foreach($page->fb_pixel_events as $event)
                        @if(!empty($event['event_name']))
                            @php
                                $paramsArray = [];
                                if(!empty($event['params'])) {
                                    foreach($event['params'] as $p) {
                                        if(!empty($p['key']) && isset($p['value'])) {
                                            $val = is_numeric($p['value']) ? $p['value'] : "'" . addslashes($p['value']) . "'";
                                            $paramsArray[] = "'" . addslashes($p['key']) . "': " . $val;
                                        }
                                    }
                                }
                                $paramString = !empty($paramsArray) ? ", { " . implode(', ', $paramsArray) . " }" : "";
                            @endphp
                            fbq('track', '{{ $event['event_name'] }}'{!! $paramString !!});
                        @endif
                    @endforeach
                }
            });
        </script>
    @elseif(!empty($page->ad_event_name))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if(typeof fbq === 'function') {
                    fbq('track', '{{ $page->ad_event_name }}');
                }
            });
        </script>
    @endif
    
    <style>
        /* Scalev-style Blank Canvas Resets */
        body { 
            margin: 0; 
            padding: 0; 
            width: 100%; 
            overflow-x: hidden; 
            background-color: #fff; 
            font-family: var(--font-primary), sans-serif;
        }
        
        /* Floating WA Button for Conversions */
        .floating-wa-canvas {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-decoration: none;
        }
        .floating-wa-canvas:hover {
            transform: scale(1.1) translateY(-5px);
            background-color: #1ebe57;
            color: white;
            box-shadow: 0 15px 25px rgba(37, 211, 102, 0.4);
        }
    </style>
</head>
<body>
    @if(!empty($settings['gtm_id']))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['gtm_id'] }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    
    @php
        $html_content = $page->content;
        
        // Dynamically replace any hardcoded WhatsApp links in builder content with our rotator redirect route
        $html_content = preg_replace_callback('/href=["\'](https?:\/\/(wa\.me|api\.whatsapp\.com)[^"\']*)["\']/i', function($matches) use ($page) {
            $url = html_entity_decode($matches[1]);
            $parsedUrl = parse_url($url);
            $query = [];
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $query);
            }
            $text = $query['text'] ?? ($query['message'] ?? '');
            
            $redirectUrl = route('landing.whatsapp-redirect', ['slug' => $page->slug]);
            if (!empty($text)) {
                $redirectUrl .= '?text=' . urlencode($text);
            }
            return 'href="' . $redirectUrl . '"';
        }, $html_content);
        
        // Floating WhatsApp Button Link using our redirect route
        $wa_input = $page->custom_wa_number ?? ($settings['wa_number'] ?? '');
        $wa_message = $page->custom_wa_message ?? ("Halo Elnair, saya ingin bertanya tentang " . $page->title);
        $wa_link = route('landing.whatsapp-redirect', ['slug' => $page->slug]) . "?text=" . urlencode($wa_message);
    @endphp

    <!-- 100% UNRESTRICTED CANVAS CONTENT (From Elementor Builder) -->
    {!! $html_content !!}
    
    @if(!empty($wa_input))
    <a href="{{ $wa_link }}" target="_blank" class="floating-wa-canvas" aria-label="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    @endif

    <style>
        /* Premium Glassmorphism Lead Modal */
        .lead-modal {
            position: fixed;
            z-index: 999999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 20px;
        }
        .lead-modal.show {
            opacity: 1;
        }
        .lead-modal-content {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            width: 100%;
            max-width: 420px;
            padding: 2.25rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: 'Outfit', 'Inter', sans-serif;
            text-align: left;
        }
        .lead-modal.show .lead-modal-content {
            transform: scale(1);
        }
        .lead-modal-close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .lead-modal-close:hover {
            color: #0f172a;
        }
        .lead-modal-logo-icon {
            width: 50px;
            height: 50px;
            background-color: #e8fbf1;
            color: #25d366;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }
        .lead-form-group {
            margin-bottom: 1.25rem;
        }
        .lead-form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .lead-form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .lead-form-group input:focus {
            border-color: #0D4C54;
            box-shadow: 0 0 0 3px rgba(13, 76, 84, 0.15);
        }
        #lead_submit_btn {
            width: 100%;
            background-color: #25d366;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.2s ease;
            margin-top: 1.5rem;
        }
        #lead_submit_btn:hover {
            background-color: #128c7e;
        }
        #lead_submit_btn:disabled {
            background-color: #cbd5e1;
            cursor: not-allowed;
        }
    </style>

    <!-- Modal Popup Form -->
    <div id="leadCaptureModal" class="lead-modal">
        <div class="lead-modal-content">
            <span class="lead-modal-close">&times;</span>
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <div class="lead-modal-logo-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h3 style="margin: 10px 0 5px 0; font-size: 1.25rem; font-weight: bold; color: #0D4C54;">Hubungi Customer Service</h3>
                <p style="margin: 0; font-size: 0.85rem; color: #64748b;">Silakan lengkapi form berikut untuk terhubung langsung via WhatsApp.</p>
            </div>
            <form id="leadCaptureForm">
                <div class="lead-form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" id="lead_name" required placeholder="Contoh: Ahmad Fauzi">
                </div>
                <div class="lead-form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="tel" id="lead_phone" required placeholder="Contoh: 08123456789">
                </div>
                <div class="lead-form-group">
                    <label>Pilihan Paket / Pertanyaan (Opsional)</label>
                    <input type="text" id="lead_package" placeholder="Contoh: Paket Umrah Premium / Tanya Jadwal">
                </div>
                <button type="submit" id="lead_submit_btn">
                    <span>Kirim & Mulai Chat</span> <i class="fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}" defer></script>
    <script src="{{ asset('assets/js/pixel-tracker.js') }}" defer></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = document.getElementById("leadCaptureModal");
            const closeBtn = document.querySelector(".lead-modal-close");
            const form = document.getElementById("leadCaptureForm");
            const submitBtn = document.getElementById("lead_submit_btn");
            let activeRedirectUrl = "";
            
            // Tangkap semua tombol/link yang memuat rute whatsapp-redirect kita
            const waRedirectLinks = document.querySelectorAll('a[href*="/whatsapp-redirect"]');
            
            waRedirectLinks.forEach(function(link) {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    activeRedirectUrl = this.getAttribute("href");
                    
                    // Ekstrak pesan text pembawa paket jika ada untuk dimasukkan ke form pilihan paket
                    try {
                        const urlParams = new URLSearchParams(this.search);
                        const textParam = urlParams.get('text');
                        if (textParam && !document.getElementById("lead_package").value) {
                            document.getElementById("lead_package").value = textParam.split(',')[0].replace('Halo Elnair, saya ingin bertanya tentang ', '');
                        }
                    } catch(err) {
                        console.log("No query parameters parsed", err);
                    }
                    
                    // Munculkan modal popup form
                    modal.style.display = "flex";
                    setTimeout(() => {
                        modal.classList.add("show");
                    }, 10);
                });
            });
            
            closeBtn.addEventListener("click", function() {
                modal.classList.remove("show");
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300);
            });
            
            window.addEventListener("click", function(e) {
                if (e.target === modal) {
                    modal.classList.remove("show");
                    setTimeout(() => {
                        modal.style.display = "none";
                    }, 300);
                }
            });
            
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                
                const name = document.getElementById("lead_name").value.trim();
                const phone = document.getElementById("lead_phone").value.trim();
                const packageVal = document.getElementById("lead_package").value.trim();
                
                // Matikan tombol submit untuk mencegah klik ganda
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Menghubungkan...</span> <i class="fas fa-spinner fa-spin"></i>';
                
                // Generate event_id unik di browser untuk deduplikasi
                const leadEventId = 'ld_' + Math.random().toString(36).substring(2, 9) + '_' + Date.now();
                
                // 1. Jalankan Pixel Browser Event secara lokal (dengan eventID deduplikasi)
                if (typeof fbq === 'function') {
                    fbq('track', 'Lead', {
                        content_name: 'WhatsApp Lead Form Submission',
                        content_category: 'Lead'
                    }, {eventID: leadEventId});
                    
                    fbq('track', 'Contact', {
                        content_name: 'WhatsApp Lead Form Submission',
                        content_category: 'Contact'
                    }, {eventID: leadEventId + '_contact'});
                }
                
                if (typeof ttq === 'object') {
                    ttq.track('SubmitForm', {
                        content_name: 'WhatsApp Lead Form Submission',
                        content_category: 'Lead'
                    }, {event_id: leadEventId});
                    
                    ttq.track('Contact', {
                        content_name: 'WhatsApp Lead Form Submission',
                        content_category: 'Contact'
                    }, {event_id: leadEventId + '_contact'});
                }

                if (typeof kwaiq === 'object') {
                    kwaiq.track('buttonClick');
                }

                @if(!empty($activeGooglePixelId) && !empty($page->google_conversion_label))
                if (typeof gtag === 'function') {
                    gtag('event', 'conversion', {
                        'send_to': '{{ $activeGooglePixelId }}/{{ $page->google_conversion_label }}'
                    });
                }
                @endif
                
                // 2. Submit data ke Laravel backend via AJAX
                fetch('{{ route("landing.store-lead", $page->slug) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        phone: phone,
                        package: packageVal,
                        lead_event_id: leadEventId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.redirect_url) {
                        // Respon sukses: Arahkan langsung ke chat WhatsApp CS (sudah dirandom/rotator)
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'Terjadi kesalahan sistem, silakan coba lagi.');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<span>Kirim & Mulai Chat</span> <i class="fas fa-chevron-right"></i>';
                    }
                })
                .catch(error => {
                    console.error('Error submitting lead:', error);
                    // Fallback: Jika koneksi server error, langsung redirect secara manual ke tautan WA fallback
                    if (activeRedirectUrl) {
                        window.location.href = activeRedirectUrl;
                    } else {
                        alert('Koneksi sedang lambat. Mengalihkan Anda secara manual...');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<span>Kirim & Mulai Chat</span> <i class="fas fa-chevron-right"></i>';
                    }
                });
            });
        });
    </script>
</body>
</html>
