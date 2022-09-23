<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomenclaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomenclatures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Наименование');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('nomenclature_type_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('nomenclature_type_id')->references('id')->on('nomenclature_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomenclatures');
    }
}
