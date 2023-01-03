<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_learns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('learn_id')->nullable()->default(NULL);
            $table->boolean('active')->nullable()->default(false);
            $table->date('start_date')->nullable()->default(NULL);
            $table->date('end_date')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_learns');
    }
}
