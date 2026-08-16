<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\LoginDTO;
use App\DTOs\RegisterStudentDTO;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    public function registerStudent(RegisterStudentDTO $dto): User
    {
        $cvPath = null;
        if ($dto->cvFile) {
            $cvPath = $this->fileUploadService->uploadCv($dto->cvFile);
        }

        $user = User::create([
            'name' => $dto->name,
            'username' => $dto->username,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'role' => 'siswa_pkl',
            'status' => 'pending',
            'is_approved' => false,
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'nisn_nim' => $dto->nisnNim,
            'phone_number' => $dto->phoneNumber,
            'cv_path' => $cvPath,
            'session_type' => 'full_day',
            'school_name' => $dto->schoolName,
            'major_name' => $dto->majorName,
        ]);

        return $user;
    }

    public function attemptLogin(LoginDTO $dto): bool
    {
        $field = filter_var($dto->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => strtolower($dto->login), 'password' => $dto->password], $dto->remember)) {
            request()->session()->regenerate();

            return true;
        }

        throw ValidationException::withMessages([
            'login' => 'Email/Username atau password yang Anda masukkan salah.',
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
