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
        Schema::create('detail_cutis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_cuti');
            $table->integer('id_staff');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('durasi');
            $table->string('alasan')->nullable();
            $table->string('alasan_lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_cutis');
    }
};
