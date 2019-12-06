<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cash_flow_id');
            $table->unsignedBigInteger('nomenclature_id');
            $table->integer('quantity')->default(1);
            $table->double('cost')->default(0);
            $table->string('comment',100)->nullable();

            $table->foreign('cash_flow_id')->references('id')->on('cash_flows')->onDelete('cascade');
            $table->foreign('nomenclature_id')->references('id')->on('nomenclatures');
        });
    }

    /**cost_item_id
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_flow_details');
    }
}
