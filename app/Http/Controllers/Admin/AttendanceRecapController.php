<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceRecapController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Attendance::with(['user.profile']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        $today = now()->format('Y-m-d');
        $stats = [
            'total_students' => User::where('role', 'siswa_pkl')->where('status', 'approved')->count(),
            'today_hadir' => Attendance::where('date', $today)->where('status', 'hadir')->count(),
            'today_izin_sakit' => Attendance::where('date', $today)->whereIn('status', ['izin', 'sakit'])->count(),
            'today_alpha' => Attendance::where('date', $today)->where('status', 'alpha')->count(),
        ];

        return Inertia::render('Admin/Attendances/Index', [
            'attendances' => $attendances,
            'stats' => $stats,
            'filters' => $request->only(['search', 'date', 'status']),
            'allStudents' => User::where('role', 'siswa_pkl')->where('status', 'approved')->select('id', 'name')->get(),
        ]);
    }

    public function storeManual(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:hadir,izin,sakit,alpha'],
            'time_in' => ['nullable'],
            'time_out' => ['nullable'],
            'notes' => ['nullable', 'string'],
        ]);

        Attendance::updateOrCreate(
            ['user_id' => $request->user_id, 'date' => $request->date],
            [
                'status' => $request->status,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'notes' => $request->notes,
            ]
        );

        return back()->with('success', 'Data presensi berhasil disimpan/diperbarui.');
    }
}
