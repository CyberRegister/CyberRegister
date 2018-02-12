<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExpertisesChangeRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expertises', function (Blueprint $table) {
            $table->dropColumn('expertise_code');
            $table->integer('cyber_expertise_id')->unsigned()->after('user_id');
            $table->foreign('cyber_expertise_id')->references('id')->on('cyber_expertises')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expertises', function (Blueprint $table) {
            $table->dropForeign(['cyber_expertise_id']);
        });
        Schema::table('expertises', function (Blueprint $table) {
            $table->dropColumn(['cyber_expertise_id']);
            $table->string('expertise_code', 3)->nullable()->after('user_id');
        });
    }
}
