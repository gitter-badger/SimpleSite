<?php

namespace App\Providers;

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
    }
}
