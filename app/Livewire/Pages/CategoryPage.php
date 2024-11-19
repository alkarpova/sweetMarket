<?php

namespace App\Livewire\Pages;

use App\Models\Allergen;
use App\Models\Category;
use App\Models\Product;
use App\Models\Theme;
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

    /**
     * Selected allergens in the filter
     *
     * @var array
     */
    #[Url(as: 't')]
    public array $selectedAllergens = [];

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
    public function mount(string $slug)
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
        $query = Product::query()
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

        // Apply allergen filter if selected allergens are not empty
        $query->when(!empty($this->selectedAllergens), function ($query) {
            $selectedAllergens = $this->filterSelectedAllergens();
            if (!empty($selectedAllergens)) {
                $query->whereHas('allergens', function ($query) use ($selectedAllergens) {
                    $query->whereIn('allergens.id', $selectedAllergens);
                });
            }
        });

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
    public function themes()
    {
        return Theme::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);
        })->status()->get();
    }

    /**
     * Get the allergens for the category
     */
    #[Computed]
    public function allergens()
    {
        return Allergen::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);
        })->status()->get();
    }

    /**
     * Filter selected allergens to include only available allergens for the category
     */
    #[Computed]
    public function filterSelectedAllergens(): array
    {
        $available = $this->allergens()->pluck('id')->toArray();

        // Filter out themes that are not available
        return collect($this->selectedAllergens)
            ->filter(fn($theme) => in_array($theme, $available, true))
            ->values()
            ->all();
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.pages.category-page');
    }
}
