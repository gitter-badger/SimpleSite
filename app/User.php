<?php

namespace App;

use App\Traits\HasRoles;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 *
 * @property int $id
 *
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @property string $avatar
 * @property string $avatar_path
 * @property string $avatar_url
 *
 * @property Collection|Role[] $roles
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{

    use Upload, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hash',
        'is_ldap',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'avatar' => 'upload',
        'is_ldap' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $uploadSettings = [
        'avatar' => [
            'resize' => [200, 200],
        ],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'hash',
    ];

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(Role::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isManager()
    {
        return $this->hasRole(Role::ROLE_MANAGER);
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string|null $name
     *
     * @return string|void
     */
    public function getNameAttribute(string $name = null)
    {
        if (empty($name)) {
            return;
        }

        $avatar = $this->avatar_url;

        if (! empty($avatar)) {
            return "<img class=\"ui avatar mini image\" src=\"{$this->avatar_url}\" /> {$name}";
        }

        return $name;
    }
}
