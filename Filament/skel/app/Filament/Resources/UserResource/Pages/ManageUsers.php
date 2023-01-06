<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use \Closure;

class ManageUsers extends ManageRecords
{
  protected static string $resource = UserResource::class;

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

  protected function getTableRecordUrlUsing(): Closure
  {
    return fn ($record): string => UserResource::getUrl('view', ['record' => $record]);
  }
}
