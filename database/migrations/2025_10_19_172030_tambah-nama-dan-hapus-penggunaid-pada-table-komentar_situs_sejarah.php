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
        Schema::table('komentar_situs_sejarah', function (Blueprint $table) {
            $table->dropForeign(['pengguna_id']);
            $table->dropColumn('pengguna_id');
            $table->string('nama', 50)->after('situs_sejarah_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komentar_situs_sejarah', function (Blueprint $table) {
            $table->unsignedBigInteger('pengguna_id')->after('situs_sejarah_id');
            $table->foreign('pengguna_id')->references('id')->on('users')->onDelete('cascade');
            $table->dropColumn('nama');
        });
    }
};
