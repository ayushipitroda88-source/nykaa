@props([
    'product',
    'showRating' => true,
    'showCategory' => true,
])

<x-card class="product-card h-full flex flex-col">
    <!-- Product Image -->
    <div class="product-image-wrapper">
        <a href="{{ route('product.show', $product->id) }}">
            <img 
                src="{{ asset('uploads/' . $product->image) }}" 
                alt="{{ $product->title }}"
                class="w-full h-full object-cover"
            />
        </a>
        
        @if($product->quantity < 10 && $product->quantity > 0)
            <div class="absolute top-3 right-3">
                <x-badge variant="warning" size="sm">Only {{ $product->quantity }} left</x-badge>
            </div>
        @elseif($product->quantity == 0)
            <div class="absolute inset-0 bg-black/40 flex-center">
                <span class="text-white font-bold text-lg">Out of Stock</span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4 flex-1 flex flex-col">
        <!-- Category -->
        @if($showCategory && $product->category)
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-2">
                {{ $product->category->name }}
            </p>
        @endif

        <!-- Title -->
        <a href="{{ route('product.show', $product->id) }}" class="block">
            <h3 class="text-sm font-semibold text-brand-dark line-clamp-2 hover:text-brand-primary transition-colors">
                {{ $product->title }}
            </h3>
        </a>

        <!-- Description -->
        <p class="text-xs text-gray-600 mt-2 line-clamp-2 flex-1">
            {{ Str::limit($product->description, 60) }}
        </p>

        <!-- Price & Rating -->
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
            <span class="text-lg font-bold text-brand-primary">₹{{ number_format($product->price, 2) }}</span>
            
            @if($showRating)
                <div class="flex items-center gap-1">
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
            @endif
        </div>

        <!-- Add to Cart Button -->
        <div class="mt-4">
            @if($product->quantity > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full btn-primary py-2 text-sm">
                        Add to Cart
                    </button>
                </form>
            @else
                <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-600 rounded-lg text-sm font-medium cursor-not-allowed">
                    Out of Stock
                </button>
            @endif
        </div>
    </div>
</x-card>
