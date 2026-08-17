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

// Static vector curves for 0% CPU consumption
const paths = computed(() => {
  const pos = props.position
  return Array.from({ length: 6 }, (_, i) => ({
    id: i,
    d: `M-${380 - i * 35 * pos} -${189 + i * 35}C-${
      380 - i * 35 * pos
    } -${189 + i * 35} -${312 - i * 35 * pos} ${216 - i * 35} ${
      152 - i * 35 * pos
    } ${343 - i * 35}C${616 - i * 35 * pos} ${470 - i * 35} ${
      684 - i * 35 * pos
    } ${875 - i * 35} ${684 - i * 35 * pos} ${875 - i * 35}`,
    width: 0.75 + i * 0.1,
    opacity: 0.15 + (i % 3) * 0.05,
  }))
})
</script>

<template>
  <div :class="cn('relative w-full overflow-hidden', props.class)">
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
      <svg
        class="h-full w-full text-zinc-900/40"
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
          :stroke-opacity="path.opacity"
        />
      </svg>
    </div>
    <slot />
  </div>
</template>
