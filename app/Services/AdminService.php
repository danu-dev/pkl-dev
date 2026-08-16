<?php

namespace App\Services;

use App\Contracts\Services\AdminServiceInterface;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Division;
use App\Models\Journal;
use App\Models\LeaveRequest;
use App\Models\Major;
use App\Models\PicketReport;
use App\Models\PicketSchedule;
use App\Models\PklBatch;
use App\Models\School;
use App\Models\Setting;
use App\Models\StudentGrade;
use App\Models\Supervisor;
use App\Models\User;

class AdminService implements AdminServiceInterface
{
    public function getPendingStudents(): object
    {
        return User::with(['profile.school', 'profile.major', 'profile.pklBatch'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
    }

    public function approveStudent(User $user): void
    {
        $user->update([
            'status' => 'approved',
            'is_approved' => true,
        ]);
    }

    public function rejectStudent(User $user): void
    {
        $user->update([
            'status' => 'rejected',
            'is_approved' => false,
        ]);
    }

    public function getStudentsData(array $filters): array
    {
        $query = User::with(['profile.school', 'profile.major', 'profile.pklBatch'])
            ->where('role', 'siswa_pkl');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return [
            'students' => $students,
            'filters' => [
                'search' => $filters['search'] ?? '',
                'status' => $filters['status'] ?? '',
            ],
            'schools' => School::all(),
            'majors' => Major::all(),
            'divisions' => Division::all(),
            'batches' => PklBatch::all(),
            'supervisors' => Supervisor::all(),
        ];
    }

    public function updateStudent(User $user, array $data): void
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'],
            'is_approved' => $data['status'] === 'approved',
        ]);

