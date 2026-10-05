<!-- Section Alur Kerja / Workflow (Compact Single-Frame Horizontal Bar) -->
<div id="workflow" style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px dashed rgba(139,94,60,0.25);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--brand-dark); font-weight: 800; margin: 0;" class="workflow-header-title">
                Alur Kerja Pemesanan Layanan
            </h3>
            <p style="font-size: 0.85rem; color: var(--text-dark); opacity: 0.8; margin: 0.2rem 0 0 0;" class="workflow-header-subtext">5 Langkah Praktis Ibadah Nyaman & Terpercaya</p>
        </div>
        <div>
            <span class="workflow-tagline-badge" style="background: rgba(139,94,60,0.1); color: var(--brand-gold); padding: 6px 16px; border-radius: 50px; font-weight: 700; font-size: 0.8rem; border: 1px solid rgba(139,94,60,0.2); display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-shield-alt"></i> Ibadah aman bersama kami
            </span>
        </div>
    </div>

    @if(isset($workflows) && $workflows->count() > 0)
        <div class="workflow-progress-container" style="display: flex; align-items: center; justify-content: space-between; gap: 0; position: relative;">
            @foreach($workflows as $index => $wf)
                <!-- Step Item -->
                <div class="workflow-step-item" style="flex: 1; display: flex; flex-direction: column; align-items: center; position: relative; z-index: 2;">
                    <!-- Icon Circle with Step Number -->
                    <div class="workflow-icon-circle" style="width: 70px; height: 70px; border-radius: 50%; background: var(--gold-gradient); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; box-shadow: 0 6px 20px rgba(139,94,60,0.3); position: relative; border: 4px solid var(--bg-silk);">
                        <i class="fas {{ $wf->icon }}"></i>
                        <div style="position: absolute; top: -8px; right: -8px; background: var(--brand-dark); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; box-shadow: 0 4px 10px rgba(13,76,84,0.4); border: 2px solid var(--bg-silk);">
                            {{ $wf->step_number }}
                        </div>
                    </div>

                    <!-- Step Content -->
                    <div style="text-align: center; max-width: 160px;">
                        <h4 class="workflow-step-title" style="font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--brand-dark); font-weight: 700; margin-bottom: 0.5rem; line-height: 1.3;">
                            {{ $wf->title }}
                        </h4>
                        <p class="workflow-step-desc" style="font-size: 0.8rem; color: var(--text-dark); opacity: 0.8; line-height: 1.4; margin: 0;">
                            {{ $wf->description }}
                        </p>
                    </div>
                </div>

                <!-- Progress Line Connector (except after last item) -->
                @if($index < $workflows->count() - 1)
                    <div class="workflow-connector-line" style="flex: 0 0 auto; width: 60px; height: 3px; background: linear-gradient(90deg, var(--brand-gold) 0%, rgba(139,94,60,0.3) 100%); position: relative; top: -45px; margin: 0 -10px;">
                        <div style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-left: 8px solid rgba(139,94,60,0.5); border-top: 5px solid transparent; border-bottom: 5px solid transparent;"></div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>

<style>
.workflow-step-item:hover .workflow-icon-circle {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(139,94,60,0.4) !important;
}

.workflow-icon-circle {
    transition: all 0.3s ease;
}

[data-theme="dark"] #workflow {
    border-top-color: rgba(255, 255, 255, 0.1) !important;
}

[data-theme="dark"] .workflow-header-title {
    color: var(--text-dark) !important;
}

[data-theme="dark"] .workflow-header-subtext {
    color: var(--text-dark) !important;
    opacity: 0.75 !important;
}

[data-theme="dark"] .workflow-tagline-badge {
    background: rgba(102, 165, 173, 0.15) !important;
    color: var(--brand-teal) !important;
    border-color: rgba(102, 165, 173, 0.3) !important;
}

[data-theme="dark"] .workflow-icon-circle {
    border-color: var(--bg-dark) !important;
}

[data-theme="dark"] .workflow-icon-circle > div {
    border-color: var(--bg-dark) !important;
}

[data-theme="dark"] .workflow-step-title {
    color: var(--brand-teal) !important;
}

[data-theme="dark"] .workflow-step-desc {
    color: var(--text-dark) !important;
    opacity: 0.75 !important;
}

[data-theme="dark"] .workflow-connector-line {
    background: linear-gradient(90deg, var(--brand-gold) 0%, rgba(102, 165, 173, 0.3) 100%) !important;
}

@media (max-width: 900px) {
    .workflow-progress-container {
        flex-wrap: wrap !important;
        gap: 2rem !important;
    }

    .workflow-connector-line {
        display: none !important;
    }

    .workflow-step-item {
        flex: 0 0 calc(50% - 1rem) !important;
    }
}

@media (max-width: 480px) {
    .workflow-step-item {
        flex: 0 0 100% !important;
    }
}
</style>
