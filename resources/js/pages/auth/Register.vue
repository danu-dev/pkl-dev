<script setup lang="ts">
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import { 
    User, 
    Mail, 
    Lock, 
    Phone, 
    Upload, 
    CheckCircle2, 
    FileText, 
    ArrowRight, 
    ArrowLeft, 
    Building2,
    GraduationCap,
    Eye,
    EyeOff,
    X
} from '@lucide/vue';

defineProps<{
    schools: any[];
    majors: any[];
    batches: any[];
}>();

const currentStep = ref<1 | 2>(1);
const showPassword = ref(false);

const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    school_name: '',
    major_name: '',
    nisn_nim: '',
    phone_number: '',
    cv_file: null as File | null,
});

const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.cv_file = target.files[0];
    }
};

const removeFile = () => {
    form.cv_file = null;
};

const goToStep2 = () => {
    if (!form.name || !form.username || !form.email || !form.phone_number || !form.password || !form.password_confirmation) {
        alert('Harap lengkapi semua kolom langkah 1 sebelum melanjutkan.');
        return;
    }
    if (form.password !== form.password_confirmation) {
        alert('Konfirmasi password tidak cocok.');
        return;
    }
    currentStep.value = 2;
};

const submit = () => {
    form.post('/register');
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 flex flex-col justify-center items-center p-4 sm:p-6 font-sans text-slate-800 selection:bg-[rgb(93,135,255)] selection:text-white">
        <!-- Top Nav -->
        <div class="w-full max-w-lg mb-4 flex items-center justify-between">
            <Link href="/" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[rgb(93,135,255)] to-blue-500 text-white flex items-center justify-center font-extrabold text-base shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    PKL
                </div>
                <span class="font-bold text-slate-900 text-base">SIPKL System</span>
            </Link>

            <Link href="/login" class="text-xs font-semibold text-slate-500 hover:text-[rgb(93,135,255)] flex items-center gap-1 transition-colors">
                <span>Sudah punya akun? Masuk</span>
                <ArrowRight class="w-3.5 h-3.5" />
            </Link>
        </div>

        <!-- Minimalist Register Card -->
        <div class="w-full max-w-lg bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-6 sm:p-8 space-y-6">
            <!-- Header -->
            <div class="space-y-1 text-center">
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Siswa PKL</h1>
                <p class="text-xs text-slate-500">Lengkapi formulir untuk verifikasi akun</p>
            </div>

            <!-- Step Tabs Minimalist -->
            <div class="flex items-center gap-2 p-1 bg-slate-100 rounded-xl border border-slate-200 text-xs font-bold">
                <button 
                    type="button" 
                    @click="currentStep = 1"
                    class="flex-1 py-2 rounded-lg transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                    :class="currentStep === 1 ? 'bg-[rgb(93,135,255)] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                >
                    <User class="w-3.5 h-3.5" />
                    <span>1. Akun</span>
                </button>
                <button 
                    type="button" 
                    @click="goToStep2"
                    class="flex-1 py-2 rounded-lg transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                    :class="currentStep === 2 ? 'bg-[rgb(93,135,255)] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900'"
                >
                    <GraduationCap class="w-3.5 h-3.5" />
                    <span>2. Sekolah & CV</span>
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <!-- STEP 1 -->
                <div v-show="currentStep === 1" class="space-y-3.5">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Nama Lengkap *</label>
                        <input v-model="form.name" type="text" required placeholder="Afdanu Aprilian" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                        <span v-if="form.errors.name" class="text-[11px] text-rose-500">{{ form.errors.name }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">Username *</label>
                            <input v-model="form.username" type="text" required placeholder="afdanu" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                            <span v-if="form.errors.username" class="text-[11px] text-rose-500">{{ form.errors.username }}</span>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">Email *</label>
                            <input v-model="form.email" type="email" required placeholder="email@contoh.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                            <span v-if="form.errors.email" class="text-[11px] text-rose-500">{{ form.errors.email }}</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Nomor WhatsApp *</label>
                        <input v-model="form.phone_number" type="text" required placeholder="081234567890" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                        <span v-if="form.errors.phone_number" class="text-[11px] text-rose-500">{{ form.errors.phone_number }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">Password *</label>
                            <div class="relative">
                                <input v-model="form.password" :type="showPassword ? 'text' : 'password'" required placeholder="Minimal 8 karakter" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                    <Eye v-if="!showPassword" class="w-4 h-4" />
                                    <EyeOff v-else class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">Ulangi Password *</label>
                            <input v-model="form.password_confirmation" :type="showPassword ? 'text' : 'password'" required placeholder="Konfirmasi password" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                        </div>
                    </div>

                    <button 
                        type="button" 
                        @click="goToStep2"
                        class="w-full py-3 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 transition-all cursor-pointer mt-2"
                    >
                        <span>Lanjut ke Langkah 2</span>
                        <ArrowRight class="w-4 h-4" />
                    </button>
                </div>

                <!-- STEP 2 -->
                <div v-show="currentStep === 2" class="space-y-3.5">
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-700">Asal Sekolah / Kampus *</label>
                        <input v-model="form.school_name" type="text" required placeholder="SMKN 1 Surabaya" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">Jurusan *</label>
                            <input v-model="form.major_name" type="text" required placeholder="Rekayasa Perangkat Lunak" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-700">NISN / NIM</label>
                            <input v-model="form.nisn_nim" type="text" placeholder="12345678" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)] focus:bg-white" />
                        </div>
                    </div>

                    <!-- Upload CV -->
                    <div class="space-y-1 pt-1">
                        <label class="text-xs font-bold text-slate-700">Berkas CV (PDF) *</label>
                        <div v-if="!form.cv_file" class="border-2 border-dashed border-slate-200 hover:border-[rgb(93,135,255)] rounded-2xl p-4 text-center transition-all bg-slate-50">
                            <input type="file" accept=".pdf" required @change="handleFileUpload" class="hidden" id="cv-upload-min" />
                            <label for="cv-upload-min" class="cursor-pointer flex flex-col items-center gap-1.5">
                                <Upload class="w-5 h-5 text-[rgb(93,135,255)]" />
                                <p class="text-xs font-bold text-slate-800">Pilih berkas PDF CV (Maks 5MB)</p>
                            </label>
                        </div>
                        <div v-else class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate">
                                <FileText class="w-4 h-4 text-rose-500 shrink-0" />
                                <span class="text-xs font-semibold text-slate-800 truncate">{{ form.cv_file.name }}</span>
                            </div>
                            <button type="button" @click="removeFile" class="text-slate-400 hover:text-rose-600"><X class="w-4 h-4" /></button>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button 
                            type="button" 
                            @click="currentStep = 1"
                            class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold flex items-center gap-1 transition-all cursor-pointer"
                        >
                            <ArrowLeft class="w-3.5 h-3.5" />
                            <span>Kembali</span>
                        </button>

                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="flex-1 py-2.5 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 text-xs transition-all disabled:opacity-50 cursor-pointer"
                        >
                            <CheckCircle2 class="w-4 h-4" />
                            <span>Kirim Pendaftaran</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
