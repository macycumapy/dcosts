<?php

declare(strict_types=1);

use App\Enums\CashFlowType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();
            $table->float('sum')->comment('Сумма')->default(0.0);
            $table->timestamp('date')->comment('Дата движения денежных средств');
            $table->enum('type', CashFlowType::values())->comment('Тип движения');
            $table->unsignedBigInteger('cost_item_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('cost_item_id')->references('id')->on('cost_items')->onDelete('set null');
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_flows');
    }
}
