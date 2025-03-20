<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Preline CSS -->
{{--    <link href="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.min.css" rel="stylesheet">--}}

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- REMOVE this Toastify script since it's bundled via Vite -->
    <!-- <script src="./node_modules/toastify-js/src/toastify.js"></script> -->
</head>
<body class="font-sans antialiased">
@include('layouts.navigation')
<div class="w-full lg:ps-64">
    <div class="min-h-screen  dark:bg-primary">
        <!-- Page Heading -->
        @isset($header)
            <header class=" shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 border-b border-gray-200 dark:border-gray-700">
                    {{ $header }}
                </div>
            </header>

        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</div>


@stack('scripts')
@include('components.flash-toast')
<script src="https://cdn.jsdelivr.net/npm/preline@2.7.0/dist/preline.min.js"></script>
<script src="/public/js/preline.min.js"></script>

</body>
</html>
