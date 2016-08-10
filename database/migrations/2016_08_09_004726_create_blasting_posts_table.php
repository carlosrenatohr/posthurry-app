<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlastingPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blasting', function (Blueprint $table) {
            $table->increments('id');
            $table->text('post_text');
            $table->text('post_img_url')->nullable();
            $table->text('groups_id');
            $table->text('groups_names');
            $table->text('groups_published_id');
//            $table->text('groups_published_status')->nullable();
//            $table->text('groups_published_message')->nullable();
            $table->text('pages_id');
            $table->text('pages_names');
            $table->text('pages_published_id');
//            $table->text('pages_published_status')->nullable();
//            $table->text('pages_published_message')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('blasting');
    }
}
