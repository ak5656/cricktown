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
        Schema::create('fatchs', function (Blueprint $table) {
            $table->id();
            $table->string('match_id', 250)->nullable();
            $table->string('api_name', 250)->nullable();
            $table->string('called', 250)->nullable();
            $table->string('json', 250)->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fatchs');
    }
};
