<div class="flex flex-col  border shadow-sm rounded-xl bg-brand-900 dark:border-neutral-700">
    <div class="p-4 md:p-5">
        <div class="flex items-center gap-x-2">
            <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                {{ strtoupper($title) }}
            </p>
        </div>
        <div class="mt-1 flex items-center gap-x-2">
            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                {{ $value }}
            </h3>
        </div>
    </div>
</div>
