<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Game;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menus = Game::orderBy('nama', 'asc')->where('status', 1)->get();
        view()->share('menus', $menus);
    }
}
