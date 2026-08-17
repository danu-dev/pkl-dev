<script setup lang="ts">
import { Maximize2 } from '@lucide/vue';
import { useIntersectionObserver } from '@vueuse/core';
import { ref, computed } from 'vue';

import { Badge } from '@/components/ui/badge';
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogDescription,
} from '@/components/ui/dialog';
import type { GalleryItem } from '@/types/landing';

const props = defineProps<{
    gallery: GalleryItem[];
}>();

const galeriSectionRef = ref<HTMLElement | null>(null);
const isGaleriVisible = ref(false);

useIntersectionObserver(
    galeriSectionRef,
    ([{ isIntersecting }]) => {
        if (isIntersecting) {
            isGaleriVisible.value = true;
        }
    },
    { threshold: 0.15 },
);

const activeGalleryCategory = ref('Semua');
const selectedGalleryItem = ref<GalleryItem | null>(null);
const isGalleryDialogOpen = ref(false);

const galleryCategories = ['Semua', 'Orientasi', 'Kegiatan', 'Evaluasi'];

const filteredGallery = computed(() => {
    if (activeGalleryCategory.value === 'Semua') {
        return props.gallery;
    }
    return props.gallery.filter(
        (item) => item.category === activeGalleryCategory.value,
    );
});

const openGalleryLightbox = (item: GalleryItem) => {
    selectedGalleryItem.value = item;
    isGalleryDialogOpen.value = true;
};
</script>

<template>
    <section
        id="galeri"
        ref="galeriSectionRef"
        class="relative overflow-hidden border-b border-zinc-200 bg-white py-24"
    >
        <div class="mx-auto max-w-6xl space-y-12 px-4 sm:px-6 lg:px-8">
            <!-- Section Header & Category Filter -->
            <div
                class="flex flex-col justify-between gap-6 transition-all duration-700 ease-out md:flex-row md:items-end"
                :class="
                    isGaleriVisible
                        ? 'translate-y-0 scale-100 opacity-100'
                        : 'translate-y-8 scale-95 opacity-0'
                "
            >
                <div class="max-w-xl space-y-2.5 sm:space-y-3">
                    <Badge
                        variant="outline"
                        class="border-zinc-300 bg-white text-[10px] font-semibold tracking-wider text-zinc-800 uppercase"
                    >
                        Dokumentasi
                    </Badge>
                    <h2
                        class="text-xl font-bold tracking-tight text-zinc-950 sm:text-3xl md:text-4xl"
                    >
                        Galeri Kegiatan & Aktivitas
                    </h2>
                    <p class="text-xs text-zinc-500 sm:text-sm">
                        Potret kegiatan pembelajaran, penugasan teknis, dan
                        evaluasi peserta PKL.
                    </p>
                </div>

                <!-- Category Filter Buttons -->
                <div
                    class="flex flex-wrap gap-1.5 rounded-lg border border-zinc-200 bg-zinc-100 p-1"
                >
                    <button
                        v-for="cat in galleryCategories"
                        :key="cat"
                        @click="activeGalleryCategory = cat"
                        class="cursor-pointer rounded-md px-3.5 py-1.5 text-xs font-medium transition-all"
                        :class="
                            activeGalleryCategory === cat
                                ? 'bg-zinc-950 text-white shadow-2xs'
                                : 'text-zinc-600 hover:text-zinc-950'
                        "
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>

            <!-- Gallery Photo Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                <div
                    v-for="(item, index) in filteredGallery"
                    :key="item.id"
                    @click="openGalleryLightbox(item)"
                    class="group relative flex cursor-pointer flex-col justify-between overflow-hidden rounded-xl border border-zinc-200 bg-white transition-all duration-500 hover:-translate-y-1.5 hover:border-zinc-400 hover:shadow-lg"
                    :class="
                        isGaleriVisible
                            ? 'translate-y-0 scale-100 opacity-100'
                            : 'translate-y-10 scale-95 opacity-0'
                    "
                    :style="{
                        transitionDelay: `${(index % 6) * 100 + 100}ms`,
                    }"
                >
                    <div class="relative h-56 overflow-hidden bg-zinc-100">
                        <img
                            :src="item.image_path"
                            :alt="item.title"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-zinc-950/20 opacity-0 transition-opacity group-hover:opacity-100"
                        >
                            <span
                                class="rounded-full bg-white p-2 text-zinc-950 shadow-md"
                            >
                                <Maximize2 class="h-4 w-4" />
                            </span>
                        </div>
                        <Badge
                            class="absolute top-3 left-3 border-zinc-200 bg-white/95 text-[10px] text-zinc-900 shadow-2xs"
                        >
                            {{ item.category }}
                        </Badge>
                    </div>
                    <div class="space-y-1 bg-white p-4">
                        <h3
                            class="text-sm font-bold text-zinc-900 transition-colors group-hover:text-zinc-700"
                        >
                            {{ item.title }}
                        </h3>
                        <p
                            v-if="item.caption"
                            class="line-clamp-1 text-xs text-zinc-500"
                        >
                            {{ item.caption }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <Dialog v-model:open="isGalleryDialogOpen">
            <DialogContent
                class="max-w-3xl rounded-2xl border-zinc-200 bg-white p-6 text-zinc-950"
            >
                <DialogHeader
                    v-if="selectedGalleryItem"
                    class="space-y-2 text-left"
                >
                    <div class="flex items-center gap-2">
                        <Badge
                            variant="outline"
                            class="border-zinc-300 text-[10px] text-zinc-800"
                        >
                            {{ selectedGalleryItem.category }}
                        </Badge>
                    </div>
                    <DialogTitle class="text-lg font-bold text-zinc-900">
                        {{ selectedGalleryItem.title }}
                    </DialogTitle>
                    <DialogDescription
                        v-if="selectedGalleryItem.caption"
                        class="text-xs text-zinc-500"
                    >
                        {{ selectedGalleryItem.caption }}
                    </DialogDescription>
                </DialogHeader>

                <div
                    v-if="selectedGalleryItem"
                    class="mt-4 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100"
                >
                    <img
                        :src="selectedGalleryItem.image_path"
                        :alt="selectedGalleryItem.title"
                        class="mx-auto max-h-[70vh] w-full object-contain"
                    />
                </div>
            </DialogContent>
        </Dialog>
    </section>
</template>
