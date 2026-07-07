@props([
    'variant' => 'default', // default, elevated, outline
])

@php
    $variantClasses = match($variant) {
        'default' => 'bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100',
        'elevated' => 'bg-white rounded-xl shadow-lg border border-gray-100',
        'outline' => 'bg-transparent rounded-xl border-2 border-gray-200 hover:border-brand-primary',
        default => 'bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100',
    };
@endphp

<div {{ $attributes->merge(['class' => "card transition-all duration-300 {$variantClasses}"]) }}>
    {{ $slot }}
</div>
