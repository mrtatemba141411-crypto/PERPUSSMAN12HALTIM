<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = ['nomor_anggota', 'nama', 'jenis_kelamin', 'alamat', 'no_hp', 'email'];

    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
