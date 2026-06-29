<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals';

    protected $fillable = [
        'kode_matakuliah',
        'nidn',
        'kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }
}
