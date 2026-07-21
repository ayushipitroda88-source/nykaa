@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Product Analytics</h3>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.analytics.products') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Search Product</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Title...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Seller</label>
                    <select name="seller_id" class="form-select">
                        <option value="">All Sellers</option>
                        @foreach($sellers as $seller)
                            <option value="{{ $seller->id }}" {{ request('seller_id') == $seller->id ? 'selected' : '' }}>{{ $seller->business_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Activity From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Activity To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-filter"></i> Filter</button>
                    <button type="button" class="btn btn-danger me-2" onclick="openPdfModal()"><i class="fas fa-file-pdf"></i> Export PDF</button>
                    <a href="{{ route('admin.analytics.products.export-excel', request()->query()) }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
               <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Seller</th>
                    <th>Category</th>
                    <th class="text-center">Cart Users</th>
                    <th class="text-center">Wishlist Users</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}" style="width:50px; height:50px; object-fit:cover; border-radius:4px;" class="me-3">
                                    <span>{{ $product->title }}</span>
                                </div>
                            </td>
                            <td>{{ $product->brand->name ?? '-' }}</td>
                            <td>{{ $product->seller->business_name ?? '-' }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td class="text-center"><span class="badge bg-primary fs-6">{{ $product->cart_users_count }}</span></td>
                            <td class="text-center"><span class="badge bg-info text-dark fs-6">{{ $product->wishlist_users_count }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No Product Analytics Found</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($products->count() > 0)
                <tfoot>
                    <tr class="table-secondary fw-bold">
                        <td colspan="4">Total (This Page)</td>
                        <td class="text-center"><span class="badge bg-primary fs-6">{{ $products->sum('cart_users_count') }}</span></td>
                        <td class="text-center"><span class="badge bg-info text-dark fs-6">{{ $products->sum('wishlist_users_count') }}</span></td>
                    </tr>
                </tfoot>
                @endif
            </table>
            
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
<!-- PDF Preview Modal -->
<div id="pdfModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; width:90%; max-width:960px; height:90vh; display:flex; flex-direction:column; box-shadow:0 20px 60px rgba(0,0,0,0.4); overflow:hidden;">
        <!-- Modal Header -->
        <div style="background:linear-gradient(135deg,#dc3545,#a71d2a); padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:12px;">
                <i class="fas fa-file-pdf" style="color:#fff; font-size:22px;"></i>
                <div>
                    <h5 style="margin:0; color:#fff; font-size:16px; font-weight:700;">Product Analytics Report</h5>
                    <small style="color:rgba(255,255,255,0.75); font-size:12px;">Preview before downloading or printing</small>
                </div>
            </div>
            <button onclick="closePdfModal()" style="background:rgba(255,255,255,0.2); border:none; color:#fff; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:18px; display:flex; align-items:center; justify-content:center; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">&times;</button>
        </div>
        <!-- PDF Iframe -->
        <div style="flex:1; position:relative; overflow:hidden;">
            <div id="pdfLoadingOverlay" style="position:absolute; top:0; left:0; width:100%; height:100%; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; z-index:10;">
                <div class="spinner-border text-danger" style="width:48px; height:48px;" role="status"></div>
                <p style="margin-top:16px; color:#6c757d; font-size:14px;">Loading PDF preview...</p>
            </div>
            <iframe id="pdfIframe" src="" style="width:100%; height:100%; border:none;" onload="hidePdfLoading()"></iframe>
        </div>
    </div>
</div>

<script>
    var pdfExportUrl = "{{ route('admin.analytics.products.export-pdf', request()->query()) }}";

    function openPdfModal() {
        var modal = document.getElementById('pdfModal');
        var iframe = document.getElementById('pdfIframe');
        var loadingOverlay = document.getElementById('pdfLoadingOverlay');

        // Reset
        loadingOverlay.style.display = 'flex';
        iframe.src = '';

        // Set URL
        iframe.src = pdfExportUrl;

        // Show modal
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

    function printPdf() {
        var iframe = document.getElementById('pdfIframe');
        try {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        } catch(e) {
            // Fallback: open in new tab and print
            window.open(pdfExportUrl, '_blank');
        }
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

@endsection
