<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyPicketScheduleRequest;
use App\Http\Requests\Admin\StorePicketScheduleRequest;
use App\Models\PicketSchedule;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PicketManagementController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Picket/Index', $this->adminService->getPicketManagementData());
    }

    public function storeSchedule(StorePicketScheduleRequest $request): RedirectResponse
    {
        $this->adminService->storePicketSchedule($request->validated());

        return back()->with('success', 'Jadwal piket siswa berhasil disimpan.');
    }

    public function destroySchedule(DestroyPicketScheduleRequest $request, PicketSchedule $picketSchedule): RedirectResponse
    {
        $this->adminService->deletePicketSchedule($picketSchedule->id);

        return back()->with('success', 'Petugas piket dihapus dari jadwal.');
    }
}
