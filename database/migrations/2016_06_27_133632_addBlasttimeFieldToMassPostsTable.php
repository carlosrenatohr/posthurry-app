<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlasttimeFieldToMassPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('massPosts', function (Blueprint $table) {
            //
            $table->dateTime('blastAt')->after('posts_published')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('massPosts', function (Blueprint $table) {
            //
            $table->dropColumn('blastAt');
        });
    }
}