        if ($user->profile) {
            $division = ! empty($data['division_id']) ? Division::find($data['division_id']) : null;
            $user->profile->update([
                'session_type' => $data['session_type'],
                'division_id' => $data['division_id'] ?? null,
                'division_name' => $division?->name,
            ]);
        }
    }

    public function deleteStudent(User $user): void
    {
        $user->delete();
    }

    public function getJournalRecapData(array $filters): array
    {
        $selectedDate = $filters['date'] ?? now()->format('Y-m-d');
        $search = $filters['search'] ?? null;
        $statusFilter = $filters['status'] ?? null;

        $studentsQuery = User::with(['profile'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'approved');

        if ($search) {
            $studentsQuery->where('name', 'like', "%{$search}%");
        }

        $students = $studentsQuery->get();

        $journalsMap = Journal::where('date', $selectedDate)
            ->get()
            ->keyBy('user_id');

        $recapData = $students->map(function ($student) use ($journalsMap, $selectedDate) {
            $journal = $journalsMap->get($student->id);
            $hasFilled = ! is_null($journal);

            return [
                'id' => $student->id,
                'name' => $student->name,
                'username' => $student->username,
                'school_name' => $student->profile?->school_name ?? '-',
                'major_name' => $student->profile?->major_name ?? '-',
                'date' => $selectedDate,
                'has_filled' => $hasFilled,
                'journal' => $journal ? [
                    'id' => $journal->id,
                    'title' => $journal->title,
                    'description' => $journal->description,
                    'proof_file' => $journal->proof_file,
                    'created_at' => $journal->created_at->format('H:i'),
                ] : null,
            ];
        });

        if ($statusFilter === 'filled') {
            $recapData = $recapData->filter(fn ($item) => $item['has_filled']);
        } elseif ($statusFilter === 'not_filled') {
            $recapData = $recapData->filter(fn ($item) => ! $item['has_filled']);
        }

        return [
            'recapData' => $recapData->values(),
            'filters' => [
                'search' => $search ?? '',
                'date' => $selectedDate,
                'status' => $statusFilter ?? '',
            ],
            'stats' => [
                'total' => $students->count(),
                'filled' => $journalsMap->count(),
                'not_filled' => max(0, $students->count() - $journalsMap->count()),
            ],
        ];
    }

    public function getAttendanceRecapData(array $filters): array
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

        $attendances = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        $today = now()->format('Y-m-d');
        $stats = [
            'total_students' => User::where('role', 'siswa_pkl')->where('status', 'approved')->count(),
            'today_hadir' => Attendance::where('date', $today)->where('status', 'hadir')->count(),
            'today_izin_sakit' => Attendance::where('date', $today)->whereIn('status', ['izin', 'sakit'])->count(),
            'today_alpha' => Attendance::where('date', $today)->where('status', 'alpha')->count(),
        ];

        return [
            'attendances' => $attendances,
            'stats' => $stats,
            'filters' => [
                'search' => $filters['search'] ?? '',
                'date' => $filters['date'] ?? '',
                'status' => $filters['status'] ?? '',
            ],
            'allStudents' => User::where('role', 'siswa_pkl')->where('status', 'approved')->select('id', 'name')->get(),
        ];
    }

    public function storeManualAttendance(array $data): void
    {
        Attendance::updateOrCreate(
            ['user_id' => $data['user_id'], 'date' => $data['date']],
            [
                'status' => $data['status'],
                'time_in' => $data['time_in'] ?? null,
                'time_out' => $data['time_out'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]
        );
    }

    public function getLeaveRequests(): object
    {
        return LeaveRequest::with(['user.profile'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function updateLeaveStatus(int $leaveRequestId, array $data): void
    {
        $leaveRequest = LeaveRequest::findOrFail($leaveRequestId);
        $leaveRequest->update([
            'status' => $data['status'],
            'admin_note' => $data['admin_note'] ?? null,
        ]);
    }

    public function getMasterData(): array
    {
        return [
            'schools' => School::with('majors')->get(),
            'divisions' => Division::all(),
            'batches' => PklBatch::all(),
            'supervisors' => Supervisor::all(),
        ];
    }

    public function storeSchool(array $data): void
    {
        School::create($data);
    }

    public function storeMajor(array $data): void
    {
        Major::create($data);
    }

    public function storeDivision(array $data): void
    {
        Division::create($data);
    }

    public function storeBatch(array $data): void
    {
        PklBatch::create($data);
    }

    public function storeSupervisor(array $data): void
    {
        Supervisor::create($data);
    }

    public function getPicketManagementData(): array
    {
        $students = User::where('role', 'siswa_pkl')->where('status', 'approved')->select('id', 'name')->get();
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        $schedules = [];

        foreach ($days as $day) {
            $schedules[$day] = [
                'pagi' => PicketSchedule::with('user:id,name')
                    ->where('day', $day)
                    ->where('shift', 'pagi')
                    ->get(),
                'sore' => PicketSchedule::with('user:id,name')
                    ->where('day', $day)
                    ->where('shift', 'sore')
                    ->get(),
            ];
        }

        $reports = PicketReport::with('user:id,name')
            ->latest()
            ->paginate(10);

        return [
            'students' => $students,
            'schedules' => $schedules,
            'reports' => $reports,
        ];
    }

    public function storePicketSchedule(array $data): void
    {
        PicketSchedule::updateOrCreate(
            ['user_id' => $data['user_id'], 'day' => $data['day']],
            ['shift' => $data['shift']]
        );
    }

    public function deletePicketSchedule(int $scheduleId): void
    {
        PicketSchedule::destroy($scheduleId);
    }

    public function getGradesData(): object
    {
        return User::with(['profile', 'grade'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'approved')
            ->get();
    }

    public function storeGradeEvaluation(array $data): void
    {
        $finalScore = (
            $data['discipline_score'] * 0.20 +
            $data['technical_score'] * 0.30 +
            $data['journal_score'] * 0.20 +
            $data['attendance_score'] * 0.15 +
            $data['attitude_score'] * 0.15
        );

        $gradeLetter = 'A';
        if ($finalScore < 60) {
            $gradeLetter = 'D';
        } elseif ($finalScore < 75) {
            $gradeLetter = 'C';
        } elseif ($finalScore < 85) {
            $gradeLetter = 'B';
        }

        StudentGrade::updateOrCreate(
            ['user_id' => $data['user_id']],
            [
                'discipline_score' => $data['discipline_score'],
                'technical_score' => $data['technical_score'],
                'journal_score' => $data['journal_score'],
                'attendance_score' => $data['attendance_score'],
                'attitude_score' => $data['attitude_score'],
                'final_score' => $finalScore,
                'grade_letter' => $gradeLetter,
                'notes' => $data['notes'] ?? null,
            ]
        );
    }

    public function getAnnouncementsData(): object
    {
        return Announcement::latest()->paginate(10);
    }

    public function storeAnnouncement(array $data): void
    {
        Announcement::create($data);
    }

    public function deleteAnnouncement(int $id): void
    {
        Announcement::destroy($id);
    }

    public function getOperationalSettings(): array
    {
        return [
            'journal_start_time' => Setting::get('journal_start_time', '04:00'),
            'journal_end_time' => Setting::get('journal_end_time', '23:59'),
            'attendance_in_start' => Setting::get('attendance_in_start', '06:00'),
            'attendance_in_end' => Setting::get('attendance_in_end', '09:00'),
            'attendance_out_start' => Setting::get('attendance_out_start', '15:00'),
            'attendance_out_end' => Setting::get('attendance_out_end', '18:00'),
            'is_holiday_mode' => Setting::get('is_holiday_mode', 'false'),
        ];
    }

    public function updateOperationalSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::set($key, (string) $value);
        }
    }
}
