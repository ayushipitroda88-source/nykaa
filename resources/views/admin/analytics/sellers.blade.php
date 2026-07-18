@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Seller Analytics</h3>
        <button type="button" class="btn btn-danger" onclick="openPdfModal()"><i class="fas fa-file-pdf"></i> Export PDF</button>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
               <thead class="table-dark">
                <tr>
                    <th>Seller Name</th>
                    <th class="text-center">Total Products</th>
                    <th class="text-center">Total Cart Users</th>
                    <th class="text-center">Total Wishlist Users</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($seller->business_logo)
                                        <img src="{{ asset('uploads/'.$seller->business_logo) }}" alt="{{ $seller->business_name }}" style="width:40px; height:40px; object-fit:contain;" class="me-3">
                                    @endif
                                    <span>{{ $seller->business_name }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $seller->products_count }}</td>
                            <td class="text-center"><span class="badge bg-primary fs-6">{{ $seller->cart_users_count ?? 0 }}</span></td>
                            <td class="text-center"><span class="badge bg-info text-dark fs-6">{{ $seller->wishlist_users_count ?? 0 }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No Seller Analytics Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-3">
                {{ $sellers->links() }}
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
                    <h5 style="margin:0; color:#fff; font-size:16px; font-weight:700;">Seller Analytics Report</h5>
                    <small style="color:rgba(255,255,255,0.75); font-size:12px;">PDF Preview</small>
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
    var pdfExportUrl = "{{ route('admin.analytics.sellers.export-pdf') }}";

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

    document.getElementById('pdfModal').addEventListener('click', function(e) {
        if (e.target === this) closePdfModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePdfModal();
    });
</script>

@endsection
