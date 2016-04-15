<?php

use Illuminate\Database\Seeder;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Post::truncate();

        File::deleteDirectory(public_path('upload/posts'));
        
        factory(App\Post::class, 100)->create();
    }
}
