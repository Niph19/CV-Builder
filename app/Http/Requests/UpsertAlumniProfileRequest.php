<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertAlumniProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jurusan' => ['required', 'string', 'max:100'],
            'tahun_lulus' => ['required', 'integer', 'min:1900', 'max:'.now()->year],
            'status_saat_ini' => ['required', 'in:bekerja,kuliah,wirausaha,mencari_kerja,lainnya'],
            'nama_instansi' => ['nullable', 'string', 'max:150'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
        ];
    }
}
