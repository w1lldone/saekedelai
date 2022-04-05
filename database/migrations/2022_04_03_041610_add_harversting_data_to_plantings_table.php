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
            $table->integer('water_content')->nullable();
            $table->integer('value')->nullable();
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
