<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeColumnHistoryPompasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_pompas', function (Blueprint $table) {
            $table->dropColumn('date');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `before` DOUBLE DEFAULT 0');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `after` DOUBLE DEFAULT 0');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `selisih` DOUBLE DEFAULT 0');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `capacity` DOUBLE DEFAULT 0');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_pompas', function (Blueprint $table) {
            $table->date('date');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `before` DOUBLE DEFAULT NULL');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `after` DOUBLE DEFAULT NULL');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `selisih` DOUBLE DEFAULT NULL');
            DB::statement('ALTER TABLE `history_pompas` MODIFY `capacity` DOUBLE DEFAULT NULL');
        });
    }
}
