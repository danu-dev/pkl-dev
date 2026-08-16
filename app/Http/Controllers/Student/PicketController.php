<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StorePicketReportRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PicketController extends Controller
{
    public function __construct(
        protected StudentServiceInterface $studentService
    ) {}

    public function scheduleIndex(): Response
    {
        return Inertia::render('Student/Picket/Schedule', [
            'schedules' => $this->studentService->getPicketSchedules(),
            'todayDate' => now()->translatedFormat('l, d F Y'),
        ]);
    }

    public function reportIndex(Request $request): Response
    {
        $data = $this->studentService->getStudentPicketReports($request->user()->id);

        return Inertia::render('Student/Picket/Report', $data);
    }

    public function storeReport(StorePicketReportRequest $request): RedirectResponse
    {
        $this->studentService->storePicketReport($request->user()->id, $request->validated());

        return redirect()->back()->with('success', 'Laporan piket hari ini berhasil dikirim.');
    }
}
