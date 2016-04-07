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

    public function testName()
    {
        /** @var App\User $user */
        $user = new App\User();

        $user->name = 'test';
        $this->assertEquals($user->name, 'test');
    }


    public function testEmptyName()
    {
        /** @var App\User $user */
        $user = new App\User();

        $user->email = 'test@test.ru';
        $this->assertEquals($user->name, 'test@test.ru');
    }

    public function testEmptyAvatar()
    {
        /** @var App\User $user */
        $user = new App\User();

        $user->name = 'Test Test';

        $this->assertNull($user->avatar);
        $this->assertNull($user->avatar_url);
        $this->assertNull($user->avatar_path);

        $this->assertEquals($user->name_with_avatar, "Test Test");
    }

    public function testAvatar()
    {
        /** @var App\User $user */
        $user = new App\User();

        $user->avatar = 'test';
        $user->name = 'Test Test';

        $this->assertEquals($user->avatar, 'test');
        $this->assertEquals($user->avatar_url, url('test'));
        $this->assertEquals($user->avatar_path, public_path('test'));
        $this->assertEquals($user->name_with_avatar, "<img class=\"ui avatar mini image\" src=\"".url('test')."\" /> Test Test");
    }
}