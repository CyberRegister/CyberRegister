<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Drop the U2F key table.
 *
 * The FIDO U2F JavaScript API was removed from browsers, and the
 * lahaxearnaud/laravel-u2f package that backed this table is archived.
 * Hardware key support returns via WebAuthn, which uses its own table.
 */
class DropU2fKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('u2f_key');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create(
            'u2f_key',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('keyHandle');
                $table->string('publicKey')->unique();
                $table->text('certificate');
                $table->integer('counter');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
            }
        );
    }
}
