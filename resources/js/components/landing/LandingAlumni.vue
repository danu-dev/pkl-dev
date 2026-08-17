<script setup lang="ts">
import { useIntersectionObserver } from '@vueuse/core';
import { ref } from 'vue';

import { Badge } from '@/components/ui/badge';
import type { AlumniItem } from '@/types/landing';

defineProps<{
    alumni: AlumniItem[];
}>();

const alumniSectionRef = ref<HTMLElement | null>(null);
const isAlumniVisible = ref(false);

useIntersectionObserver(
    alumniSectionRef,
    ([{ isIntersecting }]) => {
        if (isIntersecting) {
            isAlumniVisible.value = true;
        }
    },
    { threshold: 0.15 },
);
</script>

<template>
    <section
        id="alumni"
        ref="alumniSectionRef"
        class="relative overflow-hidden border-b border-zinc-200 bg-zinc-50/50 py-24"
    >
        <div class="mx-auto max-w-6xl space-y-16 px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div
                class="mx-auto max-w-2xl space-y-2.5 text-center transition-all duration-700 ease-out sm:space-y-3"
                :class="
                    isAlumniVisible
                        ? 'translate-y-0 scale-100 opacity-100'
                        : 'translate-y-8 scale-95 opacity-0'
                "
            >
                <Badge
                    variant="outline"
                    class="border-zinc-300 bg-white text-[10px] font-semibold tracking-wider text-zinc-800 uppercase"
                >
                    Alumni Magang
                </Badge>
                <h2
                    class="px-2 text-xl font-bold tracking-tight text-zinc-950 sm:px-0 sm:text-3xl md:text-4xl"
                >
                    Jejak Rekam Alumni PKL
                </h2>
                <p class="px-3 text-xs text-zinc-500 sm:px-0 sm:text-sm">
                    Peserta didik yang telah menyelesaikan program praktek kerja
                    industri dengan predikat memuaskan.
                </p>
            </div>

            <!-- Alumni Cards Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="(item, index) in alumni"
                    :key="item.id"
                    class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-zinc-200/90 bg-white shadow-xs transition-all duration-500 hover:-translate-y-2 hover:border-zinc-400 hover:shadow-xl"
                    :class="
                        isAlumniVisible
                            ? 'translate-y-0 scale-100 opacity-100'
                            : 'translate-y-12 scale-95 opacity-0'
                    "
                    :style="{ transitionDelay: `${index * 120 + 100}ms` }"
                >
                    <!-- Pixel/Notion Avatar Header Canvas -->
                    <div
                        class="relative flex h-48 items-center justify-center overflow-hidden bg-zinc-900 p-4"
                    >
                        <!-- Background Grid Pattern -->
                        <div
                            class="absolute inset-0 bg-[radial-gradient(#27272a_1px,transparent_1px)] [background-size:12px_12px] opacity-70"
                        ></div>

                        <!-- Avatar Image (Dicebear Pixel-Art) -->
                        <img
                            :src="`https://api.dicebear.com/7.x/pixel-art/svg?seed=${encodeURIComponent(item.name)}&backgroundColor=transparent`"
                            :alt="item.name"
                            class="relative h-28 w-28 object-contain drop-shadow-lg transition-transform duration-500 ease-out group-hover:scale-115 group-hover:-rotate-2"
                            loading="lazy"
                        />

                        <!-- Division Badge -->
                        <div class="absolute top-3 left-3">
                            <span
                                class="inline-flex items-center rounded-full border border-zinc-700 bg-zinc-800/90 px-2.5 py-1 text-[10px] font-medium text-zinc-100 shadow-xs backdrop-blur-md transition-colors group-hover:border-zinc-500"
                            >
                                {{ item.division_name || 'Tim PKL' }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div
                        class="flex flex-1 flex-col justify-between space-y-3 bg-white p-5"
                    >
                        <div class="space-y-1">
                            <h4
                                class="text-base leading-snug font-bold tracking-tight text-zinc-900 group-hover:text-zinc-950"
                            >
                                {{ item.name }}
                            </h4>
                            <p class="text-xs font-medium text-zinc-500">
                                {{ item.school_name }}
                            </p>
                        </div>

                        <div
                            v-if="item.quote"
                            class="flex-1 border-t border-zinc-100 pt-3"
                        >
                            <p
                                class="line-clamp-3 text-xs leading-relaxed text-zinc-600 italic"
                            >
                                “{{ item.quote }}”
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
