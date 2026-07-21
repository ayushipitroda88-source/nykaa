<!-- ==============================
     FILTER SIDEBAR
============================== -->
<style>
/* Filter Sidebar Styles */
.filter-sidebar {
    width: 260px;
    flex-shrink: 0;
    background: #fff;
    border-radius: 12px;
    border: 1px solid #eee;
    padding: 20px;
    position: sticky;
    top: 90px;
    align-self: flex-start;
    max-height: calc(100vh - 110px);
    overflow-y: auto;
}

.filter-sidebar::-webkit-scrollbar {
    width: 4px;
}

.filter-sidebar::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 10px;
}

.filter-section {
    border-bottom: 1px solid #f0f0f0;
    padding: 14px 0;
}

.filter-section:last-child {
    border-bottom: none;
}

.filter-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
    padding: 4px 0;
}

.filter-section-header h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #222;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.filter-section-header .collapse-icon {
    font-size: 12px;
    color: #999;
    transition: transform 0.3s ease;
}

.filter-section-header .collapse-icon.collapsed {
    transform: rotate(-90deg);
}

.filter-section-body {
    padding-top: 12px;
    display: block;
}

.filter-section-body.hidden {
    display: none;
}

/* Category tree in filter */
.filter-cat-item {
    margin: 2px 0;
}

.filter-cat-link {
    display: block;
    padding: 6px 8px;
    font-size: 13px;
    font-weight: 500;
    color: #555;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.2s;
}

.filter-cat-link:hover {
    background: #fff0f5;
    color: #fc2779;
}

.filter-cat-link.active {
    background: #fc2779;
    color: #fff;
    font-weight: 600;
}

.filter-cat-child {
    padding-left: 18px;
}

/* Checkbox styled items */
.filter-check-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 8px;
    font-size: 13px;
    color: #555;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.2s;
}

.filter-check-item:hover {
    background: #fff5f7;
    color: #fc2779;
}

.filter-check-item input[type="checkbox"],
.filter-check-item input[type="radio"] {
    accent-color: #fc2779;
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.filter-check-item .count {
    margin-left: auto;
    font-size: 11px;
    color: #aaa;
}

/* Color circles */
.color-circle-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 4px 0;
}

.color-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #e0e0e0;
    cursor: pointer;
    position: relative;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.color-circle:hover {
    transform: scale(1.15);
    border-color: #fc2779;
    box-shadow: 0 3px 10px rgba(252, 39, 121, 0.3);
}

.color-circle.selected {
    border-color: #fc2779;
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #fc2779;
}

.color-circle.selected::after {
    content: '✓';
    color: #fff;
    font-size: 14px;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

/* Size pills */
.size-pill-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.size-pill {
    padding: 6px 14px;
    border-radius: 8px;
    border: 1.5px solid #e0e0e0;
    font-size: 12px;
    font-weight: 600;
    color: #555;
    cursor: pointer;
    transition: all 0.2s;
    background: #fff;
    text-decoration: none;
    display: inline-block;
}

.size-pill:hover {
    border-color: #fc2779;
    color: #fc2779;
    background: #fff0f5;
}

.size-pill.selected {
    border-color: #fc2779;
    background: #fc2779;
    color: #fff;
}

/* Price inputs */
.price-range {
    display: flex;
    gap: 8px;
    align-items: center;
}

.price-range input {
    width: 100%;
    padding: 8px 10px;
    border: 1.5px solid #e0e0e0;
    border-radius: 8px;
    font-size: 13px;
    outline: none;
    transition: border-color 0.2s;
}

.price-range input:focus {
    border-color: #fc2779;
}

.price-range span {
    color: #999;
    font-size: 13px;
}

.price-apply-btn {
    width: 100%;
    margin-top: 8px;
    padding: 8px;
    background: #fc2779;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: background 0.3s;
}

.price-apply-btn:hover {
    background: #d91d66;
}

/* Discount pills */
.discount-pill {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    border: 1.5px solid #e0e0e0;
    font-size: 12px;
    font-weight: 600;
    color: #555;
    cursor: pointer;
    transition: all 0.2s;
    margin: 3px;
    background: #fff;
    text-decoration: none;
}

.discount-pill:hover {
    border-color: #fc2779;
    color: #fc2779;
}

.discount-pill.selected {
    border-color: #fc2779;
    background: #fc2779;
    color: #fff;
}

/* Active filters bar */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    padding: 12px 0;
}

