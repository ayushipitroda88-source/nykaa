<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Seller;
use App\Models\Category;
use App\Exports\ProductAnalyticsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AnalyticsController extends Controller
{
    /**
     * Build the base product analytics query with cart/wishlist subqueries and filters.
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getProductAnalyticsQuery(Request $request)
    {
        $query = Product::with(['brand', 'seller', 'category']);

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
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        return $query;
    }

    /**
     * Display the product analytics page with filters and paginated results.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function products(Request $request)
    {
        $query = $this->getProductAnalyticsQuery($request);
        $products = $query->paginate(15)->withQueryString();
        
        $brands = Brand::all();
        $sellers = Seller::all();
        $categories = Category::all();

        return view('admin.analytics.products', compact('products', 'brands', 'sellers', 'categories'));
    }

    /**
     * Export filtered products as a PDF document.
     * Shows a message if no records are found.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function exportPdf(Request $request)
    {
        try {
            // Reuse the same analytics query to respect all filters
            $query = $this->getProductAnalyticsQuery($request);
            $products = $query->get();

            // If no records found, redirect back with a message
            if ($products->isEmpty()) {
                return redirect()->route('admin.analytics.products')
                    ->with('error', 'No records found matching the applied filters. Cannot generate an empty PDF.');
            }

            // Load brands and categories for filter labels in the PDF
            $brands = Brand::all();
            $categories = Category::all();

            // Generate PDF with landscape orientation and A4 size
            $pdf = Pdf::loadView('admin.analytics.exports.products-pdf', compact('products', 'brands', 'categories'))
                ->setPaper('a4', 'landscape');

            // Generate filename with current date
            $fileName = 'product-analytics-report-' . date('Y-m-d-His') . '.pdf';

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'GD extension')) {
                return redirect()->back()->with('error', 'The PHP GD extension is required to generate PDFs. Please enable "ext-gd" in your PHP configuration (php.ini).');
            }
            return redirect()->back()->with('error', 'Could not generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * Export filtered products as an Excel file.
     * Shows a message if no records are found.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function exportExcel(Request $request)
    {
        $products = $this->getProductAnalyticsQuery($request)->get();

        if ($products->isEmpty()) {
            return redirect()->route('admin.analytics.products')
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

    public function brands(Request $request)
    {
        $query = Brand::withCount('products');

        $cartSubquery = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->selectRaw('count(distinct cart_items.user_id)')
            ->whereColumn('products.brand_id', 'brands.id');

        $wishlistSubquery = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->selectRaw('count(distinct wishlists.user_id)')
            ->whereColumn('products.brand_id', 'brands.id');

        $query->addSelect([
            'cart_users_count' => $cartSubquery,
            'wishlist_users_count' => $wishlistSubquery
        ]);

        $brands = $query->paginate(15)->withQueryString();

        return view('admin.analytics.brands', compact('brands'));
    }

    public function sellers(Request $request)
    {
        $query = Seller::withCount('products');

        $cartSubquery = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->selectRaw('count(distinct cart_items.user_id)')
            ->whereColumn('products.seller_id', 'sellers.id');

        $wishlistSubquery = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->selectRaw('count(distinct wishlists.user_id)')
            ->whereColumn('products.seller_id', 'sellers.id');

        $query->addSelect([
            'cart_users_count' => $cartSubquery,
            'wishlist_users_count' => $wishlistSubquery
        ]);

        $sellers = $query->paginate(15)->withQueryString();

        return view('admin.analytics.sellers', compact('sellers'));
    }

    public function exportBrandsPdf(Request $request)
    {
        try {
            $query = Brand::withCount('products');

            $cartSubquery = DB::table('cart_items')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->selectRaw('count(distinct cart_items.user_id)')
                ->whereColumn('products.brand_id', 'brands.id');

            $wishlistSubquery = DB::table('wishlists')
                ->join('products', 'wishlists.product_id', '=', 'products.id')
                ->selectRaw('count(distinct wishlists.user_id)')
                ->whereColumn('products.brand_id', 'brands.id');

            $query->addSelect([
                'cart_users_count' => $cartSubquery,
                'wishlist_users_count' => $wishlistSubquery
            ]);

            $brands = $query->get();

            if ($brands->isEmpty()) {
                return redirect()->route('admin.analytics.brands')
                    ->with('error', 'No brand records found. Cannot generate an empty PDF.');
            }

            $pdf = Pdf::loadView('admin.analytics.exports.brands-pdf', compact('brands'))
                ->setPaper('a4', 'landscape');

            $fileName = 'brand-analytics-report-' . date('Y-m-d-His') . '.pdf';

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not generate PDF: ' . $e->getMessage());
        }
    }

    public function exportSellersPdf(Request $request)
    {
        try {
            $query = Seller::withCount('products');

            $cartSubquery = DB::table('cart_items')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->selectRaw('count(distinct cart_items.user_id)')
                ->whereColumn('products.seller_id', 'sellers.id');

            $wishlistSubquery = DB::table('wishlists')
                ->join('products', 'wishlists.product_id', '=', 'products.id')
                ->selectRaw('count(distinct wishlists.user_id)')
                ->whereColumn('products.seller_id', 'sellers.id');

            $query->addSelect([
                'cart_users_count' => $cartSubquery,
                'wishlist_users_count' => $wishlistSubquery
            ]);

            $sellers = $query->get();

            if ($sellers->isEmpty()) {
                return redirect()->route('admin.analytics.sellers')
                    ->with('error', 'No seller records found. Cannot generate an empty PDF.');
            }

            $pdf = Pdf::loadView('admin.analytics.exports.sellers-pdf', compact('sellers'))
                ->setPaper('a4', 'landscape');

            $fileName = 'seller-analytics-report-' . date('Y-m-d-His') . '.pdf';

            return $pdf->stream($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Could not generate PDF: ' . $e->getMessage());
        }
    }
}
