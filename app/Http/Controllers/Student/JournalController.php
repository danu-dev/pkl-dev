<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreJournalRequest;
use App\Http\Requests\Student\UpdateJournalRequest;
use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JournalController extends Controller
{
    public function __construct(
        protected StudentServiceInterface $studentService
    ) {}

    public function index(Request $request): Response
    {
        $data = $this->studentService->getStudentJournalData($request->user()->id);

        return Inertia::render('Student/Journal/Index', $data);
    }

    public function store(StoreJournalRequest $request): RedirectResponse
    {
        $this->studentService->storeJournal($request->user()->id, $request->validated());

        return redirect()->back()->with('success', 'Jurnal harian berhasil ditambahkan.');
    }

    public function update(UpdateJournalRequest $request, Journal $journal): RedirectResponse
    {
        $this->studentService->updateJournal($journal, $request->validated());

        return redirect()->back()->with('success', 'Jurnal harian berhasil diperbarui.');
    }
}
