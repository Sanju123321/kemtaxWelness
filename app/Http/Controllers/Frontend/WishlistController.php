<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        private readonly WishlistService $wishlistService
    ) {}

    /**
     * GET /wishlist
     */
    public function index(Request $request): JsonResponse
    {
        $items = $this->wishlistService->getWishlist($request->user()->id);

        return response()->json([
            'success' => true,
            'data'    => $items,
            'count'   => $items->count(),
        ]);
    }

    /**
     * POST /wishlist/toggle
     */
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $result = $this->wishlistService->toggle(
            $request->user()->id,
            $validated['product_id']
        );

        return response()->json($result);
    }

    /**
     * POST /wishlist/remove
     */
    public function remove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $removed = $this->wishlistService->remove(
            $request->user()->id,
            $validated['product_id']
        );

        return response()->json([
            'success' => $removed,
            'message' => $removed ? 'Removed from wishlist.' : 'Item not found.',
        ]);
    }
}