.active-filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    background: #fff0f5;
    border: 1px solid #ffd6e5;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: #fc2779;
    text-decoration: none;
    transition: all 0.2s;
}

.active-filter-tag:hover {
    background: #fc2779;
    color: #fff;
    border-color: #fc2779;
}

.active-filter-tag .remove-filter {
    font-size: 14px;
    line-height: 1;
    cursor: pointer;
}

.clear-all-btn {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    color: #999;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.clear-all-btn:hover {
    border-color: #fc2779;
    color: #fc2779;
}

/* Mobile filter button */
.mobile-filter-btn {
    display: none;
    padding: 10px 20px;
    background: #fc2779;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
    align-items: center;
    gap: 8px;
    margin-bottom: 16px;
}

.mobile-filter-btn:hover {
    background: #d91d66;
}

/* Mobile filter panel (slide-in) */
.filter-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 99999;
}

.filter-overlay.active {
    display: block;
}

.mobile-filter-panel {
    position: fixed;
    top: 0;
    left: -320px;
    width: 300px;
    height: 100%;
    background: #fff;
    z-index: 100000;
    transition: left 0.35s ease;
    box-shadow: 4px 0 30px rgba(0, 0, 0, 0.15);
    overflow-y: auto;
}

.mobile-filter-panel.open {
    left: 0;
}

.mobile-filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid #f0f0f0;
    background: linear-gradient(135deg, #fc2779, #ff5ba8);
    color: #fff;
}

.mobile-filter-header h5 {
    margin: 0;
    font-weight: 700;
}

.mobile-filter-close {
    border: none;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-filter-body {
    padding: 0 20px 20px;
}

.mobile-filter-footer {
    padding: 16px 20px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
}

.mobile-filter-footer .apply-filter-btn {
    flex: 1;
    padding: 12px;
    background: #fc2779;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
}

.mobile-filter-footer .reset-filter-btn {
    flex: 1;
    padding: 12px;
    background: #f5f5f5;
    color: #333;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
}

/* Responsive */
@media (max-width: 992px) {
    .filter-sidebar {
        display: none;
    }

    .mobile-filter-btn {
        display: inline-flex;
    }
}
</style>

@php
    // Current URL with query parameters for building filter links
    $currentUrl = url()->current();
    $queryParams = request()->query();
    $currentCategoryId = request('category');
    $currentBrandId = request('brand');
    $currentColor = request('color');
    $currentSize = request('size');
    $currentMinPrice = request('min_price');
    $currentMaxPrice = request('max_price');
    $currentDiscount = request('discount');
    $currentInStock = request('in_stock');
    $currentSort = request('sort', 'newest');
    $currentCollection = request('collection');
    $currentSearch = request('search');

    // Build base query params without filter keys for "clear all"
    $baseParams = ['search' => $currentSearch, 'sort' => $currentSort];
    $clearAllParams = array_filter(['search' => $currentSearch]);

    // Helper to build URL with updated query param
    function filterUrl($key, $value, $queryParams, $currentUrl) {
        $params = $queryParams;
        if ($value === null || $value === '') {
            unset($params[$key]);
        } else {
            $params[$key] = $value;
        }
        // Keep sort param
        return $currentUrl . '?' . http_build_query($params);
    }

    // Helper to check if filter param is selected
    function isSelected($key, $value, $queryParams) {
        return isset($queryParams[$key]) && $queryParams[$key] == $value;
    }
@endphp

<!-- ====================
     MOBILE FILTER BUTTON
==================== -->
<button class="mobile-filter-btn" onclick="toggleFilterPanel()">
    <i class="bi bi-funnel"></i> Filters
    @php
        $activeFilterCount = 0;
        foreach (['category', 'brand', 'color', 'size', 'min_price', 'max_price', 'discount', 'in_stock', 'collection'] as $f) {
            if (request($f)) $activeFilterCount++;
        }
    @endphp
    @if($activeFilterCount > 0)
        <span style="background:#fff;color:#fc2779;border-radius:50%;padding:2px 8px;font-size:11px;font-weight:700;">{{ $activeFilterCount }}</span>
    @endif
</button>

<!-- ====================
     ACTIVE FILTERS BAR
==================== -->
@if($activeFilterCount > 0)
<div class="active-filters">
    <span style="font-size:13px;font-weight:600;color:#666;">Filters:</span>

    @if($currentCategoryId)
        @php
            $catName = isset($categories) ? $categories->pluck('name', 'id')->get($currentCategoryId) ?? $currentCategoryId : $currentCategoryId;
        @endphp
        <a href="{{ filterUrl('category', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            {{ $currentCategoryId }} <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentBrandId)
        <a href="{{ filterUrl('brand', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            {{ $currentBrandId }} <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentCollection)
        <a href="{{ filterUrl('collection', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            {{ $currentCollection }} <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentColor)
        <a href="{{ filterUrl('color', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            {{ $currentColor }} <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentSize)
        <a href="{{ filterUrl('size', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            {{ $currentSize }} <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentMinPrice || $currentMaxPrice)
        <a href="{{ filterUrl('min_price', null, filterUrl('max_price', null, $queryParams, $currentUrl) ? [] : $queryParams, $currentUrl) }}" class="active-filter-tag">
            ₹{{ $currentMinPrice ?? 0 }}-{{ $currentMaxPrice ?? '∞' }} <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentDiscount)
        <a href="{{ filterUrl('discount', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            {{ $currentDiscount }}%+ Off <span class="remove-filter">✕</span>
        </a>
    @endif

    @if($currentInStock)
        <a href="{{ filterUrl('in_stock', null, $queryParams, $currentUrl) }}" class="active-filter-tag">
            In Stock <span class="remove-filter">✕</span>
        </a>
    @endif

    <a href="{{ $currentUrl . '?' . http_build_query($clearAllParams) }}" class="clear-all-btn">
        Clear All ✕
    </a>
