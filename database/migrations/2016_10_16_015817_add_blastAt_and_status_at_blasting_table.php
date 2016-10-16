<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBlastAtAndStatusAtBlastingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blasting', function (Blueprint $table) {
            $table->dateTime( 'blastAt' );
            $table->string( 'status' ); 
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
            $table->dropColumn( [ 'blastAt', 'status' ] );
        });
    }
}
