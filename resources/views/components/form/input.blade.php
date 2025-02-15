@props(['name', 'label', 'type' => 'text', 'required' => false])

<div>
    <label for="{{ $name }}" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">
        {{ $label }}
    </label>
    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600']) }}>
</div>
