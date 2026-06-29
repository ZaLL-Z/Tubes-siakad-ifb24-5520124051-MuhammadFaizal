<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nidn',
        'nama',
    ];

    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'nidn', 'nidn');
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'nidn', 'nidn');
    }
}
