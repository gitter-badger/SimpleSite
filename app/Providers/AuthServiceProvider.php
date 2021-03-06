<?php

namespace App\Providers;

use Adldap\Adldap;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Post::class => \App\Policies\PostPolicy::class,
        \App\Photo::class => \App\Policies\GalleryPolicy::class,
        \App\PhotoCategory::class => \App\Policies\GalleryPolicy::class,
        \App\Role::class => \App\Policies\RolePolicy::class,
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Poll::class => \App\Policies\PollPolicy::class,
        \App\PollAnswer::class => \App\Policies\PollPolicy::class,
        \App\PollVote::class => \App\Policies\PollPolicy::class,
        \App\Upload::class => \App\Policies\UploadPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $this->app['auth']->provider('ldap', function ($app, array $config) {
            return new LdapUserProvider($app['hash'], $config['model'], $config['options']);
        });

        view()->composer(\AdminTemplate::getViewPath('_partials.header'), function($view) {
            $view->getFactory()->inject(
                'navbar.right', view('auth.partials.navbar', [
                    'user' => auth()->user()
                ])
            );
        });
    }
    
    public function register()
    {
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
}
