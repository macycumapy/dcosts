<?php

declare(strict_types=1);

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
            $table->foreignId('cash_flow_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nomenclature_id')->constrained();
            $table->float('count')->default(1)->comment('Количество');
            $table->float('cost')->default(0.0)->comment('Стоимость');
            $table->string('comment')->nullable();
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
