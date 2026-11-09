<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertAlumniProfileRequest;
use App\Http\Resources\AlumniProfileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlumniProfileController extends Controller
{
    public function show(Request $request): AlumniProfileResource|JsonResponse
    {
        $profile = $request->user()->alumniProfile;

        return $profile === null
            ? response()->json(['data' => null])
            : AlumniProfileResource::make($profile);
    }

    public function update(UpsertAlumniProfileRequest $request): AlumniProfileResource
    {
        $profile = $request->user()
            ->alumniProfile()
            ->updateOrCreate([], $request->validated());

        return AlumniProfileResource::make($profile);
    }
}
