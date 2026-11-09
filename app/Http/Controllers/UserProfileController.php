<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.data', [
            'profile' => $request->user()->profile ?? $request->user()->profile()->make(),
        ]);
    }

    public function update(UserProfileRequest $request): RedirectResponse
    {
        $request->user()->profile()->updateOrCreate([], $request->validated());

        return back()->with('status', 'profile-data-updated');
    }
}
