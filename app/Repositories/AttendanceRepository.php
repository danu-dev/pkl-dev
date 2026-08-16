<?php

namespace App\Repositories;

use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Models\Attendance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function getTodayAttendance(int $userId, string $todayDate): ?Attendance
    {
        return Attendance::where('user_id', $userId)->where('date', $todayDate)->first();
    }

    public function createOrUpdateAttendance(array $conditions, array $data): Attendance
    {
        return Attendance::updateOrCreate($conditions, $data);
    }

    public function getStudentAttendances(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Attendance::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate($perPage);
    }

    public function getFilteredAttendances(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Attendance::with(['user.profile']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['date'])) {
            $query->where('date', $filters['date']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('date', 'desc')->paginate($perPage)->withQueryString();
    }

    public function countUserAttendances(int $userId): int
    {
        return Attendance::where('user_id', $userId)->count();
    }

    public function countUserAttendancesByStatus(int $userId, string $status): int
    {
        return Attendance::where('user_id', $userId)->where('status', $status)->count();
    }

    public function countUserLeaveAttendances(int $userId): int
    {
        return Attendance::where('user_id', $userId)->whereIn('status', ['izin', 'sakit'])->count();
    }

    public function countTodayAttendancesByStatus(string $todayDate, string $status): int
    {
        return Attendance::where('date', $todayDate)->where('status', $status)->count();
    }

    public function countTodayLeaveAttendances(string $todayDate): int
    {
        return Attendance::where('date', $todayDate)->whereIn('status', ['izin', 'sakit'])->count();
    }
}
