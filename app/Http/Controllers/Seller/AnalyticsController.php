<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

use Barryvdh\DomPDF\Facade\Pdf;

class AnalyticsController extends Controller
{
    private function getProductAnalyticsQuery(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();

        $query = Product::with(['brand', 'category'])
            ->where('seller_id', $sellerId);

        $cartSubquery = DB::table('cart_items')
            ->selectRaw('count(distinct user_id)')
            ->whereColumn('product_id', 'products.id');

        $wishlistSubquery = DB::table('wishlists')
            ->selectRaw('count(distinct user_id)')
            ->whereColumn('product_id', 'products.id');

        if ($request->filled('date_from')) {
            $cartSubquery->whereDate('created_at', '>=', $request->date_from);
            $wishlistSubquery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $cartSubquery->whereDate('created_at', '<=', $request->date_to);
            $wishlistSubquery->whereDate('created_at', '<=', $request->date_to);
        }

        $query->addSelect([
            'cart_users_count' => $cartSubquery,
            'wishlist_users_count' => $wishlistSubquery
        ]);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        return $query;
    }
    public function products(Request $request)
    {
        $query = $this->getProductAnalyticsQuery($request);

        $products = $query->paginate(15)->withQueryString();
        
        $categories = Category::all();

        return view('seller.analytics.products', compact('products', 'categories'));
    }

    public function exportPdf(Request $request)
    {
        try {
            $query = $this->getProductAnalyticsQuery($request);
            $products = $query->get();

            if ($products->isEmpty()) {
                return redirect()->route('seller.analytics.products')
                    ->with('error', 'No records found matching the applied filters. Cannot generate an empty PDF.');
            }

            $categories = Category::all();
            $seller = Auth::guard('seller')->user();

            $pdf = Pdf::loadView('seller.analytics.exports.products-pdf', compact('products', 'categories', 'seller'))
                ->setPaper('a4', 'landscape');

            $fileName = 'product-analytics-report-' . date('Y-m-d-His') . '.pdf';

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'GD extension')) {
                return redirect()->back()->with('error', 'The PHP GD extension is required to generate PDFs. Please enable "ext-gd" in your PHP configuration (php.ini).');
            }
            return redirect()->back()->with('error', 'Could not generate PDF: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $products = $this->getProductAnalyticsQuery($request)->get();

        if ($products->isEmpty()) {
            return redirect()->route('seller.analytics.products')
                ->with('error', 'No records found matching the applied filters. Cannot generate an empty Excel file.');
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Product');
        $sheet->setCellValue('B1', 'Brand');
        $sheet->setCellValue('C1', 'Cart Users');
        $sheet->setCellValue('D1', 'Wishlist Users');
        
        // Bold header
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product->title);
            $sheet->setCellValue('B' . $row, $product->brand ? $product->brand->name : '-');
            $sheet->setCellValue('C' . $row, $product->cart_users_count);
            $sheet->setCellValue('D' . $row, $product->wishlist_users_count);
            $row++;
        }

        // Auto width
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Borders
        if ($row > 2) {
            $sheet->getStyle('A1:D' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'product-analytics-report-' . date('Y-m-d-His') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        exit;
    }
}
