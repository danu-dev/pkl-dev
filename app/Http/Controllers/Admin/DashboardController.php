<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminDashboardServiceInterface;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        protected AdminDashboardServiceInterface $adminDashboardService
    ) {}

    public function index(): Response
    {
        $overview = $this->adminDashboardService->getDashboardOverview();

        return Inertia::render('Admin/Dashboard', $overview);
    }
}
