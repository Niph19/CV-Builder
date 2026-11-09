<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationStatusLog extends Model
{
    public $timestamps = false; // tabel pakai changed_at, bukan created_at/updated_at

    protected $fillable = [
        'application_id', 'old_status', 'new_status',
        'changed_by', 'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(job_applications::class, 'application_id');
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}