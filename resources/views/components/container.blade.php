@props([
    'maxWidth' => '7xl', // sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
    'padding' => true,
])

@php
    $maxWidthClasses = match($maxWidth) {
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        '7xl' => 'max-w-7xl',
        default => 'max-w-7xl',
    };
    
    $paddingClasses = $padding ? 'px-4 md:px-6 lg:px-8' : '';
@endphp

<div {{ $attributes->merge(['class' => "mx-auto {$maxWidthClasses} {$paddingClasses}"]) }}>
    {{ $slot }}
</div>
