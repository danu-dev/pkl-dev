<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyStudentRequest;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(Request $request): Response
    {
        $data = $this->adminService->getStudentsData($request->only(['search', 'status']));

        return Inertia::render('Admin/Students/Index', $data);
    }

    public function update(UpdateStudentRequest $request, User $user): RedirectResponse
    {
        $this->adminService->updateStudent($user, $request->validated());

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(DestroyStudentRequest $request, User $user): RedirectResponse
    {
        $this->adminService->deleteStudent($user);

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }
}
