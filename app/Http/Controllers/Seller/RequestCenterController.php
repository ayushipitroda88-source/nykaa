<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\RequestCenterRequest;
use App\Http\Requests\RequestCenter\StoreRequestRequest;
use App\Services\RequestCenterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestCenterController extends Controller
{
    protected $requestCenterService;

    public function __construct(RequestCenterService $requestCenterService)
    {
        $this->requestCenterService = $requestCenterService;
    }

    /**
     * Display a listing of all requests for the seller.
     */
    public function index()
    {
        $sellerId = Auth::guard('seller')->id();
        $requests = RequestCenterRequest::where('seller_id', $sellerId)
            ->with(['product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.request-center.index', compact('requests'));
    }

    /**
     * Display pending requests.
     */
    public function pending()
    {
        $sellerId = Auth::guard('seller')->id();
        $requests = RequestCenterRequest::where('seller_id', $sellerId)
            ->where('status', 'pending')
            ->with(['product', 'variant'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.request-center.index', compact('requests'));
    }

    /**
     * Display approved requests.
     */
    public function approved()
    {
        $sellerId = Auth::guard('seller')->id();
        $requests = RequestCenterRequest::where('seller_id', $sellerId)
            ->where('status', 'approved')
            ->with(['product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.request-center.index', compact('requests'));
    }

    /**
     * Display rejected requests.
     */
    public function rejected()
    {
        $sellerId = Auth::guard('seller')->id();
        $requests = RequestCenterRequest::where('seller_id', $sellerId)
            ->where('status', 'rejected')
            ->with(['product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.request-center.index', compact('requests'));
    }

    /**
     * Display requests needing more info.
     */
    public function needMoreInfo()
    {
        $sellerId = Auth::guard('seller')->id();
        $requests = RequestCenterRequest::where('seller_id', $sellerId)
            ->where('status', 'need_more_info')
            ->with(['product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('seller.request-center.index', compact('requests'));
    }

    /**
     * Show the form for creating a new request.
     */
    public function create(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();
        $product = null;
        $variant = null;
        $mainCategories = Category::whereNull('parent_id')->orderBy('position')->get();

        if ($request->has('product_id')) {
            $product = Product::where('seller_id', $sellerId)
                ->with('variants.color', 'variants.sizes.size')
                ->findOrFail($request->product_id);
        }

        if ($request->has('variant_id')) {
            $variant = $product->variants()
                ->with('color', 'sizes.size')
                ->findOrFail($request->variant_id);
        }

        $requestType = $request->input('type', 'product_edit');
        $products = Product::where('seller_id', $sellerId)->get();

        return view('seller.request-center.create', compact(
            'products',
            'product',
            'variant',
            'requestType',
            'mainCategories'
        ));
    }

    /**
     * Store a newly created request.
     */
    public function store(StoreRequestRequest $request)
    {
        try {
            $data = $request->validated();
            $requestCenterRequest = $this->requestCenterService->createRequest($data);

            return redirect()
                ->route('seller.request-center.show', $requestCenterRequest->id)
                ->with('success', 'Request has been submitted successfully. Request #: ' . $requestCenterRequest->request_number);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified request.
     */
    public function show($id)
    {
        $sellerId = Auth::guard('seller')->id();
        $request = RequestCenterRequest::where('seller_id', $sellerId)
            ->with(['product', 'variant', 'reviewer', 'conversations.seller', 'conversations.admin'])
            ->findOrFail($id);

        return view('seller.request-center.show', compact('request'));
    }

    /**
     * Show the form for resubmitting a rejected request.
     */
    public function edit($id)
    {
        $sellerId = Auth::guard('seller')->id();
        $requestCenterRequest = RequestCenterRequest::where('seller_id', $sellerId)
            ->whereIn('status', ['rejected', 'need_more_info'])
            ->findOrFail($id);

        $mainCategories = Category::whereNull('parent_id')->orderBy('position')->get();
        $products = Product::where('seller_id', $sellerId)->get();
        $product = $requestCenterRequest->product;
        $variant = $requestCenterRequest->variant;

        return view('seller.request-center.edit', compact('requestCenterRequest', 'products', 'product', 'variant', 'mainCategories'));
    }

    /**
     * Update the specified request (resubmit).
     */
    public function update(StoreRequestRequest $request, $id)
    {
        $sellerId = Auth::guard('seller')->id();
        $requestCenterRequest = RequestCenterRequest::where('seller_id', $sellerId)
            ->whereIn('status', ['rejected', 'need_more_info'])
            ->findOrFail($id);

        try {
            $data = $request->validated();
            $this->requestCenterService->resubmitRequest($requestCenterRequest, $data);

            return redirect()
                ->route('seller.request-center.show', $requestCenterRequest->id)
                ->with('success', 'Request has been resubmitted successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Seller adds a message to the conversation.
     */
    public function addMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $sellerId = Auth::guard('seller')->id();
        $requestCenterRequest = RequestCenterRequest::where('seller_id', $sellerId)->findOrFail($id);

        $this->requestCenterService->addSellerMessage($requestCenterRequest, $request->message);

        return back()->with('success', 'Message added successfully.');
    }

    /**
     * Mark notifications as read.
     */
    public function markNotificationsRead()
    {
        $sellerId = Auth::guard('seller')->id();
        $this->requestCenterService->markNotificationsAsRead($sellerId);

        return response()->json(['success' => true]);
    }

    /**
     * Get products for the given request type (AJAX).
     */
    public function getProducts()
    {
        $sellerId = Auth::guard('seller')->id();
        $products = Product::where('seller_id', $sellerId)->get(['id', 'title']);
        return response()->json($products);
    }

    /**
     * Get product variants (AJAX).
     */
    public function getVariants($productId)
    {
        $sellerId = Auth::guard('seller')->id();
        $product = Product::where('seller_id', $sellerId)->findOrFail($productId);
        $variants = $product->variants()->with('color')->get(['id', 'color_id', 'sku']);

        return response()->json($variants->map(function ($v) {
            return [
                'id' => $v->id,
                'label' => ($v->color ? $v->color->name : 'No Color') . ($v->sku ? ' - ' . $v->sku : ''),
            ];
        }));
    }
}