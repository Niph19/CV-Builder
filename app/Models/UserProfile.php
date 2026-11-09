<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'phone',
    'address',
    'school_major',
    'graduation_year',
    'education',
    'experience',
    'skills',
    'portfolio_url',
    'linkedin_url',
])]
class UserProfile extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
