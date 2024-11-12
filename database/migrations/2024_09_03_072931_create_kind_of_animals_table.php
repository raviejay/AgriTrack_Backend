<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kind_of_animals', function (Blueprint $table) {
            $table->id('Kind_ID');
            $table->string('Name');
            $table->foreignId('animal_id')->constrained('animals', 'Animal_ID')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kind_of_animals');
    }
};
