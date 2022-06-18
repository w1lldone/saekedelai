<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductColumnsToPlantingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plantings', function (Blueprint $table) {
            $table->timestamp('production_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->string('harvest_batch')->nullable();
            $table->string('product_batch')->nullable();
            $table->string('product_processor')->nullable();
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
            $table->dropColumn(['production_date', 'expired_date', 'harvest_batch', 'product_batch', 'product_processor']);
        });
    }
}
