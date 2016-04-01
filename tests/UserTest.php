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
        $this->assertEquals(1, $user->roles()->count());

        $user->assignRoles($roles);
        $this->assertEquals(5, $user->roles()->count());
    }

    public function testUserRoleAssign()
    {
        /** @var App\User $user */
        $user = factory(App\User::class)->create();

        /** @var App\Role $role */
        $role = factory(App\Role::class)->create();
        $user->assignRoles($role->name);

        $this->assertEquals(1, $user->roles()->count());
    }
}