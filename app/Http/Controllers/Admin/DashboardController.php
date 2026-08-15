<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Journal;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $today = now()->format('Y-m-d');

        $stats = [
            'total_students' => User::where('role', 'siswa_pkl')->where('status', 'approved')->count(),
            'pending_approvals' => User::where('role', 'siswa_pkl')->where('status', 'pending')->count(),
            'today_journals' => Journal::where('date', $today)->count(),
            'today_attendances' => Attendance::where('date', $today)->where('status', 'hadir')->count(),
            'pending_leaves' => LeaveRequest::where('status', 'pending')->count(),
        ];

        $pendingUsers = User::with('profile')
            ->where('role', 'siswa_pkl')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentJournals = Journal::with('user:id,name')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'pendingUsers' => $pendingUsers,
            'recentJournals' => $recentJournals,
        ]);
    }
}
