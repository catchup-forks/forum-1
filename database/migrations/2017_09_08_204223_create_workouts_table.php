<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('tempo'); // In seconds
            $table->integer('distance'); // In meters?
            $table->float('latitude', 10, 6);
            $table->float('longitude', 10, 6);
            $table->dateTime('starting');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('workout_user', function (Blueprint $table) {
            $table->integer('workout_id');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workouts');
        Schema::dropIfExists('workout_user');
    }
}
