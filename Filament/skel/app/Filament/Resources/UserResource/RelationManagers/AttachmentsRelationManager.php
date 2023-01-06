<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class AttachmentsRelationManager extends RelationManager
{
  protected static string $relationship = 'attachments';

  protected static ?string $recordTitleAttribute = 'title';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\FileUpload::make('file')
          ->maxSize(5120)
          ->disk('local')
          ->directory('files')
          ->visibility('private')
          ->storeFileNamesIn('filename')
          ->acceptedFileTypes([
            'image/jpeg',
            'image/png',
            'application/pdf',
          ])
          ->afterStateUpdated( function (\Closure $set, $state) {
            $set('disk', $state->disk);
            $set('size', $state->getSize());
          }),
        Forms\Components\TextInput::make('title')
          ->maxLength(255),
        Forms\Components\Hidden::make('disk'),
        Forms\Components\Hidden::make('size'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('filename')
          ->label(__('Nombre')),
        Tables\Columns\TextColumn::make('title')
          ->label(__('Título')),
        Tables\Columns\TextColumn::make('size')
          ->label(__('Tamaño')),
        Tables\Columns\TextColumn::make('mimetype')
          ->label(__('Tipo')),
      ])
      ->filters([
        //
      ])
      ->headerActions([
        Tables\Actions\CreateAction::make()
          ->label(__('Adjuntar'))
          ->mutateFormDataUsing(function (array $data): array {
            $data['mimetype'] = Storage::mimeType($data['file']);
            if (! $data['title']) {
              $data['title'] = $data['filename'];
            }
            return $data;
          }),
      ])
      ->actions([
        Tables\Actions\EditAction::make()
          ->label(false)
          ->tooltip(__('Editar')),
        Tables\Actions\DeleteAction::make()
          ->label(false)
          ->tooltip(__('Eliminar')),
        Tables\Actions\Action::make('download')
          ->label(false)
          ->icon('heroicon-o-download')
          ->tooltip(__('Descargar'))
          ->action(function ($record) {
            return Storage::download($record->file);
          }),
      ])
      ->bulkActions([
        Tables\Actions\DeleteBulkAction::make(),
      ]);
  }
}
