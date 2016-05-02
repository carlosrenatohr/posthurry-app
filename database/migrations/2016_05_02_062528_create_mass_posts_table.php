<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMassPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('massPosts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('groups');
            $table->text('pages');
            $table->text('posts_published')->nullable();
            $table->integer('comparison_id')->index();
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
        Schema::dropIfExists('massPosts');
    }
}
