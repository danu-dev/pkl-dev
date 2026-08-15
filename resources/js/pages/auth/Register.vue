<script setup lang="ts">
import { useForm, Link } from '@inertiajs/vue3';
import { User, Mail, Lock, Building, GraduationCap, Phone, Upload, CheckCircle2 } from '@lucide/vue';

defineProps<{
    schools: any[];
    majors: any[];
    batches: any[];
}>();

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

const submit = () => {
    form.post('/register');
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 flex items-center justify-center p-4 font-sans text-slate-800 my-8">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <!-- Header Banner -->
            <div class="bg-gradient-to-tr from-[rgb(93,135,255)] to-blue-500 p-8 text-white">
                <h1 class="text-2xl font-bold tracking-tight">Pendaftaran Siswa PKL Baru</h1>
                <p class="text-xs text-blue-100 mt-1 font-medium">Lengkapi data diri dan unggah CV PDF Anda untuk verifikasi Admin.</p>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="p-8 space-y-6">
                <!-- Data Diri -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">1. Data Pengguna & Akun</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Nama Lengkap *</label>
                            <input v-model="form.name" type="text" required placeholder="Contoh: AFDANU APRILIAN" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                            <span v-if="form.errors.name" class="text-xs text-rose-500">{{ form.errors.name }}</span>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Username *</label>
                            <input v-model="form.username" type="text" required placeholder="afdanu" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                            <span v-if="form.errors.username" class="text-xs text-rose-500">{{ form.errors.username }}</span>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Email Aktif *</label>
                            <input v-model="form.email" type="email" required placeholder="email@contoh.com" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                            <span v-if="form.errors.email" class="text-xs text-rose-500">{{ form.errors.email }}</span>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Nomor HP / WhatsApp *</label>
                            <input v-model="form.phone_number" type="text" required placeholder="081234567890" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                            <span v-if="form.errors.phone_number" class="text-xs text-rose-500">{{ form.errors.phone_number }}</span>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Password *</label>
                            <input v-model="form.password" type="password" required placeholder="Minimal 8 karakter" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                            <span v-if="form.errors.password" class="text-xs text-rose-500">{{ form.errors.password }}</span>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Konfirmasi Password *</label>
                            <input v-model="form.password_confirmation" type="password" required placeholder="Ulangi password" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                        </div>
                    </div>
                </div>

                <!-- Detail Institusi & CV -->
                <div class="space-y-4 pt-2">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">2. Asal Sekolah & Upload CV PDF</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Asal Sekolah / Kampus *</label>
                            <input v-model="form.school_name" type="text" required placeholder="SMKN 1 Surabaya" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Jurusan *</label>
                            <input v-model="form.major_name" type="text" required placeholder="Rekayasa Perangkat Lunak" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                        </div>

                        <div class="space-y-1 md:col-span-2">
                            <label class="text-xs font-semibold text-slate-700">NISN / NIM</label>
                            <input v-model="form.nisn_nim" type="text" placeholder="12345678" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                        </div>
                    </div>

                    <!-- Upload File CV PDF -->
                    <div class="space-y-1.5 pt-2">
                        <label class="text-xs font-semibold text-slate-700">Upload File CV (PDF Minimal / Maksimal 5MB) *</label>
                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-[rgb(93,135,255)] transition-all bg-slate-50">
                            <input type="file" accept=".pdf" required @change="handleFileUpload" class="hidden" id="cv-upload" />
                            <label for="cv-upload" class="cursor-pointer flex flex-col items-center gap-2">
                                <Upload class="w-6 h-6 text-[rgb(93,135,255)]" />
                                <span class="text-xs font-medium text-slate-600">
                                    {{ form.cv_file ? form.cv_file.name : 'Klik untuk memilih file PDF CV Anda' }}
                                </span>
                            </label>
                        </div>
                        <span v-if="form.errors.cv_file" class="text-xs text-rose-500">{{ form.errors.cv_file }}</span>
                    </div>
                </div>

                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-900 space-y-1">
                    <p class="font-bold">Informasi Aktivasi Akun:</p>
                    <p>Setelah melakukan pendaftaran, akun Anda berstatus <strong>Pending</strong> dan tidak bisa langsung digunakan login sebelum disetujui (Approve) oleh Admin.</p>
                </div>

                <button 
                    type="submit" 
                    :disabled="form.processing"
                    class="w-full py-3 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 text-sm transition-all disabled:opacity-50"
                >
                    <CheckCircle2 class="w-4 h-4" />
                    <span>Daftarkan Akun Siswa PKL</span>
                </button>

                <div class="text-center text-xs text-slate-500">
                    <span>Sudah memiliki akun? </span>
                    <Link href="/login" class="font-semibold text-[rgb(93,135,255)] hover:underline">Masuk di sini</Link>
                </div>
            </form>
        </div>
    </div>
</template>
