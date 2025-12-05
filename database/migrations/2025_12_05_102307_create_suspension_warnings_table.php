<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suspension_warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('peminjaman_id');
            $table->timestamps();
            
            // Foreign key ke tabel peminjamans
            $table->foreign('peminjaman_id')
                ->references('id')
                ->on('peminjamans')  // ← Ini yang benar sesuai table nama
                ->onDelete('cascade');
            
            $table->unique(['user_id', 'peminjaman_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('suspension_warnings');
    }
};
