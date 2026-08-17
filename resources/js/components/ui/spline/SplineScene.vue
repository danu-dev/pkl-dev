<script setup lang="ts">
import { Application } from '@splinetool/runtime';
import { ref, onMounted, onUnmounted, type HTMLAttributes } from 'vue';

import { cn } from '@/lib/utils';

interface Props {
    scene: string;
    class?: HTMLAttributes['class'];
}

const props = defineProps<Props>();

const canvasRef = ref<HTMLCanvasElement | null>(null);
const isLoading = ref(true);
let splineApp: Application | null = null;

onMounted(async () => {
    if (!canvasRef.value) return;

    try {
        splineApp = new Application(canvasRef.value);
        await splineApp.load(props.scene);
    } catch (e) {
        console.error('Failed to load Spline 3D Scene:', e);
    } finally {
        isLoading.value = false;
    }
});

onUnmounted(() => {
    if (splineApp) {
        splineApp.dispose();
        splineApp = null;
    }
});
</script>

<template>
    <div :class="cn('relative h-full w-full overflow-hidden', props.class)">
        <div
            v-if="isLoading"
            class="absolute inset-0 flex items-center justify-center bg-zinc-950/20 backdrop-blur-xs z-10"
        >
            <div
                class="h-8 w-8 animate-spin rounded-full border-2 border-zinc-400 border-t-zinc-900 dark:border-t-white"
            ></div>
        </div>
        <canvas ref="canvasRef" class="h-full w-full pointer-events-auto" />
    </div>
</template>
