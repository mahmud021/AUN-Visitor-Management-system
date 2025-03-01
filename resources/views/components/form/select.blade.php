@props(['name', 'label'])

<div>
    <label for="{{ $name }}" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">
        {{ $label }}
    </label>
    <select name="{{ $name }}"
            id="{{ $name }}"
        {{ $attributes->merge(['class' => 'py-3 px-4 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600']) }}>
        {{ $slot }}
    </select>
</div>
