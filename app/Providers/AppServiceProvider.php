<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Http\Composers\PostSidebarComposer as ComposersPostSidebarComposer;
use Illuminate\Support\Facades\View as FacadesView;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Carbon::setLocale(config('app.locale'));
    }

    protected function registerViewComposers()
    {
        FacadesView::composer('posts.sidebar', ComposersPostSidebarComposer::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerViewComposers();
    }
}
