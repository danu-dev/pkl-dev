<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyAnnouncementRequest;
use App\Http\Requests\Admin\StoreAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AnnouncementController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Announcements/Index', [
            'announcements' => $this->adminService->getAnnouncementsData(),
        ]);
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $this->adminService->storeAnnouncement($request->validated());

        return back()->with('success', 'Pengumuman berhasil dipublikasikan.');
    }

    public function destroy(DestroyAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $this->adminService->deleteAnnouncement($announcement->id);

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
