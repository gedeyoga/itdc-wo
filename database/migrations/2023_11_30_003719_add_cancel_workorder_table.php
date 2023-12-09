<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelWorkorderTable extends Migration
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
            DB::statement("ALTER TABLE work_orders MODIFY `status` ENUM('pending','progress','finish','cancel') DEFAULT 'pending'");
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
            DB::statement("ALTER TABLE work_orders MODIFY `status` ENUM('pending','progress','finish') DEFAULT 'pending'");
        }
    }
}
