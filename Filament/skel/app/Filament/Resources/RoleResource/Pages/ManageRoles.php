<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRoles extends ManageRecords
{
  protected static string $resource = RoleResource::class;

  protected function getActions(): array
  {
    return [
      Actions\CreateAction::make()
        // ->iconButton()
        ->label(__('Nuevo'))
        ->icon('heroicon-o-plus')
        ->toolTip(__('Agregar'))
        // ->extraAttributes(['class' => 'rounded-lg border text-primary-700 bg-primary-500 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700']),
    ];
  }
}
