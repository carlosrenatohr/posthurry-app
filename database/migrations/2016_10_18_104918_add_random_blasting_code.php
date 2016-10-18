<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRandomBlastingCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blasting', function (Blueprint $table) {
           $table->integer( 'code' ); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blasting', function (Blueprint $table) {
            $table->dropColumn( 'code' );
        });
    }
}
