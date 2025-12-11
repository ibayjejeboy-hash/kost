<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
         View::composer('*', function ($view) {
        if (Auth::check()) {
            $notifications = Notifikasi::where('user_id', Auth::id())
                ->where('status', 'unread')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $notifications = collect();
        }

        $view->with('notifications', $notifications);
    });
    }
}
