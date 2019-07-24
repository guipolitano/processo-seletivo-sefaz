<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function ($table) {
            $table->increments('ID');
            $table->dateTime('HORA');
            $table->string('COD_GTIN')->nullable();
            $table->integer('STATUS_CODE');
            $table->integer('NUM_PRODUTOS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
