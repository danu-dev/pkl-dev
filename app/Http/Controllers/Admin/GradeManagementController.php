<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGradeRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GradeManagementController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Grades/Index', [
            'students' => $this->adminService->getGradesData(),
        ]);
    }

    public function store(StoreGradeRequest $request): RedirectResponse
    {
        $this->adminService->storeGradeEvaluation($request->validated());

        return back()->with('success', 'Penilaian siswa berhasil disimpan.');
    }
}
