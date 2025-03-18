@props(['title', 'count', 'tooltip', 'modalTarget'])

<div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-4 md:p-5">
        <div class="flex items-center justify-between gap-x-2">
            <div class="flex items-center gap-x-2">
                <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">{{ $title }}</p>
                <div class="hs-tooltip">
                    <div class="hs-tooltip-toggle">
                        <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                            <path d="M12 17h.01"/>
                        </svg>
                        <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
                            {{ $tooltip }}
                        </span>
                    </div>
                </div>
            </div>
            <!-- Trigger Modal Button -->
            <button type="button" aria-haspopup="dialog" aria-expanded="false"
                    aria-controls="{{ $modalTarget }}" data-hs-overlay="#{{ $modalTarget }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="lucide lucide-eye text-gray-500 dark:text-neutral-500">
                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
        <div class="mt-1 flex items-center gap-x-2">
            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                {{ $count }}
            </h3>
        </div>
    </div>
</div>
