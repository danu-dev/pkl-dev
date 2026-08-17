<script setup lang="ts">
import { computed, type HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

interface Props {
  position?: number
  class?: HTMLAttributes['class']
}

const props = withDefaults(defineProps<Props>(), {
  position: 1,
})

// Streamlined to 10 elegant paths with CSS keyframe animation for high performance (60fps, 0 JS thread blocking)
const paths = computed(() => {
  const pos = props.position
  return Array.from({ length: 10 }, (_, i) => ({
    id: i,
    d: `M-${380 - i * 18 * pos} -${189 + i * 22}C-${
      380 - i * 18 * pos
    } -${189 + i * 22} -${312 - i * 18 * pos} ${216 - i * 22} ${
      152 - i * 18 * pos
    } ${343 - i * 22}C${616 - i * 18 * pos} ${470 - i * 22} ${
      684 - i * 18 * pos
    } ${875 - i * 22} ${684 - i * 18 * pos} ${875 - i * 22}`,
    width: 0.8 + i * 0.1,
    duration: 16 + (i % 5) * 3,
    delay: i * 0.8,
  }))
})
</script>

<template>
  <div :class="cn('relative w-full overflow-hidden', props.class)">
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
      <svg
        class="h-full w-full text-zinc-900/35"
        viewBox="0 0 696 316"
        fill="none"
        preserveAspectRatio="xMidYMid slice"
      >
        <path
          v-for="path in paths"
          :key="path.id"
          :d="path.d"
          stroke="currentColor"
          :stroke-width="path.width"
          stroke-dasharray="100 200"
          class="floating-path-anim"
          :style="{
            animationDuration: `${path.duration}s`,
            animationDelay: `${path.delay}s`,
            opacity: 0.12 + (path.id % 4) * 0.04,
          }"
        />
      </svg>
    </div>
    <slot />
  </div>
</template>

<style scoped>
@keyframes floatPath {
  0% {
    stroke-dashoffset: 0;
    opacity: 0.2;
  }
  50% {
    stroke-dashoffset: 300;
    opacity: 0.6;
  }
  100% {
    stroke-dashoffset: 600;
    opacity: 0.2;
  }
}

.floating-path-anim {
  animation: floatPath linear infinite;
  will-change: stroke-dashoffset, opacity;
}
</style>
