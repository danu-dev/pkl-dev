<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PicketReport;
use App\Models\PicketSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PicketController extends Controller
{
    public function scheduleIndex(Request $request): Response
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

        return Inertia::render('Student/Picket/Schedule', [
            'schedules' => $schedules,
            'todayDate' => now()->translatedFormat('l, d F Y'),
        ]);
    }

    public function reportIndex(Request $request): Response
    {
        $user = $request->user();

        $myReports = PicketReport::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return Inertia::render('Student/Picket/Report', [
            'myReports' => $myReports,
            'todayDate' => now()->translatedFormat('l, d F Y'),
        ]);
    }

    public function storeReport(Request $request): RedirectResponse
    {
        $request->validate([
            'notes' => ['nullable', 'string'],
            'proof_file' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
        ]);

        $proofPath = $request->file('proof_file')->store('picket_proofs', 'public');

        PicketReport::create([
            'user_id' => $request->user()->id,
            'date' => now()->format('Y-m-d'),
            'proof_file' => $proofPath,
            'notes' => $request->notes,
            'status' => 'submitted',
        ]);

        return redirect()->back()->with('success', 'Laporan piket hari ini berhasil dikirim.');
    }
}
