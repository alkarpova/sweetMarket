<?php

namespace App\Models;

use App\Enums\ReviewRating;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Review extends Model
{
    use HasFactory, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'order_item_id',
        'supplier_id',
        'rating',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => ReviewRating::class,
            'comment' => 'string',
        ];
    }

    /**
     * Get the order that owns the review.
     *
     * @return BelongsTo<Order>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that owns the review.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order item that owns the review.
     *
     * @return BelongsTo<OrderItem>
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the supplier that owns the review.
     *
     * @return BelongsTo<User>
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the review.
     *
     * @return HasOneThrough<Product, OrderItem>
     */
    public function product(): HasOneThrough
    {
        return $this->hasOneThrough(
            Product::class,
            OrderItem::class,
            'id', // Foreign key on the OrderItem table
            'id', // Foreign key on the Product table
            'order_item_id', // Local key on the Review table
            'product_id'// Local key on the OrderItem table
        );
    }
}
