<?php

namespace App\Repositories;

use App\Contracts\Repositories\LeaveRequestRepositoryInterface;
use App\Models\LeaveRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class LeaveRequestRepository implements LeaveRequestRepositoryInterface
{
    public function findById(int $id): ?LeaveRequest
    {
        return LeaveRequest::find($id);
    }

    public function createLeaveRequest(array $data): LeaveRequest
    {
        return LeaveRequest::create($data);
    }

    public function updateLeaveStatus(LeaveRequest $leaveRequest, string $status, ?string $adminNote = null): void
    {
        $leaveRequest->update([
            'status' => $status,
            'admin_note' => $adminNote,
        ]);
    }

    public function getUserLeaveRequests(int $userId): Collection
    {
        return LeaveRequest::where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return LeaveRequest::with(['user.profile'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function countPendingLeaves(): int
    {
        return LeaveRequest::where('status', 'pending')->count();
    }
}
