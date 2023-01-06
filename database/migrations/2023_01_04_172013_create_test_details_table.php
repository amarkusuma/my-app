<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->nullable()->default(NULL);
            $table->string('text_option')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('test_id')->references('id')->on('tests')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_details');
    }
}
