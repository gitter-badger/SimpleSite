<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('type')->default(\App\Post::TYPE_NEWS);

            $table->text('text_intro');
            $table->text('text');
            $table->text('text_source');

            $table->string('image');
            $table->string('thumb');

            $table->unsignedInteger('author_id')->index();
            $table->foreign('author_id')->references('id')->on('users');

            $table->timestamps();
            $table->date('event_date')->nullable();

            $table->softDeletes();
        });

        Schema::create('post_member', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('user_id');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_member', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::drop('posts');
        Schema::drop('post_member');
    }
}
