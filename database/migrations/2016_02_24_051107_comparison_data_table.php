<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComparisonDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comparison_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post1_likes', false, true);
            $table->integer('post1_comments', false, true);
            $table->integer('post1_shares', false, true);
            $table->integer('post2_likes', false, true);
            $table->integer('post2_comments', false, true);
            $table->integer('post2_shares', false, true);
            $table->integer('comparison_id', false, true)->index();
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
        Schema::dropIfExists('comparison_data');
    }
}
