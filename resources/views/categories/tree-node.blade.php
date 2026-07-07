<div class="ml-2" data-id="{{ $category->id }}">

    <!-- CATEGORY ROW -->
    <div class="flex items-center gap-2 py-1 cursor-pointer group">

        <!-- + / - BUTTON -->
        @if($category->children->count() > 0)
            <button type="button"
                class="toggle-btn w-5 h-5 flex items-center justify-center text-xs
                bg-gray-200 hover:bg-gray-300 rounded font-bold"
                data-target="children-{{ $category->id }}">
                +
            </button>
        @else
            <span class="w-5"></span>
        @endif

        <!-- CATEGORY NAME -->
        <span class="text-gray-700 hover:text-blue-600 font-medium"
              onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')">
            {{ $category->name }}
        </span>

    </div>

    <!-- CHILDREN -->
    @if($category->children->count() > 0)
        <div id="children-{{ $category->id }}"
             class="ml-6 hidden border-l border-gray-200 pl-3">

            @foreach($category->children as $child)
                @include('categories.tree-node', ['category' => $child])
            @endforeach

        </div>
    @endif

</div>