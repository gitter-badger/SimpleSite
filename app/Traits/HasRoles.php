<?php

namespace App\Traits;

use App\Role;
use Illuminate\Database\Eloquent\Collection;

trait HasRoles
{

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the given role to the user.
     *
     * @param string|Role|Collection $roles
     *
     * @return mixed
     */
    public function assignRoles($roles)
    {
        if (is_string($roles)) {
            $roles = Role::whereName($roles)->firstOrFail();
        }

        if ($roles instanceof Role) {
            $roles = [$roles->id];
        }

        return $this->roles()->sync($roles, false);
    }

    /**
     * Determine if the user has the given role.
     *
     * @param string|Collection $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return ! ! $role->intersect($this->roles)->count();
    }
}
