<?php

namespace App\Contracts\Services;

use App\Models\Journal;
use App\Models\LeaveRequest;
use App\Models\PicketReport;

interface StudentServiceInterface
{
    public function getStudentDashboardData(int $userId): array;

    public function getStudentJournalData(int $userId): array;

    public function storeJournal(int $userId, array $data): Journal;

    public function updateJournal(Journal $journal, array $data): Journal;

    public function getStudentAttendanceData(int $userId): array;

    public function clockIn(int $userId): void;

    public function clockOut(int $userId): void;

    public function requestLeave(int $userId, array $data): LeaveRequest;

    public function getPicketSchedules(): array;

    public function getStudentPicketReports(int $userId): array;

    public function storePicketReport(int $userId, array $data): PicketReport;
}
