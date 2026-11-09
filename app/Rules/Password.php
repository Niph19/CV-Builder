<?php

namespace App\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as BasePassword;

class Password
{
    public static function strong(): BasePassword
    {
        return BasePassword::min(12)
            ->mixedCase()
            ->numbers()
            ->symbols()
            ->uncompromised()
            ->when(fn () => ! Auth::guest());
    }
}
