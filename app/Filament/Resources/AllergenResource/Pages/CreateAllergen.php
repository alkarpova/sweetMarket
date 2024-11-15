<?php

namespace App\Filament\Resources\AllergenResource\Pages;

use App\Filament\Resources\AllergenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAllergen extends CreateRecord
{
    protected static string $resource = AllergenResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
