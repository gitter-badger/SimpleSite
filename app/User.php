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
 * @property int               $id
 *
 * @property string            $name
 * @property string            $email
 * @property string            $password
 * @property string            $position
 * @property int               $phone_internal
 * @property int               $phone_mobile
 * @property bool              $is_ldap
 *
 * @property string            $avatar
 * @property string            $avatar_path
 * @property string            $avatar_url
 *
 * @property Collection|Role[] $roles
 *
 * @property Carbon            $created_at
 * @property Carbon            $updated_at
 * @property Carbon            $password_expired_at
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
        'is_ldap',
        'position',
        'phone_internal',
        'phone_mobile',
        'password_expired_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'avatar' => 'upload',
        'is_ldap' => 'boolean',
        'phone_internal' => 'integer'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
        'name_with_avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['password_expired_at'];

    /**
     * @return array
     */
    public function getUploadSettings()
    {
        return [
            'avatar' => [
                'resize' => [200, null, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                }],
            ],
        ];
    }

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
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->hasRole(Role::ROLE_MANAGER);
    }

    /**********************************************************************
     * Scopes
     **********************************************************************/

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByName($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string $name
     *
     * @return string
     */
    public function getNameAttribute($name)
    {
        if (empty($name)) {
            return $this->email;
        }

        return $name;
    }
    
    /**
     * @return string|void
     */
    public function getNameWithAvatarAttribute()
    {
        $name = $this->name;

        if (empty($name)) {
            return;
        }

        $avatar = $this->avatar_url;

        if (! empty($avatar)) {
            return "<img class=\"ui avatar mini image\" src=\"{$this->avatar_url}\" /> {$name}";
        }

        return $name;
    }

    /**
     * @param string $phone
     */
    public function setPhoneMobileAttribute($phone)
    {
        $this->attributes['phone_mobile'] = preg_replace(
            '~\+?[^\d]{0,7}([0-9]{1})?[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{2})[^\d]{0,7}(\d{2})~',
            '+$1 ($2) $3-$4$5',
            $phone
        );
    }

}
