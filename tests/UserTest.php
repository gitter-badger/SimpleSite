<?php

class UserTest extends TestCase
{

    use \Illuminate\Foundation\Testing\DatabaseTransactions;

    public function testUserCreation()
    {
        /** @var App\User $user */
        $user = factory(App\User::class)->create();
        $this->assertTrue($user->exists);
    }

    public function testUserRolesAssign()
    {
        /** @var App\User $user */
        $user = factory(App\User::class)->create();

        /** @var App\Role[]|\Illuminate\Database\Eloquent\Collection $roles */
        $roles = factory(App\Role::class, 5)->create();

        $user->assignRoles($roles->first());
        $this->assertEquals($user->roles->count(), 1);

        $user->assignRoles($roles);
        $this->assertEquals($user->roles->count(), 5);
    }

    public function testUserRoleAssign()
    {
        /** @var App\User $user */
        $user = factory(App\User::class)->create();

        /** @var App\Role $role */
        $role = factory(App\Role::class)->create();
        $user->assignRoles($role->name);

        $this->assertEquals($user->roles->count(), 1);
    }
}