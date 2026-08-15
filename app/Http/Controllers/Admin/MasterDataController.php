<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Major;
use App\Models\PklBatch;
use App\Models\School;
use App\Models\Supervisor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MasterDataController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/MasterData/Index', [
            'schools' => School::with('majors')->get(),
            'divisions' => Division::all(),
            'batches' => PklBatch::all(),
            'supervisors' => Supervisor::all(),
        ]);
    }

    public function storeSchool(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);

        School::create($request->only(['name', 'code', 'address']));

        return back()->with('success', 'Data Sekolah/Kampus berhasil ditambahkan.');
    }

    public function storeMajor(Request $request): RedirectResponse
    {
        $request->validate([
            'school_id' => ['required', 'exists:schools,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
        ]);

        Major::create($request->only(['school_id', 'name', 'code']));

        return back()->with('success', 'Data Jurusan berhasil ditambahkan.');
    }

    public function storeDivision(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
        ]);

        Division::create($request->only(['name', 'code']));

        return back()->with('success', 'Data Divisi berhasil ditambahkan.');
    }

    public function storeBatch(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'quota' => ['required', 'integer', 'min:1'],
        ]);

        PklBatch::create($request->only(['name', 'start_date', 'end_date', 'quota']));

        return back()->with('success', 'Gelombang PKL berhasil ditambahkan.');
    }

    public function storeSupervisor(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'phone_number' => ['nullable', 'string'],
            'company_agency' => ['nullable', 'string'],
        ]);

        Supervisor::create($request->only(['name', 'nip', 'email', 'phone_number', 'company_agency']));

        return back()->with('success', 'Data Pembimbing berhasil ditambahkan.');
    }
}
