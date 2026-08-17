<script setup lang="ts">
import { Card } from '@/components/ui/card';
import { SplineScene } from '@/components/ui/spline';
import { Spotlight } from '@/components/ui/spotlight';
</script>

<template>
    <Card class="relative h-[500px] w-full overflow-hidden border-zinc-800 bg-zinc-950 text-white shadow-2xl">
        <Spotlight
            class="-top-40 left-0 md:-top-20 md:left-60 from-zinc-200/30"
            :size="350"
        />

        <div class="flex h-full flex-col md:flex-row">
            <!-- Left content -->
            <div class="relative z-10 flex flex-1 flex-col justify-center p-8 md:p-12">
                <h2
                    class="bg-gradient-to-b from-white via-zinc-200 to-zinc-500 bg-clip-text text-3xl font-bold tracking-tight text-transparent sm:text-4xl md:text-5xl"
                >
                    Interactive 3D
                </h2>
                <p class="mt-4 max-w-lg text-sm leading-relaxed text-zinc-400 sm:text-base">
                    Bring your UI to life with beautiful 3D scenes. Create immersive experiences
                    that capture attention and enhance your design.
                </p>
            </div>

            <!-- Right content (3D Spline Scene) -->
            <div class="relative h-64 flex-1 md:h-full">
                <SplineScene
                    scene="https://prod.spline.design/kZDDjO5HuC9GJUM2/scene.splinecode"
                    class="h-full w-full"
                />
            </div>
        </div>
    </Card>
</template>
