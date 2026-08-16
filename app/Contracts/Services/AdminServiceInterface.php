<?php

namespace App\Contracts\Services;

use App\Models\User;

interface AdminServiceInterface
{
    public function getPendingStudents(): object;

    public function approveStudent(User $user): void;

    public function rejectStudent(User $user): void;

    public function getStudentsData(array $filters): array;

    public function updateStudent(User $user, array $data): void;

    public function deleteStudent(User $user): void;

    public function getJournalRecapData(array $filters): array;

    public function getAttendanceRecapData(array $filters): array;

    public function storeManualAttendance(array $data): void;

    public function getLeaveRequests(): object;

    public function updateLeaveStatus(int $leaveRequestId, array $data): void;

    public function getMasterData(): array;

    public function storeSchool(array $data): void;

    public function storeMajor(array $data): void;

    public function storeDivision(array $data): void;

    public function storeBatch(array $data): void;

    public function storeSupervisor(array $data): void;

    public function getPicketManagementData(): array;

    public function storePicketSchedule(array $data): void;

    public function deletePicketSchedule(int $scheduleId): void;

    public function getGradesData(): object;

    public function storeGradeEvaluation(array $data): void;

    public function getAnnouncementsData(): object;

    public function storeAnnouncement(array $data): void;

    public function deleteAnnouncement(int $id): void;

    public function getOperationalSettings(): array;

    public function updateOperationalSettings(array $data): void;
}
