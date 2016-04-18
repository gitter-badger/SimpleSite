<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mentions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->morphs('related');

            $table->primary(['user_id', 'related_id', 'related_type']);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_mentions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::drop('user_mentions');
    }
}
