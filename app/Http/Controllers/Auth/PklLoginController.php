<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AuthServiceInterface;
use App\DTOs\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PklLoginController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ) {}

    public function store(LoginRequest $request): RedirectResponse
    {
        $dto = LoginDTO::fromRequest($request->validated());

        $this->authService->attemptLogin($dto);

        $user = Auth::user();

        if ($user->role === 'siswa_pkl' && (! $user->is_approved || $user->status !== 'approved')) {
            $this->authService->logout();

            throw ValidationException::withMessages([
                'login' => 'Akun Anda belum disetujui oleh Admin. Silakan tunggu konfirmasi verifikasi.',
            ]);
        }

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->authService->logout();

        return redirect('/');
    }
}
