<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->char('kode_matakuliah', 8);
            $table->char('nidn', 10);
            $table->string('kelas', 10);
            $table->string('hari', 10);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            $table->foreign('kode_matakuliah')
                ->references('kode_matakuliah')
                ->on('mata_kuliahs')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('nidn')
                ->references('nidn')
                ->on('dosens')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
