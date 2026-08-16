<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;

    public function getPendingStudents(int $perPage = 10): LengthAwarePaginator;

    public function getStudentsFiltered(array $filters, int $perPage = 10): LengthAwarePaginator;

    public function updateStatus(User $user, string $status, bool $isApproved): void;

    public function updateUser(User $user, array $userData, array $profileData): void;

    public function deleteUser(User $user): void;

    public function countApprovedStudents(): int;

    public function countPendingStudents(): int;

    public function getRecentPendingStudents(int $limit = 5): Collection;
}
