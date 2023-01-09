<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 16)->nullable()->default(NULL)->after('level');
            $table->string('age', 100)->nullable()->default(NULL)->after('phone_number');
            $table->string('gender', 100)->nullable()->default(NULL)->after('age');
            $table->string('city')->nullable()->default(NULL)->after('gender');
            $table->string('otp_code', 16)->nullable()->default(NULL)->after('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_number');
            $table->dropColumn('age');
            $table->dropColumn('gender');
            $table->dropColumn('city');
            $table->dropColumn('otp_code');
        });
    }
}
