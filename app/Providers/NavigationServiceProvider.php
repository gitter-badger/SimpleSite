<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use KodiComponents\Navigation\Navigation;
use KodiComponents\Navigation\Page;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Navigation $navigation */
        $navigation = $this->app['front.navigation'];

        $navigation->setFromArray([
            (new Page())
                ->setTitle(trans('core.title.index'))
                ->setUrl(route('home'))
                ->setHtmlAttribute('class', 'item'),
            (new Page())
                ->setTitle(trans('core.title.news'))
                ->setUrl(route('news.index'))
                ->setHtmlAttribute('class', 'item')
                ->setIcon('newspaper icon'),
            (new Page())
                ->setTitle(trans('core.title.gallery'))
                ->setUrl(route('gallery.index'))
                ->setHtmlAttribute('class', 'item')
                ->setIcon('photo icon'),
            (new Page())
                ->setTitle(trans('core.title.users'))
                ->setUrl(route('user.index'))
                ->setHtmlAttribute('class', 'item')
                ->setIcon('group icon'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('front.navigation', function () {
            return new Navigation();
        });
    }
}
