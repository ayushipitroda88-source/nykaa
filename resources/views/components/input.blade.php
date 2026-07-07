@props([
    'type' => 'text',
    'name' => '',
    'label' => null,
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'hint' => null,
])

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-brand-dark mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'input-premium ' . ($error ? 'border-red-500 focus:ring-red-500' : '')]) }}
    />

    @if($error)
        <p class="text-red-500 text-sm mt-1">{{ $error }}</p>
    @endif

    @if($hint)
        <p class="text-gray-500 text-sm mt-1">{{ $hint }}</p>
    @endif
</div>
