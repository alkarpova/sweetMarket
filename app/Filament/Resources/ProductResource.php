<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'default' => 1,
                    '2xl' => 4,
                ])
                    ->schema([
                        Forms\Components\Section::make('General')
                            ->columnSpan(3)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->unique(ignoreRecord: true)
                                    ->disabled(),
                                Forms\Components\Textarea::make('description')
                                    ->disabled(),

                                Forms\Components\Grid::make([
                                    'default' => 1,
                                    '2xl' => 5,
                                ])
                                    ->schema([
                                        Forms\Components\TextInput::make('price')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('minimum')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('quantity')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('weight')
                                            ->disabled(),
                                    ]),

                                Forms\Components\Select::make('status')
                                    ->searchable()
                                    ->preload()
                                    ->options(ProductStatus::class)
                                    ->disabled(function ($livewire) {
                                        return $livewire->record->status === ProductStatus::Draft;
                                    })
                                    ->default(ProductStatus::Draft->value),
                            ]),
                        Forms\Components\Section::make('Relations')
                            ->columnSpan(1)
                            ->columns([
                                'default' => 1,
                                '2xl' => 2,
                            ])
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled(),
                                Forms\Components\Select::make('country_id')
                                    ->relationship('country', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                                Forms\Components\Select::make('region_id')
                                    ->relationship('region', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                                Forms\Components\Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                                Forms\Components\Select::make('category_id')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                                Forms\Components\Select::make('themes')
                                    ->relationship('themes', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                                Forms\Components\Select::make('allergens')
                                    ->relationship('allergens', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                                Forms\Components\Select::make('ingredients')
                                    ->relationship('ingredients', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query->with([
                    'user',
                    'category',
                ]);
            })
            ->paginated([10])
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('country')
                    ->relationship('country', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('region')
                    ->relationship('region', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('city')
                    ->relationship('city', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('themes')
                    ->relationship('themes', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(ProductStatus::class)
                    ->preload()
                    ->searchable(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
