<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_learns', function (Blueprint $table) {
            $table->dropForeign('member_learns_member_id_foreign');
            $table->dropColumn('member_id');
        });

        Schema::table('tests', function (Blueprint $table) {
            $table->dropForeign('tests_member_id_foreign');
            $table->dropColumn('member_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_member_id_foreign');
            $table->dropColumn('member_id');
        });

        Schema::dropIfExists('members');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('learn_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('prov_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('city_id')->nullable()->default(NULL);
            $table->string('level')->nullable()->default(NULL);
            $table->string('learn')->nullable()->default(NULL);
            $table->date('start_date')->nullable()->default(NULL);
            $table->date('end_date')->nullable()->default(NULL);
            $table->boolean('active')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('learn_id')->references('id')->on('learns')->onDelete('set null');
        });

        Schema::create('member_learns', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->default(NULL);
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });

        Schema::create('tests', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->default(NULL);
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->default(NULL);
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });

    }
}
