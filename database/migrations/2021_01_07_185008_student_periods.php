<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentPeriods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('StudentPeriods', function(Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('student_id')->index()->nullable();
        $table->foreign('student_id')
          ->references('id')
          ->on('Students')
          ->onDelete('cascade');

        $table->unsignedBigInteger('period_id')->index()->nullable();
        $table->foreign('period_id')
          ->references('id')
          ->on('Periods')
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
        Schema::dropIfExists('StudentPeriods');
    }
}
