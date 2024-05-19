<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPompasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_pompas', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('location_installation_id');
            $table->unsignedBigInteger('work_order_id');
            $table->double('before');
            $table->double('after');
            $table->double('selisih');
            $table->double('capacity');
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
        Schema::dropIfExists('history_pompas');
    }
}
