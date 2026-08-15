<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JournalRecapController extends Controller
{
    public function index(Request $request): Response
    {
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        $search = $request->input('search');
        $statusFilter = $request->input('status'); // 'filled' or 'not_filled' or empty

        $studentsQuery = User::with(['profile'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'approved');

        if ($search) {
            $studentsQuery->where('name', 'like', "%{$search}%");
        }

        $students = $studentsQuery->get();

        // Get journals for the selected date
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

        // Filter by status if applied
        if ($statusFilter === 'filled') {
            $recapData = $recapData->filter(fn ($item) => $item['has_filled']);
        } elseif ($statusFilter === 'not_filled') {
            $recapData = $recapData->filter(fn ($item) => ! $item['has_filled']);
        }

        return Inertia::render('Admin/Journals/Index', [
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
        ]);
    }
}
