<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Recovery codes let someone back in when their authenticator is gone.
 */
class Create2faRecoveryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            '2fa_recovery_codes',
            function (Blueprint $table) {
                $table->increments('id');
                // Matches the unsigned int id on users, which predates
                // bigIncrements, so the foreign key can form.
                $table->integer('user_id')->unsigned();
                // Hashed. A recovery code is a credential, and the point of
                // one is that it still works when the second factor does not.
                $table->string('code');
                $table->timestamp('used_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->index(['user_id', 'used_at']);
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
        Schema::dropIfExists('2fa_recovery_codes');
    }
}
