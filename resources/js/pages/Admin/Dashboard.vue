<script setup lang="ts">
import { Users, UserCheck, BookOpen, ClipboardList, FileText, ArrowUpRight } from '@lucide/vue';
import { Link } from '@inertiajs/vue3';

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
        <!-- Header section -->
        <div class="bg-gradient-to-tr from-[rgb(93,135,255)] to-blue-500 rounded-2xl p-6 text-white shadow-xl shadow-blue-500/15">
            <h1 class="text-2xl font-bold tracking-tight">Dashboard Administrator PKL 🛡️</h1>
            <p class="text-sm text-blue-100 mt-1">Kelola pendaftaran siswa, rekap absensi & jurnal, serta pengaturan operasional sistem.</p>
        </div>

        <!-- Stats Overview Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-slate-500">
                    <span class="text-xs font-semibold">Siswa Aktif</span>
                    <Users class="w-4 h-4 text-[rgb(93,135,255)]" />
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ stats.total_students }}</p>
                <p class="text-[10px] text-slate-400">Akun Disetujui</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-amber-600">
                    <span class="text-xs font-semibold">Pending Approval</span>
                    <UserCheck class="w-4 h-4 text-amber-500" />
                </div>
                <p class="text-2xl font-bold text-amber-600">{{ stats.pending_approvals }}</p>
                <p class="text-[10px] text-slate-400">Pendaftar Baru</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-blue-600">
                    <span class="text-xs font-semibold">Jurnal Hari Ini</span>
                    <BookOpen class="w-4 h-4 text-blue-500" />
                </div>
                <p class="text-2xl font-bold text-slate-900">{{ stats.today_journals }}</p>
                <p class="text-[10px] text-slate-400">Entry Masuk</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-emerald-600">
                    <span class="text-xs font-semibold">Presensi Hari Ini</span>
                    <ClipboardList class="w-4 h-4 text-emerald-500" />
                </div>
                <p class="text-2xl font-bold text-emerald-600">{{ stats.today_attendances }}</p>
                <p class="text-[10px] text-slate-400">Siswa Hadir</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
                <div class="flex items-center justify-between text-rose-600">
                    <span class="text-xs font-semibold">Izin Pending</span>
                    <FileText class="w-4 h-4 text-rose-500" />
                </div>
                <p class="text-2xl font-bold text-rose-600">{{ stats.pending_leaves }}</p>
                <p class="text-[10px] text-slate-400">Menunggu Review</p>
            </div>
        </div>

        <!-- Content Grid (Approvals Queue & Recent Activity) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pending Approvals Queue -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <UserCheck class="w-4 h-4 text-amber-500" />
                        Antrian Approval Pendaftaran
                    </h3>
                    <Link href="/admin/approvals" class="text-xs text-[rgb(93,135,255)] font-semibold hover:underline flex items-center gap-1">
                        <span>Lihat Semua</span>
                        <ArrowUpRight class="w-3.5 h-3.5" />
                    </Link>
                </div>

                <div class="space-y-3">
                    <div v-for="u in pendingUsers" :key="u.id" class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ u.name }}</p>
                            <p class="text-[11px] text-slate-500">{{ u.profile?.school_name || 'Sekolah N/A' }} • {{ u.profile?.major_name || 'Jurusan N/A' }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">
                            Pending
                        </span>
                    </div>
                    <p v-if="!pendingUsers || pendingUsers.length === 0" class="text-xs text-slate-400 text-center py-4">
                        Tidak ada antrian pendaftar baru.
                    </p>
                </div>
            </div>

            <!-- Recent Journals Queue -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                        <BookOpen class="w-4 h-4 text-[rgb(93,135,255)]" />
                        Jurnal Kegiatan Terbaru
                    </h3>
                    <Link href="/admin/journals" class="text-xs text-[rgb(93,135,255)] font-semibold hover:underline flex items-center gap-1">
                        <span>Rekap Lengkap</span>
                        <ArrowUpRight class="w-3.5 h-3.5" />
                    </Link>
                </div>

                <div class="space-y-3">
                    <div v-for="j in recentJournals" :key="j.id" class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ j.title }}</p>
                            <p class="text-[11px] text-slate-500">Oleh: {{ j.user?.name }} • {{ j.date }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold"
                              :class="j.status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'">
                            {{ j.status }}
                        </span>
                    </div>
                    <p v-if="!recentJournals || recentJournals.length === 0" class="text-xs text-slate-400 text-center py-4">
                        Belum ada jurnal yang masuk.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

