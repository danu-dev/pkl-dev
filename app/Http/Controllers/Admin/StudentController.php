<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Major;
use App\Models\PklBatch;
use App\Models\School;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::with(['profile.school', 'profile.major', 'profile.pklBatch'])
            ->where('role', 'siswa_pkl');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Admin/Students/Index', [
            'students' => $students,
            'filters' => $request->only(['search', 'status']),
            'schools' => School::all(),
            'majors' => Major::all(),
            'divisions' => Division::all(),
            'batches' => PklBatch::all(),
            'supervisors' => Supervisor::all(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'session_type' => ['required', 'in:full_day,persesi_pagi,persesi_sore'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'is_approved' => $request->status === 'approved',
        ]);

        if ($user->profile) {
            $division = $request->division_id ? Division::find($request->division_id) : null;
            $user->profile->update([
                'session_type' => $request->session_type,
                'division_id' => $request->division_id,
                'division_name' => $division?->name,
            ]);
        }

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}
