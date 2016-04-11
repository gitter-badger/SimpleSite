<?php

namespace App\Providers;

use Adldap\Adldap;
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

        $this->app->singleton('ldap', function() {
            extract(config('auth.providers.ldap.options', [null, null, null, null, null]));

            return new Adldap([
                'account_suffix' => $domain,
                'domain_controllers' => [$server],
                'base_dn' => $base_dn,
                'admin_username' => $user,
                'admin_password' => $password,
                'use_ssl' => false,
                'use_tls' => false,
            ]);
        });
    }

    protected function registerBlogComposers()
    {
        view()->composer('blog.latest', function (View $view) {
            $view->with('posts', \App\Post::latest()->take(3)->get());
        });
    }
}
