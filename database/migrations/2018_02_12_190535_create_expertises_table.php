<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'expertises', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('expertise_code', 3)->nullable();
                $table->date('date_of_certification')->nullable();
                $table->date('date_of_expiration')->nullable();
                $table->string('certification_code', 15)->nullable();
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
            'expertises', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            }
        );
        Schema::dropIfExists('expertises');
    }
}
