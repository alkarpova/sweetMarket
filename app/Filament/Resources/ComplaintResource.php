<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Models\Complaint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Complaint Information')
                    ->schema([
                        Forms\Components\Group::make()
                            ->relationship('order')
                            ->schema([
                                Forms\Components\TextInput::make('number')
                                    ->disabled(),
                            ]),
                        Forms\Components\Group::make()
                            ->relationship('supplier')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->disabled()
                                    ->label('Supplier'),
                            ]),
                        Forms\Components\Group::make()
                            ->relationship('user')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->disabled()
                                    ->label('Customer'),
                            ]),
                        Forms\Components\Textarea::make('comment')
                            ->disabled(),
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
                    'supplier',
                ]);
            })
            ->paginated([10])
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),
                Tables\Columns\TextColumn::make('order.number')
                    ->searchable()
                    ->sortable()
                    ->label('Order'),
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable()
                    ->label('Supplier'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListComplaints::route('/'),
        ];
    }
}
