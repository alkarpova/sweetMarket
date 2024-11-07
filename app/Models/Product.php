<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

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
            'maximum' => 'integer',
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
        $shortDescription = substr($this->description, 0, 60);
        return strlen($this->description) > 60 ? $shortDescription . '...' : $shortDescription;
    }

    /**
     * Get the user that owns the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the country that owns the product.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the region that owns the product.
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get the city that owns the product.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the themes for the product.
     */
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class)
            ->withTimestamps();
    }

    /**
     * Get the options for the product.
     */
    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class);
    }

    /**
     * Get the allergens for the product.
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class)
            ->withTimestamps();
    }

    /**
     * Get the ingredients for the product.
     */
    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)
            ->withTimestamps();
    }

    /**
     * Scope a query to status.
     */
    public function scopeStatus(Builder $query, ProductStatus $status = ProductStatus::Published): Builder
    {
        return $query->where('status', $status);
    }
}
