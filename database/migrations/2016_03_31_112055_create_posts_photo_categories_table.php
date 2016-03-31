<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsPhotoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_category_post', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('photo_category_id');

            $table->primary(['post_id', 'photo_category_id']);

            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('photo_category_id')->references('id')->on('photo_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photo_category_post', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropForeign(['photo_category_id']);
        });

        Schema::drop('photo_category_post');
    }
}
