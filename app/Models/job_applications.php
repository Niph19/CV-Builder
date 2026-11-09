<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class job_applications extends Model
{
    //
        protected $fillable = [
        'user_id', 'vacancy_id', 'company_name', 'position',
        'applied_at', 'status', 'notes', 'cv_id',
    ];

    protected $casts = [
        'applied_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(job_vacancies::class, 'vacancy_id');
    }

    public function statusLogs()
    {
        return $this->hasMany(ApplicationStatusLog::class, 'application_id');
    }
}
