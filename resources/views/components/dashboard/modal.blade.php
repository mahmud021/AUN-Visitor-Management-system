@props(['id', 'title'])

<div id="{{ $id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="{{ $id }}-label">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)]">
        <div class="max-h-full overflow-hidden flex flex-col bg-neutral-800 border border-neutral-700 shadow-2xs rounded-xl pointer-events-auto">
            <div class="flex justify-between items-center py-3 px-4 border-b border-neutral-700">
                <h3 id="{{ $id }}-label" class="font-bold text-white">{{ $title }}</h3>
                <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-neutral-700 text-neutral-400 hover:bg-neutral-600 focus:outline-none focus:bg-neutral-600 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close" data-hs-overlay="#{{ $id }}">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6L6 18"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 overflow-y-auto">
                {{ $slot }}
            </div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-neutral-700">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-neutral-700 bg-neutral-800 text-white shadow-2xs hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#{{ $id }}">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
