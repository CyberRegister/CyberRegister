<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCyberExpertisesChangeExpertiseCodeUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'cyber_expertises',
            function (Blueprint $table) {
                $table->string('expertise_code', 3)->nullable()->unique()->change();
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
            'cyber_expertises',
            function (Blueprint $table) {
                $table->dropUnique('cyber_expertises_expertise_code_unique');
            }
        );
    }
}
