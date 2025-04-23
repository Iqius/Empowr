<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

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
    public function boot()
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $unreadCount = Notification::where('user_id', auth()->id())
                                        ->where('is_read', false)
                                        ->count();

                $notifications = Notification::where('user_id', auth()->id())
                                            ->latest()
                                            ->take(5)
                                            ->get();

                $view->with([
                    'unreadCount' => $unreadCount,
                    'notifications' => $notifications,
                ]);
            }
        });
    }
}
