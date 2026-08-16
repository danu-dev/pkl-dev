<?php

namespace App\Services;

use App\Contracts\Services\StudentServiceInterface;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Journal;
use App\Models\LeaveRequest;
use App\Models\PicketReport;
use App\Models\PicketSchedule;
use App\Models\Setting;
use Illuminate\Validation\ValidationException;

class StudentService implements StudentServiceInterface
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    public function getStudentDashboardData(int $userId): array
    {
        $today = now()->format('Y-m-d');

        $journalStats = [
            'total' => Journal::where('user_id', $userId)->count(),
            'approved' => Journal::where('user_id', $userId)->where('status', 'approved')->count(),
            'submitted' => Journal::where('user_id', $userId)->where('status', 'submitted')->count(),
            'today_submitted' => Journal::where('user_id', $userId)->where('date', $today)->exists(),
        ];

        $attendanceStats = [
            'total' => Attendance::where('user_id', $userId)->count(),
            'hadir' => Attendance::where('user_id', $userId)->where('status', 'hadir')->count(),
            'izin_sakit' => Attendance::where('user_id', $userId)->whereIn('status', ['izin', 'sakit'])->count(),
            'alpha' => Attendance::where('user_id', $userId)->where('status', 'alpha')->count(),
            'today_attendance' => Attendance::where('user_id', $userId)->where('date', $today)->first(),
        ];

        $announcements = Announcement::where('target_role', 'all')
            ->orWhere('target_role', 'siswa_pkl')
            ->latest()
            ->take(5)
            ->get();

        return [
            'journalStats' => $journalStats,
            'attendanceStats' => $attendanceStats,
            'announcements' => $announcements,
        ];
    }

    public function getStudentJournalData(int $userId): array
    {
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');

        $startTime = Setting::get('journal_start_time', '04:00');
        $endTime = Setting::get('journal_end_time', '23:59');

        $canSubmit = ($currentTime >= $startTime && $currentTime <= $endTime);

        $journals = Journal::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return [
            'journals' => $journals,
            'canSubmit' => $canSubmit,
            'operatingHours' => [
                'start' => $startTime,
                'end' => $endTime,
            ],
            'today' => $today,
        ];
    }

    public function storeJournal(int $userId, array $data): Journal
    {
        $currentTime = now()->format('H:i');
        $startTime = Setting::get('journal_start_time', '04:00');
        $endTime = Setting::get('journal_end_time', '23:59');

        if ($currentTime < $startTime || $currentTime > $endTime) {
            throw ValidationException::withMessages([
                'journal' => "Pengisian jurnal hanya diperbolehkan pada jam {$startTime} hingga {$endTime}.",
            ]);
        }

        $proofPath = null;
        if (isset($data['proof_file']) && $data['proof_file']) {
            $proofPath = $this->fileUploadService->uploadImage($data['proof_file'], 'journal_proofs');
        }

        return Journal::create([
            'user_id' => $userId,
            'date' => now()->format('Y-m-d'),
            'title' => $data['title'],
            'description' => $data['description'],
            'proof_file' => $proofPath,
            'status' => 'submitted',
        ]);
    }

    public function updateJournal(Journal $journal, array $data): Journal
    {
        $currentTime = now()->format('H:i');
        $startTime = Setting::get('journal_start_time', '04:00');
        $endTime = Setting::get('journal_end_time', '23:59');

        if ($currentTime < $startTime || $currentTime > $endTime) {
            throw ValidationException::withMessages([
                'journal' => "Perubahan jurnal hanya diperbolehkan pada jam {$startTime} hingga {$endTime}.",
            ]);
        }

        if (isset($data['proof_file']) && $data['proof_file']) {
            $journal->proof_file = $this->fileUploadService->uploadImage($data['proof_file'], 'journal_proofs');
        }

        $journal->title = $data['title'];
        $journal->description = $data['description'];
        $journal->status = 'submitted';
        $journal->save();

        return $journal;
    }

    public function getStudentAttendanceData(int $userId): array
    {
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');

        $inStart = Setting::get('attendance_in_start', '06:00');
        $inEnd = Setting::get('attendance_in_end', '09:00');
        $outStart = Setting::get('attendance_out_start', '15:00');
        $outEnd = Setting::get('attendance_out_end', '18:00');

        $canClockIn = ($currentTime >= $inStart && $currentTime <= $inEnd);
        $canClockOut = ($currentTime >= $outStart && $currentTime <= $outEnd);

        $todayAttendance = Attendance::where('user_id', $userId)
            ->where('date', $today)
            ->first();

        $stats = [
            'total' => Attendance::where('user_id', $userId)->count(),
            'hadir' => Attendance::where('user_id', $userId)->where('status', 'hadir')->count(),
            'izin_sakit' => Attendance::where('user_id', $userId)->whereIn('status', ['izin', 'sakit'])->count(),
            'alpha' => Attendance::where('user_id', $userId)->where('status', 'alpha')->count(),
        ];

        $attendances = Attendance::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(15);

        $leaveRequests = LeaveRequest::where('user_id', $userId)
            ->latest()
            ->get();

        return [
            'stats' => $stats,
            'todayAttendance' => $todayAttendance,
            'canClockIn' => $canClockIn,
            'canClockOut' => $canClockOut,
            'operatingHours' => [
                'inStart' => $inStart,
                'inEnd' => $inEnd,
                'outStart' => $outStart,
                'outEnd' => $outEnd,
            ],
            'attendances' => $attendances,
            'leaveRequests' => $leaveRequests,
        ];
    }

    public function clockIn(int $userId): void
    {
        $today = now()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $inStart = Setting::get('attendance_in_start', '06:00');
        $inEnd = Setting::get('attendance_in_end', '09:00');
        $currentTime = now()->format('H:i');

        if ($currentTime < $inStart || $currentTime > $inEnd) {
            throw ValidationException::withMessages([
                'attendance' => "Waktu absen masuk hanya diperbolehkan pada jam {$inStart} - {$inEnd}.",
            ]);
        }

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if ($attendance && $attendance->time_in) {
            throw ValidationException::withMessages([
                'attendance' => 'Anda sudah melakukan absen masuk hari ini.',
            ]);
        }

        Attendance::updateOrCreate(
            ['user_id' => $userId, 'date' => $today],
            [
                'status' => 'hadir',
                'time_in' => $nowTime,
            ]
        );
    }

    public function clockOut(int $userId): void
    {
        $today = now()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $outStart = Setting::get('attendance_out_start', '15:00');
        $outEnd = Setting::get('attendance_out_end', '18:00');
        $currentTime = now()->format('H:i');

        if ($currentTime < $outStart || $currentTime > $outEnd) {
            throw ValidationException::withMessages([
                'attendance' => "Waktu absen pulang hanya diperbolehkan pada jam {$outStart} - {$outEnd}.",
            ]);
        }

        $attendance = Attendance::where('user_id', $userId)->where('date', $today)->first();

        if (! $attendance || ! $attendance->time_in) {
            throw ValidationException::withMessages([
                'attendance' => 'Anda belum melakukan absen masuk hari ini.',
            ]);
        }

        $attendance->time_out = $nowTime;
        $attendance->save();
    }

    public function requestLeave(int $userId, array $data): LeaveRequest
    {
        $attachmentPath = null;
        if (isset($data['attachment']) && $data['attachment']) {
            $attachmentPath = $this->fileUploadService->uploadImage($data['attachment'], 'leave_attachments');
        }

        return LeaveRequest::create([
            'user_id' => $userId,
            'type' => $data['type'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);
    }

    public function getPicketSchedules(): array
    {
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
        $schedules = [];

        foreach ($days as $day) {
            $schedules[$day] = [
                'pagi' => PicketSchedule::with('user:id,name,username')
                    ->where('day', $day)
                    ->where('shift', 'pagi')
                    ->get()
                    ->pluck('user.name')
                    ->toArray(),
                'sore' => PicketSchedule::with('user:id,name,username')
                    ->where('day', $day)
                    ->where('shift', 'sore')
                    ->get()
                    ->pluck('user.name')
                    ->toArray(),
            ];
        }

        return $schedules;
    }

    public function getStudentPicketReports(int $userId): array
    {
        $myReports = PicketReport::where('user_id', $userId)
            ->latest()
            ->paginate(10);

        return [
            'myReports' => $myReports,
            'todayDate' => now()->translatedFormat('l, d F Y'),
        ];
    }

    public function storePicketReport(int $userId, array $data): PicketReport
    {
        $proofPath = $this->fileUploadService->uploadImage($data['proof_file'], 'picket_proofs');

        return PicketReport::create([
            'user_id' => $userId,
            'date' => now()->format('Y-m-d'),
            'proof_file' => $proofPath,
            'notes' => $data['notes'] ?? null,
            'status' => 'submitted',
        ]);
    }
}
