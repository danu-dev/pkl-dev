<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
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
    Globe
} from '@lucide/vue';
import { ref } from 'vue';

const page = usePage();
const user = page.props.auth?.user as any;
const isSidebarOpen = ref(false);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 font-sans text-slate-800 flex flex-col md:flex-row">
        <!-- Sidebar Mobile Toggle -->
        <div class="md:hidden flex items-center justify-between bg-white px-4 py-3 border-b border-slate-200">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl overflow-hidden shadow-md shadow-blue-500/20">
                    <img src="/images/app-icon.png" alt="SIPKL" class="w-full h-full object-contain" />
                </div>
                <span class="font-black text-slate-900 tracking-tight text-base">SIPKL App</span>
            </div>
            <button @click="toggleSidebar" class="p-2 text-slate-600 hover:text-slate-900">
                <Menu v-if="!isSidebarOpen" class="w-6 h-6" />
                <X v-else class="w-6 h-6" />
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <aside 
            :class="[
                'fixed md:static inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col justify-between transition-transform duration-300 ease-in-out md:translate-x-0',
                isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
            ]"
        >
            <div class="flex flex-col h-full">
                <!-- App Header Logo -->
                <div class="p-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl overflow-hidden shadow-md shadow-blue-500/20 shrink-0">
                        <img src="/images/app-icon.png" alt="SIPKL" class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <h1 class="font-extrabold text-slate-900 leading-tight text-base tracking-tight">SIPKL System</h1>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Portal Monitoring PKL</p>
                    </div>
                </div>

                <!-- Nav Menu Scrollable -->
                <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">
                    <!-- User Profile Quick Card -->
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-[rgb(93,135,255)] text-white flex items-center justify-center font-semibold text-sm">
                            {{ user?.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                        </div>
                        <div class="truncate">
                            <p class="text-xs font-bold text-slate-900 truncate flex items-center gap-1">
                                <span>{{ user?.name }}</span>
                            </p>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full capitalize"
                                      :class="user?.role === 'admin' ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600'">
                                    {{ user?.role === 'admin' ? 'Administrator' : 'Siswa PKL' }}
                                </span>
                                <span v-if="user?.profile?.division_name" class="inline-block text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-50 text-[rgb(93,135,255)]">
                                    {{ user.profile.division_name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- SISWA PKL MENU -->
                    <template v-if="user?.role === 'siswa_pkl'">
                        <div class="space-y-1">
                            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Main Navigation</p>
                            <Link 
                                href="/dashboard" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url === '/dashboard' ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <LayoutDashboard class="w-4 h-4" />
                                <span>Dashboard</span>
                            </Link>

                            <Link 
                                href="/jurnal" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/jurnal') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <BookOpen class="w-4 h-4" />
                                <span>Jurnal Kegiatan</span>
                            </Link>

                            <Link 
                                href="/absensi" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/absensi') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <CalendarCheck class="w-4 h-4" />
                                <span>Absensi</span>
                            </Link>
                        </div>

                        <div class="space-y-1">
                            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Lainnya</p>
                            <Link 
                                href="/picket-schedule" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/picket-schedule') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Calendar class="w-4 h-4" />
                                <span>Jadwal Piket</span>
                            </Link>

                            <Link 
                                href="/picket-report" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/picket-report') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Sparkles class="w-4 h-4" />
                                <span>Laporan Piket</span>
                            </Link>
                        </div>
                    </template>

                    <!-- ADMIN MENU -->
                    <template v-if="user?.role === 'admin'">
                        <div class="space-y-1">
                            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Admin Overview</p>
                            <Link 
                                href="/admin/dashboard" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url === '/admin/dashboard' ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <LayoutDashboard class="w-4 h-4" />
                                <span>Dashboard Admin</span>
                            </Link>

                            <Link 
                                href="/admin/approvals" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/approvals') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <UserCheck class="w-4 h-4" />
                                <span>Approval Pendaftaran</span>
                            </Link>

                            <Link 
                                href="/admin/students" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/students') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Users class="w-4 h-4" />
                                <span>Master Semua Siswa</span>
                            </Link>
                        </div>

                        <div class="space-y-1">
                            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rekap & Monitoring</p>
                            <Link 
                                href="/admin/journals" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/journals') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <BookOpen class="w-4 h-4" />
                                <span>Rekap Jurnal</span>
                            </Link>

                            <Link 
                                href="/admin/attendances" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/attendances') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <ClipboardList class="w-4 h-4" />
                                <span>Rekap Absensi</span>
                            </Link>

                            <Link 
                                href="/admin/leave-requests" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/leave-requests') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <FileText class="w-4 h-4" />
                                <span>Pengajuan Izin/Sakit</span>
                            </Link>
                        </div>

                        <div class="space-y-1">
                            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Manajemen System</p>
                            <Link 
                                href="/admin/master-data" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/master-data') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <FolderKanban class="w-4 h-4" />
                                <span>Master Data School/Batch</span>
                            </Link>

                            <Link 
                                href="/admin/picket" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/picket') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Sparkles class="w-4 h-4" />
                                <span>Kelola Piket</span>
                            </Link>

                            <Link 
                                href="/admin/grades" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/grades') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Award class="w-4 h-4" />
                                <span>Penilaian & Sertifikat</span>
                            </Link>

                            <Link 
                                href="/admin/announcements" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/announcements') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Megaphone class="w-4 h-4" />
                                <span>Broadcast Announcement</span>
                            </Link>

                            <Link 
                                href="/admin/settings" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/settings') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Clock class="w-4 h-4" />
                                <span>Jam Operasional</span>
                            </Link>

                            <Link 
                                href="/admin/landing-cms" 
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all"
                                :class="$page.url.startsWith('/admin/landing-cms') ? 'bg-blue-50 text-[rgb(93,135,255)] font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'"
                            >
                                <Globe class="w-4 h-4" />
                                <span>Kelola Landing Page</span>
                            </Link>
                        </div>
                    </template>
                </div>

                <!-- Sidebar Footer & Logout -->
                <div class="p-4 border-t border-slate-100">
                    <Link 
                        href="/logout" 
                        method="post" 
                        as="button"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium text-rose-600 bg-rose-50 hover:bg-rose-100 transition-all"
                    >
                        <LogOut class="w-4 h-4" />
                        <span>Keluar Sistem</span>
                    </Link>
                </div>
            </div>
        </aside>

        <!-- Main Content Viewport -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Topbar Header -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg tracking-tight">Sistem Monitoring PKL</h2>
                    <p class="text-xs text-slate-500 font-medium">Platform Manajemen Absensi & Jurnal PKL</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        System Online
                    </span>
                </div>
            </header>

            <!-- Page Body Slot -->
            <div class="p-6 max-w-7xl w-full mx-auto space-y-6">
                <!-- Flash Notification Banner -->
                <div v-if="$page.props.flash?.success" class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <CheckCircle2 class="w-5 h-5 text-emerald-600" />
                        <span>{{ $page.props.flash.success }}</span>
                    </div>
                </div>

                <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium space-y-1">
                    <p class="font-semibold text-rose-900">Perhatian:</p>
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        <li v-for="(err, key) in $page.props.errors" :key="key">{{ err }}</li>
                    </ul>
                </div>

                <slot />
            </div>
        </main>
    </div>
</template>
