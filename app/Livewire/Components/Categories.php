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
        return DB::table('categories')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('products')
                    ->whereRaw('products.category_id = categories.id')
                    ->where('products.status', ProductStatus::Published);
            })
            ->where('categories.status', 1)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.components.categories', [
            'categories' => $this->categories(),
        ]);
    }
}
