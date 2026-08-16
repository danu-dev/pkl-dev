<?php

namespace App\Providers;

use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Contracts\Repositories\JournalRepositoryInterface;
use App\Contracts\Repositories\LandingRepositoryInterface;
use App\Contracts\Repositories\LeaveRequestRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AdminDashboardServiceInterface;
use App\Contracts\Services\AdminServiceInterface;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\StudentServiceInterface;
use App\Repositories\AttendanceRepository;
use App\Repositories\JournalRepository;
use App\Repositories\LandingRepository;
use App\Repositories\LeaveRequestRepository;
use App\Repositories\UserRepository;
use App\Services\AdminDashboardService;
use App\Services\AdminService;
use App\Services\AuthService;
use App\Services\StudentService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LandingRepositoryInterface::class, LandingRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(JournalRepositoryInterface::class, JournalRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(LeaveRequestRepositoryInterface::class, LeaveRequestRepository::class);

        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(StudentServiceInterface::class, StudentService::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(AdminDashboardServiceInterface::class, AdminDashboardService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
