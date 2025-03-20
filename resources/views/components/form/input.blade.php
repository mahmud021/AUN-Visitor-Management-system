@props(['name', 'label', 'type' => 'text', 'required' => false])

<div>
    <label for="{{ $name }}" class="block mb-2 text-sm text-white font-medium">
        {{ $label }}
    </label>
    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'py-3 px-4 block w-full border-neutral-700 rounded-lg text-sm bg-neutral-900 text-neutral-400 placeholder-neutral-500 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none focus:ring-neutral-600'
        ]) }}>
</div>
