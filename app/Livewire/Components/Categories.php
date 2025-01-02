<?php

namespace App\Livewire\Components;

use App\Enums\ProductStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Categories extends Component
{
    #[Computed]
    public function categories(): Collection
    {
        // Get the categories that have published products
        return DB::table('categories')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereRaw('products.category_id = categories.id')
                    ->where('products.status', ProductStatus::Published);
            })
            ->where('categories.status', 1)
            ->whereNull('deleted_at')
            ->get();
    }

    #[Computed]
    public function isActiveCategory($id): bool
    {
        // Check if the current URL is the category page
        return url()->current() === route('category-page', ['id' => $id]);
    }

    public function render(): View
    {
        return view('livewire.components.categories');
    }
}
