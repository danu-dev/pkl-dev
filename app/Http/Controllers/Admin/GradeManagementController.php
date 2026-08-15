<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentGrade;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GradeManagementController extends Controller
{
    public function index(): Response
    {
        $students = User::with(['profile', 'grade'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'approved')
            ->get();

        return Inertia::render('Admin/Grades/Index', [
            'students' => $students,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'discipline_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'technical_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'journal_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'attendance_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'attitude_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $finalScore = (
            $request->discipline_score * 0.20 +
            $request->technical_score * 0.30 +
            $request->journal_score * 0.20 +
            $request->attendance_score * 0.15 +
            $request->attitude_score * 0.15
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
            ['user_id' => $request->user_id],
            [
                'discipline_score' => $request->discipline_score,
                'technical_score' => $request->technical_score,
                'journal_score' => $request->journal_score,
                'attendance_score' => $request->attendance_score,
                'attitude_score' => $request->attitude_score,
                'final_score' => $finalScore,
                'grade_letter' => $gradeLetter,
                'notes' => $request->notes,
            ]
        );

        return back()->with('success', 'Penilaian siswa berhasil disimpan.');
    }
}
