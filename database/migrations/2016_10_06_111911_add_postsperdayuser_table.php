<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostsperdayuserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_postsperday', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('today');
            $table->integer('posts')->default(0);
            $table->boolean('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_postsperday');
    }
}
