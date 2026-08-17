<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <span
        :class="className"
        v-bind="$attrs"
        class="inline-flex items-center font-extrabold tracking-tight text-zinc-950 dark:text-white"
    >
        SIPKL.
    </span>
</template>
