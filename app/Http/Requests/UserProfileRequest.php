<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null && ! $this->user()->isAdmin();
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $currentYear = (int) date('Y');
        $yearRules = $this->user()->isAlumni()
            ? ['required', 'integer', 'min:1990', 'max:'.$currentYear]
            : ['nullable', 'integer', 'min:'.$currentYear, 'max:'.$currentYear + 5];

        return [
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'address' => ['nullable', 'string', 'max:500'],
            'school_major' => ['required', 'string', 'max:100'],
            'graduation_year' => $yearRules,
            'education' => ['nullable', 'string', 'max:3000'],
            'experience' => ['nullable', 'string', 'max:3000'],
            'skills' => ['required', 'string', 'max:2000'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
