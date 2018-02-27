<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create2faKeyTableAndCleanUpUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('2fa_key', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('google2fa_enable')->default(false);
            $table->string('google2fa_secret')->nullable();
            $table->timestamps();
        });
        Schema::table('2fa_key', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google2fa_secret');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('2fa_key', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->text('google2fa_secret')->nullable()->after('is_controller');
        });
        Schema::dropIfExists('2fa_key');
    }
}
