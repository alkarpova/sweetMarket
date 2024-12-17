<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'country_id',
        'region_id',
        'city_id',
        'category_id',
        'name',
        'image',
        'price',
        'minimum',
        'quantity',
        'weight',
        'description',
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
            'name' => 'string',
            'image' => 'string',
            'description' => 'string',
            'price' => 'float',
            'minimum' => 'integer',
            'quantity' => 'integer',
            'weight' => 'float',
            'status' => ProductStatus::class,
        ];
    }

    /**
     * Get the short description attribute.
     */
    public function getShortDescriptionAttribute(): string
    {
        return str($this->description)->words(10);
    }

    /**
     * Get the user that owns the product.
     *
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the country that owns the product.
     *
     * @return BelongsTo<Country>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the region that owns the product.
     *
     * @return BelongsTo<Region>
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the city that owns the product.
     *
     * @return BelongsTo<City>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo<Category>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the themes for the product.
     *
     * @return BelongsToMany<Theme>
     */
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class)
            ->withTimestamps();
    }

    /**
     * Get the allergens for the product.
     *
     * @return BelongsToMany<Allergen>
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)
            ->withTimestamps();
    }

    /**
     * Get the ingredients for the product.
     *
     * @return BelongsToMany<Ingredient>
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->withTimestamps();
    }

    /**
     * Get the reviews for the product.
     *
     * @return HasManyThrough<Review, OrderItem>
     */
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            Review::class,
            OrderItem::class,
            'product_id', // Foreign key on the OrderItem table
            'order_item_id', // Foreign key on the Review table
            'id', // Local key on the Product table
            'id' // Local key on the OrderItem table
        );
    }

    /**
     * Scope a query to status.
     */
    public function scopeStatus(Builder $query, ProductStatus $status = ProductStatus::Published): Builder
    {
        return $query->where('status', $status);
    }
}
