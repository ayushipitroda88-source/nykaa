@props([
    'title' => null,
    'subtitle' => null,
    'dark' => false,
])

@php
    $bgClasses = $dark ? 'bg-brand-dark' : 'bg-white';
    $textClasses = $dark ? 'text-white' : 'text-brand-dark';
@endphp

<section {{ $attributes->merge(['class' => "section-py {$bgClasses}"]) }}>
    @if($title || $subtitle)
        <x-container class="mb-12">
            @if($title)
                <h2 class="text-4xl font-bold {{ $textClasses }} mb-4">
                    {{ $title }}
                </h2>
            @endif
            @if($subtitle)
                <p class="text-lg {{ $dark ? 'text-gray-300' : 'text-gray-600' }} max-w-2xl">
                    {{ $subtitle }}
                </p>
            @endif
        </x-container>
    @endif

    <x-container>
        {{ $slot }}
    </x-container>
</section>
