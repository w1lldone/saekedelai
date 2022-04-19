<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Planting::class)->index();
            $table->string('bag_number')->nullable();
            $table->integer('water_content')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('scheme')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->integer('impurities')->nullable();
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
        Schema::dropIfExists('sortations');
    }
}
