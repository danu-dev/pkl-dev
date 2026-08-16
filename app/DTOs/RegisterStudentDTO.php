<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class RegisterStudentDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly string $schoolName,
        public readonly string $majorName,
        public readonly ?string $nisnNim,
        public readonly string $phoneNumber,
        public readonly ?UploadedFile $cvFile = null
    ) {}

    public static function fromRequest(array $data, ?UploadedFile $cvFile = null): self
    {
        return new self(
            name: $data['name'],
            username: strtolower($data['username']),
            email: strtolower($data['email']),
            password: $data['password'],
            schoolName: $data['school_name'],
            majorName: $data['major_name'],
            nisnNim: $data['nisn_nim'] ?? null,
            phoneNumber: $data['phone_number'],
            cvFile: $cvFile
        );
    }
}
