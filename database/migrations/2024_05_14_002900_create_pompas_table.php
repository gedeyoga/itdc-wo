<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePompasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pompas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('merk');
            $table->year('year');
            $table->string('type');
            $table->double('power_kwh');
            $table->double('capacity');
            $table->enum('status' , ['active' , 'not_active'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pompas');
    }
}
