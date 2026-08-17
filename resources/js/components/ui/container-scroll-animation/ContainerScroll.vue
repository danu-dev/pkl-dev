<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed, type HTMLAttributes } from 'vue'
import { motion, useScroll, useTransform } from 'motion-v'
import { cn } from '@/lib/utils'

interface Props {
  titleComponent?: string
  class?: HTMLAttributes['class']
}

const props = defineProps<Props>()

const containerRef = ref<HTMLElement | null>(null)
const isMobile = ref(false)

const checkMobile = () => {
  if (typeof window !== 'undefined') {
    isMobile.value = window.innerWidth <= 768
  }
}

onMounted(() => {
  checkMobile()
  window.addEventListener('resize', checkMobile)
})

onUnmounted(() => {
  if (typeof window !== 'undefined') {
    window.removeEventListener('resize', checkMobile)
  }
})

const { scrollYProgress } = useScroll({
  target: containerRef,
  offset: ['start start', 'end end'],
})

const scaleDimensions = computed(() => {
  return isMobile.value ? [0.92, 1] : [1.03, 1]
})

const rotate = useTransform(scrollYProgress, [0, 1], [12, 0])
const scale = useTransform(scrollYProgress, [0, 1], scaleDimensions.value)
const translate = useTransform(scrollYProgress, [0, 1], [0, -30])
</script>

<template>
  <div
    ref="containerRef"
    :class="
      cn(
        'relative flex flex-col items-center justify-center p-2 sm:p-4 md:p-8',
        props.class
      )
    "
  >
    <div
      class="relative w-full py-4 md:py-8"
      style="perspective: 1200px"
    >
      <motion.div
        :style="{ translateY: translate }"
        class="max-w-5xl mx-auto text-center will-change-transform"
      >
        <slot name="title">
          <component :is="'h1'" v-if="titleComponent" class="text-4xl font-semibold text-foreground">
            {{ titleComponent }}
          </component>
        </slot>
      </motion.div>

      <motion.div
        :style="{
          rotateX: rotate,
          scale: scale,
          boxShadow:
            '0 0 #0000004d, 0 10px 30px #00000022, 0 30px 60px #00000018, 0 50px 80px #00000010',
        }"
        class="max-w-5xl mt-6 sm:mt-10 mx-auto w-full border border-zinc-200/90 dark:border-zinc-800 p-2.5 sm:p-4 bg-zinc-100/95 dark:bg-zinc-900/95 backdrop-blur-md rounded-2xl md:rounded-3xl shadow-2xl will-change-transform"
      >
        <div class="w-full min-h-[420px] md:min-h-[520px] overflow-hidden rounded-xl md:rounded-2xl bg-white dark:bg-zinc-950 flex flex-col">
          <slot />
        </div>
      </motion.div>
    </div>
  </div>
</template>



