<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnfarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onfarms', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp');
            $table->foreignId('planting_id')->index();
            $table->string('activity')->nullable();
            $table->string('category')->nullable();
            $table->integer('cost')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('onfarms');
    }
}
