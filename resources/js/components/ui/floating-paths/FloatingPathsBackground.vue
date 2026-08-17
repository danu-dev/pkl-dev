<script setup lang="ts">
import { computed, type HTMLAttributes } from 'vue'
import { motion } from 'motion-v'
import { cn } from '@/lib/utils'

interface Props {
  position?: number
  class?: HTMLAttributes['class']
}

const props = withDefaults(defineProps<Props>(), {
  position: 1,
})

const paths = computed(() => {
  const pos = props.position
  return Array.from({ length: 36 }, (_, i) => ({
    id: i,
    d: `M-${380 - i * 5 * pos} -${189 + i * 6}C-${
      380 - i * 5 * pos
    } -${189 + i * 6} -${312 - i * 5 * pos} ${216 - i * 6} ${
      152 - i * 5 * pos
    } ${343 - i * 6}C${616 - i * 5 * pos} ${470 - i * 6} ${
      684 - i * 5 * pos
    } ${875 - i * 6} ${684 - i * 5 * pos} ${875 - i * 6}`,
    color: `rgba(15,23,42,${0.1 + i * 0.03})`,
    width: 0.5 + i * 0.03,
    duration: 20 + (i % 10) * 1.5,
  }))
})
</script>

<template>
  <div :class="cn('relative w-full overflow-hidden', props.class)">
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
      <svg
        class="h-full w-full text-zinc-900/40 dark:text-white/40"
        viewBox="0 0 696 316"
        fill="none"
        preserveAspectRatio="xMidYMid slice"
      >
        <motion.path
          v-for="path in paths"
          :key="path.id"
          :d="path.d"
          stroke="currentColor"
          :stroke-width="path.width"
          :stroke-opacity="0.08 + (path.id % 12) * 0.02"
          :initial="{ pathLength: 0.3, opacity: 0.6 }"
          :animate="{
            pathLength: 1,
            opacity: [0.3, 0.7, 0.3],
            pathOffset: [0, 1, 0],
          }"
          :transition="{
            duration: path.duration,
            repeat: Infinity,
            ease: 'linear',
          }"
        />
      </svg>
    </div>
    <slot />
  </div>
</template>
