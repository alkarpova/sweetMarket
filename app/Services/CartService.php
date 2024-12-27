<?php

namespace App\Services;

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartService
{
    public const DEFAULT_INSTANCE = 'shipping-cart';

    protected string $instance;

    public mixed $errors = [];

    public mixed $warnings = [];

    public function __construct()
    {
        $this->instance = self::DEFAULT_INSTANCE;
    }

    /**
     * Create a new cart item.
     */
    protected function createCartItem(Product $product, int $quantity): Collection
    {
        return collect([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Get all cart items.
     */
    protected function getCartItems(): Collection
    {
        return Session::get($this->instance, collect());
    }

    /**
     * Save the cart to the session.
     */
    protected function saveCart(Collection $cartItems): void
    {
        Session::put($this->instance, $cartItems);
    }

    /**
     * Validate product and quantity before adding to the cart.
     */
    public function validateProduct(Product $product, int $quantity): void
    {
        $validator = Validator::make(
            [
                'status' => $product->status->value,
                'requested_quantity' => $quantity,
                'minimum' => $product->minimum,
            ],
            [
                'status' => ['in:' . ProductStatus::Published->value],
                'requested_quantity' => ['gte:minimum'],
            ],
            [
                'status.in' => 'This product is not available for purchase.',
                'requested_quantity.gte' => "The minimum quantity for this product is {$product->minimum}.",
            ]
        );

        // Check if the requested quantity is more than the available stock
        if ($quantity > $product->quantity) {
            $this->warnings[] = [
                'id' => $product->id,
                'name' => $product->name,
                'warning' => 'You are ordering more than the available stock. Delivery may take longer.',
            ];
        }

        // Global errors
        if ($validator->fails()) {
            $this->errors[] = [
                'id' => $product->id,
                'name' => $product->name,
                'errors' => $validator->errors(),
            ];
        }
    }

    /**
     * Add or update a product in the cart.
     */
    public function add(Product $product, int $quantity = 1): void
    {
        // Validate product and quantity
        $this->validateProduct($product, $quantity);

        // Get the cart items
        $cartItems = $this->getCartItems();

        // If product exists in the cart, update its quantity
        if ($cartItems->has($product->id)) {
            $existingItem = $cartItems->get($product->id);
            $quantity += $existingItem->get('quantity');
        }

        // Add or update the product
        $cartItem = $this->createCartItem($product, $quantity);
        // Add or update the cart item
        $cartItems->put($product->id, $cartItem);

        $this->saveCart($cartItems);
    }

    /**
     * Increase the quantity of a product in the cart.
     */
    public function increase($productId): void
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->has($productId)) {
            $cartItem = $cartItems->get($productId);
            $quantity = $cartItem->get('quantity') + 1;
            $cartItem->put('quantity', $quantity);
            $cartItems->put($productId, $cartItem);
            $this->saveCart($cartItems);
        }
    }

    /**
     * Decrease the quantity of a product in the cart.
     */
    public function decrease($productId): void
    {
        $cartItems = $this->getCartItems();

        if ($cartItems->has($productId)) {
            $cartItem = $cartItems->get($productId);
            $quantity = $cartItem->get('quantity') - 1;
            if ($quantity <= 0) {
                $cartItems->forget($productId);
            } else {
                $cartItem->put('quantity', $quantity);
                $cartItems->put($productId, $cartItem);
            }
            $this->saveCart($cartItems);
        }
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product): void
    {
        // Get the cart items
        $cartItems = $this->getCartItems();

        // Remove the product
        if ($cartItems->has($product->id)) {
            $cartItems->forget($product->id);
            // Re-index the cart items
            $this->saveCart($cartItems);
        }
    }

    /**
     * Clear the cart.
     */
    public function clear(): void
    {
        Session::forget($this->instance);
    }

    /**
     * Get the cart content.
     */
    public function getContent(): Collection
    {
        return $this->getCartItems();
    }

    /**
     * Calculate the total cost of the cart.
     */
    public function total(): float
    {
        return $this->getCartItems()->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    /**
     * Get the cart errors.
     */
    public function getErrors(): Collection
    {
        return collect($this->errors);
    }

    public function getWarnings(): Collection
    {
        return collect($this->warnings);
    }
}
