<?php

namespace App\Contracts\Repositories;

use App\Models\Attendance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AttendanceRepositoryInterface
{
    public function getTodayAttendance(int $userId, string $todayDate): ?Attendance;

    public function createOrUpdateAttendance(array $conditions, array $data): Attendance;

    public function getStudentAttendances(int $userId, int $perPage = 15): LengthAwarePaginator;

    public function getFilteredAttendances(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function countUserAttendances(int $userId): int;

    public function countUserAttendancesByStatus(int $userId, string $status): int;

    public function countUserLeaveAttendances(int $userId): int;

    public function countTodayAttendancesByStatus(string $todayDate, string $status): int;

    public function countTodayLeaveAttendances(string $todayDate): int;
}
