<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Planting::class)->index();
            $table->string('category')->index();
            $table->decimal('water_content', 4)->nullable();
            $table->decimal('dirts', 4)->nullable();
            $table->decimal('discolors', 4)->nullable();
            $table->decimal('splits', 4)->nullable();
            $table->decimal('fungal', 4)->nullable();
            $table->decimal('damaged', 4)->nullable();
            $table->decimal('bugs', 4)->nullable();
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
        Schema::dropIfExists('qualities');
    }
}
