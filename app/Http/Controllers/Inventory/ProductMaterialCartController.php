<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Inventory\ProductMaterialCartService;
use Illuminate\Http\Request;

class ProductMaterialCartController extends BackendController
{
    private ProductMaterialCartService $service;

    public function __construct()
    {
        $this->service = new ProductMaterialCartService();
    }

    public function addToCart(Request $request) {
        try {
            return $this->service->addToCart($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product added to cart successfully',
            'data' => $data
        ]);
    }

    public function getCartContents() {
        $data['carts'] = $this->service->getCartContents();
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function updateCartQty(Request $request) {
        $this->service->updateCartQty($request);
        return response()->json([
            'status' => 200,
            'message' => "Qty Updated Successfully!"
        ]);
    }

    public function removeCartItem(Request $request) {
        $this->service->removeCartItem($request);
        return response()->json([
            'status' => 200,
            'message' => "Cart Item Removed!"
        ]);
    }

    public function submitCart(Request $request) {
        try {
            return $this->service->submitCart($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Cart submitted successfully'
        ]);
    }
}
