<script setup lang="ts">
import { ref, onMounted, onUnmounted, type HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

interface Props {
  titleComponent?: string
  class?: HTMLAttributes['class']
}

const props = defineProps<Props>()

const containerRef = ref<HTMLElement | null>(null)
const rotateX = ref(10)
const scale = ref(0.96)
const translateY = ref(0)

let ticking = false

const handleScroll = () => {
  if (!ticking) {
    window.requestAnimationFrame(() => {
      if (!containerRef.value) {
        ticking = false
        return
      }
      const rect = containerRef.value.getBoundingClientRect()
      const windowHeight = window.innerHeight
      
      // Calculate progress 0 to 1 as container scrolls through viewport
      const total = windowHeight + rect.height
      const current = windowHeight - rect.top
      const progress = Math.min(Math.max(current / total, 0), 1)

      // Smooth easing transform calculation
      rotateX.value = Math.max(0, (1 - progress * 1.5) * 12)
      scale.value = 0.94 + progress * 0.06
      translateY.value = (1 - progress) * 20

      ticking = false
    })
    ticking = true
  }
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll, { passive: true })
  handleScroll()
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
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
      style="perspective: 1000px"
    >
      <div
        class="max-w-5xl mx-auto text-center will-change-transform transition-transform duration-100 ease-out"
        :style="{ transform: `translateY(-${translateY}px)` }"
      >
        <slot name="title">
          <component :is="'h1'" v-if="titleComponent" class="text-4xl font-semibold text-foreground">
            {{ titleComponent }}
          </component>
        </slot>
      </div>

      <div
        :style="{
          transform: `rotateX(${rotateX}deg) scale(${scale})`,
          boxShadow:
            '0 0 #0000004d, 0 10px 30px #00000015, 0 25px 50px #00000010',
        }"
        class="max-w-5xl mt-6 sm:mt-10 mx-auto w-full border border-zinc-200/90 p-2.5 sm:p-4 bg-zinc-100/95 backdrop-blur-md rounded-2xl md:rounded-3xl shadow-xl will-change-transform transition-transform duration-150 ease-out"
      >
        <div class="w-full min-h-[380px] md:min-h-[480px] overflow-hidden rounded-xl md:rounded-2xl bg-white flex flex-col">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>



