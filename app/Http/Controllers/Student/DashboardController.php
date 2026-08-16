<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        protected StudentServiceInterface $studentService
    ) {}

    public function index(Request $request): Response
    {
        $user = $request->user();
        $user->load('profile');

        $data = $this->studentService->getStudentDashboardData($user->id);

        return Inertia::render('Student/Dashboard', array_merge($data, [
            'username' => $user->username,
            'user' => $user,
        ]));
    }
}
