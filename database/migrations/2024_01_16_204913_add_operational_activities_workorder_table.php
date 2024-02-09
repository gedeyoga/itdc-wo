<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOperationalActivitiesWorkorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        if($driver != 'sqlite') {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->enum('operational_activities', ['normal', 'daily', 'monthly', 'yearly'])->default('normal');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        if ($driver != 'sqlite') {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->dropColumn('operational_activities');
            });
        }
    }
}
