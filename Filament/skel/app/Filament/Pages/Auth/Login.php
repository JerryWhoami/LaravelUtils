<?php

namespace  App\Filament\Pages\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Yepsua\Filament\Forms\Components\Captcha;

/**
 * @property ComponentContainer $form
 */
class Login extends Component implements HasForms
{
  use InteractsWithForms;
  use WithRateLimiting;

  public $username = '';

  public $password = '';

  public $remember = false;

  public function mount(): void
  {
    if (Filament::auth()->check()) {
      redirect()->intended(Filament::getUrl());
    }

    $this->form->fill();
  }

  public function authenticate(): ?LoginResponse
  {
    try {
      $this->rateLimit(5);
    } catch (TooManyRequestsException $exception) {
      throw ValidationException::withMessages([
        'username' => __('filament::login.messages.throttled', [
          'seconds' => $exception->secondsUntilAvailable,
          'minutes' => ceil($exception->secondsUntilAvailable / 60),
        ]),
      ]);
    }

    $data = $this->form->getState();

    if (!Filament::auth()->attempt([
      'username' => $data['username'],
      'password' => $data['password'],
    ], $data['remember'])) {
      throw ValidationException::withMessages([
        'username' => __('filament::login.messages.failed'),
      ]);
    }

    return app(LoginResponse::class);
  }

  protected function getFormSchema(): array
  {
    return [
      TextInput::make('username')
        ->label(__('login.fields.username.label'))
        ->required()
        ->autocomplete(),
      TextInput::make('password')
        ->label(__('filament::login.fields.password.label'))
        ->password()
        ->required(),
      Captcha::make('captcha'),
      Checkbox::make('remember')
        ->label(__('filament::login.fields.remember.label')),
    ];
  }

  public function render(): View
  {
    return view('filament::login')
      ->layout('filament::components.layouts.card', [
        'title' => __('filament::login.title'),
      ]);
  }
}
