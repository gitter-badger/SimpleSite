<?php

namespace App\Providers;

use App\User;
use Crypt;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Str;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class LdapUserProvider extends EloquentUserProvider
{

    /**
     * @var array
     */
    protected $options = [];

    protected $ldap;

    /**
     * @var bool
     */
    protected $ldapUser = false;

    /**
     * Create a new database user provider.
     *
     * @param \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param string $model
     * @param array $options
     */
    public function __construct(HasherContract $hasher, $model, array $options = [])
    {
        parent::__construct($hasher, $model);
        $this->options = $options;
    }

    /**
     * @return boolean
     */
    public function isLdapUser()
    {
        return $this->ldapUser;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $user = parent::retrieveByCredentials($credentials);

        if (is_null($user) and Str::contains($credentials['email'], '@itprotect.ru')) {

            list($name, $domain) = explode("@", $credentials['email'], 2);
            $password = $credentials['password'];

            $this->ldapUser = \Ldap::authenticate($name, $password);

            if ($this->ldapUser) {
                $user = User::create([
                    'email' => $credentials['email'],
                    'name' => $name,
                    'password' => $this->getHasher()->make($credentials['password']),
                    'is_ldap' => true,
                ]);
            }
        }

        return $user;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     *
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $this->isLdapUser() or parent::validateCredentials($user, $credentials);
    }
}