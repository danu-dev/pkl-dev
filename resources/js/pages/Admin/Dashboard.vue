<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Users,
    UserCheck,
    BookOpen,
    ClipboardList,
    FileText,
    ArrowUpRight,
} from '@lucide/vue';

defineProps<{
    stats: {
        total_students: number;
        pending_approvals: number;
        today_journals: number;
        today_attendances: number;
        pending_leaves: number;
    };
    pendingUsers: any[];
    recentJournals: any[];
}>();
</script>

<template>
    <div class="space-y-6">
        <!-- Header section (Monochrome Modern B&W) -->
        <div
            class="rounded-2xl border border-zinc-800 bg-zinc-950 p-6 text-white shadow-xs"
        >
            <h1 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                Dashboard Administrator PKL 🛡️
            </h1>
            <p class="mt-1 text-xs text-zinc-400 sm:text-sm">
                Kelola pendaftaran siswa, rekap absensi & jurnal, serta
                pengaturan operasional sistem.
            </p>
        </div>

        <!-- Stats Overview Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <div
                class="space-y-2 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div class="flex items-center justify-between text-zinc-500">
                    <span class="text-xs font-semibold">Siswa Aktif</span>
                    <Users class="h-4 w-4 text-zinc-900" />
                </div>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.total_students }}
                </p>
                <p class="text-[10px] text-zinc-400">Akun Disetujui</p>
            </div>

            <div
                class="space-y-2 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div class="flex items-center justify-between text-zinc-700">
                    <span class="text-xs font-semibold">Pending Approval</span>
                    <UserCheck class="h-4 w-4 text-zinc-900" />
                </div>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.pending_approvals }}
                </p>
                <p class="text-[10px] text-zinc-400">Pendaftar Baru</p>
            </div>

            <div
                class="space-y-2 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div class="flex items-center justify-between text-zinc-700">
                    <span class="text-xs font-semibold">Jurnal Hari Ini</span>
                    <BookOpen class="h-4 w-4 text-zinc-900" />
                </div>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.today_journals }}
                </p>
                <p class="text-[10px] text-zinc-400">Entry Masuk</p>
            </div>

            <div
                class="space-y-2 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div class="flex items-center justify-between text-zinc-700">
                    <span class="text-xs font-semibold">Presensi Hari Ini</span>
                    <ClipboardList class="h-4 w-4 text-zinc-900" />
                </div>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.today_attendances }}
                </p>
                <p class="text-[10px] text-zinc-400">Siswa Hadir</p>
            </div>

            <div
                class="space-y-2 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div class="flex items-center justify-between text-zinc-700">
                    <span class="text-xs font-semibold">Izin Pending</span>
                    <FileText class="h-4 w-4 text-zinc-900" />
                </div>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.pending_leaves }}
                </p>
                <p class="text-[10px] text-zinc-400">Menunggu Review</p>
            </div>
        </div>

        <!-- Content Grid (Approvals Queue & Recent Activity) -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Pending Approvals Queue -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-100 pb-3"
                >
                    <h3
                        class="flex items-center gap-2 text-sm font-bold text-zinc-950"
                    >
                        <UserCheck class="h-4 w-4 text-zinc-900" />
                        <span>Antrean Registrasi Siswa</span>
                    </h3>
                    <Link
                        href="/admin/approval"
                        class="flex items-center gap-1 text-xs font-semibold text-zinc-950 hover:underline"
                    >
                        <span>Lihat Semua</span>
                        <ArrowUpRight class="h-3.5 w-3.5" />
                    </Link>
                </div>

                <div
                    v-if="pendingUsers && pendingUsers.length > 0"
                    class="space-y-3"
                >
                    <div
                        v-for="userItem in pendingUsers"
                        :key="userItem.id"
                        class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50 p-3.5"
                    >
                        <div class="space-y-0.5">
                            <h4 class="text-xs font-bold text-zinc-900">
                                {{ userItem.name }}
                            </h4>
                            <p class="text-[11px] text-zinc-500">
                                {{ userItem.school_name }} •
                                {{ userItem.major_name }}
                            </p>
                        </div>
                        <Link
                            href="/admin/approval"
                            class="rounded-lg bg-zinc-950 px-3 py-1.5 text-[11px] font-semibold text-white transition-colors hover:bg-zinc-800"
                        >
                            Review
                        </Link>
                    </div>
                </div>
                <div v-else class="py-8 text-center text-xs text-zinc-400">
                    Tidak ada antrean pendaftar baru.
                </div>
            </div>

            <!-- Recent Journals -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-100 pb-3"
                >
                    <h3
                        class="flex items-center gap-2 text-sm font-bold text-zinc-950"
                    >
                        <BookOpen class="h-4 w-4 text-zinc-900" />
                        <span>Jurnal Terbaru Masuk</span>
                    </h3>
                    <Link
                        href="/admin/journals"
                        class="flex items-center gap-1 text-xs font-semibold text-zinc-950 hover:underline"
                    >
                        <span>Lihat Semua</span>
                        <ArrowUpRight class="h-3.5 w-3.5" />
                    </Link>
                </div>

                <div
                    v-if="recentJournals && recentJournals.length > 0"
                    class="space-y-3"
                >
                    <div
                        v-for="journal in recentJournals"
                        :key="journal.id"
                        class="space-y-1 rounded-xl border border-zinc-100 bg-zinc-50 p-3.5"
                    >
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold text-zinc-900">
                                {{ journal.student_name }}
                            </h4>
                            <span class="font-mono text-[10px] text-zinc-400">{{
                                journal.created_at
                            }}</span>
                        </div>
                        <p class="line-clamp-1 text-xs text-zinc-600">
                            {{ journal.activity_description }}
                        </p>
                    </div>
                </div>
                <div v-else class="py-8 text-center text-xs text-zinc-400">
                    Belum ada entri jurnal terbaru hari ini.
                </div>
            </div>
        </div>
    </div>
</template>
