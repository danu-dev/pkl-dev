<?php

namespace App\Contracts\Services;

use App\DTOs\LoginDTO;
use App\DTOs\RegisterStudentDTO;
use App\Models\User;

interface AuthServiceInterface
{
    public function registerStudent(RegisterStudentDTO $dto): User;

    public function attemptLogin(LoginDTO $dto): bool;

    public function logout(): void;
}
