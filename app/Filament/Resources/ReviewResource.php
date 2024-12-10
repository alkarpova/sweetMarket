<?php

namespace App\Filament\Resources;

use App\Enums\ReviewRating;
use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->aside()
                    ->description('Review Information')
                    ->schema([
                        Forms\Components\Group::make()
                            ->relationship('order')
                            ->schema([
                                Forms\Components\TextInput::make('number')
                                    ->disabled(),
                            ]),
                        Forms\Components\Group::make()
                            ->relationship('orderItem')
                            ->schema([
                                Forms\Components\Group::make()
                                    ->relationship('product')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->disabled()
                                            ->label('Product'),
                                    ]),
                            ]),
                        Forms\Components\Group::make()
                            ->relationship('user')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->disabled()
                                    ->label('Customer'),
                            ]),
                        Forms\Components\Select::make('rating')
                            ->options(ReviewRating::class)
                            ->disabled(),
                        Forms\Components\Textarea::make('comment')
                            ->disabled(),
                        Forms\Components\Toggle::make('status'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->with([
                    'user',
                    'order',
                    'orderItem' => fn ($query) => $query->with('product'),
                ]);
            })
            ->columns([
                Tables\Columns\TextColumn::make('order.number')
                    ->searchable()
                    ->label('Order'),
                Tables\Columns\TextColumn::make('orderItem.product.name')
                    ->searchable()
                    ->label('Product'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('rating')
                    ->searchable()
                    ->label('Rating'),
                Tables\Columns\IconColumn::make('status')
                    ->sortable()
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
