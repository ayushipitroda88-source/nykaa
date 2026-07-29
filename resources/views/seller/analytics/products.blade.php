@extends('layout.seller')

@section('page-title', 'Product Analytics')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="fw-bold mb-1" style="color:var(--nykaa-dark);">Product Analytics</h4>
        <p class="text-muted mb-0">Analyze customer interest in your products</p>
    </div>
</div>

{{-- Filters --}}
<div class="seller-card mb-4">
    <div class="card-body-custom">
        <form action="{{ route('seller.analytics.products') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Search Product</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by title..." style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Category</label>
                <select name="category_id" class="form-select" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
            </div>
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn-nykaa me-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button type="button" class="btn-nykaa-outline me-2" onclick="openPdfModal()">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
                <a href="{{ route('seller.analytics.products.export-excel', request()->query()) }}" class="btn-nykaa-outline text-decoration-none" style="border-color:var(--nykaa-success);color:var(--nykaa-success);">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="seller-card">
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="seller-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th class="text-center">Cart Users</th>
                        <th class="text-center">Wishlist Users</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}" style="width:44px;height:44px;object-fit:cover;border-radius:8px;" class="me-3">
                                    <span class="fw-semibold">{{ $product->title }}</span>
                                </div>
                            </td>
                            <td>{{ $product->brand->name ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge-nykaa bg-active fs-6 px-3">{{ $product->cart_users_count ?? 0 }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge-nykaa bg-pending fs-6 px-3">{{ $product->wishlist_users_count ?? 0 }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5" style="color:var(--nykaa-text-light);">
                                <i class="fas fa-chart-line fa-2x mb-2 d-block"></i>
                                No Product Analytics Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($products->count() > 0)
                <tfoot>
                    <tr style="background:#FAFAFE;">
                        <td colspan="2" class="fw-bold">Total (This Page)</td>
                        <td class="text-center">
                            <span class="badge-nykaa bg-active fs-6 px-3">{{ $products->sum('cart_users_count') }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge-nykaa bg-pending fs-6 px-3">{{ $products->sum('wishlist_users_count') }}</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        <div class="p-3 border-top" style="border-color:var(--nykaa-border)!important;">
            {{ $products->links() }}
        </div>
    </div>
</div>

{{-- PDF Preview Modal --}}
<div id="pdfModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; width:90%; max-width:960px; height:90vh; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.4); overflow:hidden;">
        <div style="background:linear-gradient(135deg,var(--nykaa-pink),var(--nykaa-purple)); padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="fas fa-file-pdf" style="color:#fff; font-size:22px;"></i>
                <div>
                    <h5 style="margin:0; color:#fff; font-size:16px; font-weight:700;">Product Analytics Report</h5>
                    <small style="color:rgba(255,255,255,0.75); font-size:12px;">Preview before downloading or printing</small>
                </div>
            </div>
            <button onclick="closePdfModal()" style="background:rgba(255,255,255,0.2); border:none; color:#fff; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:18px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
        <div style="flex:1; position:relative; overflow:hidden;">
            <div id="pdfLoadingOverlay" style="position:absolute; top:0; left:0; width:100%; height:100%; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; z-index:10;">
                <div class="spinner-border text-danger" style="width:48px; height:48px;" role="status"></div>
                <p style="margin-top:16px; color:#6c757d; font-size:14px;">Loading PDF preview...</p>
            </div>
            <iframe id="pdfIframe" src="" style="width:100%; height:100%; border:none;" onload="hidePdfLoading()"></iframe>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var pdfExportUrl = "{{ route('seller.analytics.products.export-pdf', request()->query()) }}";

    function openPdfModal() {
        var modal = document.getElementById('pdfModal');
        var iframe = document.getElementById('pdfIframe');
        var loadingOverlay = document.getElementById('pdfLoadingOverlay');
        loadingOverlay.style.display = 'flex';
        iframe.src = '';
        iframe.src = pdfExportUrl;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePdfModal() {
        var modal = document.getElementById('pdfModal');
        var iframe = document.getElementById('pdfIframe');
        iframe.src = '';
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    function hidePdfLoading() {
        document.getElementById('pdfLoadingOverlay').style.display = 'none';
    }

    // Close modal on backdrop click
    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) closePdfModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePdfModal();
    });
</script>
@endpush
@endsection