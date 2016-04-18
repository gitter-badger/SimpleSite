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

        File::deleteDirectory(public_path('upload/users'));

        factory(User::class, 50)->create()->each(function(User $user) {
            $chief = User::first();

            if ($user->id != $chief->id) {
                $user->chief()->associate(User::first());
                $user->save();
            }
        });

        /** @var User $user */
        $user = factory(User::class)->create([
            'email' => 'admin@site.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRoles(\App\Role::ROLE_ADMIN);
    }
}
