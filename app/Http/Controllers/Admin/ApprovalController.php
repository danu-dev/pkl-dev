<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ApprovalController extends Controller
{
    public function index(): Response
    {
        $pendingUsers = User::with(['profile.school', 'profile.major', 'profile.pklBatch'])
            ->where('role', 'siswa_pkl')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return Inertia::render('Admin/Approval/Index', [
            'pendingUsers' => $pendingUsers,
        ]);
    }

    public function approve(User $user): RedirectResponse
    {
        $user->update([
            'status' => 'approved',
            'is_approved' => true,
        ]);

        return back()->with('success', "Akun siswa {$user->name} berhasil disetujui.");
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        $user->update([
            'status' => 'rejected',
            'is_approved' => false,
        ]);

        return back()->with('success', "Pendaftaran siswa {$user->name} ditolak.");
    }
}
