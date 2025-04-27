<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google / Bunny / custom fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Tailwind + app code (built with Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Extra <head> assets injected by individual pages -->
    @stack('head')
</head>
<body class="font-sans antialiased bg-primary">
@include('layouts.navigation')

<div class="w-full lg:ps-64 min-h-screen">
    @isset($header)
        <header class="shadow border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        {{ $slot }}
    </main>
</div>

<!-- Global helpers -->
@include('components.flash-toast')

<!-- Preline (UI helpers) -->
<script defer src="{{ asset('js/preline.min.js') }}"></script>

<!-- Page‑specific scripts injected by individual views -->
@vite('resources/js/app.js')
@stack('scripts')
<script>
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

        // Find the corresponding tab button and select option
        const targetButton = Array.from(tabButtons).find(btn => btn.getAttribute('data-hs-tab') === `#${hash}`);
        const targetOption = tabSelect.querySelector(`option[value="#${hash}"]`);

        // Restore tab state on page load (refresh fix)
        if (hash && targetButton && targetOption) {
            console.log('Found matching tab for hash:', hash);

            // Update select dropdown for mobile
            tabSelect.value = `#${hash}`;

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
            console.log('No matching tab found for hash or defaulting to "My Visitors".');
        }

        // Update URL hash when tab changes (via select or buttons)
        tabSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            window.location.hash = selectedValue;
            console.log('Tab changed via select to:', selectedValue);
            updatePaginationLinks(); // Update pagination links on tab change
        });

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-hs-tab');
                window.location.hash = tabId;
                console.log('Tab changed via button to:', tabId);
                updatePaginationLinks(); // Update pagination links on tab change
            });
        });

        // Function to update pagination links with the current hash (pagination fix)
        function updatePaginationLinks() {
            const currentHash = window.location.hash || '#tab-my'; // Default to first tab if no hash
            // Target your pagination links
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
            updatePaginationLinks();
        });
    });
</script>
</body>
</html>
