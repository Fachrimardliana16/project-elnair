<!-- Dynamic JavaScript Controls -->
<script>
    // Tab switching controls
    function switchTab(evt, tabId) {
        // Get all elements with class="tab-content" and hide them
        var tabContents = document.getElementsByClassName("tab-content");
        for (var i = 0; i < tabContents.length; i++) {
            tabContents[i].classList.remove("active");
        }

        // Get all elements with class="tab-btn" and remove the class "active"
        var tabBtns = document.getElementsByClassName("tab-btn");
        for (var i = 0; i < tabBtns.length; i++) {
            tabBtns[i].classList.remove("active");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabId).classList.add("active");
        evt.currentTarget.classList.add("active");
        
        // Save current tab in localStorage
        localStorage.setItem('active_leads_tab', tabId);
    }

    // Restore last active tab on load
    window.addEventListener('DOMContentLoaded', (event) => {
        const lastTab = localStorage.getItem('active_leads_tab');
        if (lastTab && document.getElementById(lastTab)) {
            // Find corresponding button
            const buttons = document.getElementsByClassName('tab-btn');
            for(let btn of buttons) {
                if(btn.getAttribute('onclick').includes(lastTab)) {
                    btn.click();
                    break;
                }
            }
        }
        
        // Restore last business mode on load
        const savedMode = localStorage.getItem('elnair_business_mode') || 'leadgen';
        switchBusinessMode(savedMode);
    });

    // Business model mode switching controls (NEW!)
    function switchBusinessMode(mode) {
        const btnLeadGen = document.getElementById('btn-mode-leadgen');
        const btnRetail = document.getElementById('btn-mode-retail');
        const cardLeadGen = document.getElementById('card-roi-leadgen');
        const cardRetail = document.getElementById('card-roi-retail');
        
        if (!btnLeadGen || !btnRetail) return;

        if (mode === 'leadgen') {
            // Style active button
            btnLeadGen.style.backgroundColor = '#ffffff';
            btnLeadGen.style.color = 'var(--brand-dark)';
            btnLeadGen.style.boxShadow = '0 2px 4px rgba(0,0,0,0.08)';
            
            // Style inactive button
            btnRetail.style.backgroundColor = 'transparent';
            btnRetail.style.color = '#475569';
            btnRetail.style.boxShadow = 'none';
            
            // Toggle tables
            if (cardLeadGen) cardLeadGen.style.display = 'block';
            if (cardRetail) cardRetail.style.display = 'none';
            
            localStorage.setItem('elnair_business_mode', 'leadgen');
        } else {
            // Style active button
            btnRetail.style.backgroundColor = '#ffffff';
            btnRetail.style.color = 'var(--brand-dark)';
            btnRetail.style.boxShadow = '0 2px 4px rgba(0,0,0,0.08)';
            
            // Style inactive button
            btnLeadGen.style.backgroundColor = 'transparent';
            btnLeadGen.style.color = '#475569';
            btnLeadGen.style.boxShadow = 'none';
            
            // Toggle tables
            if (cardLeadGen) cardLeadGen.style.display = 'none';
            if (cardRetail) cardRetail.style.display = 'block';
            
            localStorage.setItem('elnair_business_mode', 'retail');
        }
    }

    // Modal show/hide functions
    function openModal() {
        const modal = document.getElementById('connectAccountModal');
        modal.classList.add('show');
    }
    
    function closeModal() {
        const modal = document.getElementById('connectAccountModal');
        modal.classList.remove('show');
    }
    
    function closeModalOnBackdrop(e) {
        if(e.target.id === 'connectAccountModal') {
            closeModal();
        }
    }

    // WhatsApp dynamic message template selector
    function changeWaTemplate(select, leadId) {
        const option = select.options[select.selectedIndex];
        const rawMsg = option.getAttribute('data-msg');
        const link = document.getElementById('wa_link_' + leadId);
        
        const name = link.getAttribute('data-name');
        const phone = link.getAttribute('data-phone');
        const packageVal = link.getAttribute('data-package');
        
        // Replace templates
        let msg = rawMsg.replace(/{name}/g, name).replace(/{package}/g, packageVal);
        
        // Encode and set href
        link.href = 'https://api.whatsapp.com/send?phone=' + phone + '&text=' + encodeURIComponent(msg);
    }

    // Chart.js initialization
    @if(count($chartDates) > 0)
    const rawChartDates = {!! json_encode($chartDates) !!};
    const rawChartSpend = {!! json_encode($chartSpend) !!};
    const rawChartLeads = {!! json_encode($chartLeads) !!};
    const rawChartClicks = {!! json_encode($chartClicks) !!};
    const rawChartCtr = {!! json_encode($chartCtr) !!};
    const rawChartCvr = {!! json_encode($chartCvr) !!};

    var ctx = document.getElementById('roiTrendsChart').getContext('2d');
    window.roiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: rawChartDates,
            datasets: [
                {
                    label: 'Biaya Spent Iklan (Rp)',
                    yAxisID: 'y-spend',
                    data: rawChartSpend,
                    borderColor: '#0d4c54',
                    backgroundColor: 'rgba(13, 76, 84, 0.05)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#0d4c54'
                },
                {
                    label: 'Jumlah Leads',
                    yAxisID: 'y-leads',
                    data: rawChartLeads,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#3b82f6'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                'y-spend': {
                    type: 'linear',
                    position: 'left',
                    grid: {
                        drawOnChartArea: true,
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                'y-leads': {
                    type: 'linear',
                    position: 'right',
                    grid: {
                        drawOnChartArea: false, // avoid gridline overlap
                    },
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Toggle and Switch Chart datasets
    function switchChartDataset(type) {
        if (!window.roiChart) return;
        
        // Remove active class from all buttons
        document.getElementById('btn-chart-spend-leads').classList.remove('active');
        document.getElementById('btn-chart-spend-clicks').classList.remove('active');
        document.getElementById('btn-chart-ctr-cvr').classList.remove('active');
        
        // Reset button colors
        document.getElementById('btn-chart-spend-leads').style.backgroundColor = '#64748b';
        document.getElementById('btn-chart-spend-clicks').style.backgroundColor = '#64748b';
        document.getElementById('btn-chart-ctr-cvr').style.backgroundColor = '#64748b';
        
        // Set selected active
        const activeBtn = document.getElementById('btn-chart-' + type);
        activeBtn.classList.add('active');
        activeBtn.style.backgroundColor = '#0d4c54'; // Brand Teal
        
        if (type === 'spend-leads') {
            window.roiChart.data.datasets[0].label = 'Biaya Spent Iklan (Rp)';
            window.roiChart.data.datasets[0].data = rawChartSpend;
            window.roiChart.data.datasets[0].yAxisID = 'y-spend';
            
            window.roiChart.data.datasets[1].label = 'Jumlah Leads';
            window.roiChart.data.datasets[1].data = rawChartLeads;
            window.roiChart.data.datasets[1].yAxisID = 'y-leads';
            
            window.roiChart.options.scales['y-spend'].ticks.callback = function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            };
        } else if (type === 'spend-clicks') {
            window.roiChart.data.datasets[0].label = 'Biaya Spent Iklan (Rp)';
            window.roiChart.data.datasets[0].data = rawChartSpend;
            window.roiChart.data.datasets[0].yAxisID = 'y-spend';
            
            window.roiChart.data.datasets[1].label = 'Jumlah Klik Iklan';
            window.roiChart.data.datasets[1].data = rawChartClicks;
            window.roiChart.data.datasets[1].yAxisID = 'y-leads';
            
            window.roiChart.options.scales['y-spend'].ticks.callback = function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
            };
        } else if (type === 'ctr-cvr') {
            window.roiChart.data.datasets[0].label = 'Rasio Klik (CTR) %';
            window.roiChart.data.datasets[0].data = rawChartCtr;
            window.roiChart.data.datasets[0].yAxisID = 'y-spend';
            
            window.roiChart.data.datasets[1].label = 'Konversi Leads (CVR) %';
            window.roiChart.data.datasets[1].data = rawChartCvr;
            window.roiChart.data.datasets[1].yAxisID = 'y-leads';
            
            window.roiChart.options.scales['y-spend'].ticks.callback = function(value) {
                return value.toFixed(2) + '%';
            };
        }
        
        window.roiChart.update();
    }
    @endif
</script>
