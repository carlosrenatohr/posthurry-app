<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableMassposts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('massPosts', function (Blueprint $table) {
            $table->string( 'groups_name' )->nullable();
            $table->string( 'pages_name' )->nullable(); 
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
        });
    }
}
