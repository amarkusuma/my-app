<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToMemberLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_learns', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->default(NULL)->after('id');
            $table->tinyInteger('level')->nullable()->default(NULL)->after('learn_id');
            $table->string('learn')->nullable()->default(NULL)->after('level');
            $table->boolean('finished')->nullable()->default(false)->after('active');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // $table->dropForeign('member_learns_member_id_foreign');
            // $table->dropColumn('member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_learns', function (Blueprint $table) {
            $table->dropForeign('member_learns_user_id_foreign');
            $table->dropColumn('user_id');

            $table->dropColumn('level');
            $table->dropColumn('learn');
            $table->dropColumn('finished');

            $table->unsignedBigInteger('member_id')->nullable()->default(NULL);
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });
    }
}
