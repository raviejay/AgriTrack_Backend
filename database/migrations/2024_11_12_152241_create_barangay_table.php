<?php

// database/migrations/xxxx_xx_xx_create_barangay_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangayTable extends Migration
{
    public function up()
    {
        Schema::create('barangay', function (Blueprint $table) {
            $table->id('barangay_id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangay');
    }
}
