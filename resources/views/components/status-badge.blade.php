@props(['status'])

@php
    $statusClasses = [
        'Enrolled'    => 'bg-green-600/20 text-green-400',
        'Inactive'    => 'bg-red-600/20 text-red-400',
        'Graduated'   => 'bg-blue-600/20 text-blue-400',
        'pending'     => 'bg-yellow-600/20 text-yellow-400',
        'approved'    => 'bg-blue-600/20 text-blue-400',
        'denied'      => 'bg-red-600/20 text-red-400',
        'checked_in'  => 'bg-green-600/20 text-green-400',
        'checked_out' => 'bg-gray-600/20 text-gray-400',
    ];

    $defaultClasses = 'py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full';
    $statusClass = $statusClasses[$status] ?? 'bg-gray-600/20 text-gray-400';

    // Map statuses to custom SVG icons.
    $iconMap = [
        'pending'     => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-dashed-icon"><path d="M10.1 2.182a10 10 0 0 1 3.8 0"/><path d="M13.9 21.818a10 10 0 0 1-3.8 0"/><path d="M17.609 3.721a10 10 0 0 1 2.69 2.7"/><path d="M2.182 13.9a10 10 0 0 1 0-3.8"/><path d="M20.279 17.609a10 10 0 0 1-2.7 2.69"/><path d="M21.818 10.1a10 10 0 0 1 0 3.8"/><path d="M3.721 6.391a10 10 0 0 1 2.7-2.69"/><path d="M6.391 20.279a10 10 0 0 1-2.69-2.7"/></svg>',
        'approved'    => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check-icon"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>',
        'denied'      => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
        'checked_in'  => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-arrow-up-icon"><path d="M13.228 21.925A10 10 0 1 1 21.994 12.338"/><path d="M12 6v6l1.562.781"/><path d="m14 18 4-4 4 4"/><path d="M18 22v-8"/></svg>',
        'checked_out' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>',
    ];

    $lowerStatus = strtolower($status);
    $icon = $iconMap[$lowerStatus] ?? '<svg class="size-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/></svg>';
@endphp

<span class="{{ $defaultClasses }} {{ $statusClass }}">
    {!! $icon !!}
    {{ ucfirst($status) }}
</span>
