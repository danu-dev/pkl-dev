<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\PklBatch;
use App\Models\School;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class PklRegisterController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('auth/Register', [
            'schools' => School::all(),
            'majors' => Major::all(),
            'batches' => PklBatch::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'school_name' => ['required', 'string', 'max:255'],
            'major_name' => ['required', 'string', 'max:255'],
            'nisn_nim' => ['nullable', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'max:20'],
            'cv_file' => ['required', 'file', 'mimes:pdf', 'max:5120'], // Max 5MB PDF
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('cv_files', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'username' => strtolower($request->username),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => 'siswa_pkl',
            'status' => 'pending',
            'is_approved' => false,
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'nisn_nim' => $request->nisn_nim,
            'phone_number' => $request->phone_number,
            'cv_path' => $cvPath,
            'session_type' => 'full_day',
            'school_name' => $request->school_name,
            'major_name' => $request->major_name,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda berstatus pending dan sedang menunggu verifikasi/approval dari Admin.');
    }
}
