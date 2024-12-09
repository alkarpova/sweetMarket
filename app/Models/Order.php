<?php

namespace App\Models;

use App\Enums\OrderItemStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'city_id',
        'number',
        'name',
        'email',
        'phone',
        'shipping_address',
        'shipping_method',
        'payment_method',
        'total',
        'notes',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'shipping_method' => ShippingMethod::class,
            'payment_method' => PaymentMethod::class,
            'total' => 'float',
            'notes' => 'string',
            'status' => OrderStatus::class,
        ];
    }

    /**
     * Get the user that owns the order.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the city that owns the order.
     *
     * @return BelongsTo<City>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the items for the order.
     *
     * @return HasMany<OrderItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getItemsStatusAttribute(): string
    {
        // Проверяем, есть ли элементы заказа
        if ($this->items->isEmpty()) {
            return 'No items';
        }

        // Если все элементы имеют статус Completed
        if ($this->items->every(fn ($item) => $item->status === OrderItemStatus::Completed)) {
            return 'Finished';
        }

        $duration = now()->diffForHumans($this->created_at, [
            'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
        ]);

        return "In progress ({$duration})";
    }

    /**
     * Get the reviews for the order.
     *
     * @return HasMany<Review>
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
