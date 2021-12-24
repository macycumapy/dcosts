<?php

use App\Enums\CashFlowType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlowTypeToCostItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cost_items', function (Blueprint $table) {
            $table->enum('type', CashFlowType::values())
                ->comment('Тип движения');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cost_items', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
