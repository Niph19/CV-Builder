<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'nama_lengkap',
    'jurusan',
    'tahun_lulus',
    'status_saat_ini',
    'nama_instansi',
    'jabatan',
    'no_hp',
    'alamat',
])]
class AlumniProfile extends Model
{
    protected function casts(): array
    {
        return [
            'tahun_lulus' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
