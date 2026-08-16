<?php

namespace App\Contracts\Repositories;

use App\Models\LeaveRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface LeaveRequestRepositoryInterface
{
    public function findById(int $id): ?LeaveRequest;

    public function createLeaveRequest(array $data): LeaveRequest;

    public function updateLeaveStatus(LeaveRequest $leaveRequest, string $status, ?string $adminNote = null): void;

    public function getUserLeaveRequests(int $userId): Collection;

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    public function countPendingLeaves(): int;
}
