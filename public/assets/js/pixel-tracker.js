document.addEventListener('DOMContentLoaded', function() {
    try {
        // Track WhatsApp Clicks as Leads
        document.querySelectorAll('a[href*="wa.me"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (typeof fbq !== 'undefined') {
                    fbq('track', 'Contact');
                    fbq('track', 'Lead', {
                        content_name: 'WhatsApp Inquiry',
                        content_category: 'Communication'
                    });
                }
            });
        });

        // Track Package View / Interest
        document.querySelectorAll('a[href*="#paket"]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (typeof fbq !== 'undefined') {
                    fbq('track', 'ViewContent', {
                        content_name: 'Packages Section'
                    });
                }
            });
        });
    } catch (err) {
        console.log('Pixel tracking error ignored.');
    }
});
