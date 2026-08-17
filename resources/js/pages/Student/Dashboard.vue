<script setup lang="ts">
import {
    BookOpen,
    CalendarCheck,
    CheckCircle2,
    Clock,
    Megaphone,
    AlertCircle,
} from '@lucide/vue';

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
        <!-- Welcome Hero Banner (Monochrome Minimalist) -->
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-800 bg-zinc-950 p-6 text-white shadow-xs md:flex-row md:items-center"
        >
            <div class="space-y-1.5">
                <div class="flex flex-wrap items-center gap-2">
                    <h1
                        class="text-xl font-bold tracking-tight text-white sm:text-2xl"
                    >
                        Selamat Datang, {{ username }}!
                    </h1>
                    <span
                        v-if="user?.profile?.division_name"
                        class="rounded-full bg-white px-2.5 py-0.5 text-xs font-semibold text-zinc-950 shadow-2xs"
                    >
                        {{ user.profile.division_name }}
                    </span>
                </div>
                <p class="text-xs text-zinc-400 sm:text-sm">
                    Selamat beraktivitas di Portal Monitoring PKL. Tetap
                    disiplin dan jaga kesehatan.
                </p>
            </div>
            <div
                class="flex shrink-0 items-center gap-2 self-start rounded-xl border border-zinc-800 bg-zinc-900 px-3.5 py-2 text-xs font-medium text-zinc-300 md:self-auto"
            >
                <Clock class="h-4 w-4 text-zinc-400" />
                <span
                    >Sesi:
                    {{
                        user?.profile?.session_type === 'full_day'
                            ? 'Full Day'
                            : user?.profile?.session_type || 'Reguler'
                    }}</span
                >
            </div>
        </div>

        <!-- Announcement Board -->
        <div
            v-if="announcements && announcements.length > 0"
            class="space-y-3 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <div
                class="flex items-center gap-2 text-sm font-bold text-zinc-950"
            >
                <Megaphone class="h-4 w-4 text-zinc-900" />
                <span>Pengumuman Terbaru</span>
            </div>
            <div class="space-y-3">
                <div
                    v-for="item in announcements"
                    :key="item.id"
                    class="space-y-1 rounded-xl border border-zinc-100 bg-zinc-50 p-3.5"
                >
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-semibold text-zinc-950">
                            {{ item.title }}
                        </h4>
                        <span
                            v-if="item.is_pinned"
                            class="rounded-full bg-zinc-950 px-2 py-0.5 text-[10px] font-bold text-white"
                            >Pinned</span
                        >
                    </div>
                    <p class="text-xs leading-relaxed text-zinc-600">
                        {{ item.content }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <!-- Data Statistik Jurnal -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-100 pb-3"
                >
                    <div
                        class="flex items-center gap-2 text-sm font-bold text-zinc-950 sm:text-base"
                    >
                        <BookOpen class="h-4 w-4 text-zinc-900 sm:h-5 sm:w-5" />
                        <span>Data Statistik Jurnal</span>
                    </div>
                    <span
                        class="rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-900"
                    >
                        Total: {{ journalStats.total }} Kegiatan
                    </span>
                </div>

                <div
                    class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50 p-4"
                >
                    <span class="text-xs font-semibold text-zinc-600"
                        >Total Jurnal Diisi</span
                    >
                    <span class="text-2xl font-bold text-zinc-950">{{
                        journalStats.total
                    }}</span>
                </div>

                <div
                    class="flex items-center justify-between rounded-xl p-3 text-xs font-medium"
                    :class="
                        journalStats.today_submitted
                            ? 'bg-zinc-950 text-white'
                            : 'border border-zinc-200 bg-zinc-50 text-zinc-800'
                    "
                >
                    <span>Status Jurnal Hari Ini:</span>
                    <span class="flex items-center gap-1.5 font-semibold">
                        <CheckCircle2
                            v-if="journalStats.today_submitted"
                            class="h-4 w-4 text-emerald-400"
                        />
                        <AlertCircle v-else class="h-4 w-4 text-amber-500" />
                        <span>{{
                            journalStats.today_submitted
                                ? 'Sudah Mengisi'
                                : 'Belum Mengisi'
                        }}</span>
                    </span>
                </div>
            </div>

            <!-- Data Statistik Presensi -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-100 pb-3"
                >
                    <div
                        class="flex items-center gap-2 text-sm font-bold text-zinc-950 sm:text-base"
                    >
                        <CalendarCheck
                            class="h-4 w-4 text-zinc-900 sm:h-5 sm:w-5"
                        />
                        <span>Data Statistik Presensi</span>
                    </div>
                    <span
                        class="rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-900"
                    >
                        Total: {{ attendanceStats.total }} Hari
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center">
                    <div
                        class="space-y-0.5 rounded-xl border border-zinc-100 bg-zinc-50 p-3"
                    >
                        <div class="text-xl font-bold text-zinc-950">
                            {{ attendanceStats.hadir }}
                        </div>
                        <div class="text-[11px] font-medium text-zinc-500">
                            Hadir
                        </div>
                    </div>
                    <div
                        class="space-y-0.5 rounded-xl border border-zinc-100 bg-zinc-50 p-3"
                    >
                        <div class="text-xl font-bold text-zinc-950">
                            {{ attendanceStats.izin_sakit }}
                        </div>
                        <div class="text-[11px] font-medium text-zinc-500">
                            Izin / Sakit
                        </div>
                    </div>
                    <div
                        class="space-y-0.5 rounded-xl border border-zinc-100 bg-zinc-50 p-3"
                    >
                        <div class="text-xl font-bold text-zinc-950">
                            {{ attendanceStats.alpha }}
                        </div>
                        <div class="text-[11px] font-medium text-zinc-500">
                            Alpha
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50 p-3 text-xs"
                >
                    <span class="font-medium text-zinc-600"
                        >Presensi Hari Ini:</span
                    >
                    <span
                        v-if="attendanceStats.today_attendance"
                        class="flex items-center gap-1 font-bold text-zinc-950"
                    >
                        <CheckCircle2 class="h-4 w-4 text-emerald-600" />
                        <span
                            >{{ attendanceStats.today_attendance.status }} ({{
                                attendanceStats.today_attendance.check_in_time
                            }})</span
                        >
                    </span>
                    <span v-else class="font-medium text-zinc-500"
                        >Belum melakukan check-in</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>
