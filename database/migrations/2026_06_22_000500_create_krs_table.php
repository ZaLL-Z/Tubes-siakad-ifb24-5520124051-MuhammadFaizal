<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->char('npm', 10);
            $table->char('kode_matakuliah', 8);
            $table->timestamps();

            $table->foreign('npm')
                ->references('npm')
                ->on('mahasiswas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('kode_matakuliah')
                ->references('kode_matakuliah')
                ->on('mata_kuliahs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique(['npm', 'kode_matakuliah']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
