<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\PklLoginController;
use App\Http\Controllers\Auth\PklRegisterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Student;
use App\Http\Middleware\EnsureAccountApproved;
use App\Http\Middleware\EnsureIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');

// Guest Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => Inertia\Inertia::render('auth/Login'))->name('login');
    Route::post('/login', [PklLoginController::class, 'store']);

    Route::get('/register', [PklRegisterController::class, 'create'])->name('register');
    Route::post('/register', [PklRegisterController::class, 'store']);
});

Route::post('/logout', [PklLoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Role Siswa PKL Routes
Route::middleware(['auth', EnsureAccountApproved::class])->group(function () {
    Route::get('/dashboard', [Student\DashboardController::class, 'index'])->name('dashboard');

    // Jurnal Kegiatan
    Route::get('/jurnal', [Student\JournalController::class, 'index'])->name('student.journal.index');
    Route::post('/jurnal', [Student\JournalController::class, 'store'])->name('student.journal.store');
    Route::post('/jurnal/{journal}', [Student\JournalController::class, 'update'])->name('student.journal.update');

    // Absensi
    Route::get('/absensi', [Student\AttendanceController::class, 'index'])->name('student.attendance.index');
    Route::post('/absensi/clock-in', [Student\AttendanceController::class, 'clockIn'])->name('student.attendance.clock-in');
    Route::post('/absensi/clock-out', [Student\AttendanceController::class, 'clockOut'])->name('student.attendance.clock-out');
    Route::post('/absensi/leave', [Student\AttendanceController::class, 'requestLeave'])->name('student.attendance.leave');

    // Piket & Lainnya (Terpisah)
    Route::get('/picket-schedule', [Student\PicketController::class, 'scheduleIndex'])->name('student.picket.schedule');
    Route::get('/picket-report', [Student\PicketController::class, 'reportIndex'])->name('student.picket.report');
    Route::post('/picket-report', [Student\PicketController::class, 'storeReport'])->name('student.picket.report.store');
});

// Role Admin Routes
Route::middleware(['auth', EnsureIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Approval Pendaftaran
    Route::get('/approvals', [Admin\ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{user}/approve', [Admin\ApprovalController::class, 'approve'])->name('approvals.approve');
    Route::post('/approvals/{user}/reject', [Admin\ApprovalController::class, 'reject'])->name('approvals.reject');

    // Data Siswa
    Route::get('/students', [Admin\StudentController::class, 'index'])->name('students.index');
    Route::put('/students/{user}', [Admin\StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{user}', [Admin\StudentController::class, 'destroy'])->name('students.destroy');

    // Rekap Jurnal TERPISAH
    Route::get('/journals', [Admin\JournalRecapController::class, 'index'])->name('journals.index');
    Route::post('/journals/{journal}/verify', [Admin\JournalRecapController::class, 'verify'])->name('journals.verify');

    // Rekap Absensi TERPISAH
    Route::get('/attendances', [Admin\AttendanceRecapController::class, 'index'])->name('attendances.index');
    Route::post('/attendances/manual', [Admin\AttendanceRecapController::class, 'storeManual'])->name('attendances.manual');

    // Pengajuan Izin / Sakit
    Route::get('/leave-requests', [Admin\LeaveManagementController::class, 'index'])->name('leave.index');
    Route::post('/leave-requests/{leaveRequest}', [Admin\LeaveManagementController::class, 'update'])->name('leave.update');

    // Master Data
    Route::get('/master-data', [Admin\MasterDataController::class, 'index'])->name('master-data.index');
    Route::post('/master-data/schools', [Admin\MasterDataController::class, 'storeSchool'])->name('master-data.schools.store');
    Route::post('/master-data/majors', [Admin\MasterDataController::class, 'storeMajor'])->name('master-data.majors.store');
    Route::post('/master-data/divisions', [Admin\MasterDataController::class, 'storeDivision'])->name('master-data.divisions.store');
    Route::post('/master-data/batches', [Admin\MasterDataController::class, 'storeBatch'])->name('master-data.batches.store');
    Route::post('/master-data/supervisors', [Admin\MasterDataController::class, 'storeSupervisor'])->name('master-data.supervisors.store');

    // Kelola Piket
    Route::get('/picket', [Admin\PicketManagementController::class, 'index'])->name('picket.index');
    Route::post('/picket/schedule', [Admin\PicketManagementController::class, 'storeSchedule'])->name('picket.schedule.store');
    Route::delete('/picket/schedule/{picketSchedule}', [Admin\PicketManagementController::class, 'destroySchedule'])->name('picket.schedule.destroy');

    // Penilaian & Sertifikat
    Route::get('/grades', [Admin\GradeManagementController::class, 'index'])->name('grades.index');
    Route::post('/grades', [Admin\GradeManagementController::class, 'store'])->name('grades.store');

    // Pengumuman
    Route::get('/announcements', [Admin\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [Admin\AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/announcements/{announcement}', [Admin\AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Settings jam operasional
    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    // CMS Landing Page Editor
    Route::get('/landing-cms', [Admin\LandingCmsController::class, 'index'])->name('landing.index');
    Route::post('/landing-cms/sections', [Admin\LandingCmsController::class, 'updateSections'])->name('landing.sections.update');
    Route::post('/landing-cms/alumni', [Admin\LandingCmsController::class, 'storeAlumni'])->name('landing.alumni.store');
    Route::delete('/landing-cms/alumni/{id}', [Admin\LandingCmsController::class, 'destroyAlumni'])->name('landing.alumni.destroy');
    Route::post('/landing-cms/gallery', [Admin\LandingCmsController::class, 'storeGallery'])->name('landing.gallery.store');
    Route::delete('/landing-cms/gallery/{id}', [Admin\LandingCmsController::class, 'destroyGallery'])->name('landing.gallery.destroy');
    Route::post('/landing-cms/procedures', [Admin\LandingCmsController::class, 'storeProcedure'])->name('landing.procedure.store');
    Route::delete('/landing-cms/procedures/{id}', [Admin\LandingCmsController::class, 'destroyProcedure'])->name('landing.procedure.destroy');
});

require __DIR__.'/settings.php';
