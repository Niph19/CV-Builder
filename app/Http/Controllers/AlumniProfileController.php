<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertAlumniProfileRequest;
use App\Http\Resources\AlumniProfileResource;
use App\Models\AlumniProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniProfileController extends Controller
{
    public function show(Request $request): View|AlumniProfileResource|JsonResponse
    {
        $profile = $request->user()->alumniProfile;

        if (! $request->expectsJson()) {
            return view('alumni.profile.edit', [
                'profile' => $profile ?? new AlumniProfile,
            ]);
        }

        return $profile === null
            ? response()->json(['data' => null])
            : AlumniProfileResource::make($profile);
    }

    public function update(UpsertAlumniProfileRequest $request): AlumniProfileResource|JsonResponse|RedirectResponse
    {
        $profile = $request->user()
            ->alumniProfile()
            ->updateOrCreate([], $request->validated());

        if (! $request->expectsJson()) {
            return back()->with('status', 'alumni-profile-updated');
        }

        return AlumniProfileResource::make($profile)
            ->response()
            ->setStatusCode($profile->wasRecentlyCreated ? 201 : 200);
    }
}
