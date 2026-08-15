<script setup lang="ts">
import { BookOpen, CalendarCheck, CheckCircle2, Clock, Megaphone, AlertCircle } from '@lucide/vue';

defineProps<{
    username: string;
    user: any;
    journalStats: {
        total: number;
        approved: number;
        submitted: number;
        today_submitted: boolean;
    };
    attendanceStats: {
        total: number;
        hadir: number;
        izin_sakit: number;
        alpha: number;
        today_attendance: any;
    };
    announcements: any[];
}>();
</script>

<template>
    <div class="space-y-6">
        <!-- Welcome Hero Banner -->
        <div class="bg-gradient-to-tr from-[rgb(93,135,255)] to-blue-500 rounded-2xl p-6 text-white shadow-xl shadow-blue-500/15 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold tracking-tight">Selamat Datang, {{ username }}! 👋</h1>
                    <span v-if="user?.profile?.division_name" class="px-3 py-1 rounded-full text-xs font-bold bg-white text-[rgb(93,135,255)] shadow-xs">
                        {{ user.profile.division_name }}
                    </span>
                </div>
                <p class="text-sm text-blue-100">Selamat beraktivitas di Portal Monitoring PKL. Tetap disiplin dan jaga kesehatan!</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20 text-xs font-semibold flex items-center gap-2">
                <Clock class="w-4 h-4 text-blue-200" />
                <span>Sesi: {{ user?.profile?.session_type === 'full_day' ? 'Full Day (Seharian)' : user?.profile?.session_type }}</span>
            </div>
        </div>

        <!-- Announcement Board -->
        <div v-if="announcements && announcements.length > 0" class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center gap-2 text-[rgb(93,135,255)] font-bold text-sm">
                <Megaphone class="w-4 h-4" />
                <span>Pengumuman Terbaru</span>
            </div>
            <div class="space-y-3">
                <div v-for="item in announcements" :key="item.id" class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 space-y-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-semibold text-slate-900 text-sm">{{ item.title }}</h4>
                        <span v-if="item.is_pinned" class="text-[10px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-bold">Pinned</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ item.content }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Data Statistik Jurnal -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2 text-slate-900 font-bold text-base">
                        <BookOpen class="w-5 h-5 text-[rgb(93,135,255)]" />
                        <span>Data Statistik Jurnal</span>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-[rgb(93,135,255)]">
                        Total: {{ journalStats.total }} Kegiatan
                    </span>
                </div>

                <div class="p-3 bg-blue-50 rounded-xl border border-blue-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-700">Total Jurnal Kegiatan Diisi:</span>
                    <span class="text-xl font-bold text-[rgb(93,135,255)]">{{ journalStats.total }}</span>
                </div>

                <div class="p-3 rounded-xl flex items-center justify-between text-xs font-medium"
                     :class="journalStats.today_submitted ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200'">
                    <span class="flex items-center gap-1.5">
                        <CheckCircle2 v-if="journalStats.today_submitted" class="w-4 h-4 text-emerald-600" />
                        <AlertCircle v-else class="w-4 h-4 text-amber-600" />
                        Status Jurnal Hari Ini
                    </span>
                    <span class="font-bold">{{ journalStats.today_submitted ? 'Sudah Mengisi' : 'Belum Mengisi' }}</span>
                </div>
            </div>

            <!-- Data Absensi -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2 text-slate-900 font-bold text-base">
                        <CalendarCheck class="w-5 h-5 text-[rgb(93,135,255)]" />
                        <span>Data Absensi</span>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-[rgb(93,135,255)]">
                        Total: {{ attendanceStats.total }} Absensi
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                        <p class="text-[11px] text-emerald-700 font-medium">Hadir</p>
                        <p class="text-xl font-bold text-emerald-800 mt-1">{{ attendanceStats.hadir }}</p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-100">
                        <p class="text-[11px] text-amber-700 font-medium">Izin & Sakit</p>
                        <p class="text-xl font-bold text-amber-800 mt-1">{{ attendanceStats.izin_sakit }}</p>
                    </div>
                    <div class="p-3 bg-rose-50 rounded-xl border border-rose-100">
                        <p class="text-[11px] text-rose-700 font-medium">Alpha</p>
                        <p class="text-xl font-bold text-rose-800 mt-1">{{ attendanceStats.alpha }}</p>
                    </div>
                </div>

                <div class="p-3 rounded-xl flex items-center justify-between text-xs font-medium bg-slate-50 border border-slate-200">
                    <span>Jam Masuk Hari Ini:</span>
                    <span class="font-bold text-slate-900">{{ attendanceStats.today_attendance?.time_in || 'Belum Absen' }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
