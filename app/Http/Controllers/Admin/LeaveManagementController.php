<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLeaveStatusRequest;
use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LeaveManagementController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Leave/Index', [
            'leaveRequests' => $this->adminService->getLeaveRequests(),
        ]);
    }

    public function update(UpdateLeaveStatusRequest $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $this->adminService->updateLeaveStatus($leaveRequest->id, $request->validated());

        return back()->with('success', 'Status pengajuan izin berhasil diperbarui.');
    }
}
