<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSplitResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('split_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('split_id');
            $table->unsignedInteger('result_id');
            $table->integer('total_time')->nullable();
            $table->integer('split_time')->nullable();
            $table->integer('split_distance')->nullable();
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
        Schema::dropIfExists('split_results');
    }
}
