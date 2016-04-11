<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsPollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_post', function (Blueprint $table) {
            $table->unsignedInteger('post_id');
            $table->unsignedInteger('poll_id');

            $table->primary(['post_id', 'poll_id']);

            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('poll_id')->references('id')->on('polls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_post', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropForeign(['poll_id']);
        });

        Schema::drop('poll_post');
    }
}
