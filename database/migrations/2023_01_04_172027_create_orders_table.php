<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('learn_id')->nullable()->default(NULL);
            $table->string('learn_name')->nullable()->default(NULL);
            $table->string('price')->nullable()->default(NULL);
            $table->string('amounts')->nullable()->default(NULL);
            $table->string('discount')->nullable()->default(NULL);
            $table->string('payment_status')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
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
        Schema::dropIfExists('orders');
    }
}
