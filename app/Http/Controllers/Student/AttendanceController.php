<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $user->load('profile');

        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');

        $inStart = Setting::get('attendance_in_start', '06:00');
        $inEnd = Setting::get('attendance_in_end', '09:00');
        $outStart = Setting::get('attendance_out_start', '15:00');
        $outEnd = Setting::get('attendance_out_end', '18:00');

        $canClockIn = ($currentTime >= $inStart && $currentTime <= $inEnd);
        $canClockOut = ($currentTime >= $outStart && $currentTime <= $outEnd);

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        $stats = [
            'total' => Attendance::where('user_id', $user->id)->count(),
            'hadir' => Attendance::where('user_id', $user->id)->where('status', 'hadir')->count(),
            'izin_sakit' => Attendance::where('user_id', $user->id)->whereIn('status', ['izin', 'sakit'])->count(),
            'alpha' => Attendance::where('user_id', $user->id)->where('status', 'alpha')->count(),
        ];

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(15);

        $leaveRequests = LeaveRequest::where('user_id', $user->id)
            ->latest()
            ->get();

        return Inertia::render('Student/Attendance/Index', [
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
            'studentName' => $user->name,
        ]);
    }

    public function clockIn(Request $request): RedirectResponse
    {
        $user = $request->user();
        $today = now()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $inStart = Setting::get('attendance_in_start', '06:00');
        $inEnd = Setting::get('attendance_in_end', '09:00');
        $currentTime = now()->format('H:i');

        if ($currentTime < $inStart || $currentTime > $inEnd) {
            return back()->withErrors(['attendance' => "Waktu absen masuk hanya diperbolehkan pada jam {$inStart} - {$inEnd}."]);
        }

        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if ($attendance && $attendance->time_in) {
            return back()->withErrors(['attendance' => 'Anda sudah melakukan absen masuk hari ini.']);
        }

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'status' => 'hadir',
                'time_in' => $nowTime,
            ]
        );

        return redirect()->back()->with('success', 'Absen masuk berhasil direkam.');
    }

    public function clockOut(Request $request): RedirectResponse
    {
        $user = $request->user();
        $today = now()->format('Y-m-d');
        $nowTime = now()->format('H:i:s');

        $outStart = Setting::get('attendance_out_start', '15:00');
        $outEnd = Setting::get('attendance_out_end', '18:00');
        $currentTime = now()->format('H:i');

        if ($currentTime < $outStart || $currentTime > $outEnd) {
            return back()->withErrors(['attendance' => "Waktu absen pulang hanya diperbolehkan pada jam {$outStart} - {$outEnd}."]);
        }

        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if (! $attendance || ! $attendance->time_in) {
            return back()->withErrors(['attendance' => 'Anda belum melakukan absen masuk hari ini.']);
        }

        $attendance->time_out = $nowTime;
        $attendance->save();

        return redirect()->back()->with('success', 'Absen pulang berhasil direkam.');
    }

    public function requestLeave(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'in:izin,sakit'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        LeaveRequest::create([
            'user_id' => $request->user()->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin/sakit berhasil dikirim dan menunggu konfirmasi Admin.');
    }
}
