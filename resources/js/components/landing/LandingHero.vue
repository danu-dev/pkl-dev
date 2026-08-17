<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    LayoutDashboard,
    Compass,
    Clock,
    BookOpen,
    Award,
    Check,
    Sparkles,
    Shield,
    FileCheck,
    CalendarCheck,
    ChevronRight,
    TrendingUp,
} from '@lucide/vue';
import { useMouseInElement, useWindowScroll, useRafFn } from '@vueuse/core';
import { ref, computed } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ContainerScroll } from '@/components/ui/container-scroll-animation';
import { FloatingPathsBackground } from '@/components/ui/floating-paths';

defineProps<{
    sections: Record<string, string>;
    isAuthenticated: boolean;
    userDashboardUrl: string;
}>();

// Parallax & Mouse Tracking with Multi-Layer Physics
const heroSectionRef = ref<HTMLElement | null>(null);
const { elementX, elementY, isOutside, elementWidth, elementHeight } =
    useMouseInElement(heroSectionRef);

const mouseNormalizedX = computed(() => {
    if (isOutside.value || elementWidth.value === 0) return 0;
    return (elementX.value / elementWidth.value - 0.5) * 2;
});

const mouseNormalizedY = computed(() => {
    if (isOutside.value || elementHeight.value === 0) return 0;
    return (elementY.value / elementHeight.value - 0.5) * 2;
});

const smoothMouseX = ref(0);
const smoothMouseY = ref(0);

useRafFn(() => {
    smoothMouseX.value += (mouseNormalizedX.value - smoothMouseX.value) * 0.07;
    smoothMouseY.value += (mouseNormalizedY.value - smoothMouseY.value) * 0.07;
});

const { y: scrollY } = useWindowScroll();

// Parallax Multi-Layer Transformations
const gridBackgroundStyle = computed(() => {
    const tx = smoothMouseX.value * 15;
    const ty = smoothMouseY.value * 15 + scrollY.value * 0.05;
    return {
        transform: `translate3d(${tx.toFixed(1)}px, ${ty.toFixed(1)}px, 0)`,
    };
});

const bgOrbLeftStyle = computed(() => {
    const tx = -smoothMouseX.value * 50;
    const ty = -smoothMouseY.value * 45 + scrollY.value * 0.18;
    return {
        transform: `translate3d(${tx.toFixed(1)}px, ${ty.toFixed(1)}px, 0)`,
    };
});

const bgOrbRightStyle = computed(() => {
    const tx = smoothMouseX.value * 60;
    const ty = smoothMouseY.value * 40 - scrollY.value * 0.14;
    return {
        transform: `translate3d(${tx.toFixed(1)}px, ${ty.toFixed(1)}px, 0)`,
    };
});

const bgOrbCenterStyle = computed(() => {
    const tx = smoothMouseX.value * 25;
    const ty = smoothMouseY.value * 25 + scrollY.value * 0.1;
    return {
        transform: `translate3d(${tx.toFixed(1)}px, ${ty.toFixed(1)}px, 0) scale(${1 + Math.abs(smoothMouseX.value) * 0.1})`,
    };
});

// Floating Badge 1 (Left Float)
const floatingBadgeLeftStyle = computed(() => {
    const tx = -smoothMouseX.value * 28;
    const ty = -smoothMouseY.value * 32 - scrollY.value * 0.08;
    return {
        transform: `translate3d(${tx.toFixed(1)}px, ${ty.toFixed(1)}px, 0)`,
    };
});

// Floating Badge 2 (Right Float)
const floatingBadgeRightStyle = computed(() => {
    const tx = smoothMouseX.value * 35;
    const ty = smoothMouseY.value * 26 - scrollY.value * 0.1;
    return {
        transform: `translate3d(${tx.toFixed(1)}px, ${ty.toFixed(1)}px, 0)`,
    };
});
</script>

