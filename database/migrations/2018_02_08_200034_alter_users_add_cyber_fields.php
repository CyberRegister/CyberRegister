<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersAddCyberFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->string('cyber_code', 6)->unique()->nullable()->after('remember_token');
                $table->string('verification_code', 4)->nullable()->after('cyber_code');
                $table->string('first_name')->nullable()->after('id');
                $table->string('middle_name')->nullable()->after('first_name');
                $table->string('last_name')->nullable()->after('middle_name');
                $table->string('initials')->nullable()->after('id');
                $table->date('date_of_birth')->nullable()->after('verification_code');
                $table->string('place_of_birth')->nullable()->after('date_of_birth');
                $table->binary('photo')->nullable()->after('place_of_birth');
                $table->string('controller_code', 6)->nullable()->after('photo');
                $table->boolean('is_controller')->default(false)->after('controller_code');
                $table->dropColumn('name');
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
            'users',
            function (Blueprint $table) {
                $table->dropColumn(
                    [
                        'cyber_code', 'verification_code', 'first_name', 'middle_name',
                        'last_name', 'initials', 'date_of_birth', 'place_of_birth', 'photo',
                        'controller_code', 'is_controller',
                    ]
                );
                $table->string('name')->after('id');
            }
        );
    }
}
