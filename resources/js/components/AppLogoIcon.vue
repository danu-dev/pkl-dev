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
    <img 
        src="/images/logo-emblem.png" 
        alt="SIPKL Logo" 
        :class="className" 
        v-bind="$attrs" 
        class="object-contain"
    />
</template>
