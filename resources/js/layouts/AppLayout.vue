<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    BookOpen,
    CalendarCheck,
    Sparkles,
    Users,
    CheckCircle2,
    FileText,
    ClipboardList,
    Clock,
    Award,
    Megaphone,
    LogOut,
    Menu,
    X,
    UserCheck,
    FolderKanban,
    Calendar,
    Globe,
} from '@lucide/vue';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
    DialogFooter,
} from '@/components/ui/dialog';

const page = usePage();
const user = page.props.auth?.user as any;
const isSidebarOpen = ref(false);
const showLogoutDialog = ref(false);

const closeSidebar = () => {
    isSidebarOpen.value = false;
};

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

const confirmLogout = () => {
    showLogoutDialog.value = false;
    router.post('/logout');
};
</script>

<template>
    <div
        class="flex min-h-screen flex-col bg-white font-sans text-zinc-900 antialiased selection:bg-zinc-950 selection:text-white md:flex-row"
    >
        <!-- Backdrop Overlay untuk Mobile Sidebar -->
        <div
            v-if="isSidebarOpen"
            @click="closeSidebar"
            class="backdrop-blur-2xs fixed inset-0 z-40 bg-black/40 transition-opacity duration-300 md:hidden"
        ></div>

        <!-- Sidebar Navigation (Monochrome Black & White) -->
        <aside
            :class="[
                'fixed inset-y-0 left-0 z-50 flex w-64 flex-col justify-between border-r border-zinc-200 bg-white transition-transform duration-300 ease-in-out md:static md:translate-x-0',
                isSidebarOpen
                    ? 'translate-x-0 shadow-2xl'
                    : '-translate-x-full',
            ]"
        >
            <div class="flex h-full flex-col">
                <!-- App Header Logo (Clean Minimalist Typography) -->
                <div
                    class="flex h-16 items-center justify-between border-b border-zinc-200 px-6"
                >
                    <Link href="/" class="group flex items-center">
                        <span
                            class="text-xl font-extrabold tracking-tight text-zinc-950"
                        >
                            SIPKL<span class="text-zinc-950">.</span>
                        </span>
                    </Link>
                    <!-- Close button in mobile view -->
                    <button
                        @click="closeSidebar"
                        class="rounded-lg p-1.5 text-zinc-500 transition-colors hover:bg-zinc-100 hover:text-zinc-950 md:hidden"
                        aria-label="Tutup Menu"
                    >
                        <X class="h-5 w-5" />
                    </button>
                </div>

                <!-- Nav Menu Scrollable -->
                <div class="flex-1 space-y-6 overflow-y-auto px-4 py-4">
                    <!-- User Profile Quick Card (Clean Monochrome) -->
                    <div
                        class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-zinc-50 p-3.5"
                    >
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-zinc-950 text-xs font-bold text-white shadow-2xs"
                        >
                            {{
                                user?.name
                                    ? user.name.charAt(0).toUpperCase()
                                    : 'U'
                            }}
                        </div>
                        <div class="space-y-1 truncate">
                            <p
                                class="truncate text-xs leading-none font-bold text-zinc-950"
                            >
                                {{ user?.name }}
                            </p>
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span
                                    class="inline-block rounded-md bg-zinc-200/80 px-2 py-0.5 text-[10px] font-semibold text-zinc-800 capitalize"
                                >
                                    {{
                                        user?.role === 'admin'
                                            ? 'Administrator'
                                            : 'Siswa PKL'
                                    }}
                                </span>
                                <span
                                    v-if="user?.profile?.division_name"
                                    class="inline-block max-w-28 truncate rounded-md bg-zinc-950 px-2 py-0.5 text-[10px] font-semibold text-white"
                                >
                                    {{ user.profile.division_name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- SISWA PKL MENU -->
                    <template v-if="user?.role === 'siswa_pkl'">
                        <div class="space-y-1">
                            <p
                                class="px-3 text-[10px] font-semibold tracking-widest text-zinc-400 uppercase"
                            >
                                Main Navigation
                            </p>
                            <Link
                                @click="closeSidebar"
                                href="/dashboard"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url === '/dashboard'
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <LayoutDashboard class="h-4 w-4" />
                                <span>Dashboard</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/jurnal"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/jurnal')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <BookOpen class="h-4 w-4" />
                                <span>Jurnal Kegiatan</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/absensi"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/absensi')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <CalendarCheck class="h-4 w-4" />
                                <span>Absensi</span>
                            </Link>
                        </div>

                        <div class="space-y-1 pt-2">
                            <p
                                class="px-3 text-[10px] font-semibold tracking-widest text-zinc-400 uppercase"
                            >
                                Lainnya
                            </p>
                            <Link
                                @click="closeSidebar"
                                href="/picket-schedule"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/picket-schedule')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Calendar class="h-4 w-4" />
                                <span>Jadwal Piket</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/picket-report"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/picket-report')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Sparkles class="h-4 w-4" />
                                <span>Laporan Piket</span>
                            </Link>
                        </div>
                    </template>

                    <!-- ADMIN MENU -->
                    <template v-if="user?.role === 'admin'">
                        <div class="space-y-1">
                            <p
                                class="px-3 text-[10px] font-semibold tracking-widest text-zinc-400 uppercase"
                            >
                                Admin Overview
                            </p>
                            <Link
                                @click="closeSidebar"
                                href="/admin/dashboard"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url === '/admin/dashboard'
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <LayoutDashboard class="h-4 w-4" />
                                <span>Dashboard Admin</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/approvals"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/approvals') ||
                                    $page.url.startsWith('/admin/approval')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <UserCheck class="h-4 w-4" />
                                <span>Approval Pendaftaran</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/students"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/students')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Users class="h-4 w-4" />
                                <span>Data Siswa PKL</span>
                            </Link>
                        </div>

                        <div class="space-y-1 pt-2">
                            <p
                                class="px-3 text-[10px] font-semibold tracking-widest text-zinc-400 uppercase"
                            >
                                Operasional Harian
                            </p>
                            <Link
                                @click="closeSidebar"
                                href="/admin/attendances"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/attendances')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <ClipboardList class="h-4 w-4" />
                                <span>Rekap Absensi</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/journals"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/journals')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <BookOpen class="h-4 w-4" />
                                <span>Verifikasi Jurnal</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/leave-requests"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith(
                                        '/admin/leave-requests',
                                    ) || $page.url.startsWith('/admin/leave')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <FileText class="h-4 w-4" />
                                <span>Pengajuan Izin/Sakit</span>
                            </Link>
                        </div>

                        <div class="space-y-1 pt-2">
                            <p
                                class="px-3 text-[10px] font-semibold tracking-widest text-zinc-400 uppercase"
                            >
                                Manajemen System
                            </p>
                            <Link
                                @click="closeSidebar"
                                href="/admin/master-data"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/master-data')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <FolderKanban class="h-4 w-4" />
                                <span>Master Data</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/picket"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/picket')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Sparkles class="h-4 w-4" />
                                <span>Kelola Piket</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/grades"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/grades')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Award class="h-4 w-4" />
                                <span>Penilaian & Sertifikat</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/announcements"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/announcements')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Megaphone class="h-4 w-4" />
                                <span>Broadcast Pengumuman</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/settings"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/settings')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Clock class="h-4 w-4" />
                                <span>Jam Operasional</span>
                            </Link>

                            <Link
                                @click="closeSidebar"
                                href="/admin/landing-cms"
                                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-xs font-medium transition-all"
                                :class="
                                    $page.url.startsWith('/admin/landing-cms')
                                        ? 'bg-zinc-950 font-semibold text-white shadow-xs'
                                        : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950'
                                "
                            >
                                <Globe class="h-4 w-4" />
                                <span>Kelola Landing Page</span>
                            </Link>
                        </div>
                    </template>
                </div>

                <!-- Sidebar Footer & Logout -->
                <div class="border-t border-zinc-200 p-4">
                    <button
                        type="button"
                        @click="showLogoutDialog = true"
                        class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-xs font-semibold text-zinc-700 transition-all hover:bg-zinc-950 hover:text-white"
                    >
                        <LogOut class="h-3.5 w-3.5" />
                        <span>Keluar Sistem</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content Viewport -->
        <main class="flex min-w-0 flex-1 flex-col overflow-y-auto bg-white">
            <!-- Topbar Header (Synced with Hamburger Toggle on Left for Mobile) -->
            <header
                class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-zinc-200 bg-white px-4 sm:px-6"
            >
                <div class="flex items-center gap-3">
                    <!-- Hamburger Button on Topbar (Left aligned with Brand for Mobile) -->
                    <button
                        @click="toggleSidebar"
                        class="rounded-lg border border-zinc-200 p-2 text-zinc-700 transition-colors hover:bg-zinc-100 hover:text-zinc-950 md:hidden"
                        aria-label="Buka Menu Sidebar"
                    >
                        <Menu class="h-5 w-5" />
                    </button>

                    <div class="flex flex-col">
                        <h2
                            class="text-sm leading-none font-bold tracking-tight text-zinc-950 sm:text-base"
                        >
                            Sistem Monitoring PKL
                        </h2>
                        <p
                            class="mt-0.5 hidden text-[11px] font-medium text-zinc-500 sm:block"
                        >
                            Platform Manajemen Absensi & Jurnal Digital
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2.5 pl-2">
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-950 text-xs font-bold text-white shadow-2xs"
                        >
                            {{
                                user?.name
                                    ? user.name.charAt(0).toUpperCase()
                                    : 'U'
                            }}
                        </div>
                        <div class="hidden flex-col text-left sm:flex">
                            <span
                                class="max-w-32 truncate text-xs leading-none font-bold text-zinc-950"
                                >{{ user?.name }}</span
                            >
                            <span
                                class="mt-0.5 text-[10px] font-medium text-zinc-500 capitalize"
                                >{{
                                    user?.role === 'admin'
                                        ? 'Administrator'
                                        : 'Siswa PKL'
                                }}</span
                            >
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body Slot -->
            <div
                class="mx-auto min-h-[calc(100vh-4rem)] w-full max-w-7xl space-y-6 bg-white p-4 sm:p-6"
            >
                <!-- Flash Notification Banner -->
                <div
                    v-if="$page.props.flash?.success"
                    class="flex items-center justify-between rounded-xl bg-zinc-900 p-3.5 text-xs font-medium text-white shadow-2xs"
                >
                    <div class="flex items-center gap-2">
                        <CheckCircle2 class="h-4 w-4 text-emerald-400" />
                        <span>{{ $page.props.flash.success }}</span>
                    </div>
                </div>

                <div
                    v-if="
                        $page.props.errors &&
                        Object.keys($page.props.errors).length > 0
                    "
                    class="space-y-1 rounded-xl border border-rose-200 bg-rose-50 p-3.5 text-xs font-medium text-rose-800"
                >
                    <p class="font-semibold text-rose-900">Perhatian:</p>
                    <ul class="list-inside list-disc space-y-0.5 text-[11px]">
                        <li v-for="(err, key) in $page.props.errors" :key="key">
                            {{ err }}
                        </li>
                    </ul>
                </div>

                <slot />
            </div>
        </main>

        <!-- Dialog Konfirmasi Logout (Shadcn B&W Modal) -->
        <Dialog v-model:open="showLogoutDialog">
            <DialogContent
                class="max-w-md rounded-2xl border-zinc-200 bg-white p-6 text-zinc-950"
            >
                <DialogHeader class="space-y-2 text-left">
                    <div
                        class="mb-1 flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-100 text-zinc-950"
                    >
                        <LogOut class="h-5 w-5" />
                    </div>
                    <DialogTitle class="text-lg font-bold text-zinc-950">
                        Konfirmasi Keluar
                    </DialogTitle>
                    <DialogDescription
                        class="text-xs leading-relaxed text-zinc-500"
                    >
                        Apakah Anda yakin ingin keluar dari akun sistem SIPKL?
                        Anda perlu memasukkan kredensial login untuk masuk
                        kembali.
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter
                    class="mt-6 flex flex-row items-center justify-end gap-2.5"
                >
                    <button
                        type="button"
                        @click="showLogoutDialog = false"
                        class="h-10 cursor-pointer rounded-xl border border-zinc-200 bg-white px-4.5 text-xs font-semibold text-zinc-900 shadow-xs transition-all hover:bg-zinc-50 active:scale-95"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        @click="confirmLogout"
                        class="h-10 cursor-pointer rounded-xl bg-rose-600 px-4.5 text-xs font-semibold text-white shadow-xs transition-all hover:bg-rose-700 active:scale-95"
                    >
                        Ya, Keluar Akun
                    </button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </div>
</template>
