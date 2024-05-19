<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFillHistoryPompaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->boolean('fill_history_pompa')->default(false);
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('fill_history_pompa')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('fill_history_pompa');
        });
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('fill_history_pompa');
        });
    }
}
