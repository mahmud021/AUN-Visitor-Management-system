@props(['id'])

<div id="{{ $id }}"
     class="hs-overlay [--overlay-backdrop:static] hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
     role="dialog" tabindex="-1" aria-labelledby="{{ $id }}-label"
     data-hs-overlay-keyboard="false">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
        <div class="w-full flex flex-col bg-neutral-800 border border-neutral-700 shadow-neutral-700/70 rounded-xl pointer-events-auto">
            {{ $slot }}
        </div>
    </div>
</div>
