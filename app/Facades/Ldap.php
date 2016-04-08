<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Adldap\Adldap
 */
class Ldap extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ldap';
    }
}
