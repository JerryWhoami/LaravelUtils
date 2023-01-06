<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Profile extends Page implements HasForms
{
  use InteractsWithForms;
  use WithFileUploads;

  public User $user;
  public $avatar;
  public $password = '';
  public $password_confirmation = '';

  protected static bool $shouldRegisterNavigation = false;

  protected static ?string $navigationIcon = 'heroicon-o-document-text';

  protected static string $view = 'filament.pages.profile';

  public function mount(): void
  {
    $this->user = auth()->user();
    $this->form->fill([
      'name' => $this->user->name,
      'email' => $this->user->email,
      'avatar' => $this->user->avatar,
    ]);
  }

  public function save()
  {
    $this->validate();
    $this->user->name = $this->name;
    $this->user->email = $this->email;
    $avatar = array_pop($this->avatar);
    if ($avatar && is_object($avatar)) {
      $this->user->avatar = $avatar->store('avatar', 'public');
    }
    if ($this->password) {
      $this->user->password = Hash::make($this->password);
    }
    $this->user->save();
    $this->reset('avatar');
    Notification::make()->title(__('Operación Exitosa'))->success()->send();
  }

  protected function getFormModel(): User
  {
    return $this->user;
  }

  protected function getFormSchema(): array
  {
    return [
      Forms\Components\Grid::make(2)
      ->schema([
        Forms\Components\Card::make()
        ->schema([
          Forms\Components\FileUpload::make('avatar')
            ->maxSize(100)
            ->image()
            ->directory('avatar')
            ->visibility('public')
            ->multiple(false),
        ])
        ->columnSpan(['lg' => 1])
        ->hidden(fn (?User $record) => $record === null),


        Forms\Components\Card::make()
        ->schema([
          Forms\Components\TextInput::make('name')
            ->required(),
          Forms\Components\TextInput::make('email')
            ->email()
            ->unique(ignoreRecord: true)
            ->required(),
          Forms\Components\TextInput::make('password')
            ->password()
            ->same('password_confirmation'),
          Forms\Components\TextInput::make('password_confirmation')
            ->password(),
        ])
        ->columns(1)
        ->columnSpan(['lg' => fn (?User $record) => $record === null ? 2 : 1]),

      ])      
    ];
  }

}
