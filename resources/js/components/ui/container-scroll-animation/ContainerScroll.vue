<script setup lang="ts">
import { type HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

interface Props {
  titleComponent?: string
  class?: HTMLAttributes['class']
}

const props = defineProps<Props>()
</script>

<template>
  <div
    :class="
      cn(
        'relative flex flex-col items-center justify-center p-2 sm:p-4 md:p-8',
        props.class
      )
    "
  >
    <div class="relative w-full py-4 md:py-8">
      <div class="max-w-5xl mx-auto text-center">
        <slot name="title">
          <component :is="'h1'" v-if="titleComponent" class="text-4xl font-semibold text-foreground">
            {{ titleComponent }}
          </component>
        </slot>
      </div>

      <div
        class="max-w-5xl mt-6 sm:mt-10 mx-auto w-full border border-zinc-200/90 p-2.5 sm:p-4 bg-zinc-100/95 rounded-2xl md:rounded-3xl shadow-xl transition-transform hover:-translate-y-1 duration-300"
      >
        <div class="w-full min-h-[380px] md:min-h-[480px] overflow-hidden rounded-xl md:rounded-2xl bg-white flex flex-col">
          <slot />
        </div>
      </div>
    </div>
  </div>
</template>



