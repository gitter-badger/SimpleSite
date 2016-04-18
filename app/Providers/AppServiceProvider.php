<?php

namespace App\Providers;

use App\Helpers\SemanticUIPresenter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBlogComposers();
        $this->registerUserComposers();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::presenter(function ($paginator) {
            return new SemanticUIPresenter($paginator);
        });
    }

    protected function registerBlogComposers()
    {
        view()->composer('blog.latest', function (View $view) {
            $view->with('posts', \App\Post::latest()->with('members')->take(3)->get());
        });
    }

    protected function registerUserComposers()
    {
        view()->composer('users.birthdays', function (View $view) {
            $view->with('users', \App\User::nearestBirthday()->get());
        });
    }
}
