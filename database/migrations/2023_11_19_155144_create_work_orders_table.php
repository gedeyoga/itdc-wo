<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description');
            $table->unsignedBigInteger('task_category_id');
            $table->unsignedBigInteger('priority_id');

            if ($driver == 'sqlite') {
                $table->unsignedBigInteger('location_id')->default(null)->after('priority_id');
                $table->enum('status', ['pending', 'progress', 'finish' , 'cancel'])->default('pending');
                $table->enum('operational_activities', ['normal', 'daily', 'monthly', 'yearly'])->default('normal');
            } else {
                $table->enum('status' , ['pending', 'progress', 'finish'])->default('pending');
            }
            
            $table->dateTime('date');
            $table->dateTime('start_at')->nullable();
            $table->unsignedBigInteger('start_by')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->unsignedBigInteger('finish_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            
            

            $table->timestamps();

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
        Schema::dropIfExists('work_orders');
    }
}
