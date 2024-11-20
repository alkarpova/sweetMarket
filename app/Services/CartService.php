<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartService
{
    public const DEFAULT_INSTANCE = 'shipping-cart';

    protected string $instance;

    public mixed $errors = [];

    public function __construct()
    {
        $this->instance = self::DEFAULT_INSTANCE;
    }

    /**
     * Create a new cart item.
     */
    protected function createCartItem(Product $product, int $quantity, array $options = []): Collection
    {
        return collect([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'options' => $options,
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
    protected function validateProduct(Product $product, int $quantity): void
    {
        $validator = Validator::make([
            'status' => $product->status->value,
            'quantity' => $quantity,
            'minimum' => $product->minimum,
            'maximum' => $product->maximum,
            'available_quantity' => $product->quantity,
        ], [
            'status' => ['in:4'],
            'quantity' => ['integer', 'min:' . $product->minimum, 'max:' . $product->maximum],
            'quantity' => ['lte:available_quantity'], // Ensure requested quantity is less than or equal to available stock
        ], [
            'status.in' => 'This product is not available for purchase.',
            'quantity.min' => "Minimum quantity for order: {$product->minimum}",
            'quantity.max' => "Maximum quantity for order: {$product->maximum}",
            'quantity.lte' => "Requested quantity exceeds available stock.",
        ]);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
        }
    }

    /**
     * Add or update a product in the cart.
     */
    public function add(Product $product, int $quantity = 1, array $options = []): void
    {
        // Validate product and quantity
        $this->validateProduct($product, $quantity);

        if ($this->errors) {
            return;
        }

        // Get the cart items
        $cartItems = $this->getCartItems();

        // If product exists in the cart, update its quantity
        if ($cartItems->has($product->id)) {
            $existingItem = $cartItems->get($product->id);
            $quantity += $existingItem->get('quantity');
        }

        // Add or update the product
        $cartItem = $this->createCartItem($product, $quantity, $options);
        // Add or update the cart item
        $cartItems->put($product->id, $cartItem);

        $this->saveCart($cartItems);
    }

    /**
     * Update the quantity of a product in the cart.
     */
    public function update(Product $product, int $quantity): void
    {
        // Validate product and quantity
        $this->validateProduct($product, $quantity);

        if ($this->errors) {
            return;
        }

        // Get the cart items
        $cartItems = $this->getCartItems();

        // Update the quantity of the product
        if ($cartItems->has($product->id)) {
            // Update the quantity
            $cartItem = $cartItems->get($product->id)->put('quantity', $quantity);
            // Update the cart item
            $cartItems->put($product->id, $cartItem);
            // Re-index the cart items
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
    public function content(): Collection
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
}
