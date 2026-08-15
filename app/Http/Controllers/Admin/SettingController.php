<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function index(): Response
    {
        $settings = [
            'journal_start_time' => Setting::get('journal_start_time', '04:00'),
            'journal_end_time' => Setting::get('journal_end_time', '23:59'),
            'attendance_in_start' => Setting::get('attendance_in_start', '06:00'),
            'attendance_in_end' => Setting::get('attendance_in_end', '09:00'),
            'attendance_out_start' => Setting::get('attendance_out_start', '15:00'),
            'attendance_out_end' => Setting::get('attendance_out_end', '18:00'),
            'is_holiday_mode' => Setting::get('is_holiday_mode', 'false'),
        ];

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'journal_start_time' => ['required', 'string'],
            'journal_end_time' => ['required', 'string'],
            'attendance_in_start' => ['required', 'string'],
            'attendance_in_end' => ['required', 'string'],
            'attendance_out_start' => ['required', 'string'],
            'attendance_out_end' => ['required', 'string'],
        ]);

        foreach ($request->only([
            'journal_start_time',
            'journal_end_time',
            'attendance_in_start',
            'attendance_in_end',
            'attendance_out_start',
            'attendance_out_end',
            'is_holiday_mode',
        ]) as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Pengaturan jam operasional & batasan waktu berhasil disimpan.');
    }
}
