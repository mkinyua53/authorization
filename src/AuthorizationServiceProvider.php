<?php

namespace Mkinyua53\Authorization;

use Illuminate\Support\ServiceProvider;

class AuthorizationServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
        //
  }
}
