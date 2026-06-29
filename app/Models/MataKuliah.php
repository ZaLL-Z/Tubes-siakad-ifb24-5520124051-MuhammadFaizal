<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliahs';
    protected $primaryKey = 'kode_matakuliah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
    ];

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class, 'kode_matakuliah', 'kode_matakuliah');
    }
}
