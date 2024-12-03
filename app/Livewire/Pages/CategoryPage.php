<?php

namespace App\Livewire\Pages;

use App\Models\Allergen;
use App\Models\Category;
use App\Models\Product;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPage extends Component
{
    use WithPagination;

    /**
     * Selected themes in the filter
     *
     * @var array
     */
    #[Url(as: 't')]
    public array $selectedThemes = [];
    public ?string $selectedSupplier = null;

    /**
     * Category record
     *
     * @var Category
     */
    public ?Category $record;

    /**
     * Get the category by slug
     *
     */
    public function mount(string $slug): void
    {
         $this->record = Category::where('slug', $slug)
            ->status()
            ->firstOrFail();
    }

    /**
     * Get the products for the category
     *
     */
    #[Computed]
    public function products()
    {
        // Create base query
        $query = Product::whereHas('user', static fn (Builder $query) => $query->whereNull('deleted_at'))
            ->orderBy('created_at', 'desc')
            ->where('category_id', $this->record->id)
            ->with([
                'themes',
            ])
            ->status();

        // Apply theme filter if selected themes are not empty
        $query->when(!empty($this->selectedThemes), function ($query) {
            $selectedThemes = $this->filterSelectedThemes();
            if (!empty($selectedThemes)) {
                $query->whereHas('themes', function ($query) use ($selectedThemes) {
                    $query->whereIn('themes.id', $selectedThemes);
                });
            }
        });

        if ($this->selectedSupplier) {
            $query->where('user_id', $this->selectedSupplier);
        }

        // Return paginated results
        return $query->paginate();
    }

    /**
     * Filter selected themes to include only available themes for the category
     *
     */
    #[Computed]
    protected function filterSelectedThemes(): array
    {
        $availableThemes = $this->themes()->pluck('id')->toArray();

        // Filter out themes that are not available
        return collect($this->selectedThemes)
            ->filter(fn($theme) => in_array($theme, $availableThemes, true))
            ->values()
            ->all();
    }

    /**
     * Get the themes for the category
     */
    #[Computed]
    public function themes(): Collection
    {
        return Theme::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);
        })->status()->get();
    }

    #[Computed]
    public function suppliers(): Collection
    {
        return User::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);
            $query->status();
        })->get();
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.pages.category-page');
    }
}
