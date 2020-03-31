<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'pce_points',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('location_code', 6)->nullable();
                $table->integer('points')->unsigned();
                $table->string('controller_code', 6)->nullable();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('no action')->onUpdate('no action');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'pce_points',
            function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            }
        );
        Schema::dropIfExists('pce_points');
    }
}
