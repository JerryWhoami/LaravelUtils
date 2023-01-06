<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
  protected static string $resource = UserResource::class;

  protected function getActions(): array
  {
    return [
      Actions\Action::make('back')
        ->url($this->getResource()::getUrl('index'))
        ->icon('heroicon-o-chevron-left')
        ->color('secondary')
        ->label(__('Volver')),
      Actions\Action::make('edit')
        ->url($this->getResource()::getUrl('edit', ['record' => $this->getRecord()]))
        ->icon('heroicon-o-pencil')
        ->label(__('Editar')),
    ];
  }

}
