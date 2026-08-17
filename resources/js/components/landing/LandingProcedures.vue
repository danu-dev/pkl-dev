<script setup lang="ts">
import {
    ChevronRight,
    UserPlus,
    ShieldCheck,
    Building,
    CalendarCheck,
    Award,
    FileText,
} from '@lucide/vue';
import { useIntersectionObserver } from '@vueuse/core';
import { ref } from 'vue';

import { Badge } from '@/components/ui/badge';
import type { ProcedureItem } from '@/types/landing';

defineProps<{
    procedures: ProcedureItem[];
}>();

const prosedurSectionRef = ref<HTMLElement | null>(null);
const isProsedurVisible = ref(false);

useIntersectionObserver(
    prosedurSectionRef,
    ([{ isIntersecting }]) => {
        if (isIntersecting) {
            isProsedurVisible.value = true;
        }
    },
    { threshold: 0.15 },
);

const getProcedureIcon = (iconName: string) => {
    switch (iconName) {
        case 'UserPlus':
            return UserPlus;
        case 'ShieldCheck':
            return ShieldCheck;
        case 'Building':
            return Building;
        case 'CalendarCheck':
            return CalendarCheck;
        case 'Award':
            return Award;
        default:
            return FileText;
    }
};
</script>

<template>
    <section
        id="prosedur"
        ref="prosedurSectionRef"
        class="relative overflow-hidden border-b border-zinc-200 bg-white py-24"
    >
        <div class="mx-auto max-w-6xl space-y-16 px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div
                class="mx-auto max-w-2xl space-y-2.5 text-center transition-all duration-700 ease-out sm:space-y-3"
                :class="
                    isProsedurVisible
                        ? 'translate-y-0 scale-100 opacity-100'
                        : 'translate-y-8 scale-95 opacity-0'
                "
            >
                <Badge
                    variant="outline"
                    class="border-zinc-300 bg-white text-[10px] font-semibold tracking-wider text-zinc-800 uppercase"
                >
                    Tahapan Prosedur
                </Badge>
                <h2
                    class="px-2 text-xl font-bold tracking-tight text-zinc-950 sm:px-0 sm:text-3xl md:text-4xl"
                >
                    Alur & Tahapan Siswa PKL
                </h2>
                <p class="px-3 text-xs text-zinc-500 sm:px-0 sm:text-sm">
                    Panduan terstruktur dari awal registrasi hingga penyerahan
                    sertifikat kelulusan magang.
                </p>
            </div>

            <!-- Stepper Grid -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-5">
                <div
                    v-for="(proc, index) in procedures"
                    :key="proc.id"
                    class="group flex flex-col justify-between space-y-4 rounded-xl border border-zinc-200 bg-white p-5 transition-all duration-500 hover:-translate-y-1 hover:border-zinc-400 hover:bg-zinc-50/50 hover:shadow-sm"
                    :class="
                        isProsedurVisible
                            ? 'translate-y-0 scale-100 opacity-100'
                            : 'translate-y-10 scale-95 opacity-0'
                    "
                    :style="{ transitionDelay: `${index * 100 + 100}ms` }"
                >
                    <div class="flex items-center justify-between">
                        <span
                            class="font-mono text-xs font-bold text-zinc-400 transition-colors group-hover:text-zinc-950"
                        >
                            0{{ proc.step_number }}
                        </span>
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-md border border-zinc-200 bg-zinc-100 text-zinc-700 transition-all group-hover:bg-zinc-950 group-hover:text-white"
                        >
                            <component
                                :is="getProcedureIcon(proc.icon)"
                                class="h-4 w-4"
                            />
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <h3 class="text-sm font-bold text-zinc-900">
                            {{ proc.title }}
                        </h3>
                        <p class="text-xs leading-relaxed text-zinc-500">
                            {{ proc.description }}
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-1 border-t border-zinc-100 pt-2 text-[11px] font-medium text-zinc-400 transition-colors group-hover:text-zinc-900"
                    >
                        <span>Langkah {{ proc.step_number }}</span>
                        <ChevronRight
                            class="h-3 w-3 transition-transform group-hover:translate-x-1"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
