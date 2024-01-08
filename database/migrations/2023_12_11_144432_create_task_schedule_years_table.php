<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskScheduleYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_schedule_years', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_schedule_id');
            $table->integer('month');
            $table->integer('date');
            $table->time('hour');
            $table->timestamps();

            $table->foreign('task_schedule_id')->references('id')->on('task_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_schedule_years');
    }
}
