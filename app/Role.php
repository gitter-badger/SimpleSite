<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App
 *
 * @property string $name
 * @property string $label
 * @property Collection|User[] $roles
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Role extends Model
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
    ];

    /**********************************************************************
     * Relations
     **********************************************************************/
    
    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
