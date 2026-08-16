<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\RegisterStudentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StudentRegisterRequest;
use App\Http\Resources\MajorResource;
use App\Http\Resources\PklBatchResource;
use App\Http\Resources\SchoolResource;
use App\Models\Major;
use App\Models\PklBatch;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PklRegisterController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function create(): Response
    {
        return Inertia::render('auth/Register', [
            'schools' => SchoolResource::collection(School::all()),
            'majors' => MajorResource::collection(Major::all()),
            'batches' => PklBatchResource::collection(PklBatch::where('is_active', true)->get()),
        ]);
    }

    public function store(StudentRegisterRequest $request): RedirectResponse
    {
        $dto = RegisterStudentDTO::fromRequest(
            $request->validated(),
            $request->file('cv_file')
        );

        $this->authService->registerStudent($dto);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda berstatus pending dan sedang menunggu verifikasi/approval dari Admin.');
    }
}
