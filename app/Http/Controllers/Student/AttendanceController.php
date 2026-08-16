<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ClockInAttendanceRequest;
use App\Http\Requests\Student\ClockOutAttendanceRequest;
use App\Http\Requests\Student\StoreLeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceController extends Controller
{
    public function __construct(
        protected StudentServiceInterface $studentService
    ) {}

    public function index(Request $request): Response
    {
        $user = $request->user();
        $user->load('profile');

        $data = $this->studentService->getStudentAttendanceData($user->id);

        return Inertia::render('Student/Attendance/Index', array_merge($data, [
            'studentName' => $user->name,
        ]));
    }

    public function clockIn(ClockInAttendanceRequest $request): RedirectResponse
    {
        $this->studentService->clockIn($request->user()->id);

        return redirect()->back()->with('success', 'Absen masuk berhasil direkam.');
    }

    public function clockOut(ClockOutAttendanceRequest $request): RedirectResponse
    {
        $this->studentService->clockOut($request->user()->id);

        return redirect()->back()->with('success', 'Absen pulang berhasil direkam.');
    }

    public function requestLeave(StoreLeaveRequest $request): RedirectResponse
    {
        $this->studentService->requestLeave($request->user()->id, $request->validated());

        return redirect()->back()->with('success', 'Pengajuan izin/sakit berhasil dikirim dan menunggu konfirmasi Admin.');
    }
}
