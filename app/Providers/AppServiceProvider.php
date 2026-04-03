<?php
namespace App\Providers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

            if (auth::check()) {

                $notifikasi = Notifikasi::where('user_id', auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $unread = Notifikasi::where('user_id', auth::id())
                    ->where('is_read', false)
                    ->count();

                $view->with([
                    'notifikasi' => $notifikasi,
                    'unread'     => $unread,
                ]);
            }
        });
    }
}
