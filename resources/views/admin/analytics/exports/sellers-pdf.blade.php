<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Analytics Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            padding: 20px 30px;
        }

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

        .meta-info {
            margin-bottom: 20px;
            font-size: 9pt;
            color: #333;
        }
        .meta-info table { width: 100%; }
        .meta-info td { padding: 2px 5px; vertical-align: top; }
        .meta-info .label { font-weight: bold; width: 120px; }

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

        .badge-count {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 9pt;
        }
        .badge-cart { background-color: #333; color: #fff; }
        .badge-wishlist { background-color: #666; color: #fff; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
            font-size: 12pt;
        }

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
    </style>
</head>
<body>

    <!-- Company Header -->
    <div class="company-header">
        <h1>Nykaa Marketplace</h1>
        <p>Your Trusted Beauty & Lifestyle Destination</p>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h2>Seller Analytics Report</h2>
    </div>

    <!-- Meta Information -->
    <div class="meta-info">
        <table>
            <tr>
                <td class="label">Export Date:</td>
                <td>{{ date('d F Y, h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Total Sellers:</td>
                <td>{{ $sellers->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Data Table -->
    @if($sellers->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Seller Name</th>
                    <th style="width: 120px; text-align: center;">Total Products</th>
                    <th style="width: 120px; text-align: center;">Cart Users</th>
                    <th style="width: 120px; text-align: center;">Wishlist Users</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $seller)
                    <tr>
                        <td>{{ $seller->business_name }}</td>
                        <td style="text-align: center;">{{ $seller->products_count }}</td>
                        <td style="text-align: center;">
                            <span class="badge-count badge-cart">{{ $seller->cart_users_count ?? 0 }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-count badge-wishlist">{{ $seller->wishlist_users_count ?? 0 }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p style="font-size: 24pt; margin-bottom: 10px;">📭</p>
            <p><strong>No Seller Analytics Found</strong></p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <span>Nykaa Marketplace &mdash; Seller Analytics Report &mdash; Generated on {{ date('d F Y, h:i A') }}</span>
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