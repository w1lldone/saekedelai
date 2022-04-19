<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHarverstingDataToPlantingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantings', function (Blueprint $table) {
            $table->integer('yield')->nullable();
            $table->integer('value')->nullable();
            $table->integer('harvest_quantity')->nullable();
            $table->integer('released_quantity')->nullable();
            $table->integer('unreleased_quantity')->nullable();
            $table->json('harvest_costs')->nullable();
            $table->bigInteger('total_harvest_cost')->nullable();
            $table->string('lot_code')->nullable();
            $table->string('batch_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plantings', function (Blueprint $table) {
            //
        });
    }
}
