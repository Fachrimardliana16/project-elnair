<!-- Full Page Image Lightbox Modal (Pure Vanilla JS & CSS, Zero Dependencies) -->
<div id="elnairImageModal" class="elnair-image-modal" style="display: none;" aria-hidden="true" role="dialog" aria-modal="true">
    {{-- Backdrop click to close --}}
    <div class="elnair-modal-backdrop" onclick="closeImageModal()"></div>
    
    <div class="elnair-modal-container">
        <!-- Top Navigation / Action Bar (Clean, no overlap with image) -->
        <div class="elnair-modal-header">
            <div class="elnair-modal-title">
                <i class="fas fa-file-image" style="color: var(--brand-gold, #C08261); margin-right: 8px;"></i>
                <span>Flyer Resmi Paket</span>
            </div>
            
            <div class="elnair-modal-actions">
                <a id="elnairModalOpenNewTab" href="#" target="_blank" class="elnair-modal-btn elnair-btn-secondary" title="Buka Gambar Penuh di Tab Baru">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Buka Resolusi Penuh</span>
                </a>
                <a id="elnairModalDownload" href="#" download class="elnair-modal-btn elnair-btn-primary" title="Unduh Gambar Flyer">
                    <i class="fas fa-download"></i>
                    <span>Unduh Flyer</span>
                </a>
                <button type="button" class="elnair-modal-btn elnair-btn-close" onclick="closeImageModal()" aria-label="Tutup Preview (ESC)" title="Tutup (ESC)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Image Content Area (Contained within viewport, zero overlap) -->
        <div class="elnair-modal-body" onclick="if(event.target === this) closeImageModal()">
            <div id="elnairModalSpinner" class="elnair-modal-spinner">
                <i class="fas fa-circle-notch fa-spin"></i>
                <span style="display:block; font-size:0.8rem; margin-top:8px; opacity:0.85;">Memuat Flyer...</span>
            </div>
            <div id="elnairModalError" class="elnair-modal-error" style="display: none;">
                <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #e74c3c; margin-bottom: 8px;"></i>
                <p style="margin: 0 0 10px 0; font-size: 0.9rem;">Tidak dapat memuat gambar flyer.</p>
                <button type="button" class="elnair-modal-btn elnair-btn-secondary" onclick="closeImageModal()">Tutup</button>
            </div>
            <img id="elnairModalImg" src="" alt="Flyer Full Page" class="elnair-modal-img" style="opacity: 0;">
        </div>
    </div>
</div>

