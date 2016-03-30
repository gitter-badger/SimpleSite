<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->sentence(5),
        'text_source' => $faker->sentence(10).'<cut></cut># Title'.PHP_EOL.$faker->sentence(100),
        'author_id'   => function () {
            $user = App\User::first();
            if (is_null($user)) {
                $user = factory(App\User::class)->create();
            }

            return $user->id;
        },
        'upload_file' => $faker->randomElement([
            null,
            null,
            null,
            function() {
                $files = File::files(public_path('tmp'));
                $filesPath = $files[array_rand($files)];

                $file = new \Illuminate\Http\UploadedFile(
                    $filesPath,
                    basename($filesPath),
                    'image/jpeg',
                    File::size($filesPath)
                );

                return $file;
            }
        ])
    ];
});

$factory->define(App\Poll::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->title,
        'description' => $faker->text,
        'author_id'   => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\PollAnswer::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->title,
        'description' => $faker->text,
        'author_id'   => function () {
            $user = App\User::first();
            if (is_null($user)) {
                $user = factory(App\User::class)->create();
            }

            return $user->id;
        },
    ];
});

$factory->define(App\PhotoCategory::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->sentence(3),
        'description' => $faker->randomElement([
            $faker->sentence(3),
            '',
        ]),
    ];
});

$factory->define(App\Photo::class, function (Faker\Generator $faker) {
    return [
        'caption'     => $faker->sentence(3),
        'description' => $faker->randomElement([
            $faker->sentence(3),
            '',
        ]),
        'category_id' => function () use ($faker) {
            $categories = App\PhotoCategory::pluck('id')->all();

            if (empty($categories)) {
                $categories[] = factory(App\PhotoCategory::class)->create()->id;
            }

            return $faker->randomElement($categories);
        },
        'upload_file' => function() {
            $files = File::files(public_path('tmp'));
            $filesPath = $files[array_rand($files)];

            $file = new \Illuminate\Http\UploadedFile(
                $filesPath,
                basename($filesPath),
                'image/jpeg',
                File::size($filesPath)
            );

            return $file;
        }
    ];
});