<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import {
    User,
    Lock,
    ArrowRight,
    Eye,
    EyeOff,
    ShieldCheck,
    CheckCircle2,
    ArrowLeft,
} from '@lucide/vue';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-white p-4 font-sans text-zinc-900 selection:bg-zinc-950 selection:text-white sm:p-6"
    >
        <!-- Minimalist Back to Home & Logo -->
        <div class="mb-6 flex w-full max-w-sm items-center justify-between">
            <Link href="/" class="group flex items-center">
                <span
                    class="text-xl font-extrabold tracking-tight text-zinc-950"
                >
                    SIPKL<span class="text-zinc-950">.</span>
                </span>
            </Link>

            <Link
                href="/"
                class="flex items-center gap-1 text-xs font-medium text-zinc-500 transition-colors hover:text-zinc-950"
            >
                <ArrowLeft class="h-3.5 w-3.5" />
                <span>Beranda</span>
            </Link>
        </div>

        <!-- Minimalist Auth Card (Monochrome Modern B&W) -->
        <div
            class="w-full max-w-sm space-y-6 rounded-2xl border border-zinc-200 bg-white p-6 shadow-xs sm:p-8"
        >
            <!-- Header Text -->
            <div class="space-y-1 text-center">
                <h1 class="text-xl font-bold tracking-tight text-zinc-950">
                    Masuk ke Akun
                </h1>
                <p class="text-xs text-zinc-500">
                    Masukkan kredensial Anda untuk melanjutkan
                </p>
            </div>

            <!-- Alerts -->
            <div
                v-if="$page.props.flash?.success"
                class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-zinc-50 p-3 text-xs font-medium text-zinc-900"
            >
                <CheckCircle2 class="h-4 w-4 shrink-0 text-emerald-600" />
                <span>{{ $page.props.flash.success }}</span>
            </div>

            <div
                v-if="form.errors.login"
                class="flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 p-3 text-xs font-medium text-rose-800"
            >
                <ShieldCheck class="h-4 w-4 shrink-0 text-rose-600" />
                <span>{{ form.errors.login }}</span>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Email atau Username</label
                    >
                    <div class="relative">
                        <User
                            class="absolute top-3.5 left-3.5 h-4 w-4 text-zinc-400"
                        />
                        <input
                            v-model="form.login"
                            type="text"
                            required
                            placeholder="nama@email.com atau username"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 py-2.5 pr-4 pl-10 text-xs text-zinc-900 placeholder-zinc-400 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                        />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Password</label
                    >
                    <div class="relative">
                        <Lock
                            class="absolute top-3.5 left-3.5 h-4 w-4 text-zinc-400"
                        />
                        <input
                            v-model="form.password"
                            :type="showPassword ? 'text' : 'password'"
                            required
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 py-2.5 pr-10 pl-10 text-xs text-zinc-900 placeholder-zinc-400 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute top-3 right-3.5 text-zinc-400 hover:text-zinc-700"
                        >
                            <Eye v-if="!showPassword" class="h-4 w-4" />
                            <EyeOff v-else class="h-4 w-4" />
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-0.5 text-xs">
                    <label
                        class="flex cursor-pointer items-center gap-2 text-zinc-600 select-none hover:text-zinc-900"
                    >
                        <input
                            v-model="form.remember"
                            type="checkbox"
                            class="h-3.5 w-3.5 rounded border-zinc-300 text-zinc-950 focus:ring-zinc-950"
                        />
                        <span>Ingat saya</span>
                    </label>
                </div>

                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="flex h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-950 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800 active:scale-[0.98] disabled:opacity-50"
                >
                    <span>Masuk</span>
                    <ArrowRight class="h-3.5 w-3.5" />
                </Button>
            </form>

            <div
                class="border-t border-zinc-100 pt-4 text-center text-xs text-zinc-500"
            >
                <span>Belum punya akun? </span>
                <Link
                    href="/register"
                    class="font-bold text-zinc-950 hover:underline"
                    >Daftar Siswa Baru</Link
                >
            </div>
        </div>
    </div>
</template>
