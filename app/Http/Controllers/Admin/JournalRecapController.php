<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AdminServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JournalRecapController extends Controller
{
    public function __construct(
        protected AdminServiceInterface $adminService
    ) {}

    public function index(Request $request): Response
    {
        $filters = $request->only(['date', 'search', 'status']);
        $data = $this->adminService->getJournalRecapData($filters);

        return Inertia::render('Admin/Journals/Index', $data);
    }
}
