<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Division;
use App\Models\Major;
use App\Models\PklBatch;
use App\Models\School;
use App\Models\Setting;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = env('ADMIN_DEFAULT_PASSWORD', 'AdminPkl#Dev2026');
        $studentPassword = env('STUDENT_DEFAULT_PASSWORD', 'AfdanuPkl#Dev2026');

        // 1. Admin User
        User::create([
            'name' => 'Administrator PKL',
            'username' => 'admin',
            'email' => 'admin@pkl.com',
            'password' => Hash::make($adminPassword),
            'role' => 'admin',
            'status' => 'approved',
            'is_approved' => true,
        ]);

        // 2. Sample Master Schools, Majors, Divisions
        $school = School::create([
            'name' => 'SMK Negeri 1 Surabaya',
            'code' => 'SMKN1SBY',
            'address' => 'Jl. Smkn 1 Surabaya',
        ]);

        $major = Major::create([
            'school_id' => $school->id,
            'name' => 'Rekayasa Perangkat Lunak',
            'code' => 'RPL',
        ]);

        $divisionBackend = Division::create(['name' => 'Backend Developer', 'code' => 'BACKEND']);
        Division::create(['name' => 'Frontend Developer', 'code' => 'FRONTEND']);
        Division::create(['name' => 'Mobile Developer', 'code' => 'MOBILE']);
        Division::create(['name' => 'UI/UX Designer', 'code' => 'UIUX']);

        // 3. Sample PKL Batch
        $batch = PklBatch::create([
            'name' => 'Gelombang 1 - 2026',
            'start_date' => '2026-01-01',
            'end_date' => '2026-06-30',
            'quota' => 50,
            'is_active' => true,
        ]);

        // 4. Sample Siswa PKL Approved
        $siswa = User::create([
            'name' => 'MOHAMMAD AFDANU APRILIAN SAPUTRA',
            'username' => 'afdanu',
            'email' => 'afdanu@gmail.com',
            'password' => Hash::make($studentPassword),
            'role' => 'siswa_pkl',
            'status' => 'approved',
            'is_approved' => true,
        ]);

        StudentProfile::create([
            'user_id' => $siswa->id,
            'school_id' => $school->id,
            'major_id' => $major->id,
            'pkl_batch_id' => $batch->id,
            'division_id' => $divisionBackend->id,
            'nisn_nim' => '1234567890',
            'phone_number' => '081234567890',
            'session_type' => 'full_day',
            'school_name' => $school->name,
            'major_name' => $major->name,
            'division_name' => $divisionBackend->name,
        ]);

        // 5. Default Settings
        Setting::set('journal_start_time', '04:00');
        Setting::set('journal_end_time', '23:59');
        Setting::set('attendance_in_start', '06:00');
        Setting::set('attendance_in_end', '09:00');
        Setting::set('attendance_out_start', '15:00');
        Setting::set('attendance_out_end', '18:00');
        Setting::set('is_holiday_mode', 'false');

        // 6. Announcement
        Announcement::create([
            'title' => 'Selamat Datang Peserta PKL Baru',
            'content' => 'Pastikan mengisi jurnal harian sebelum jam 23:59 WIB dan melakukan absensi tepat waktu.',
            'is_pinned' => true,
            'target_role' => 'all',
        ]);
    }
}
