<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Periods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Periods', function(Blueprint $table) {
        $table->id();
        $table->string('name', 100);

        $table->unsignedBigInteger('teacher_id')->index()->nullable();
        $table->foreign('teacher_id')
          ->references('id')
          ->on('Teachers')
          ->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Periods');
    }
}
