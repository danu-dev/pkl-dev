<script setup lang="ts">
import { Clock, BookOpen, Award } from '@lucide/vue';
import { useIntersectionObserver, useWindowScroll } from '@vueuse/core';
import { ref, computed } from 'vue';

import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
} from '@/components/ui/card';

defineProps<{
    sections: Record<string, string>;
}>();

const fiturSectionRef = ref<HTMLElement | null>(null);
const isFiturVisible = ref(false);

useIntersectionObserver(
    fiturSectionRef,
    ([{ isIntersecting }]) => {
        if (isIntersecting) {
            isFiturVisible.value = true;
        }
    },
    { threshold: 0.15 },
);

const { y: scrollY } = useWindowScroll();

const bgParallaxStyle = computed(() => {
    const offset = Math.min((scrollY.value - 400) * 0.1, 80);
    return {
        transform: `translate3d(0, ${offset.toFixed(1)}px, 0)`,
    };
});
</script>

<template>
    <section
        id="fitur"
        ref="fiturSectionRef"
        class="relative overflow-hidden border-b border-zinc-200 bg-zinc-50/60 py-24"
    >
        <!-- Floating Ambient Glow Background Parallax -->
        <div
            :style="bgParallaxStyle"
            class="pointer-events-none absolute right-1/4 -bottom-24 h-96 w-96 rounded-full bg-zinc-200/50 blur-3xl transition-transform ease-out will-change-transform"
        ></div>
        <div
            class="pointer-events-none absolute inset-0 bg-[radial-gradient(#e4e4e7_1px,transparent_1px)] [background-size:20px_20px] opacity-60"
        ></div>

        <div
            class="relative z-10 mx-auto max-w-6xl space-y-16 px-4 sm:px-6 lg:px-8"
        >
            <!-- Section Header -->
            <div
                class="mx-auto max-w-2xl space-y-2.5 text-center transition-all duration-700 ease-out sm:space-y-3"
                :class="
                    isFiturVisible
                        ? 'translate-y-0 scale-100 opacity-100'
                        : 'translate-y-8 scale-95 opacity-0'
                "
            >
                <Badge
                    variant="outline"
                    class="border-zinc-300 bg-white text-[10px] font-semibold tracking-wider text-zinc-800 uppercase"
                >
                    Fitur Unggulan
                </Badge>
                <h2
                    class="px-2 text-xl font-bold tracking-tight text-zinc-950 sm:px-0 sm:text-3xl md:text-4xl"
                >
                    {{
                        sections.about_title ||
                        'Dirancang untuk Disiplin & Transparansi PKL'
                    }}
                </h2>
                <p
                    class="px-3 text-xs leading-relaxed text-zinc-500 sm:px-0 sm:text-sm"
                >
                    {{
                        sections.about_description ||
                        'Membantu sinkronisasi data kegiatan siswa antara pihak sekolah, peserta didik, dan pembimbing industri secara transparan dan akurat.'
                    }}
                </p>
            </div>

            <!-- Bento Box Cards Layout -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Feature Card 1 -->
                <Card
                    class="group relative flex flex-col justify-between overflow-hidden border-zinc-200/90 bg-white shadow-xs transition-all duration-500 hover:-translate-y-2 hover:border-zinc-400 hover:shadow-xl"
                    :class="
                        isFiturVisible
                            ? 'translate-y-0 scale-100 opacity-100'
                            : 'translate-y-12 scale-95 opacity-0'
                    "
                    style="transition-delay: 100ms"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-zinc-50/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                    ></div>

                    <CardHeader class="relative z-10 space-y-4">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-100 text-zinc-900 shadow-2xs transition-all duration-300 group-hover:scale-110 group-hover:bg-zinc-950 group-hover:text-white"
                        >
                            <Clock class="h-5 w-5" />
                        </div>
                        <div class="space-y-1.5">
                            <CardTitle class="text-lg font-bold text-zinc-900">
                                Presisi Kehadiran 1-Klik
                            </CardTitle>
                            <CardDescription
                                class="text-xs leading-relaxed text-zinc-500"
                            >
                                Pencatatan jam masuk & pulang terverifikasi
                                sistem dengan batasan jadwal kerja harian yang
                                mencegah manipulasi waktu.
                            </CardDescription>
                        </div>
                    </CardHeader>
                    <CardContent class="relative z-10">
                        <div
                            class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50/90 p-3 text-xs font-medium text-zinc-700 transition-colors group-hover:border-zinc-200 group-hover:bg-zinc-50"
                        >
                            <span>Status Jam Kerja</span>
                            <span
                                class="font-mono text-[11px] font-bold text-zinc-900"
                            >
                                07:30 - 16:30 WIB
                            </span>
                        </div>
                    </CardContent>
                </Card>

                <!-- Feature Card 2 -->
                <Card
                    class="group relative flex flex-col justify-between overflow-hidden border-zinc-200/90 bg-white shadow-xs transition-all duration-500 hover:-translate-y-2 hover:border-zinc-400 hover:shadow-xl"
                    :class="
                        isFiturVisible
                            ? 'translate-y-0 scale-100 opacity-100'
                            : 'translate-y-12 scale-95 opacity-0'
                    "
                    style="transition-delay: 250ms"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-zinc-50/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                    ></div>

                    <CardHeader class="relative z-10 space-y-4">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-100 text-zinc-900 shadow-2xs transition-all duration-300 group-hover:scale-110 group-hover:bg-zinc-950 group-hover:text-white"
                        >
                            <BookOpen class="h-5 w-5" />
                        </div>
                        <div class="space-y-1.5">
                            <CardTitle class="text-lg font-bold text-zinc-900">
                                Logbook Jurnal Digital
                            </CardTitle>
                            <CardDescription
                                class="text-xs leading-relaxed text-zinc-500"
                            >
                                Dokumentasikan setiap pekerjaan harian dan
                                lampiran foto yang langsung dapat ditinjau dan
                                disetujui mentor industri.
                            </CardDescription>
                        </div>
                    </CardHeader>
                    <CardContent class="relative z-10">
                        <div
                            class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50/90 p-3 text-xs font-medium text-zinc-700 transition-colors group-hover:border-zinc-200 group-hover:bg-zinc-50"
                        >
                            <span>Verifikasi Berjenjang</span>
                            <span
                                class="text-[11px] font-semibold text-emerald-600"
                            >
                                Tersetujui Otomatis
                            </span>
                        </div>
                    </CardContent>
                </Card>

                <!-- Feature Card 3 -->
                <Card
                    class="group relative flex flex-col justify-between overflow-hidden border-zinc-200/90 bg-white shadow-xs transition-all duration-500 hover:-translate-y-2 hover:border-zinc-400 hover:shadow-xl"
                    :class="
                        isFiturVisible
                            ? 'translate-y-0 scale-100 opacity-100'
                            : 'translate-y-12 scale-95 opacity-0'
                    "
                    style="transition-delay: 400ms"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-b from-zinc-50/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                    ></div>

                    <CardHeader class="relative z-10 space-y-4">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-100 text-zinc-900 shadow-2xs transition-all duration-300 group-hover:scale-110 group-hover:bg-zinc-950 group-hover:text-white"
                        >
                            <Award class="h-5 w-5" />
                        </div>
                        <div class="space-y-1.5">
                            <CardTitle class="text-lg font-bold text-zinc-900">
                                Rekapitulasi Penilaian
                            </CardTitle>
                            <CardDescription
                                class="text-xs leading-relaxed text-zinc-500"
                            >
                                Kalkulasi nilai otomatis mencakup aspek
                                kehadiran, disiplin, pelaksanaan jurnal, dan
                                evaluasi capaian tugas akhir.
                            </CardDescription>
                        </div>
                    </CardHeader>
                    <CardContent class="relative z-10">
                        <div
                            class="flex items-center justify-between rounded-xl border border-zinc-100 bg-zinc-50/90 p-3 text-xs font-medium text-zinc-700 transition-colors group-hover:border-zinc-200 group-hover:bg-zinc-50"
                        >
                            <span>Standar Penilaian</span>
                            <span
                                class="font-mono text-[11px] font-bold text-zinc-900"
                            >
                                Grade A/B/C/D
                            </span>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>
</template>
