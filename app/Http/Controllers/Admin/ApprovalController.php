<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveUserRequest;
use App\Http\Requests\Admin\RejectUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ApprovalController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Approval/Index', [
            'pendingUsers' => $this->adminService->getPendingStudents(),
        ]);
    }

    public function approve(ApproveUserRequest $request, User $user): RedirectResponse
    {
        $this->adminService->approveStudent($user);

        return back()->with('success', "Akun siswa {$user->name} berhasil disetujui.");
    }

    public function reject(RejectUserRequest $request, User $user): RedirectResponse
    {
        $this->adminService->rejectStudent($user);

        return back()->with('success', "Pendaftaran siswa {$user->name} ditolak.");
    }
}
