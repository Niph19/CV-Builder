<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class alumni_profiles extends Model
{
    //
    protected $Fillable = [
        'nama_lengkap',
        'jurusan',
        'tahun_lulus',
        'status_saat_ini',
        'nama_instansi',
        'jabatan', 
        'no_hp',
        'alamat',
    ];
        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
