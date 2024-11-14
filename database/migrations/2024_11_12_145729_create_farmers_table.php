<?php

// database/migrations/xxxx_xx_xx_create_farmers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmersTable extends Migration
{
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id('farmer_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('contact');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('farmers');
    }
}
