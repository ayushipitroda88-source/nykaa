<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Analytics Report</title>
    <style>
        /* Reset & Base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            padding: 20px 30px;
        }

        /* Company Header */
        .company-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px double #000;
            margin-bottom: 20px;
        }
        .company-header h1 {
            font-size: 22pt;
            color: #000;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .company-header p {
            font-size: 9pt;
            color: #555;
        }

        /* Report Title */
        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h2 {
            font-size: 16pt;
            color: #000;
            border-bottom: 1px solid #999;
            padding-bottom: 8px;
            display: inline-block;
        }

        /* Meta Info */
        .meta-info {
            margin-bottom: 20px;
            font-size: 9pt;
            color: #333;
        }
        .meta-info table { width: 100%; }
        .meta-info td { padding: 2px 5px; vertical-align: top; }
        .meta-info .label { font-weight: bold; width: 120px; }

        /* Filters Section */
        .filters-section {
            background: #f0f0f0;
            border: 1px solid #999;
            border-radius: 6px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
        .filters-section h4 {
            font-size: 11pt;
            color: #000;
            margin-bottom: 8px;
        }
        .filters-section .filter-item {
            display: inline-block;
            margin-right: 20px;
            font-size: 9pt;
        }
        .filters-section .filter-item strong {
            display: inline-block;
            min-width: 90px;
        }
        .filter-empty {
            color: #666;
            font-style: italic;
        }

        /* Data Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table thead th {
            background-color: #333;
            color: #ffffff;
            padding: 10px 8px;
            font-size: 9.5pt;
            text-align: left;
            font-weight: bold;
            border: 1px solid #000;
        }
        table.data-table tbody td {
            padding: 8px;
            border: 1px solid #999;
            vertical-align: middle;
            font-size: 9pt;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f0f0f0;
        }
        table.data-table tbody tr:hover {
            background-color: #e0e0e0;
        }

        /* Number badges */
        .badge-count {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 9pt;
        }
        .badge-cart { background-color: #333; color: #fff; }
        .badge-wishlist { background-color: #666; color: #fff; }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-size: 12pt;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
        .footer .page-number {
            /* DOMPDF automatically handles page numbering with inline PHP */
        }
    </style>
</head>
<body>

    <!-- Company Header -->
    <div class="company-header">
        <h1>{{ $seller->business_name }}</h1>
        <p>Seller Analytics Report</p>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h2>Product Analytics Report</h2>
    </div>

    <!-- Meta Information -->
    <div class="meta-info">
        <table>
            <tr>
                <td class="label">Export Date:</td>
                <td>{{ date('d F Y, h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Total Products:</td>
                <td>{{ $products->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Applied Filters Section -->
    <div class="filters-section">
        <h4>📋 Applied Filters</h4>
        <div>
            <span class="filter-item">
                <strong>Search:</strong>
                @if(request('search'))
                    {{ request('search') }}
                @else
                    <span class="filter-empty">None</span>
                @endif
            </span>
            <span class="filter-item">
                <strong>Category:</strong>
                @if(request('category_id') && isset($categories) && $categories->count())
                    {{ $categories->firstWhere('id', request('category_id'))->name ?? 'N/A' }}
                @else
                    <span class="filter-empty">All</span>
                @endif
            </span>
            <span class="filter-item">
                <strong>Brand:</strong>
                @if(request('brand_id') && isset($brands) && $brands->count())
                    {{ $brands->firstWhere('id', request('brand_id'))->name ?? 'N/A' }}
                @else
                    <span class="filter-empty">All</span>
                @endif
            </span>
            <span class="filter-item">
                <strong>Activity From:</strong>
                @if(request('date_from'))
                    {{ request('date_from') }}
                @else
                    <span class="filter-empty">None</span>
                @endif
            </span>
            <span class="filter-item">
                <strong>Activity To:</strong>
                @if(request('date_to'))
                    {{ request('date_to') }}
                @else
                    <span class="filter-empty">None</span>
                @endif
            </span>
        </div>
    </div>

    <!-- Data Table -->
    @if($products->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th style="width: 100px; text-align: center;">Cart Users</th>
                    <th style="width: 110px; text-align: center;">Wishlist Users</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->brand->name ?? '-' }}</td>
                        <td style="text-align: center;">
                            <span class="badge-count badge-cart">{{ $product->cart_users_count ?? 0 }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-count badge-wishlist">{{ $product->wishlist_users_count ?? 0 }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <p style="font-size: 24pt; margin-bottom: 10px;">📭</p>
            <p><strong>No Product Analytics Found</strong></p>
            <p>The current filters did not match any product records.</p>
        </div>
    @endif

    <!-- Footer with Page Number -->
    <div class="footer">
        <span>{{ $seller->business_name }} &mdash; Product Analytics Report &mdash; Generated on {{ date('d F Y, h:i A') }}</span>
    </div>

    <script type="text/php">
        $font = $fontMetrics->getFont("DejaVu Sans", "normal");
        $pdf->page_text(
            $pdf->get_width() / 2 - 40,
            $pdf->get_height() - 22,
            "Page {PAGE_NUM} of {PAGE_COUNT}",
            $font,
            9,
            array(80, 80, 80)
        );
    </script>

</body>
</html>