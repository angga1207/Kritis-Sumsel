<?php

namespace App\Providers;

use App\Models\Comment;
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
        View::composer('components.layouts.admin', function ($view): void {
            $view->with('pendingCommentsCount', Comment::where('status', 'pending')->count());
        });
    }
}
