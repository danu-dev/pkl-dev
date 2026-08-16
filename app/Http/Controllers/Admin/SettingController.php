<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOperationalSettingsRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => $this->adminService->getOperationalSettings(),
        ]);
    }

    public function update(UpdateOperationalSettingsRequest $request): RedirectResponse
    {
        $this->adminService->updateOperationalSettings($request->validated());

        return back()->with('success', 'Pengaturan jam operasional & batasan waktu berhasil disimpan.');
    }
}
