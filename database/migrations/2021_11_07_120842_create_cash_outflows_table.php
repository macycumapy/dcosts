<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOutflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_outflows', function (Blueprint $table) {
            $table->id();
            $table->float('sum')->comment('Сумма')->default(0.0);
            $table->timestamp('date')->comment('Дата расхода');
            $table->timestamps();
            $table->unsignedBigInteger('cost_item_id')->nullable();
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cost_item_id')->references('id')->on('cost_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_outflows');
    }
}
