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
@stack('scripts')
</body>
</html>
