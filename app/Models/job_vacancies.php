<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class job_vacancies extends Model
{
    //
        protected $fillable = [
        'title', 'company_name', 'location', 'job_type',
        'description', 'requirements', 'apply_link',
        'deadline', 'status', 'created_by',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function applications()
    {
        return $this->hasMany(job_applications::class, 'vacancy_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
