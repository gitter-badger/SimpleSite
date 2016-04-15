<?php

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Photo::truncate();
        App\PhotoCategory::truncate();

        File::deleteDirectory(public_path('upload/upload'));
        File::deleteDirectory(public_path('upload/photos'));

        factory(App\PhotoCategory::class, 20)->create();
        factory(App\Photo::class, 200)->create();
    }
}
