<script setup lang="ts">
import { useMouseInElement } from '@vueuse/core';
import { ref, computed, type HTMLAttributes } from 'vue';

import { cn } from '@/lib/utils';

interface Props {
    className?: HTMLAttributes['class'];
    size?: number;
}

const props = withDefaults(defineProps<Props>(), {
    size: 300,
});

const targetRef = ref<HTMLElement | null>(null);
const { elementX, elementY, isOutside } = useMouseInElement(targetRef);

const spotlightPos = computed(() => {
    return {
        left: `${elementX.value - props.size / 2}px`,
        top: `${elementY.value - props.size / 2}px`,
        width: `${props.size}px`,
        height: `${props.size}px`,
    };
});
</script>

<template>
    <div
        ref="targetRef"
        class="pointer-events-none absolute inset-0 overflow-hidden"
    >
        <div
            :class="
                cn(
                    'pointer-events-none absolute rounded-full bg-[radial-gradient(circle_at_center,var(--tw-gradient-stops),transparent_80%)] blur-2xl transition-opacity duration-300',
                    'from-zinc-100/40 via-zinc-200/20 to-transparent',
                    !isOutside ? 'opacity-100' : 'opacity-0',
                    props.className
                )
            "
            :style="spotlightPos"
        />
    </div>
</template>
