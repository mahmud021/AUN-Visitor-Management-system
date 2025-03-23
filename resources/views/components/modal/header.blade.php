@props(['title', 'modalId'])

<div class="flex justify-between items-center py-3 px-4 border-b border-neutral-700">
    <h3 id="{{ $modalId }}-label" class="font-bold text-neutral-200">
        {{ $title }}
    </h3>
    <button type="button"
            class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-neutral-800 text-neutral-200 hover:bg-neutral-700 focus:outline-none"
            aria-label="Close"
            data-hs-overlay="#{{ $modalId }}">

        <span class="sr-only">Close</span>
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
        </svg>
    </button>
</div>
