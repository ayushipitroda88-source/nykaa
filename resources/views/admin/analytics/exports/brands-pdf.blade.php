<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Analytics Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #333;
            padding: 20px 30px;
        }

        .company-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px double #007BFF;
            margin-bottom: 20px;
        }
        .company-header h1 {
            font-size: 22pt;
            color: #007BFF;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .company-header p {
            font-size: 9pt;
            color: #666;
        }

        .report-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title h2 {
            font-size: 16pt;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
            display: inline-block;
        }

        .meta-info {
            margin-bottom: 20px;
            font-size: 9pt;
            color: #555;
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
            background-color: #007BFF;
            color: #ffffff;
            padding: 10px 8px;
            font-size: 9.5pt;
            text-align: left;
            font-weight: bold;
            border: 1px solid #0056b3;
        }
        table.data-table tbody td {
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
            font-size: 9pt;
        }
        table.data-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .badge-count {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 9pt;
        }
        .badge-cart { background-color: #007BFF; color: #fff; }
        .badge-wishlist { background-color: #17a2b8; color: #fff; }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
            font-size: 12pt;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    <!-- Company Header -->
    <div class="company-header">
        <h1>Nykaa Marketplace</h1>
        <p>Your Trusted Beauty &amp; Lifestyle Destination</p>
    </div>

    <!-- Report Title -->
    <div class="report-title">
        <h2>Brand Analytics Report</h2>
    </div>

    <!-- Meta Information -->
    <div class="meta-info">
        <table>
            <tr>
                <td class="label">Export Date:</td>
                <td>{{ date('d F Y, h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Total Brands:</td>
                <td>{{ $brands->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Data Table -->
    @if($brands->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Brand Name</th>
                    <th style="width: 120px; text-align: center;">Total Products</th>
                    <th style="width: 120px; text-align: center;">Cart Users</th>
                    <th style="width: 120px; text-align: center;">Wishlist Users</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $brand->name }}</td>
                        <td style="text-align: center;">{{ $brand->products_count }}</td>
                        <td style="text-align: center;">
                            <span class="badge-count badge-cart">{{ $brand->cart_users_count ?? 0 }}</span>
                        </td>
                        <td style="text-align: center;">
                            <span class="badge-count badge-wishlist">{{ $brand->wishlist_users_count ?? 0 }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p style="font-size: 24pt; margin-bottom: 10px;">📭</p>
            <p><strong>No Brand Analytics Found</strong></p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <span>Nykaa Marketplace &mdash; Brand Analytics Report &mdash; Generated on {{ date('d F Y, h:i A') }}</span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $fontMetrics = $pdf->getFontMetrics();
            $font = $fontMetrics->getFont('DejaVu Sans');
            $size = 8;
            $canvas = $pdf->getCanvas();
            $w = $canvas->get_width();
            $h = $canvas->get_height();
            $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
            $x = ($w - $textWidth) / 2;
            $y = $h - 12;
            $canvas->page_text($x, $y, $text, $font, $size, array(153, 153, 153));
        }
    </script>
</body>
</html>
