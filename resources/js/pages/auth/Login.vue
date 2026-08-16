<script setup lang="ts">
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import { 
    User, 
    Lock, 
    ArrowRight, 
    Eye, 
    EyeOff, 
    ShieldCheck, 
    CheckCircle2, 
    ArrowLeft
} from '@lucide/vue';

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
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center p-4 sm:p-6 font-sans text-slate-800 selection:bg-[rgb(93,135,255)] selection:text-white">
        <!-- Minimalist Back to Home -->
        <div class="w-full max-w-md mb-4 flex items-center justify-between">
            <Link href="/" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 rounded-2xl overflow-hidden shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform shrink-0">
                    <img src="/images/app-icon.png" alt="SIPKL" class="w-full h-full object-contain" />
                </div>
                <span class="font-black text-slate-900 text-base tracking-tight">SIPKL System</span>
            </Link>

            <Link href="/" class="text-xs font-semibold text-slate-500 hover:text-[rgb(93,135,255)] flex items-center gap-1 transition-colors">
                <ArrowLeft class="w-3.5 h-3.5" />
                <span>Beranda</span>
            </Link>
        </div>

        <!-- Minimalist Auth Card -->
        <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-7 sm:p-9 space-y-6">
            <!-- Header Text -->
            <div class="space-y-1 text-center">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Masuk ke Portal</h1>
                <p class="text-xs text-slate-500">Silakan masukkan akun Anda untuk melanjutkan</p>
            </div>

            <!-- Alerts -->
            <div v-if="$page.props.flash?.success" class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-medium flex items-center gap-2.5">
                <CheckCircle2 class="w-4 h-4 text-emerald-600 shrink-0" />
                <span>{{ $page.props.flash.success }}</span>
            </div>

            <div v-if="form.errors.login" class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-medium flex items-center gap-2.5">
                <ShieldCheck class="w-4 h-4 text-rose-600 shrink-0" />
                <span>{{ form.errors.login }}</span>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700">Email atau Username</label>
                    <div class="relative">
                        <User class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                        <input 
                            v-model="form.login" 
                            type="text" 
                            required 
                            placeholder="nama@email.com atau username"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white focus:ring-2 focus:ring-[rgb(93,135,255)]/20 transition-all"
                        />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700">Password</label>
                    <div class="relative">
                        <Lock class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                        <input 
                            v-model="form.password" 
                            :type="showPassword ? 'text' : 'password'" 
                            required 
                            placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white focus:ring-2 focus:ring-[rgb(93,135,255)]/20 transition-all"
                        />
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute right-3.5 top-3 text-slate-400 hover:text-slate-600"
                        >
                            <Eye v-if="!showPassword" class="w-4 h-4" />
                            <EyeOff v-else class="w-4 h-4" />
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 hover:text-slate-800 select-none">
                        <input 
                            v-model="form.remember" 
                            type="checkbox" 
                            class="w-4 h-4 rounded border-slate-300 text-[rgb(93,135,255)] focus:ring-[rgb(93,135,255)]" 
                        />
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="w-full py-3 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 text-xs transition-all disabled:opacity-50 active:scale-[0.99] cursor-pointer"
                >
                    <span>Masuk</span>
                    <ArrowRight class="w-4 h-4" />
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500">
                <span>Belum punya akun? </span>
                <Link href="/register" class="font-bold text-[rgb(93,135,255)] hover:underline">Daftar Siswa Baru</Link>
            </div>
        </div>
    </div>
</template>
