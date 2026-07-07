@props(['items' => []])

<nav class="flex items-center gap-2 text-sm py-4">
    @foreach($items as $index => $item)
        @if($index < count($items) - 1)
            <a href="{{ $item['url'] ?? '#' }}" class="text-gray-600 hover:text-brand-primary transition-colors">
                {{ $item['label'] }}
            </a>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        @else
            <span class="text-gray-700 font-medium">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
