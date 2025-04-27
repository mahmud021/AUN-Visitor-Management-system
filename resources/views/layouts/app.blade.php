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
        if (typeof HSStaticMethods === 'undefined') {
            console.error('Preline JS is not loaded. Ensure preline.js is included.');
            return;
        }

        const tabSelect = document.getElementById('tab-select');
        const tabButtons = document.querySelectorAll('[role="tab"]');
        let hash = window.location.hash;

        console.log('Initial URL Hash:', hash);

        hash = hash.startsWith('#') ? hash.slice(1) : hash;

        const targetButton = Array.from(tabButtons).find(btn => btn.getAttribute('data-hs-tab') === `#${hash}`);
        const targetOption = tabSelect.querySelector(`option[value="#${hash}"]`);

        if (hash && targetButton && targetOption) {
            console.log('Found matching tab for hash:', hash);

            tabSelect.value = `#${hash}`;

            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600');
                btn.setAttribute('aria-selected', 'false');
            });

            targetButton.classList.add('active', 'hs-tab-active:font-semibold', 'hs-tab-active:border-blue-600', 'hs-tab-active:text-blue-600');
            targetButton.setAttribute('aria-selected', 'true');

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

        tabSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            window.location.hash = selectedValue;
            console.log('Tab changed via select to:', selectedValue);
        });

        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = this.getAttribute('data-hs-tab');
                window.location.hash = tabId;
                console.log('Tab changed via button to:', tabId);
            });
        });
    });
</script>
</body>
</html>
