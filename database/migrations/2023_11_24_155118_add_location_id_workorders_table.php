<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdWorkordersTable extends Migration
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
                $table->unsignedBigInteger('location_id')->default(null)->after('priority_id');
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

        if($driver != 'sqlite') {
            Schema::table('work_orders', function (Blueprint $table) {
                $table->dropColumn(['location_id']);
            });
        }
    }
}
