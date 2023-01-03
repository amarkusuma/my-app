<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
