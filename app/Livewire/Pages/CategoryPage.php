<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use App\Models\Theme;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPage extends Component
{
    use WithPagination;

    /**
     * Url slug of the category
     *
     * @var string
     */
    public string $slug;

    /**
     * Selected themes in the filter
     *
     * @var array
     */
    #[Url(as: 't')]
    public array $selectedThemes = [];

    /**
     * Get the category by slug
     *
     */
    public function category()
    {
        return cache()->remember("category_{$this->slug}", 3600, function () {
            return Category::where('slug', $this->slug)
                ->status()
                ->firstOrFail();
        });
    }

    /**
     * Get the products for the category
     *
     */
    public function products()
    {
        // Create base query
        $query = Product::query()
            ->orderBy('created_at', 'desc')
            ->where('category_id', $this->category()->id)
            ->with([
                'user',
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

        // Return paginated results
        return $query->paginate();
    }

    /**
     * Filter selected themes to include only available themes for the category
     *
     */
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
    public function themes()
    {
        return cache()->remember("themes_for_category_{$this->category()->id}", 3600, function () {
            return Theme::whereHas('products', function ($query) {
                $query->where('category_id', $this->category()->id);
            })->status()->get();
        });
    }

    /**
     * Render the component
     */
    public function render()
    {
        return view('livewire.pages.category-page', [
            'category' => $this->category(),
            'products' => $this->products(),
            'themes' => $this->themes(),
        ]);
    }
}
