<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_soal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_soal_id')->nullable();
            $table->string('question');
            $table->string('correct_answer');
            $table->string('correct_option',50);
            $table->string('option_A')->nullable();
            $table->string('option_B')->nullable();
            $table->string('option_C')->nullable();
            $table->string('option_D')->nullable();
            $table->timestamps();

            $table->foreign('bank_soal_id')->references('id')->on('bank_soal')
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
        Schema::dropIfExists('sub_soal');
    }
}
