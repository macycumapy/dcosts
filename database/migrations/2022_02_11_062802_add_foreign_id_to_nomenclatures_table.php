<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignIdToNomenclaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->unsignedBigInteger('foreign_id')->nullable()->comment('Id внешнего источника');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomenclatures', function (Blueprint $table) {
            $table->dropColumn('foreign_id');
        });
    }
}
