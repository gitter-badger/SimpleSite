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

        $user->email = 'test@test.ru';
        $user->name = 'test';

        $this->assertEquals($user->name, 'test');

        $user->name = '';
        $this->assertEquals($user->name, 'test@test.ru');
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
        $this->assertEquals( "<img class=\"ui avatar image\" src=\"".url('test')."\" /> Test Test", $user->name_with_avatar);
    }

    /**
     * @dataProvider phoneNumbers
     */
    public function testPhoneNumberParser($phone)
    {
        $user = new \App\User([
            'phone_mobile' => $phone
        ]);

        $this->assertEquals('+7 (495) 569-6223', $user->phone_mobile, $phone);
    }
    
    public function phoneNumbers()
    {
        return [
            ['+7 (495) 5696223'], ['+7 (495) 56962 23'], ['+7 (495) 56962-23'],
            ['7 (495) 5696223'], ['7 (495) 56962 23'], ['7 (495) 56962-23'],
            ['+7(495)5696223'], ['+7(495)56962 23'], ['+7(495)56962-23'],
            ['7(495)5696223'], ['7(495)56962 23'], ['7(495)56962-23'],
            ['+74955696223'], ['+749556962 23'], ['74955696223'],
            ['749556962 23'], ['749556962-23'], ['+7 495 5696223'],
            ['+7 495 56962 23'], ['+7 495 56962-23'], ['7 495 5696223'],
            ['7 495 56962 23'], ['7 495 56962-23'], ['+7 495 569 6223'],
            ['+7 495 569 62 23'], ['+7 495 569 62-23'], ['7 495 569 6223'],
            ['7 495 569 62 23'], ['7 495 569 62-23'], ['+7-495-569-62-23'],
            ['+7 (495) 569-62-23'], ['+7 (495) 569 62-23'], ['+7 495-569 62-23'],
            ['+7 495-569-62-23'], ['+7 495-5696223'], ['+7495-5696223'],
            ['7495-5696223'],
        ];
    }
}