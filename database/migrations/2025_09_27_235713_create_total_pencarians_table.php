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
        Schema::create('total_pencarian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('situs_sejarah_id')->constrained('situs_sejarah')->onDelete('cascade');
            $table->integer('jlh_pencarian')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_pencarian');
    }
};
