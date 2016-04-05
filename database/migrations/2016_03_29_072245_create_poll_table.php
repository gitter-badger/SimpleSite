<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('description')->default('');
            $table->boolean('multiple')->default(false);

            $table->timestamps();
            $table->date('expired_at');
            $table->softDeletes();

            $table->unsignedInteger('author_id')->index();
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::create('poll_answers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('description')->default('');

            $table->unsignedInteger('votes')->default(0);

            $table->timestamps();

            $table->unsignedInteger('poll_id')->index();
            $table->foreign('poll_id')->references('id')->on('polls');

            $table->unsignedInteger('author_id')->index();
            $table->foreign('author_id')->references('id')->on('users');
        });

        Schema::create('poll_votes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('poll_id')->index();
            $table->foreign('poll_id')->references('id')->on('polls');

            $table->unsignedInteger('answer_id')->index();
            $table->foreign('answer_id')->references('id')->on('poll_answers');

            $table->unsignedInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');

            $table->unique(['poll_id', 'answer_id', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polls', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::table('poll_answers', function (Blueprint $table) {
            $table->dropForeign(['poll_id']);
            $table->dropForeign(['author_id']);
        });

        Schema::table('poll_votes', function (Blueprint $table) {
            $table->dropForeign(['poll_id']);
            $table->dropForeign(['answer_id']);
            $table->dropForeign(['author_id']);
        });

        Schema::drop('polls');
        Schema::drop('poll_answers');
        Schema::drop('poll_votes');
    }
}