<style>
.elnair-image-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 999999;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.25s;
    user-select: none;
}
.elnair-image-modal.is-active {
    opacity: 1;
    visibility: visible;
}
.elnair-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(8, 20, 22, 0.94);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    cursor: zoom-out;
}
.elnair-modal-container {
    position: relative;
    z-index: 2;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    pointer-events: none;
}
.elnair-modal-header {
    pointer-events: auto;
    width: 100%;
    height: 64px;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: rgba(0, 0, 0, 0.5);
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    flex-shrink: 0;
    box-sizing: border-box;
}
.elnair-modal-title {
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
}
.elnair-modal-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.elnair-modal-btn {
    pointer-events: auto;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 16px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    outline: none;
}
.elnair-btn-secondary {
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #ffffff !important;
}
.elnair-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-1px);
}
.elnair-btn-primary {
    background: linear-gradient(135deg, #8B5E3C 0%, #C08261 100%);
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(139, 94, 60, 0.35);
}
.elnair-btn-primary:hover {
    background: linear-gradient(135deg, #A06D46 0%, #D19270 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(139, 94, 60, 0.5);
}
.elnair-btn-close {
    width: 38px;
    height: 38px;
    padding: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    margin-left: 6px;
}
.elnair-btn-close:hover {
    background: #e74c3c;
    border-color: #e74c3c;
    transform: rotate(90deg) scale(1.08);
}

.elnair-modal-body {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    box-sizing: border-box;
    overflow: hidden;
    position: relative;
    cursor: zoom-out;
}
.elnair-modal-img {
    pointer-events: auto;
    max-width: 95vw;
    max-height: calc(100vh - 105px);
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.75), 0 0 0 1px rgba(255, 255, 255, 0.12);
    cursor: default;
    transition: transform 0.25s ease, opacity 0.2s ease;
}
.elnair-modal-spinner, .elnair-modal-error {
    position: absolute;
    pointer-events: auto;
    text-align: center;
    color: #ffffff;
    z-index: 5;
}
.elnair-modal-spinner {
    font-size: 2.2rem;
    color: var(--brand-gold, #C08261);
}

@media (max-width: 768px) {
    .elnair-modal-header {
        height: 56px;
        padding: 0 0.8rem;
    }
    .elnair-modal-title span {
        display: none;
    }
    .elnair-modal-btn {
        padding: 6px 12px;
        font-size: 0.75rem;
        gap: 5px;
    }
    .elnair-btn-secondary span {
        display: none;
    }
    .elnair-modal-body {
        padding: 0.5rem;
    }
    .elnair-modal-img {
        max-height: calc(100vh - 85px);
        max-width: 98vw;
    }
}
</style>

<script>
(function() {
    function getModalElements() {
        return {
            modal: document.getElementById('elnairImageModal'),
            img: document.getElementById('elnairModalImg'),
            spinner: document.getElementById('elnairModalSpinner'),
            errorBox: document.getElementById('elnairModalError'),
            openBtn: document.getElementById('elnairModalOpenNewTab'),
            downBtn: document.getElementById('elnairModalDownload')
        };
    }

    window.openImageModal = function(url, downloadUrl) {
        if (!url || typeof url !== 'string' || url.trim() === '' || url === '#') return;
        var el = getModalElements();
        if (!el.modal || !el.img) return;

        // Reset state
        el.img.style.opacity = '0';
        if (el.errorBox) el.errorBox.style.display = 'none';
        if (el.spinner) el.spinner.style.display = 'block';

        // Detach previous handlers first to prevent ghost events
        el.img.onload = null;
        el.img.onerror = null;

        el.img.onload = function() {
            if (el.spinner) el.spinner.style.display = 'none';
            el.img.style.opacity = '1';
        };

        el.img.onerror = function() {
            // Only trigger if modal is currently open and has a valid src
            if (el.modal && el.modal.classList.contains('is-active') && el.img.getAttribute('src')) {
                if (el.spinner) el.spinner.style.display = 'none';
                if (el.errorBox) el.errorBox.style.display = 'block';
            }
        };

        el.img.src = url;
        if (el.openBtn) el.openBtn.href = url;
        
        if (el.downBtn) {
            if (downloadUrl) {
                el.downBtn.href = downloadUrl;
                el.downBtn.removeAttribute('download');
            } else {
                el.downBtn.href = url;
                var isPng = url.toLowerCase().includes('orig-png');
                el.downBtn.setAttribute('download', 'Flyer-Paket.' + (isPng ? 'png' : 'jpg'));
            }
        }

        el.modal.style.display = 'flex';
        void el.modal.offsetWidth; // Force reflow for CSS transition
        el.modal.classList.add('is-active');
        el.modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    // Fallback converter: Never let user download raw .webp when downloading from modal
    var elInitial = getModalElements();
    if (elInitial.downBtn) {
        elInitial.downBtn.addEventListener('click', function(e) {
            var href = (this.getAttribute('href') || '').toLowerCase();
            // If it's already an application download route or pdf, allow normal navigation
            if (href.includes('/download-flyer') || href.endsWith('.pdf')) {
                return;
            }
            // If it points directly to a .webp file, convert on client via canvas
            if (href.endsWith('.webp') || href.includes('.webp?')) {
                e.preventDefault();
                var el = getModalElements();
                if (!el.img || !el.img.naturalWidth) {
                    window.location.href = this.href;
                    return;
                }
                try {
                    var canvas = document.createElement('canvas');
                    canvas.width = el.img.naturalWidth;
                    canvas.height = el.img.naturalHeight;
                    var ctx = canvas.getContext('2d');
                    var isPng = href.includes('orig-png');
                    if (!isPng) {
                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                    }
                    ctx.drawImage(el.img, 0, 0);
                    var mime = isPng ? 'image/png' : 'image/jpeg';
                    var ext = isPng ? 'png' : 'jpg';
                    canvas.toBlob(function(blob) {
                        if (!blob) {
                            window.open(el.img.src, '_blank');
                            return;
                        }
                        var blobUrl = URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = 'Flyer-Paket.' + ext;
                        document.body.appendChild(a);
                        a.click();
                        setTimeout(function() {
                            document.body.removeChild(a);
                            URL.revokeObjectURL(blobUrl);
                        }, 500);
                    }, mime, 0.95);
                } catch(err) {
                    // Fallback to normal navigation if canvas is tainted
                    window.location.href = this.href;
                }
            }
        });
    }

    window.closeImageModal = function() {
        var el = getModalElements();
        if (!el.modal) return;

        el.modal.classList.remove('is-active');
        el.modal.setAttribute('aria-hidden', 'true');

        // CRITICAL FIX: Detach handlers immediately before removing src to avoid triggering onerror
        if (el.img) {
            el.img.onload = null;
            el.img.onerror = null;
        }

        setTimeout(function() {
            if (!el.modal.classList.contains('is-active')) {
                el.modal.style.display = 'none';
                if (el.img) {
                    el.img.removeAttribute('src');
                    el.img.style.opacity = '0';
                }
                if (el.spinner) el.spinner.style.display = 'none';
                if (el.errorBox) el.errorBox.style.display = 'none';
                document.body.style.overflow = '';
            }
        }, 250);
    };

    window.addEventListener('open-image-modal', function(e) {
        var url = (e.detail && e.detail.url) ? e.detail.url : (typeof e.detail === 'string' ? e.detail : null);
        var downloadUrl = (e.detail && e.detail.downloadUrl) ? e.detail.downloadUrl : null;
        if (url) {
            window.openImageModal(url, downloadUrl);
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            window.closeImageModal();
        }
    });
})();
</script>
