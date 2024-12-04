<?php

namespace App\Filament\Resources\ThemeResource\Pages;

use App\Filament\Resources\ThemeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTheme extends CreateRecord
{
    protected static string $resource = ThemeResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
