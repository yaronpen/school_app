<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Students extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Students', function(Blueprint $table) {
        $table->id();
        $table->string('fullname', 100);
        $table->unsignedTinyInteger('grade');

        $table->unsignedBigInteger('user_id')->index()->nullable();
        $table->foreign('user_id')
          ->references('id')
          ->on('users')
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
      Schema::dropIfExists('Students');
    }
}