</div>
@endif

<!-- ====================
     DESKTOP FILTER SIDEBAR
==================== -->
<div class="filter-sidebar" id="filterSidebar">

    <!-- 1. Categories -->
    @if(isset($categories) && $categories->count() > 0)
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Categories</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            @foreach($categories as $cat)
                <div class="filter-cat-item">
                    <a href="{{ filterUrl('category', $cat->id, $queryParams, $currentUrl) }}"
                       class="filter-cat-link {{ isSelected('category', $cat->id, $queryParams) ? 'active' : '' }}">
                        {{ $cat->name }}
                    </a>
                    @if($cat->children->count() > 0)
                        @foreach($cat->children as $sub)
                            <div class="filter-cat-item filter-cat-child">
                                <a href="{{ filterUrl('category', $sub->id, $queryParams, $currentUrl) }}"
                                   class="filter-cat-link {{ isSelected('category', $sub->id, $queryParams) ? 'active' : '' }}">
                                    {{ $sub->name }}
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 2. Collections -->
    @if(isset($filterCollections) && $filterCollections->count() > 0)
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Collections</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            @foreach($filterCollections as $col)
                <label class="filter-check-item">
                    <input type="radio" name="collection_filter" value="{{ $col->id }}"
                           onchange="window.location='{{ filterUrl('collection', $col->id, $queryParams, $currentUrl) }}'"
                           {{ isSelected('collection', $col->id, $queryParams) ? 'checked' : '' }}>
                    {{ $col->name }}
                </label>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 3. Brands -->
    @if(isset($filterBrands) && $filterBrands->count() > 0)
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Brands</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            @foreach($filterBrands as $brand)
                <label class="filter-check-item">
                    <input type="checkbox"
                           onchange="window.location='{{ filterUrl('brand', $brand->id, $queryParams, $currentUrl) }}'"
                           {{ isSelected('brand', $brand->id, $queryParams) ? 'checked' : '' }}>
                    {{ $brand->name }}
                    <span class="count">({{ $brand->products_count ?? 0 }})</span>
                </label>
            @endforeach
        </div>
    </div>
    @endif

    <!-- 4. Price -->
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Price</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            <div class="price-range">
                <input type="number" name="min_price" placeholder="Min" value="{{ $currentMinPrice }}" min="0" id="minPriceInput">
                <span>—</span>
                <input type="number" name="max_price" placeholder="Max" value="{{ $currentMaxPrice }}" min="0" id="maxPriceInput">
            </div>
            <button class="price-apply-btn" onclick="applyPriceFilter()">Apply</button>
        </div>
    </div>

    <!-- 5. Availability -->
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Availability</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            <label class="filter-check-item">
                <input type="checkbox" name="in_stock"
                       onchange="window.location='{{ filterUrl('in_stock', request('in_stock') ? null : '1', $queryParams, $currentUrl) }}'"
                       {{ $currentInStock ? 'checked' : '' }}>
                In Stock Only
            </label>
        </div>
    </div>

    <!-- 6. Colors -->
    @if(isset($filterColors) && $filterColors->count() > 0)
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Colors</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            <div class="color-circle-list">
                @foreach($filterColors as $color)
                    <a href="{{ filterUrl('color', $color->id, $queryParams, $currentUrl) }}"
                       class="color-circle {{ isSelected('color', $color->id, $queryParams) ? 'selected' : '' }}"
                       style="background: {{ $color->color_code ?? '#ccc' }};"
                       title="{{ $color->name }}"
                       onclick="event.preventDefault(); window.location=this.href;">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 7. Sizes -->
    @if(isset($filterSizes) && $filterSizes->count() > 0)
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Sizes</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            <div class="size-pill-list">
                @foreach($filterSizes as $size)
                    <a href="{{ filterUrl('size', $size->id, $queryParams, $currentUrl) }}"
                       class="size-pill {{ isSelected('size', $size->id, $queryParams) ? 'selected' : '' }}">
                        {{ $size->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 8. Discount -->
    <div class="filter-section">
        <div class="filter-section-header" onclick="toggleFilterSection(this)">
            <h6>Discount</h6>
            <i class="bi bi-chevron-down collapse-icon"></i>
        </div>
        <div class="filter-section-body">
            @foreach(['10','20','30','40','50'] as $disc)
                <a href="{{ filterUrl('discount', $disc, $queryParams, $currentUrl) }}"
                   class="discount-pill {{ isSelected('discount', $disc, $queryParams) ? 'selected' : '' }}">
                    {{ $disc }}%+
                </a>
            @endforeach
        </div>
    </div>

</div>

<!-- ====================
     MOBILE FILTER PANEL
==================== -->
<div class="filter-overlay" id="filterOverlay" onclick="toggleFilterPanel()"></div>
<div class="mobile-filter-panel" id="mobileFilterPanel">
    <div class="mobile-filter-header">
        <h5><i class="bi bi-funnel"></i> Filters</h5>
        <button class="mobile-filter-close" onclick="toggleFilterPanel()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="mobile-filter-body" id="mobileFilterBody">
        <!-- Content is cloned from sidebar via JS -->
    </div>
    <div class="mobile-filter-footer">
        <button class="reset-filter-btn" onclick="window.location='{{ $currentUrl . '?' . http_build_query($clearAllParams) }}'">
            Reset All
        </button>
        <button class="apply-filter-btn" onclick="toggleFilterPanel()">
            Apply Filters
        </button>
    </div>
</div>

<script>
// Toggle filter section collapse
function toggleFilterSection(header) {
    const body = header.nextElementSibling;
    const icon = header.querySelector('.collapse-icon');
    if (body) {
        body.classList.toggle('hidden');
        icon.classList.toggle('collapsed');
    }
}

// Toggle mobile filter panel
function toggleFilterPanel() {
    const panel = document.getElementById('mobileFilterPanel');
    const overlay = document.getElementById('filterOverlay');
    panel.classList.toggle('open');
    overlay.classList.toggle('active');
    document.body.style.overflow = panel.classList.contains('open') ? 'hidden' : '';

    // Clone sidebar content into mobile panel on first open
    if (panel.classList.contains('open')) {
        const mobileBody = document.getElementById('mobileFilterBody');
        const sidebar = document.querySelector('.filter-sidebar');
        if (mobileBody && sidebar && !mobileBody.hasChildNodes()) {
            mobileBody.innerHTML = sidebar.innerHTML;
            // Re-bind collapse events for cloned content
            mobileBody.querySelectorAll('.filter-section-header').forEach(h => {
                h.onclick = function() { toggleFilterSection(this); };
            });
        }
    }
}

// Apply price filter
function applyPriceFilter() {
    const minPrice = document.getElementById('minPriceInput').value;
    const maxPrice = document.getElementById('maxPriceInput').value;
    let url = '{{ $currentUrl }}?';
    const params = new URLSearchParams(window.location.search);

    if (minPrice) params.set('min_price', minPrice); else params.delete('min_price');
    if (maxPrice) params.set('max_price', maxPrice); else params.delete('max_price');

    window.location = url + params.toString();
}

// Close on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const panel = document.getElementById('mobileFilterPanel');
        if (panel && panel.classList.contains('open')) toggleFilterPanel();
    }
});
</script>