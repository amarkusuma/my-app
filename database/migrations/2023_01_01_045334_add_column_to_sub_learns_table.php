<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSubLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_learns', function (Blueprint $table) {
            $table->integer('limit_soal')->nullable()->default(NULL)->after('min_correct');
            $table->boolean('activated')->nullable()->default(true)->after('link_youtube');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_learns', function (Blueprint $table) {
            $table->dropColumn('limit_soal');
            $table->dropColumn('activated');
        });
    }
}
