<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');

            $table->text('text_intro');
            $table->text('text');
            $table->text('text_source');

            $table->string('image');
            $table->string('thumb');

            $table->unsignedInteger('author_id')->index();
            $table->foreign('author_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::drop('blog');
    }
}
