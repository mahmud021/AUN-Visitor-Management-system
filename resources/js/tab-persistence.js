document.addEventListener('DOMContentLoaded', function() {
    // Ensure Preline is initialized
    if (typeof HSStaticMethods === 'undefined') {
        console.error('Preline JS is not loaded. Ensure preline.js is included.');
        return;
    }

    const tabSelect = document.getElementById('tab-select');
    const tabButtons = document.querySelectorAll('[role="tab"]');
    let hash = window.location.hash;

    console.log('Initial URL Hash:', hash);

    // Normalize hash (remove leading # if present)
    hash = hash.startsWith('#') ? hash.slice(1) : hash;

    // Function to activate a tab programmatically
    function activateTab(tabId) {
        const targetButton = Array.from(tabButtons).find(btn => btn.getAttribute('data-hs-tab') === `#${tabId}`);
        const targetOption = tabSelect.querySelector(`option[value="#${tabId}"]`);

        if (targetButton && targetOption) {
            console.log('Activating tab:', tabId);

            // Update select dropdown for mobile
            tabSelect.value = `#${tabId}`;

            // Remove active state from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600');
                btn.setAttribute('aria-selected', 'false');
            });

            // Set active state on the target button
            targetButton.classList.add('active', 'hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600');
            targetButton.setAttribute('aria-selected', 'true');

            // Show the corresponding tab content
            const targetPanelId = targetButton.getAttribute('data-hs-tab').slice(1);
            document.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                panel.classList.add('hidden');
                if (panel.id === targetPanelId) {
                    panel.classList.remove('hidden');
                }
            });

            console.log('Activated tab:', targetPanelId);
        } else {
            console.warn('No matching tab found for ID:', tabId);
        }
    }

    // Restore tab state on page load (refresh fix)
    if (hash) {
        activateTab(hash);
    } else {
        console.log('No hash found, defaulting to "My Visitors".');
    }

    // Update URL hash and activate tab when tab changes (via select or buttons)
    tabSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        const tabId = selectedValue.startsWith('#') ? selectedValue.slice(1) : selectedValue;
        window.location.hash = tabId;
        console.log('Tab changed via select to:', selectedValue);
        activateTab(tabId); // Forcefully activate the tab
        updatePaginationLinks(); // Update pagination links
    });

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-hs-tab').slice(1);
            window.location.hash = tabId;
            console.log('Tab changed via button to:', tabId);
            activateTab(tabId); // Forcefully activate the tab
            updatePaginationLinks(); // Update pagination links
        });
    });

    // Function to update pagination links with the current hash (pagination fix)
    function updatePaginationLinks() {
        const currentHash = window.location.hash || '#tab-my'; // Default to first tab if no hash
        // Target pagination links
        const paginationLinks = document.querySelectorAll('[role="tabpanel"] .inline-flex a');
        console.log('Found pagination links:', paginationLinks.length);

        if (paginationLinks.length === 0) {
            console.warn('No pagination links found. Check if pagination is rendered within [role="tabpanel"].');
        }

        paginationLinks.forEach(link => {
            try {
                const url = new URL(link.href, window.location.origin);
                url.hash = currentHash;
                link.href = url.toString();
                console.log('Updated link:', link.href);
            } catch (error) {
                console.error('Error updating pagination link:', link.href, error);
            }
        });
    }

    // Update pagination links on page load and when hash changes
    updatePaginationLinks();
    window.addEventListener('hashchange', function() {
        console.log('Hash changed to:', window.location.hash);
        const newHash = window.location.hash.startsWith('#') ? window.location.hash.slice(1) : window.location.hash;
        if (newHash) {
            activateTab(newHash); // Activate tab on hash change
        }
        updatePaginationLinks();
    });
});
