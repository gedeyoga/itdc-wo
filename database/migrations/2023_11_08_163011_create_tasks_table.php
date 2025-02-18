<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
            
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->unsignedBigInteger('task_category_id');
            $table->unsignedBigInteger('priority_id');

            if($driver == 'sqlite') {
                $table->unsignedBigInteger('location_id');
            }

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('task_category_id')->references('id')->on('task_categories');
            $table->foreign('priority_id')->references('id')->on('priorities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
