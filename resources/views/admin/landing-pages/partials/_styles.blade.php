<style>
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
    }
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .metric-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    }
    .metric-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }
    .metric-info h4 {
        margin: 0 0 4px 0;
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .metric-info h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
    }

    /* Tab Layout */
    .tab-nav {
        display: flex;
        border-bottom: 2px solid #e2e8f0;
        margin-bottom: 2rem;
        gap: 1.5rem;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }
    .tab-nav::-webkit-scrollbar {
        display: none;
    }
    .tab-btn {
        background: none;
        border: none;
        padding: 10px 5px;
        font-size: 1rem;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        position: relative;
        transition: color 0.2s;
        flex-shrink: 0;
    }
    .tab-btn:hover {
        color: #0f172a;
    }
    .tab-btn.active {
        color: #0d4c54;
    }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #0d4c54;
        border-radius: 3px;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }

    /* Custom Premium Info Tooltip CSS Styles */
    .info-tooltip {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: help;
        margin-left: 6px;
        color: #94a3b8;
        transition: color 0.2s, transform 0.2s;
        font-size: 0.8rem;
    }
    .info-tooltip:hover {
        color: #0d4c54;
        transform: scale(1.15);
    }
    .info-tooltip .tooltip-text {
        visibility: hidden;
        width: 260px;
        background-color: #0f172a;
        color: #f8fafc;
        text-align: left;
        border-radius: 8px;
        padding: 12px 14px;
        position: absolute;
        z-index: 999;
        bottom: 130%; /* Position above the icon */
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        font-size: 0.72rem;
        font-weight: 500;
        line-height: 1.45;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        pointer-events: none;
        text-transform: none; /* Reset uppercase */
        letter-spacing: normal;
        border: 1px solid #334155;
    }
    .info-tooltip .tooltip-text strong {
        color: #38bdf8;
        font-size: 0.78rem;
        display: block;
        margin-bottom: 4px;
    }
    .info-tooltip .tooltip-text em {
        color: #fbbf24;
        font-style: normal;
        font-weight: bold;
    }
    .info-tooltip .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%; /* At the bottom of the tooltip */
        left: 50%;
        margin-left: -6px;
        border-width: 6px;
        border-style: solid;
        border-color: #0f172a transparent transparent transparent;
    }
    .info-tooltip:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    /* Status badge */
    .status-select-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        border: 1px solid transparent;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .status-select-badge.status-pending {
        background-color: #fef3c7;
        color: #d97706;
        border-color: #fde68a;
    }
    .status-select-badge.status-followed_up {
        background-color: #dbeafe;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .status-select-badge.status-deal {
        background-color: #d1fae5;
        color: #059669;
        border-color: #a7f3d0;
    }
    .status-select-badge.status-cancel {
        background-color: #fee2e2;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .btn-wa-action {
        background-color: #25d366;
        color: white;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 0.8rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    .btn-wa-action:hover {
        background-color: #128c7e;
        color: white;
        text-decoration: none;
    }

    /* Modal Form styling */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(15, 23, 42, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
    }
    .modal-backdrop.show {
        opacity: 1;
        visibility: visible;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 16px;
        width: 100%;
        max-width: 550px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        transform: scale(0.95);
        transition: transform 0.25s ease;
        overflow: hidden;
    }
    .modal-backdrop.show .modal-card {
        transform: scale(1);
    }
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8fafc;
    }
    .modal-body {
        padding: 1.5rem;
    }

    .analytics-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .demographics-grid {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 2.5rem;
        align-items: center;
    }
    @media (max-width: 992px) {
        .analytics-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
    @media (max-width: 768px) {
        .demographics-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }
</style>
