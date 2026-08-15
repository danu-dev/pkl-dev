<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Journal;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $user->load('profile');

        $today = now()->format('Y-m-d');

        $journalStats = [
            'total' => Journal::where('user_id', $user->id)->count(),
            'approved' => Journal::where('user_id', $user->id)->where('status', 'approved')->count(),
            'submitted' => Journal::where('user_id', $user->id)->where('status', 'submitted')->count(),
            'today_submitted' => Journal::where('user_id', $user->id)->where('date', $today)->exists(),
        ];

        $attendanceStats = [
            'total' => Attendance::where('user_id', $user->id)->count(),
            'hadir' => Attendance::where('user_id', $user->id)->where('status', 'hadir')->count(),
            'izin_sakit' => Attendance::where('user_id', $user->id)->whereIn('status', ['izin', 'sakit'])->count(),
            'alpha' => Attendance::where('user_id', $user->id)->where('status', 'alpha')->count(),
            'today_attendance' => Attendance::where('user_id', $user->id)->where('date', $today)->first(),
        ];

        $announcements = Announcement::where('target_role', 'all')
            ->orWhere('target_role', 'siswa_pkl')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Student/Dashboard', [
            'username' => $user->username,
            'user' => $user,
            'journalStats' => $journalStats,
            'attendanceStats' => $attendanceStats,
            'announcements' => $announcements,
        ]);
    }
}
