<?php

namespace App\Services;

use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Contracts\Repositories\JournalRepositoryInterface;
use App\Contracts\Repositories\LeaveRequestRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AdminDashboardServiceInterface;

class AdminDashboardService implements AdminDashboardServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected JournalRepositoryInterface $journalRepository,
        protected AttendanceRepositoryInterface $attendanceRepository,
        protected LeaveRequestRepositoryInterface $leaveRequestRepository
    ) {}

    public function getDashboardOverview(): array
    {
        $today = now()->format('Y-m-d');

        $stats = [
            'total_students' => $this->userRepository->countApprovedStudents(),
            'pending_approvals' => $this->userRepository->countPendingStudents(),
            'today_journals' => $this->journalRepository->countJournalsByDate($today),
            'today_attendances' => $this->attendanceRepository->countTodayAttendancesByStatus($today, 'hadir'),
            'pending_leaves' => $this->leaveRequestRepository->countPendingLeaves(),
        ];

        $pendingUsers = $this->userRepository->getRecentPendingStudents(5);
        $recentJournals = $this->journalRepository->getRecentJournals(5);

        return [
            'stats' => $stats,
            'pendingUsers' => $pendingUsers,
            'recentJournals' => $recentJournals,
        ];
    }
}
