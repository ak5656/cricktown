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
        Schema::create('callapis', function (Blueprint $table) {
            $table->id();
            $table->integer('match_id');
            $table->string('api_name');
            $table->string('called');
            $table->text('json'); // Consider changing this to 'text' type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callapis');
    }
};
