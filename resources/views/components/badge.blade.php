@props([
    'variant' => 'primary', // primary, secondary, success, warning, error
    'size' => 'md', // sm, md, lg
])

@php
    $variantClasses = match($variant) {
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'success' => 'inline-block px-3 py-1 bg-success text-white text-sm font-medium rounded-full',
        'warning' => 'inline-block px-3 py-1 bg-warning text-brand-dark text-sm font-medium rounded-full',
        'error' => 'inline-block px-3 py-1 bg-error text-white text-sm font-medium rounded-full',
        default => 'badge-primary',
    };
    
    $sizeClasses = match($size) {
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-sm px-3 py-1',
        'lg' => 'text-base px-4 py-1.5',
        default => 'text-sm px-3 py-1',
    };
@endphp

<span {{ $attributes->merge(['class' => "{$variantClasses} {$sizeClasses}"]) }}>
    {{ $slot }}
</span>
