<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashInflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_inflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cost_item_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->float('sum')->default(0);
            $table->timestamp('date');
            $table->timestamps();

            $table->foreign('user_id','user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cost_item_id','cost_item_id')->references('id')->on('cost_items')->onDelete('set null');
            $table->foreign('partner_id','partner_id')->references('id')->on('partners')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_inflows');
    }
}
