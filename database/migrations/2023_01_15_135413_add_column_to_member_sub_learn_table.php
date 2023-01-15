<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMemberSubLearnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_sub_learn', function (Blueprint $table) {
            $table->boolean('active')->nullable()->default(false)->after('corrected');
            $table->integer('sequence_number')->nullable()->default(NULL)->after('finished');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_sub_learn', function (Blueprint $table) {
            //
        });
    }
}
