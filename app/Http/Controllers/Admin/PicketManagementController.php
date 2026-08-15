<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PicketReport;
use App\Models\PicketSchedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PicketManagementController extends Controller
{
    public function index(): Response
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

        return Inertia::render('Admin/Picket/Index', [
            'students' => $students,
            'schedules' => $schedules,
            'reports' => $reports,
        ]);
    }

    public function storeSchedule(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'day' => ['required', 'in:senin,selasa,rabu,kamis,jumat'],
            'shift' => ['required', 'in:pagi,sore'],
        ]);

        PicketSchedule::updateOrCreate(
            ['user_id' => $request->user_id, 'day' => $request->day],
            ['shift' => $request->shift]
        );

        return back()->with('success', 'Jadwal piket siswa berhasil disimpan.');
    }

    public function destroySchedule(PicketSchedule $picketSchedule): RedirectResponse
    {
        $picketSchedule->delete();

        return back()->with('success', 'Petugas piket dihapus dari jadwal.');
    }
}
