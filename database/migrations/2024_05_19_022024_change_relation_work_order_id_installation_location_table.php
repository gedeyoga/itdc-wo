<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRelationWorkOrderIdInstallationLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_pompas', function (Blueprint $table) {
            $table->renameColumn('work_order_id', 'work_order_attachment_id')->change();

            $table->foreign('work_order_attachment_id')->references('id')->on('work_order_attachments')->onDelete('cascade');
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
            $table->renameColumn('work_order_attachment_id', 'work_order_id');

            $table->dropForeign('history_pompas_work_order_attachment_id_foreign');
        });
    }
}
