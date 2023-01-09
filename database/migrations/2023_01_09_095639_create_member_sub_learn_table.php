<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberSubLearnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_sub_learn', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('learn_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('sub_learn_id')->nullable()->default(NULL);
            $table->boolean('video_status')->nullable()->default(false);
            $table->boolean('materi_status')->nullable()->default(false);
            $table->boolean('exam_status')->nullable()->default(false);
            $table->integer('min_correct')->nullable()->default(NULL);
            $table->integer('corrected')->nullable()->default(NULL);
            $table->boolean('finished')->nullable()->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('learn_id')->references('id')->on('learns')->onDelete('set null');
            $table->foreign('sub_learn_id')->references('id')->on('sub_learns')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_sub_learn');
    }
}
