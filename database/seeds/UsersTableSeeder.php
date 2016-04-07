<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        factory(User::class, 5)->create();

        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'admin@site.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRoles(\App\Role::ROLE_ADMIN);
    }
}
