<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
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
                                        Forms\Components\TextInput::make('maximum')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('quantity')
                                            ->disabled(),
                                        Forms\Components\TextInput::make('weight')
                                            ->disabled(),
                                    ]),

                                Forms\Components\Repeater::make('options')
                                    ->relationship('options')
                                    ->disabled()
                                    ->columns(5)
                                    ->schema([
                                        Forms\Components\TextInput::make('name'),
                                        Forms\Components\TextInput::make('price'),
                                        Forms\Components\TextInput::make('quantity'),
                                        Forms\Components\TextInput::make('weight'),
                                        Forms\Components\Select::make('is_required')
                                            ->options([
                                                0 => 'No',
                                                1 => 'Yes',
                                            ]),
                                    ])
                            ]),
                        Forms\Components\Section::make('Relations')
                            ->collapsible()
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
                                Forms\Components\Select::make('theme_id')
                                    ->relationship('theme', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->disabled(),

                                Forms\Components\Select::make('status')
                                    ->searchable()
                                    ->preload()
                                    ->options(ProductStatus::class)
                                    ->default(ProductStatus::Draft),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query->with([
                    'user',
                    'category',
                    'theme',
                ]);
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('theme.name'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('options_count')
                    ->counts('options'),
                Tables\Columns\SelectColumn::make('status')
                    ->options(ProductStatus::class)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
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
                Tables\Filters\SelectFilter::make('theme')
                    ->relationship('theme', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(ProductStatus::class)
                    ->preload()
                    ->searchable(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
