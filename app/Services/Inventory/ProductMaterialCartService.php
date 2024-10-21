<?php

namespace App\Services\Inventory;

use App\Models\Products\ProductMaterial;
use App\Services\Common\CartService;

class ProductMaterialCartService
{
    private $paginate_limit;
    private CartService $cartService;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
        $this->cartService = new CartService('product_material');
    }

    public function addToCart($request) {
        $product_material = ProductMaterial::where('id', $request->id)->first();
        if(empty($product_material)) {
            return response()->json([
                'status' => 404, 
                'message' => 'Invalid Product material!'
            ]);
        }

        $data = $this->cartService->addToCart(
            item_id: $product_material->id,
            name: $product_material->name,
            image: $product_material->show_image,
            price: $product_material->price,
            qty: 1,
            extra: [
                'code' => $product_material->code
            ]
        )->getCartContents();

        return $data;
    }

    public function getCartContents() {
        return $this->cartService->getCartContents();
    }

    public function updateCartQty($request) {
        return $this->cartService->updateCartQty($request->id, $request->qty);
    }

    public function removeCartItem($request) {
        return $this->cartService->removeCartItem($request->id);
    }

    
}
