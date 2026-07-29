<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RequestCenterRequest;
use App\Models\RequestCenterConversation;
use App\Models\RequestCenterNotification;
use App\Models\VariantSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestCenterService
{
    /**
     * Create a new request in the request center.
     */
    public function createRequest(array $data): RequestCenterRequest
    {
        return DB::transaction(function () use ($data) {
            $sellerId = Auth::guard('seller')->id();
            $product = Product::where('seller_id', $sellerId)->findOrFail($data['product_id']);
            
            // Check for duplicate pending requests
            $this->checkDuplicatePendingRequest($sellerId, $data['request_type'], $data['product_id'], $data['variant_id'] ?? null);
            
            // Capture current live data snapshot
            $currentData = $this->captureCurrentData($product, $data['variant_id'] ?? null);
            
            // Capture requested changes
            $requestedData = $this->buildRequestedData($data, $currentData);
            
            $request = RequestCenterRequest::create([
                'request_number' => RequestCenterRequest::generateRequestNumber(),
                'seller_id' => $sellerId,
                'request_type' => $data['request_type'],
                'status' => 'pending',
                'product_id' => $data['product_id'],
                'variant_id' => $data['variant_id'] ?? null,
                'reason' => $data['reason'] ?? null,
                'notes' => $data['notes'] ?? null,
                'attachment' => $this->handleAttachment($data['attachment'] ?? null),
                'requested_data' => $requestedData,
                'current_data' => $currentData,
            ]);

            return $request;
        });
    }

    /**
     * Approve a request and apply changes to live data.
     */
    public function approveRequest(RequestCenterRequest $request, string $adminNotes = null): void
    {
        DB::transaction(function () use ($request, $adminNotes) {
            $adminId = Auth::guard('admin')->id();
            $requestedData = $request->requested_data;

            switch ($request->request_type) {
                case 'product_edit':
                    $this->applyProductEdit($request->product, $requestedData);
                    break;
                case 'product_delete':
                    $this->applyProductDelete($request->product);
                    break;
                case 'variant_edit':
                    $this->applyVariantEdit($request->variant, $requestedData);
                    break;
                case 'variant_delete':
                    $this->applyVariantDelete($request->variant);
                    break;
            }

            $request->update([
                'status' => 'approved',
                'reviewed_by' => $adminId,
                'admin_notes' => $adminNotes,
                'reviewed_at' => now(),
            ]);

            $this->createNotification(
                $request->seller_id,
                $request->id,
                'Request Approved',
                "Your {$this->getRequestTypeLabel($request->request_type)} Request ({$request->request_number}) has been approved."
            );
        });
    }

    /**
     * Reject a request.
     */
    public function rejectRequest(RequestCenterRequest $request, string $reason): void
    {
        DB::transaction(function () use ($request, $reason) {
            $adminId = Auth::guard('admin')->id();

            $request->update([
                'status' => 'rejected',
                'reviewed_by' => $adminId,
                'admin_notes' => $reason,
                'reviewed_at' => now(),
            ]);

            $this->createNotification(
                $request->seller_id,
                $request->id,
                'Request Rejected',
                "Your {$this->getRequestTypeLabel($request->request_type)} Request ({$request->request_number}) has been rejected. Reason: {$reason}"
            );
        });
    }

    /**
     * Mark request as needing more information.
     */
    public function requestMoreInfo(RequestCenterRequest $request, string $message): void
    {
        DB::transaction(function () use ($request, $message) {
            $adminId = Auth::guard('admin')->id();

            $request->update([
                'status' => 'need_more_info',
                'reviewed_by' => $adminId,
                'reviewed_at' => now(),
            ]);

            // Add the admin message to conversation
            RequestCenterConversation::create([
                'request_id' => $request->id,
                'admin_id' => $adminId,
                'message' => $message,
            ]);

            $this->createNotification(
                $request->seller_id,
                $request->id,
                'More Information Needed',
                "Your {$this->getRequestTypeLabel($request->request_type)} Request ({$request->request_number}) needs more information. Please check the conversation."
            );
        });
    }

    /**
     * Seller adds a message to the conversation.
     */
    public function addSellerMessage(RequestCenterRequest $request, string $message): void
    {
        $sellerId = Auth::guard('seller')->id();
        if ($request->seller_id !== $sellerId) {
            abort(403, 'Unauthorized action.');
        }

        RequestCenterConversation::create([
            'request_id' => $request->id,
            'seller_id' => $sellerId,
            'message' => $message,
        ]);

        // When seller replies, set status back to pending for admin review
        if ($request->status === 'need_more_info') {
            $request->update(['status' => 'pending']);
        }
    }

    /**
     * Admin adds a message to the conversation.
     */
    public function addAdminMessage(RequestCenterRequest $request, string $message): void
    {
        RequestCenterConversation::create([
            'request_id' => $request->id,
            'admin_id' => Auth::guard('admin')->id(),
            'message' => $message,
        ]);
    }

    /**
     * Seller resubmits a rejected request with modifications.
     */
    public function resubmitRequest(RequestCenterRequest $request, array $data): RequestCenterRequest
    {
        return DB::transaction(function () use ($request, $data) {
            $sellerId = Auth::guard('seller')->id();
            if ($request->seller_id !== $sellerId) {
                abort(403);
            }

            $product = Product::findOrFail($request->product_id);
            $currentData = $this->captureCurrentData($product, $request->variant_id);
            $requestedData = $this->buildRequestedData($data, $currentData);

            $request->update([
                'status' => 'pending',
                'reason' => $data['reason'] ?? $request->reason,
                'notes' => $data['notes'] ?? $request->notes,
                'attachment' => $this->handleAttachment($data['attachment'] ?? null) ?? $request->attachment,
                'requested_data' => $requestedData,
                'current_data' => $currentData,
                'reviewed_by' => null,
                'admin_notes' => null,
                'reviewed_at' => null,
            ]);

            return $request;
        });
    }

    /**
     * Check for duplicate pending requests.
     */
    private function checkDuplicatePendingRequest(int $sellerId, string $requestType, int $productId, int $variantId = null): void
    {
        $query = RequestCenterRequest::where('seller_id', $sellerId)
            ->where('request_type', $requestType)
            ->where('product_id', $productId)
            ->whereIn('status', ['pending', 'need_more_info']);

        if ($variantId) {
            $query->where('variant_id', $variantId);
        }

        if ($query->exists()) {
            throw new \Exception('A pending request already exists for this ' . ($variantId ? 'variant' : 'product') . '. Please wait for it to be reviewed.');
        }
    }

    /**
     * Capture current live data as a snapshot.
     */
    private function captureCurrentData(Product $product, ?int $variantId = null): array
    {
        $data = [
            'product' => [
                'title' => $product->title,
                'description' => $product->description,
                'category_id' => $product->category_id,
                'brand_id' => $product->brand_id,
                'category' => $product->category ? $product->category->name : null,
                'brand' => $product->brand ? $product->brand->name : null,
            ],
        ];

        if ($variantId) {
            $variant = ProductVariant::with('color', 'sizes.size')->find($variantId);
            if ($variant) {
                $data['variant'] = [
                    'id' => $variant->id,
                    'color_id' => $variant->color_id,
                    'color_name' => $variant->color ? $variant->color->name : null,
                    'priority' => $variant->priority,
                    'sku' => $variant->sku,
                    'status' => $variant->status,
                    'image' => $variant->image,
                    'sizes' => $variant->sizes->map(function ($vs) {
                        return [
                            'id' => $vs->id,
                            'size_id' => $vs->size_id,
                            'size_name' => $vs->size ? $vs->size->name : null,
                            'price' => $vs->price,
                            'original_price' => $vs->original_price,
                            'quantity' => $vs->quantity,
                        ];
                    })->toArray(),
                ];
            }
        }

        return $data;
    }

    /**
     * Build requested data from form input.
     */
    private function buildRequestedData(array $data, array $currentData): array
    {
        $requestedData = [];

        if (isset($data['product_title']) || isset($data['product_description']) || isset($data['category_id'])) {
            $requestedData['product'] = [
                'title' => $data['product_title'] ?? $currentData['product']['title'] ?? null,
                'description' => $data['product_description'] ?? $currentData['product']['description'] ?? null,
                'category_id' => $data['category_id'] ?? $currentData['product']['category_id'] ?? null,
            ];
        }

        if (isset($data['variant_data'])) {
            $requestedData['variant'] = $data['variant_data'];
        }

        return $requestedData;
    }

    /**
     * Apply product edit changes to live data.
     */
    private function applyProductEdit(Product $product, array $requestedData): void
    {
        if (isset($requestedData['product'])) {
            $updateData = [];
            if (isset($requestedData['product']['title'])) {
                $updateData['title'] = $requestedData['product']['title'];
            }
            if (isset($requestedData['product']['description'])) {
                $updateData['description'] = $requestedData['product']['description'];
            }
            if (isset($requestedData['product']['category_id'])) {
                $updateData['category_id'] = $requestedData['product']['category_id'];
            }
            if (!empty($updateData)) {
                $product->update($updateData);
            }
        }
    }

    /**
     * Apply product delete (soft delete) to live data.
     */
    private function applyProductDelete(Product $product): void
    {
        $product->delete();
    }

    /**
     * Apply variant edit changes to live data.
     */
    private function applyVariantEdit(ProductVariant $variant, array $requestedData): void
    {
        if (isset($requestedData['variant'])) {
            $variantData = $requestedData['variant'];
            
            $updateData = [];
            if (isset($variantData['color_id'])) {
                $updateData['color_id'] = $variantData['color_id'];
            }
            if (isset($variantData['priority'])) {
                $updateData['priority'] = $variantData['priority'];
            }
            if (isset($variantData['sku'])) {
                $updateData['sku'] = $variantData['sku'];
            }
            if (isset($variantData['status'])) {
                $updateData['status'] = $variantData['status'];
            }
            if (isset($variantData['image'])) {
                $updateData['image'] = $variantData['image'];
            }

            if (!empty($updateData)) {
                $variant->update($updateData);
            }

            // Update sizes if provided
            if (isset($variantData['sizes']) && is_array($variantData['sizes'])) {
                $submittedSizeIds = [];
                foreach ($variantData['sizes'] as $sizeData) {
                    if (isset($sizeData['size_id'])) {
                        VariantSize::updateOrCreate(
                            ['variant_id' => $variant->id, 'size_id' => $sizeData['size_id']],
                            [
                                'price' => $sizeData['price'] ?? 0,
                                'original_price' => $sizeData['original_price'] ?? null,
                                'quantity' => $sizeData['quantity'] ?? 0,
                            ]
                        );
                        $submittedSizeIds[] = $sizeData['size_id'];
                    }
                }
            }
        }
    }

    /**
     * Apply variant delete to live data.
     */
    private function applyVariantDelete(ProductVariant $variant): void
    {
        $variant->delete();
    }

    /**
     * Handle file attachment upload.
     */
    private function handleAttachment($file): ?string
    {
        if ($file && $file instanceof \Illuminate\Http\UploadedFile) {
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/requests'), $fileName);
            return 'uploads/requests/' . $fileName;
        }
        return null;
    }

    /**
     * Get human-readable request type label.
     */
    private function getRequestTypeLabel(string $requestType): string
    {
        $labels = [
            'product_edit' => 'Product Edit',
            'product_delete' => 'Product Delete',
            'variant_edit' => 'Variant Edit',
            'variant_delete' => 'Variant Delete',
        ];
        return $labels[$requestType] ?? ucfirst(str_replace('_', ' ', $requestType));
    }

    /**
     * Create a notification for the seller.
     */
    private function createNotification(int $sellerId, int $requestId, string $title, string $message): void
    {
        RequestCenterNotification::create([
            'seller_id' => $sellerId,
            'request_id' => $requestId,
            'title' => $title,
            'message' => $message,
        ]);
    }

    /**
     * Get unread notification count for a seller.
     */
    public function getUnreadNotificationCount(int $sellerId): int
    {
        return RequestCenterNotification::where('seller_id', $sellerId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Mark notifications as read for a seller.
     */
    public function markNotificationsAsRead(int $sellerId): void
    {
        RequestCenterNotification::where('seller_id', $sellerId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}