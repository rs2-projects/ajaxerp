<?php

namespace App\Services\Common;

class CartService
{
    private $cart_prefix = 'cart_';
    protected $cart_key = 'default_cart';
    protected $session_key = null;

    protected $items = [];
    protected $total_price = 0;
    protected $total_quantity = 0;
    protected $total_items = 0;


    public function __construct($cart_key = null) {
        // Cart service constructor
        if($cart_key != null) {
            $this->cart_key = $cart_key;
        }

        $this->session_key = $this->cart_prefix . $this->cart_key;
    }

    public function addToCart($item_id, $name='', $image='', $price=0, $qty = 1, $extra = []) {
        // Add to cart logic
        $item = [
            'id' => $item_id,
            'name' => $name,
            'image' => $image,
            'price' => $price,
            'qty' => $qty,
            'extra' => $extra
        ];
    }

    public function removeFromCart($item_id) {
        // Remove from cart logic
    }

    public function updateCart($item_id, $quantity) {
        // Update cart logic
    }

    public function getCartContents(): array {
        // Get cart logic
        return [
            'items' => $this->items,
            'total_price' => $this->total_price,
            'total_quantity' => $this->total_quantity,
            'total_items' => $this->total_items
        ];
    }

    public function clearCart(): void {
        // Clear cart logic
        session()->forget($this->session_key);
        $this->initClassData();
    }

    public function getCartFromSession(): array {
        // Get cart from session logic
        if(session()->has($this->session_key)) {
            $items = session()->get($this->session_key);
        } else {
            $items = [];
        }
        return $items;
    }

    public function initClassData(): void {
        // Initialize class data logic
        $this->items = $this->getCartFromSession();
        $this->total_price = 0;
        $this->total_quantity = 0;
        $this->total_items = 0;
        foreach($this->items as $item) {
            $this->total_price += $item['price'] * $item['quantity'];
            $this->total_quantity += $item['quantity'];
            $this->total_items++;
        }
    }
}
