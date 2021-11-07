<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashOutflowDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_outflow_details', function (Blueprint $table) {
            $table->id();
            $table->float('count')->default(1)->comment('Количество');
            $table->float('cost')->default(0.0)->comment('Стоимость');
            $table->float('sum')->default(0.0)->comment('Сумма');
            $table->unsignedBigInteger('cash_outflow_id');
            $table->unsignedBigInteger('nomenclature_id');

            $table->foreign('cash_outflow_id')->references('id')->on('cash_flows')->onDelete('cascade');
            $table->foreign('nomenclature_id')->references('id')->on('nomenclatures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_outflow_details');
    }
}
