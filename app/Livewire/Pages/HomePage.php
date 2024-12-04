<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class HomePage extends Component
{
    /**
     * Get the latest products
     */
    #[Computed]
    public function products(): Collection
    {
        return Product::whereHas('user', static fn (Builder $query) => $query->whereNull('deleted_at'))
            ->with(['themes'])
            ->latest()
            ->status()
            ->limit(12)
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.home-page');
    }
}
