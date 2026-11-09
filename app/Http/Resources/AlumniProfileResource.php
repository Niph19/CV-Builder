<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumniProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_lengkap' => $this->nama_lengkap,
            'jurusan' => $this->jurusan,
            'tahun_lulus' => $this->tahun_lulus,
            'status_saat_ini' => $this->status_saat_ini,
            'nama_instansi' => $this->nama_instansi,
            'jabatan' => $this->jabatan,
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
