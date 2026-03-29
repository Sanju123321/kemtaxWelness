<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    /**
     * GET /cart
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->cartService->getCart($request->user()->id);

        return response()->json([
            'success' => true,
            'data'    => [
                'items'      => $data['items'],
                'count'      => $data['count'],
                'total'      => number_format($data['total'], 2),
                'item_count' => $data['item_count'],
            ],
        ]);
    }

    /**
     * POST /cart/add
     */
    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['sometimes', 'integer', 'min:1', 'max:99'],
        ]);

        $result = $this->cartService->addItem(
            $request->user()->id,
            $validated['product_id'],
            $validated['quantity'] ?? 1
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    /**
     * POST /cart/update
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $result = $this->cartService->updateItem(
            $request->user()->id,
            $validated['product_id'],
            $validated['quantity']
        );

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    /**
     * POST /cart/remove
     */
    public function remove(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $result = $this->cartService->removeItem(
            $request->user()->id,
            $validated['product_id']
        );

        return response()->json($result, $result['success'] ? 200 : 404);
    }
}
