<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_learns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learn_id')->nullable();
            $table->unsignedBigInteger('bank_soal_id')->nullable();
            $table->string('sub_name');
            $table->string('min_correct', 5)->nullable();
            $table->string('pdf')->nullable();
            $table->string('link_youtube')->nullable();
            $table->timestamps();

            $table->foreign('bank_soal_id')->references('id')->on('bank_soal')
            ->onDelete('set null');
            $table->foreign('learn_id')->references('id')->on('learns')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_learns');
    }
}
