<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlantingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_id')->index();
            $table->timestamp('started_at')->nullable();
            $table->string('seed_variety')->nullable();
            $table->integer('seed_quantity')->nullable();
            $table->timestamp('harvested_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantings');
    }
}
