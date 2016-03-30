<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('image');
            $table->string('thumb');

            $table->string('caption')->default('');
            $table->text('description')->default('');

            $table->unsignedInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('photo_categories');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::drop('photos');
    }
}
