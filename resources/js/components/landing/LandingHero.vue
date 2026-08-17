<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    LayoutDashboard,
    Compass,
    Shield,
    FileCheck,
    Sparkles,
} from '@lucide/vue';
import { defineAsyncComponent } from 'vue';

import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ContainerScroll } from '@/components/ui/container-scroll-animation';
import { FloatingPathsBackground } from '@/components/ui/floating-paths';
import { Spotlight } from '@/components/ui/spotlight';

const SplineScene = defineAsyncComponent(
    () => import('@/components/ui/spline/SplineScene.vue'),
);

defineProps<{
    sections: Record<string, string>;
    isAuthenticated: boolean;
    userDashboardUrl: string;
}>();
</script>

<template>
    <FloatingPathsBackground
        id="beranda"
        :position="1"
        class="relative border-b border-zinc-200 pt-8 pb-16 md:pt-14 md:pb-24"
    >
        <!-- Floating Ambient Background Glows -->
        <div
            class="pointer-events-none absolute -top-24 left-1/4 h-[420px] w-[420px] rounded-full bg-zinc-200/40 blur-3xl"
        ></div>
        <div
            class="pointer-events-none absolute top-1/3 -right-20 h-[450px] w-[450px] rounded-full bg-zinc-200/30 blur-3xl"
        ></div>

        <!-- Subtle Pattern Grid -->
        <div
            class="pointer-events-none absolute inset-0 bg-[radial-gradient(#e4e4e7_1px,transparent_1px)] [background-size:24px_24px] opacity-60"
        ></div>

        <!-- Floating Badges -->
        <div
            class="pointer-events-none absolute top-28 left-8 z-20 hidden items-center gap-2.5 rounded-2xl border border-zinc-200/80 bg-white/90 px-4 py-2.5 shadow-lg backdrop-blur-xs lg:flex"
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
            class="pointer-events-none absolute top-36 right-8 z-20 hidden items-center gap-2.5 rounded-2xl border border-zinc-200/80 bg-white/90 px-4 py-2.5 shadow-lg backdrop-blur-xs lg:flex"
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
                        class="inline-flex items-center gap-2 rounded-full border border-zinc-300/80 bg-zinc-50/90 px-3.5 py-1 text-[11px] font-medium text-zinc-700 shadow-2xs"
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
                            class="mx-auto max-w-2xl px-2 text-xs leading-relaxed font-normal text-zinc-600 sm:px-0 sm:text-base md:text-lg"
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

            <!-- Card Content (Spline 3D Scene + Spotlight Interactive Dashboard) -->
            <div class="relative flex h-full min-h-[460px] w-full flex-col md:flex-row overflow-hidden bg-zinc-950 text-white rounded-xl md:rounded-2xl">
                <!-- Interactive Spotlight Effect -->
                <Spotlight
                    className="-top-40 left-0 md:left-60 md:-top-20 from-zinc-100/30 via-zinc-200/10 to-transparent"
                    :size="400"
                />

                <!-- Left Content Area -->
                <div class="relative z-10 flex flex-1 flex-col justify-center p-6 sm:p-8 md:p-12 text-left">
                    <div class="inline-flex items-center gap-2 rounded-full border border-zinc-800 bg-zinc-900/90 px-3 py-1 text-[11px] font-medium text-zinc-300 w-fit mb-4 backdrop-blur-md">
                        <Sparkles class="h-3.5 w-3.5 text-amber-400" />
                        <span>Interactive 3D Experience</span>
                    </div>

                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight bg-gradient-to-b from-white via-zinc-200 to-zinc-500 bg-clip-text text-transparent">
                        Portal Digital Cerdas & Imersif
                    </h3>
                    <p class="mt-3 text-xs sm:text-sm text-zinc-400 leading-relaxed max-w-md">
                        Visualisasi ekosistem praktek kerja lapangan generasi baru. Terhubung secara interaktif dengan sistem absensi GPS, logbook realtime, dan evaluasi berbasis industri.
                    </p>

                    <!-- Quick Highlights -->
                    <div class="mt-6 grid grid-cols-2 gap-3 max-w-sm">
                        <div class="rounded-xl border border-zinc-800/80 bg-zinc-900/60 p-3">
                            <div class="text-xs font-semibold text-white">100% Real-time</div>
                            <div class="text-[10px] text-zinc-500">Presensi & Logbook</div>
                        </div>
                        <div class="rounded-xl border border-zinc-800/80 bg-zinc-900/60 p-3">
                            <div class="text-xs font-semibold text-white">Terakreditasi</div>
                            <div class="text-[10px] text-zinc-500">Standar Industri</div>
                        </div>
                    </div>
                </div>

                <!-- Right Spline 3D Scene Area -->
                <div class="relative min-h-[300px] sm:min-h-[360px] md:min-h-[460px] flex-1">
                    <SplineScene
                        scene="https://prod.spline.design/kZDDjO5HuC9GJUM2/scene.splinecode"
                        class="h-full w-full"
                    />
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


