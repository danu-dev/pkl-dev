<?php

namespace App\DTOs;

class LoginDTO
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
        public readonly bool $remember = false
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            login: $data['login'],
            password: $data['password'],
            remember: (bool) ($data['remember'] ?? false)
        );
    }
}
