<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBatchRequest;
use App\Http\Requests\Admin\StoreDivisionRequest;
use App\Http\Requests\Admin\StoreMajorRequest;
use App\Http\Requests\Admin\StoreSchoolRequest;
use App\Http\Requests\Admin\StoreSupervisorRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MasterDataController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/MasterData/Index', $this->adminService->getMasterData());
    }

    public function storeSchool(StoreSchoolRequest $request): RedirectResponse
    {
        $this->adminService->storeSchool($request->validated());

        return back()->with('success', 'Data Sekolah/Kampus berhasil ditambahkan.');
    }

    public function storeMajor(StoreMajorRequest $request): RedirectResponse
    {
        $this->adminService->storeMajor($request->validated());

        return back()->with('success', 'Data Jurusan berhasil ditambahkan.');
    }

    public function storeDivision(StoreDivisionRequest $request): RedirectResponse
    {
        $this->adminService->storeDivision($request->validated());

        return back()->with('success', 'Data Divisi berhasil ditambahkan.');
    }

    public function storeBatch(StoreBatchRequest $request): RedirectResponse
    {
        $this->adminService->storeBatch($request->validated());

        return back()->with('success', 'Gelombang PKL berhasil ditambahkan.');
    }

    public function storeSupervisor(StoreSupervisorRequest $request): RedirectResponse
    {
        $this->adminService->storeSupervisor($request->validated());

        return back()->with('success', 'Data Pembimbing berhasil ditambahkan.');
    }
}
