<?php

namespace App;

use App\Traits\HasRoles;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 *
 * @property int               $id
 *
 * @property string            $name
 * @property string            $display_name
 * @property string            $email
 * @property string            $mail_to
 * @property string            $password
 * @property string            $position
 * @property int               $phone_internal
 * @property int               $phone_mobile
 * @property bool              $is_ldap
 *
 * @property string            $avatar
 * @property string            $avatar_path
 * @property string            $avatar_url
 * @property string            $avatar_url_or_blank
 * @property string            $name_with_avatar
 * @property string            $profile_link
 *
 * @property Collection|Role[] $roles
 * @property Collection|Post[] $events
 *
 * @property Carbon            $created_at
 * @property Carbon            $updated_at
 * @property Carbon            $password_expired_at
 * @property Carbon            $birthday
 */
class User extends Authenticatable
{

    use Upload, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
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
        'avatar' => 'image',
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
        'profile_link',
        'link',
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
    protected $dates = ['password_expired_at', 'deleted_at', 'birthday'];

    /**
     * @return array
     */
    public function getUploadSettings()
    {
        return [
            'avatar' => [
                'fit' => [300, 300, function ($constraint) {
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

    /**
     * @return bool
     */
    public function hasBirthday()
    {
        return ! is_null($this->birthday) and $this->birthday->isBirthday();
    }

    /**
     * @return array
     */
    public function contacts()
    {
        $contacts = [
            [
                'title' => trans('core.user.field.email'),
                'value' => $this->mail_to,
                'icon' => 'mail outline',
            ],
        ];

        if (! empty($phone = $this->phone_internal)) {
            $contacts[] = [
                'title' => trans('core.user.field.phone_internal'),
                'value' => $phone,
                'icon' => 'phone',
            ];
        }

        if (! empty($phone = $this->phone_mobile)) {
            $contacts[] = [
                'title' => trans('core.user.field.phone_mobile'),
                'value' => $phone,
                'icon' => 'phone',
            ];
        }

        return $contacts;
    }

    /**********************************************************************
     * Scopes
     **********************************************************************/

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLdap($query)
    {
        return $query->where('is_ldap', true);
    }

    /**
     * @param     $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByName($query)
    {
        return $query->orderBy('display_name');
    }

    /**
     * @param $query
     * @param int $days
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNearestBirthday($query, $days = 14)
    {
        intval($days);

        return $query->where(function($q) use($days) {
            $q->whereNotNull('birthday')
                ->whereRaw('dayofyear(curdate()) <= dayofyear(birthday)')
                ->whereRaw("DAYOFYEAR(curdate()) + {$days} >= dayofyear(birthday)");
        })->orderByRaw('DAYOFYEAR(birthday)');
    }

    /**********************************************************************
     * Mutators
     **********************************************************************/

    /**
     * @param string $name
     *
     * @return string
     */
    public function getDisplayNameAttribute($name)
    {
        if (is_null($name)) {
            return $this->name;
        }

        return $name;
    }

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
     * @return string
     */
    public function getAvatarUrlOrBlankAttribute()
    {
        if (empty($url = $this->avatar_url)) {
            return asset('images/blank.png');
        }

        return $url;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getMailToAttribute($name)
    {
        return "<a href=\"mailto:$this->email\">$this->email</a>";
    }

    /**
     * @param string|null $name
     *
     * @return string|void
     */
    public function getNameWithAvatarAttribute($name = null)
    {
        if (is_null($name)) {
            $name = $this->display_name;
        }

        if (empty($name)) {
            return;
        }

        $avatar = $this->avatar_url;

        if (! empty($avatar)) {
            $name = "<img class=\"ui avatar image\" src=\"{$this->avatar_url}\" /> {$name}";
        }

        return $name;
    }

    /**
     * @return string
     */
    public function getProfileLinkAttribute()
    {
        return "<a href=\"".$this->link."\" target=\"_blank\">{$this->name_with_avatar}</a>";
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('user.profile', [$this->id]);
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

    /**********************************************************************
     * Relations
     **********************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(Post::class, 'post_member', 'user_id', 'post_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function mentions()
    {
        return $this->morphedByMany(Post::class, 'related', 'user_mentions');
    }
}
