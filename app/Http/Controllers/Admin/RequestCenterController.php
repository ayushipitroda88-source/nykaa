<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestCenterRequest;
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
     * Display all requests.
     */
    public function index()
    {
        $requests = RequestCenterRequest::with(['seller', 'product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.request-center.index', compact('requests'));
    }

    /**
     * Display pending requests.
     */
    public function pending()
    {
        $requests = RequestCenterRequest::where('status', 'pending')
            ->with(['seller', 'product', 'variant'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.request-center.index', compact('requests'));
    }

    /**
     * Display approved requests.
     */
    public function approved()
    {
        $requests = RequestCenterRequest::where('status', 'approved')
            ->with(['seller', 'product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.request-center.index', compact('requests'));
    }

    /**
     * Display rejected requests.
     */
    public function rejected()
    {
        $requests = RequestCenterRequest::where('status', 'rejected')
            ->with(['seller', 'product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.request-center.index', compact('requests'));
    }

    /**
     * Display requests needing more info.
     */
    public function needMoreInfo()
    {
        $requests = RequestCenterRequest::where('status', 'need_more_info')
            ->with(['seller', 'product', 'variant', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.request-center.index', compact('requests'));
    }

    /**
     * Display request history (approved + rejected).
     */
    public function history()
    {
        $requests = RequestCenterRequest::whereIn('status', ['approved', 'rejected'])
            ->with(['seller', 'product', 'variant', 'reviewer'])
            ->orderBy('reviewed_at', 'desc')
            ->paginate(20);

        return view('admin.request-center.index', compact('requests'));
    }

    /**
     * Display the specified request details.
     */
    public function show($id)
    {
        $request = RequestCenterRequest::with([
            'seller',
            'product',
            'variant.color',
            'variant.sizes.size',
            'reviewer',
            'conversations.seller',
            'conversations.admin',
        ])->findOrFail($id);

        return view('admin.request-center.show', compact('request'));
    }

    /**
     * Approve a request.
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $requestCenterRequest = RequestCenterRequest::findOrFail($id);

        try {
            $this->requestCenterService->approveRequest($requestCenterRequest, $request->admin_notes);
            return redirect()
                ->route('admin.request-center.show', $requestCenterRequest->id)
                ->with('success', 'Request has been approved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error approving request: ' . $e->getMessage());
        }
    }

    /**
     * Reject a request.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ], [
            'reject_reason.required' => 'Reject reason is mandatory.',
        ]);

        $requestCenterRequest = RequestCenterRequest::findOrFail($id);

        try {
            $this->requestCenterService->rejectRequest($requestCenterRequest, $request->reject_reason);
            return redirect()
                ->route('admin.request-center.show', $requestCenterRequest->id)
                ->with('success', 'Request has been rejected.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error rejecting request: ' . $e->getMessage());
        }
    }

    /**
     * Request more information from seller.
     */
    public function requestMoreInfo(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $requestCenterRequest = RequestCenterRequest::findOrFail($id);

        try {
            $this->requestCenterService->requestMoreInfo($requestCenterRequest, $request->message);
            return redirect()
                ->route('admin.request-center.show', $requestCenterRequest->id)
                ->with('success', 'More information requested from seller.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Admin adds a message to the conversation.
     */
    public function addMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $requestCenterRequest = RequestCenterRequest::findOrFail($id);
        $this->requestCenterService->addAdminMessage($requestCenterRequest, $request->message);

        return back()->with('success', 'Message added successfully.');
    }
}