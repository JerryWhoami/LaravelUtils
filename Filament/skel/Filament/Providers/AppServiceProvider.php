<?php

namespace App\Providers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Sendinblue\Transport\SendinblueTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;


use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Filament\Navigation\NavigationGroup;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Paginator::useBootstrapFive();

    Mail::extend('sendinblue', function () {
      return (new SendinblueTransportFactory)->create(
        new Dsn(
          'sendinblue+api',
          'default',
          config('services.sendinblue.key')
        )
      );
    });

    Filament::serving(function () {
      Filament::registerStyles(config('filament.styles', []));
      Filament::registerScripts(config('filament.scripts', []));

      Filament::registerUserMenuItems([
        'profile' => UserMenuItem::make()
          ->icon('heroicon-o-user')
          ->label(__('Perfil'))
          ->url(route('filament.pages.profile')),
      ]);

      Filament::registerRenderHook(
        'global-search.end',
        fn (): View => view('filament.components.admin-menu', [
          'items' => $this->getFilamentAdminResouces()
        ]),
      );

      Filament::registerNavigationGroups([
        NavigationGroup::make('listados')
          ->label(__('Listados')),
      ]);

      // Filament::registerTheme(
      //   app(Vite::class)('resources/css/filament.css'),
      // );

      // Filament::registerRenderHook(
      //   'global-search.end',
      //   fn (): View => view('filament.components.admin-menu', [
      //     'items' => config('menu_admin', []),
      //   ]),
      // );

      if (config('app.debug', false) && Auth::check() && in_array(Auth::user()?->username, config('app.debugbarUsers', []))) {
        Debugbar::enable();
      } else {
        Debugbar::disable();
      }

    });

    Mail::extend('sendinblue', function () {
      return (new SendinblueTransportFactory)->create(
        new Dsn(
          'sendinblue+api',
          'default',
          config('services.sendinblue.key')
        )
      );
    });

    if (! Debugbar::isEnabled()) {
      if (config('app.debug', false) && Auth::check() && in_array(Auth::user()?->username, config('app.debugbarUsers', []))) {
        Debugbar::enable();
      } else {
        Debugbar::disable();
      }
    }
  }

  public function getFilamentAdminResouces()
  {
    $adminResources = config('filament.adminMenu.resources');
    $resources = collect(Filament::getResources())
      ->filter(function ($resource) use ($adminResources) {
        return in_array($resource, $adminResources);
      })
      ->map(function ($resource) {
        $resource = App::make($resource);
        $route = $resource->getRouteBaseName() . '.index';
        if ($resource->canCreate() && Route::has($route)) {
          $navItems = $resource->getNavigationItems();
          return [
            'label' => Str::title($resource->getPluralModelLabel()),
            'icon' => $navItems[0]->getIcon(),
            'url' => route($route)
          ];
        }
      })
      ->sortBy('label')
      ->values()
      ->toArray();

    // dd($resources);
    return array_filter($resources);
  }
}
