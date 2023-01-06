<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Forms\Components;

class SetPassword extends EditRecord
{
  protected static string $resource = UserResource::class;

  protected function getActions(): array
  {
    return [];
  }

  protected function getForms(): array
  {
    return [
      'form' => $this->makeForm()
        ->context('edit')
        ->model($this->getRecord())
        ->schema($this->getFormSchema())
        ->statePath('data')
        ->inlineLabel(config('filament.layout.forms.have_inline_labels')),
    ];
  }

  protected function getFormSchema(): array
  {
    return [
      Components\Grid::make(1)
      // ->columns(2)
      ->schema([
        Forms\Components\TextInput::make('title')
          ->default('Status Update') 
          ->required(),      
        Forms\Components\TextInput::make('title2')
          ->default('Status Update') 
          ->required(),      
      ])      
    ];
  }
}
