<?php

// database/migrations/xxxx_xx_xx_create_farmer_data_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmerDataTable extends Migration
{
    public function up()
    {
        Schema::create('farmer_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers','farmer_id')->onDelete('cascade');
            $table->foreignId('kind_id')->constrained('kind_of_animals', 'Kind_ID')->onDelete('cascade');
            $table->year('year');
            $table->integer('backyard_count')->default(0);
            $table->integer('commercial_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('farmer_data');
    }
}