<template>
    <FloatingPathsBackground
        id="beranda"
        ref="heroSectionRef"
        :position="1"
        class="relative border-b border-zinc-200 pt-8 pb-16 md:pt-14 md:pb-24"
    >
        <!-- Parallax Floating Ambient Gradient Glows (Layered) -->
        <div
            :style="bgOrbLeftStyle"
            class="pointer-events-none absolute -top-32 -left-32 h-[480px] w-[480px] rounded-full bg-gradient-to-br from-zinc-200/60 via-zinc-300/40 to-transparent blur-3xl transition-transform ease-out will-change-transform"
        ></div>
        <div
            :style="bgOrbRightStyle"
            class="pointer-events-none absolute top-1/4 -right-32 h-[500px] w-[500px] rounded-full bg-gradient-to-bl from-zinc-200/50 via-zinc-300/30 to-transparent blur-3xl transition-transform ease-out will-change-transform"
        ></div>
        <div
            :style="bgOrbCenterStyle"
            class="pointer-events-none absolute top-1/2 left-1/2 h-[600px] w-[600px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-radial from-zinc-200/30 via-zinc-100/10 to-transparent blur-2xl transition-transform ease-out will-change-transform"
        ></div>

        <!-- Parallax Dynamic Mesh Grid Background -->
        <div
            :style="gridBackgroundStyle"
            class="pointer-events-none absolute inset-[-50px] bg-[linear-gradient(to_right,#8080800d_1px,transparent_1px),linear-gradient(to_bottom,#8080800d_1px,transparent_1px)] bg-[size:28px_28px] transition-transform ease-out will-change-transform"
        ></div>

        <!-- Decorative Floating Geometric Elements on Parallax -->
        <div
            :style="floatingBadgeLeftStyle"
            class="pointer-events-none absolute top-24 left-8 z-20 hidden items-center gap-2.5 rounded-2xl border border-zinc-200/80 bg-white/90 px-4 py-2.5 shadow-xl backdrop-blur-md transition-transform ease-out will-change-transform lg:flex"
        >
            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl bg-zinc-950 text-white"
            >
                <Shield class="h-4 w-4" />
            </div>
            <div class="text-left">
                <div class="text-[11px] leading-tight font-bold text-zinc-900">
                    Presensi Valid
                </div>
                <div class="font-mono text-[9px] text-zinc-400">
                    100% Terverifikasi
                </div>
            </div>
        </div>

        <div
            :style="floatingBadgeRightStyle"
            class="pointer-events-none absolute top-32 right-8 z-20 hidden items-center gap-2.5 rounded-2xl border border-zinc-200/80 bg-white/90 px-4 py-2.5 shadow-xl backdrop-blur-md transition-transform ease-out will-change-transform lg:flex"
        >
            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-100 text-zinc-900"
            >
                <FileCheck class="h-4 w-4" />
            </div>
            <div class="text-left">
                <div class="text-[11px] leading-tight font-bold text-zinc-900">
                    Jurnal Harian
                </div>
                <div class="font-mono text-[9px] text-zinc-400">
                    Real-time Approval
                </div>
            </div>
        </div>

        <!-- Container Scroll Animation Wrapper -->
        <ContainerScroll class="z-10 px-4 sm:px-6 lg:px-8">
            <template #title>
                <div class="space-y-6">
                    <!-- Announcement Tag -->
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-zinc-300/80 bg-zinc-50/90 px-3.5 py-1 text-[11px] font-medium text-zinc-700 shadow-2xs backdrop-blur-xs"
                    >
                        <span
                            class="h-1.5 w-1.5 animate-ping rounded-full bg-emerald-500"
                        ></span>
                        <span>{{
                            sections.hero_badge ||
                            'Tahun Ajaran 2026/2027 • Pendaftaran & Monitoring Terintegrasi'
                        }}</span>
                    </div>

                    <!-- Main Hero Headline -->
                    <div class="mx-auto max-w-4xl space-y-4">
                        <h1
                            class="text-2xl leading-[1.18] font-bold tracking-tight text-zinc-950 sm:text-4xl sm:leading-[1.1] md:text-6xl lg:text-7xl"
                        >
                            {{
                                sections.hero_title ||
                                'Platform Monitoring & Jurnal PKL Digital Modern'
                            }}
                        </h1>
                        <p
                            class="mx-auto max-w-2xl px-2 text-xs leading-relaxed font-normal text-zinc-500 sm:px-0 sm:text-base md:text-lg"
                        >
                            {{
                                sections.hero_subtitle ||
                                'Kelola absensi harian presisi, logbook kegiatan digital, validasi mentor berkala, hingga rekapitulasi penilaian kompetensi dalam satu portal terpadu.'
                            }}
                        </p>
                    </div>

                    <!-- Action CTA Buttons -->
                    <div
                        class="flex flex-row items-center justify-center gap-2.5 pt-2 sm:gap-3"
                    >
                        <Link
                            :href="isAuthenticated ? userDashboardUrl : '/login'"
                        >
                            <Button
                                class="h-11 cursor-pointer gap-2 rounded-xl bg-zinc-950 px-4 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800 active:scale-95 sm:h-12 sm:px-6 sm:text-sm"
                            >
                                <component
                                    :is="
                                        isAuthenticated
                                            ? LayoutDashboard
                                            : ArrowRight
                                    "
                                    class="h-4 w-4 text-white"
                                />
                                <span>{{
                                    isAuthenticated
                                        ? 'Buka Dashboard'
                                        : 'Mulai Sekarang'
                                }}</span>
                            </Button>
                        </Link>
                        <a href="#prosedur">
                            <button
                                class="flex h-11 cursor-pointer items-center justify-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 text-xs font-semibold text-zinc-950 shadow-xs transition-all hover:border-zinc-300 hover:bg-zinc-50 active:scale-95 sm:h-12 sm:px-6 sm:text-sm"
                            >
                                <Compass class="h-4 w-4 text-zinc-950" />
                                <span>Eksplor Alur PKL</span>
                            </button>
                        </a>
                    </div>
                </div>
            </template>

            <!-- Card Content (Dashboard Mockup) -->
            <div class="flex h-full w-full flex-col bg-zinc-50">
                <!-- Browser / Window Header -->
                <div
                    class="flex items-center justify-between border-b border-zinc-200 bg-white px-4 py-3 text-xs text-zinc-400"
                >
                    <div class="flex items-center gap-1.5">
                        <span
                            class="h-2.5 w-2.5 rounded-full bg-rose-400/80"
                        ></span>
                        <span
                            class="h-2.5 w-2.5 rounded-full bg-amber-400/80"
                        ></span>
                        <span
                            class="h-2.5 w-2.5 rounded-full bg-emerald-400/80"
                        ></span>
                    </div>
                    <div
                        class="rounded-md border border-zinc-200/80 bg-zinc-100/80 px-4 py-1 font-mono text-[11px] text-zinc-600 shadow-2xs"
                    >
                        pkl-dev.vercel.app/dashboard
                    </div>
                    <div class="w-12"></div>
                </div>

                <!-- Inner Dashboard Showcase -->
                <div
                    class="flex flex-1 flex-col justify-between space-y-6 bg-white p-6 text-left sm:p-8 md:p-10"
                >
                    <div
                        class="flex flex-col justify-between gap-4 border-b border-zinc-100 pb-5 sm:flex-row sm:items-center"
                    >
                        <div>
                            <div class="flex items-center gap-2">
                                <h3
                                    class="text-base font-bold text-zinc-900 sm:text-xl"
                                >
                                    Portal Siswa Praktek Kerja Lapangan
                                </h3>
                                <Badge
                                    variant="secondary"
                                    class="hidden sm:inline-flex text-[10px] uppercase font-semibold"
                                >
                                    SIPKL v2.0
                                </Badge>
                            </div>
                            <p class="text-xs sm:text-sm text-zinc-500 mt-1">
                                Monitoring status kehadiran, logbook jurnal, dan catatan harian secara real-time
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <Badge
                                variant="outline"
                                class="border-emerald-200 bg-emerald-50/70 text-[11px] font-medium text-emerald-800"
                            >
                                <span
                                    class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"
                                ></span>
                                Status: Aktif Magang
                            </Badge>
                        </div>
                    </div>

                    <!-- Showcase Widgets -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div
                            class="space-y-3 rounded-2xl border border-zinc-200 bg-zinc-50/60 p-5 transition-colors hover:border-zinc-300"
                        >
                            <div
                                class="flex items-center justify-between text-xs font-medium text-zinc-500"
                            >
                                <span>Presensi Hari Ini</span>
                                <div class="p-1.5 rounded-lg bg-zinc-100 text-zinc-900">
                                    <Clock class="h-4 w-4" />
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-zinc-900">
                                07:42 WIB
                            </div>
                            <div
                                class="flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50/60 rounded-lg px-2.5 py-1 w-fit"
                            >
                                <Check
                                    class="h-3.5 w-3.5"
                                />
                                <span>Check-in Terverifikasi</span>
                            </div>
                        </div>

                        <div
                            class="space-y-3 rounded-2xl border border-zinc-200 bg-zinc-50/60 p-5 transition-colors hover:border-zinc-300"
                        >
                            <div
                                class="flex items-center justify-between text-xs font-medium text-zinc-500"
                            >
                                <span>Jurnal Harian</span>
                                <div class="p-1.5 rounded-lg bg-zinc-100 text-zinc-900">
                                    <BookOpen class="h-4 w-4" />
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-zinc-900">
                                18 / 20 Hari
                            </div>
                            <div
                                class="flex items-center gap-1.5 text-xs font-medium text-blue-700 bg-blue-50/60 rounded-lg px-2.5 py-1 w-fit"
                            >
                                <Check
                                    class="h-3.5 w-3.5"
                                />
                                <span>90% Terverifikasi Mentor</span>
                            </div>
                        </div>

                        <div
                            class="space-y-3 rounded-2xl border border-zinc-200 bg-zinc-50/60 p-5 transition-colors hover:border-zinc-300"
                        >
                            <div
                                class="flex items-center justify-between text-xs font-medium text-zinc-500"
                            >
                                <span>Grade Kompetensi</span>
                                <div class="p-1.5 rounded-lg bg-zinc-100 text-zinc-900">
                                    <Award class="h-4 w-4" />
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-zinc-900">
                                Grade A (94.5)
                            </div>
                            <div
                                class="flex items-center gap-1.5 text-xs font-medium text-amber-700 bg-amber-50/60 rounded-lg px-2.5 py-1 w-fit"
                            >
                                <Sparkles
                                    class="h-3.5 w-3.5"
                                />
                                <span>Kriteria Sangat Baik</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Mockup Row: Activity Progress / Summary Bar -->
                    <div class="rounded-2xl border border-zinc-200/80 bg-zinc-50/50 p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-zinc-900 flex items-center justify-center text-white">
                                <CalendarCheck class="h-5 w-5" />
                            </div>
                            <div>
                                <div class="text-xs font-bold text-zinc-900">Batas Pengisian Jurnal Pekan Ini</div>
                                <div class="text-[11px] text-zinc-500">Jumat, 17:00 WIB • Evaluasi mingguan pembimbing industri</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                            <div class="text-right">
                                <div class="text-xs font-bold text-zinc-900">Progres 85%</div>
                                <div class="text-[10px] text-zinc-500">Menuju Penyelesaian</div>
                            </div>
                            <div class="h-8 w-8 rounded-lg bg-white border border-zinc-200 flex items-center justify-center text-zinc-600">
                                <ChevronRight class="h-4 w-4" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </ContainerScroll>

        <!-- Key Statistics -->
        <div
            class="relative z-10 mx-auto grid max-w-2xl grid-cols-2 gap-6 pt-4 text-center md:grid-cols-3"
        >
            <div class="space-y-1">
                <div
                    class="text-2xl font-bold tracking-tight text-zinc-950 sm:text-3xl"
                >
                    {{ sections.about_stat_students || '500+' }}
                </div>
                <div class="text-xs font-medium text-zinc-500">
                    Siswa PKL Terdaftar
                </div>
            </div>
            <div class="space-y-1">
                <div
                    class="text-2xl font-bold tracking-tight text-zinc-950 sm:text-3xl"
                >
                    {{ sections.about_stat_schools || '45+' }}
                </div>
                <div class="text-xs font-medium text-zinc-500">
                    Mitra Sekolah & Kampus
                </div>
            </div>
            <div class="col-span-2 space-y-1 md:col-span-1">
                <div
                    class="text-2xl font-bold tracking-tight text-zinc-950 sm:text-3xl"
                >
                    {{ sections.about_stat_divisions || '12+' }}
                </div>
                <div class="text-xs font-medium text-zinc-500">
                    Divisi & Industri Mitra
                </div>
            </div>
        </div>
    </FloatingPathsBackground>
</template>


