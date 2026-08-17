<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Menu, LogIn, LayoutDashboard, ChevronRight } from '@lucide/vue';
import { ref } from 'vue';

import { Button } from '@/components/ui/button';
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/components/ui/sheet';

defineProps<{
    isAuthenticated: boolean;
    userDashboardUrl: string;
}>();

const isMobileMenuOpen = ref(false);

const navLinks = [
    { label: 'Beranda', href: '#beranda' },
    { label: 'Fitur', href: '#fitur' },
    { label: 'Alur PKL', href: '#prosedur' },
    { label: 'Alumni', href: '#alumni' },
    { label: 'Galeri', href: '#galeri' },
    { label: 'Kontak', href: '#kontak' },
];
</script>

<template>
    <header
        class="sticky top-0 z-50 border-b border-zinc-200/80 bg-white/80 backdrop-blur-md"
    >
        <div
            class="mx-auto flex h-18 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8"
        >
            <!-- Brand Logo -->
            <a href="#beranda" class="group flex items-center">
                <span
                    class="text-xl font-extrabold tracking-tight text-zinc-950"
                >
                    SIPKL<span class="text-zinc-950">.</span>
                </span>
            </a>

            <!-- Desktop Navigation Links -->
            <nav
                class="hidden items-center gap-8 text-xs font-medium text-zinc-600 md:flex"
            >
                <a
                    v-for="link in navLinks"
                    :key="link.href"
                    :href="link.href"
                    class="transition-colors hover:text-zinc-950"
                >
                    {{ link.label }}
                </a>
            </nav>

            <!-- Desktop CTA -->
            <div class="hidden items-center gap-3 md:flex">
                <Link :href="isAuthenticated ? userDashboardUrl : '/login'">
                    <Button
                        class="h-9 cursor-pointer gap-2 rounded-lg bg-zinc-950 px-4.5 text-xs font-medium text-white shadow-xs hover:bg-zinc-800"
                    >
                        <component
                            :is="isAuthenticated ? LayoutDashboard : LogIn"
                            class="h-3.5 w-3.5"
                        />
                        <span>{{
                            isAuthenticated ? 'Dashboard' : 'Login'
                        }}</span>
                    </Button>
                </Link>
            </div>

            <!-- Mobile Menu Sheet Trigger -->
            <Sheet v-model:open="isMobileMenuOpen">
                <SheetTrigger as-child>
                    <button
                        class="cursor-pointer rounded-xl border border-zinc-200 p-2.5 text-zinc-700 transition-colors hover:bg-zinc-100 hover:text-zinc-950 md:hidden"
                        aria-label="Buka Navigasi"
                    >
                        <Menu class="h-5 w-5" />
                    </button>
                </SheetTrigger>
                <SheetContent
                    side="right"
                    class="flex w-[82vw] flex-col justify-between border-l border-zinc-200 bg-white p-6 sm:w-[350px]"
                >
                    <div class="space-y-6">
                        <SheetHeader
                            class="space-y-1 border-b border-zinc-100 pb-4 text-left"
                        >
                            <SheetTitle
                                class="text-xl font-extrabold tracking-tight text-zinc-950"
                            >
                                SIPKL<span class="text-zinc-950">.</span>
                            </SheetTitle>
                        </SheetHeader>

                        <!-- Navigation Links List -->
                        <nav class="flex flex-col space-y-1">
                            <a
                                v-for="link in navLinks"
                                :key="link.href"
                                @click="isMobileMenuOpen = false"
                                :href="link.href"
                                class="flex items-center justify-between rounded-xl px-3.5 py-3 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-50 hover:text-zinc-950"
                            >
                                <span>{{ link.label }}</span>
                                <ChevronRight class="h-4 w-4 text-zinc-400" />
                            </a>
                        </nav>
                    </div>

                    <!-- Bottom Action on Sidebar -->
                    <div class="space-y-3 border-t border-zinc-100 pt-4">
                        <Link
                            :href="
                                isAuthenticated ? userDashboardUrl : '/login'
                            "
                            class="block w-full"
                            @click="isMobileMenuOpen = false"
                        >
                            <Button
                                class="h-11 w-full gap-2 rounded-xl bg-zinc-950 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
                            >
                                <component
                                    :is="
                                        isAuthenticated
                                            ? LayoutDashboard
                                            : LogIn
                                    "
                                    class="h-4 w-4"
                                />
                                <span>{{
                                    isAuthenticated ? 'Dashboard' : 'Login'
                                }}</span>
                            </Button>
                        </Link>
                        <p class="text-center text-[11px] text-zinc-400">
                            © 2026 SIPKL
                        </p>
                    </div>
                </SheetContent>
            </Sheet>
        </div>
    </header>
</template>
