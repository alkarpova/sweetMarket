<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Region;
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
     */
    #[Url(as: 't')]
    public array $selectedThemes = [];

    #[Url(as: 's')]
    public ?string $selectedSupplier = null;

    #[Url(as: 'price')]
    public ?string $selectedPriceRange = null;

    #[Url(as: 'weight')]
    public ?string $selectedWeightRange = null;

    #[Url(as: 'region')]
    public ?string $selectedRegion = null;

    #[Url(as: 'city')]
    public ?string $selectedCity = null;

    /**
     * Category record
     */
    public ?Category $record;

    /**
     * Get the category by slug
     */
    public function mount(string $slug): void
    {
        $this->record = Category::where('slug', $slug)
            ->status()
            ->firstOrFail();
    }

    /**
     * Get the products for the category
     */
    #[Computed]
    public function products()
    {
        // Create base query
        $query = Product::whereHas('user', static fn (Builder $query) => $query->whereNull('deleted_at'))
            ->where('category_id', $this->record->id)
            ->with([
                'themes',
                'reviews',
            ])
            ->latest()
            ->status();

        // Apply theme filter
        $query->when(! empty($this->selectedThemes), function ($query) {
            $selectedThemes = $this->filterSelectedThemes();
            if (! empty($selectedThemes)) {
                $query->whereHas('themes', function ($query) use ($selectedThemes) {
                    $query->whereIn('themes.id', $selectedThemes);
                });
            }
        });

        // Apply supplier filter
        if ($this->selectedSupplier) {
            $query->where('user_id', $this->selectedSupplier);
        }

        // Apply price range filter
        $query->when($this->selectedPriceRange, function ($query) {
            switch ($this->selectedPriceRange) {
                case 'budget':
                    $query->where('price', '<', 10); // Example threshold
                    break;
                case 'mid':
                    $query->whereBetween('price', [11, 50]); // Example range
                    break;
                case 'premium':
                    $query->where('price', '>', 50); // Example threshold
                    break;
                default:
                    break;
            }
        });

        // Apply weight or quantity filter
        $query->when($this->selectedWeightRange, function ($query) {
            switch ($this->selectedWeightRange) {
                case 'under_1kg':
                    $query->where('weight', '<', 1);
                    break;
                case '1_2kg':
                    $query->whereBetween('weight', [1, 2]);
                    break;
                case '2_5kg':
                    $query->whereBetween('weight', [2, 5]);
                    break;
                case 'above_5kg':
                    $query->where('weight', '>', 5);
                    break;
                default:
                    break;
            }
        });

        // Apply region filter
        if ($this->selectedRegion) {
            $query->where('region_id', $this->selectedRegion);
        }

        // Apply city filter
        if ($this->selectedCity) {
            $query->where('city_id', $this->selectedCity);
        }

        // Return paginated results
        return $query->paginate();
    }

    /**
     * Get the available price ranges
     *
     * @return string[]
     */
    #[Computed]
    public function priceRanges(): array
    {
        return [
            'budget' => 'Budget products',
            'mid' => 'Medium price segment',
            'premium' => 'Premium segment',
        ];
    }

    /**
     *  Get the available weight ranges
     *
     * @return string[]
     */
    #[Computed]
    public function weightRanges(): array
    {
        return [
            'under_1kg' => 'Up to 1 kg',
            '1_2kg' => '1-2 kg',
            '2_5kg' => '2-5 kg',
            'above_5kg' => 'Above 5 kg',
        ];
    }

    /**
     * Filter selected themes to include only available themes for the category
     */
    #[Computed]
    protected function filterSelectedThemes(): array
    {
        $availableThemes = $this->themes()->pluck('id')->toArray();

        // Filter out themes that are not available
        return collect($this->selectedThemes)
            ->filter(fn ($theme) => in_array($theme, $availableThemes, true))
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

    /**
     * Get the suppliers for the category
     */
    #[Computed]
    public function suppliers(): Collection
    {
        return User::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);
            $query->status();
        })->get();
    }

    /**
     * Get the regions for the category
     */
    #[Computed]
    public function regions(): Collection
    {
        return Region::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);
        })->get();
    }

    /**
     * Get the cities for the category
     */
    #[Computed]
    public function cities(): Collection
    {
        return City::whereHas('products', function ($query) {
            $query->where('category_id', $this->record->id);

            // Apply region filter if selected
            if ($this->selectedRegion) {
                $query->where('region_id', $this->selectedRegion);
            }
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
