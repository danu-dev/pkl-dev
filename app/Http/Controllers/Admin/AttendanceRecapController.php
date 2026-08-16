<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreManualAttendanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceRecapController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'date', 'status']);
        $data = $this->adminService->getAttendanceRecapData($filters);

        return Inertia::render('Admin/Attendances/Index', $data);
    }

    public function storeManual(StoreManualAttendanceRequest $request): RedirectResponse
    {
        $this->adminService->storeManualAttendance($request->validated());

        return back()->with('success', 'Data presensi berhasil disimpan/diperbarui.');
    }
}
