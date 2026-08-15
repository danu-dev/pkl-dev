<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JournalController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i');

        $startTime = Setting::get('journal_start_time', '04:00');
        $endTime = Setting::get('journal_end_time', '23:59');

        $canSubmit = ($currentTime >= $startTime && $currentTime <= $endTime);

        $journals = Journal::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Student/Journal/Index', [
            'journals' => $journals,
            'canSubmit' => $canSubmit,
            'operatingHours' => [
                'start' => $startTime,
                'end' => $endTime,
            ],
            'today' => $today,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $currentTime = now()->format('H:i');
        $startTime = Setting::get('journal_start_time', '04:00');
        $endTime = Setting::get('journal_end_time', '23:59');

        if ($currentTime < $startTime || $currentTime > $endTime) {
            return back()->withErrors([
                'journal' => "Pengisian jurnal hanya diperbolehkan pada jam {$startTime} hingga {$endTime}.",
            ]);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'proof_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_file')) {
            $proofPath = $request->file('proof_file')->store('journal_proofs', 'public');
        }

        Journal::create([
            'user_id' => $request->user()->id,
            'date' => now()->format('Y-m-d'),
            'title' => $request->title,
            'description' => $request->description,
            'proof_file' => $proofPath,
            'status' => 'submitted',
        ]);

        return redirect()->back()->with('success', 'Jurnal harian berhasil ditambahkan.');
    }

    public function update(Request $request, Journal $journal): RedirectResponse
    {
        if ($journal->user_id !== $request->user()->id) {
            abort(403);
        }

        $currentTime = now()->format('H:i');
        $startTime = Setting::get('journal_start_time', '04:00');
        $endTime = Setting::get('journal_end_time', '23:59');

        if ($currentTime < $startTime || $currentTime > $endTime) {
            return back()->withErrors([
                'journal' => "Perubahan jurnal hanya diperbolehkan pada jam {$startTime} hingga {$endTime}.",
            ]);
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'proof_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        if ($request->hasFile('proof_file')) {
            $journal->proof_file = $request->file('proof_file')->store('journal_proofs', 'public');
        }

        $journal->title = $request->title;
        $journal->description = $request->description;
        $journal->status = 'submitted';
        $journal->save();

        return redirect()->back()->with('success', 'Jurnal harian berhasil diperbarui.');
    }
}
