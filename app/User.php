<?php

namespace App;

use App\Traits\Upload;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 *
 * @property int    $id
 *
 * @property string $name
 * @property string $email
 * @property string $password
 *
 */
class User extends Authenticatable
{

    use Upload;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'avatar' => 'upload',
    ];

    /**
     * @var array
     */
    protected $uploadSettings = [
        'avatar' => [
            'resize' => [200, 200]
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
    ];

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string $name
     *
     * @return string|void
     */
    public function getNameAttribute($name)
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
