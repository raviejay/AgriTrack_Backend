<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBarangayIdToFarmersTable extends Migration
{
    public function up()
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id')->after('contact');
            $table->foreign('barangay_id')->references('barangay_id')->on('barangay')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('farmers', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn('barangay_id');
        });
    }
}
