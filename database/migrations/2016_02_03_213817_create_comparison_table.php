<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComparisonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comparison', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('post1_sort', false, true)->comment = '1 = page; 2 = group';
            $table->integer('post1_page_id')->comment = 'id of group/page';
            $table->string('post1_post_id')->comment = 'id of new post created by user';
            $table->text('post1_text');
            $table->tinyInteger('post2_sort', false, true)->comment = '1 = page; 2 = group';
            $table->integer('post2_page_id')->comment = 'id of group/page';
            $table->string('post2_post_id')->comment = 'id of new post created by user';
            $table->text('post2_text');
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
        Schema::dropIfExists('comparison');
    }
}
