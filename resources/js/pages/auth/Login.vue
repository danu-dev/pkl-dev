<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { User, Lock, ArrowRight, ShieldCheck } from '@lucide/vue';

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4 font-sans text-slate-800">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <!-- Header Banner -->
            <div class="bg-gradient-to-tr from-[rgb(93,135,255)] to-blue-500 p-8 text-white text-center">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mx-auto mb-3 font-bold text-2xl border border-white/20">
                    PKL
                </div>
                <h1 class="text-2xl font-bold tracking-tight">Portal Masuk SIPKL</h1>
                <p class="text-xs text-blue-100 mt-1 font-medium">Sistem Monitoring Jurnal & Absensi PKL</p>
            </div>

            <!-- Login Form -->
            <form @submit.prevent="submit" class="p-8 space-y-5">
                <div v-if="$page.props.flash?.success" class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs font-medium">
                    {{ $page.props.flash.success }}
                </div>

                <div v-if="form.errors.login" class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs font-medium">
                    {{ form.errors.login }}
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-700">Email atau Username</label>
                    <div class="relative">
                        <User class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                        <input 
                            v-model="form.login" 
                            type="text" 
                            required 
                            placeholder="Masukkan email atau username"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white transition-all"
                        />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-700">Password</label>
                    <div class="relative">
                        <Lock class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" />
                        <input 
                            v-model="form.password" 
                            type="password" 
                            required 
                            placeholder="••••••••"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white transition-all"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input v-model="form.remember" type="checkbox" class="rounded text-[rgb(93,135,255)] focus:ring-[rgb(93,135,255)]" />
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="w-full py-3 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 text-sm transition-all disabled:opacity-50"
                >
                    <span>Masuk ke Akun</span>
                    <ArrowRight class="w-4 h-4" />
                </button>

                <div class="pt-4 border-t border-slate-100 text-center text-xs text-slate-500 space-y-2">
                    <p>Belum memiliki akun Siswa PKL?</p>
                    <Link href="/register" class="inline-flex items-center gap-1 font-semibold text-[rgb(93,135,255)] hover:underline">
                        <span>Daftar Siswa PKL Baru</span>
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
