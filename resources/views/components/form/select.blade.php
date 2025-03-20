@props(['name', 'label'])

<div>
    <label for="{{ $name }}" class="block mb-2 text-sm text-white font-medium">
        {{ $label }}
    </label>
    <select name="{{ $name }}"
            id="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'py-3 px-4 pe-9 block w-full border-neutral-700 rounded-lg text-sm bg-brand-900 text-neutral-400 placeholder-neutral-500 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none focus:ring-neutral-600'
        ]) }}>
        {{ $slot }}
    </select>
</div>
