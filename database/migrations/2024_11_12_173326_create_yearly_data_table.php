<?php

// database/migrations/xxxx_xx_xx_create_yearly_data_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearlyDataTable extends Migration
{
    public function up()
    {
        Schema::create('yearly_data', function (Blueprint $table) {
            $table->id('id');
            $table->year('year');
            $table->foreignId('kind_id')->constrained('kind_of_animals', 'Kind_ID')->onDelete('cascade');
            $table->foreignId('barangay_id')->constrained('barangay', 'barangay_id')->onDelete('cascade');
            $table->integer('backyard_count')->default(0);
            $table->integer('commercial_count')->default(0);
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('yearly_data');
    }
}

