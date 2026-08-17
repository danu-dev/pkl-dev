<script setup lang="ts">
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
    X,
} from '@lucide/vue';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';

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
    if (
        !form.name ||
        !form.username ||
        !form.email ||
        !form.phone_number ||
        !form.password ||
        !form.password_confirmation
    ) {
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
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-white p-4 font-sans text-zinc-900 selection:bg-zinc-950 selection:text-white sm:p-6"
    >
        <!-- Top Nav -->
        <div class="mb-6 flex w-full max-w-md items-center justify-between">
            <Link href="/" class="group flex items-center">
                <span
                    class="text-xl font-extrabold tracking-tight text-zinc-950"
                >
                    SIPKL<span class="text-zinc-950">.</span>
                </span>
            </Link>

            <Link
                href="/login"
                class="flex items-center gap-1 text-xs font-medium text-zinc-500 transition-colors hover:text-zinc-950"
            >
                <span>Sudah punya akun? Masuk</span>
                <ArrowRight class="h-3.5 w-3.5" />
            </Link>
        </div>

        <!-- Minimalist Register Card (Monochrome Modern B&W) -->
        <div
            class="w-full max-w-md space-y-6 rounded-2xl border border-zinc-200 bg-white p-6 shadow-xs sm:p-8"
        >
            <!-- Header -->
            <div class="space-y-1 text-center">
                <h1 class="text-xl font-bold tracking-tight text-zinc-950">
                    Daftar Akun Siswa
                </h1>
                <p class="text-xs text-zinc-500">
                    Lengkapi formulir untuk verifikasi pendaftaran
                </p>
            </div>

            <!-- Step Tabs Minimalist -->
            <div
                class="flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-zinc-100 p-1 text-xs font-semibold"
            >
                <button
                    type="button"
                    @click="currentStep = 1"
                    class="flex flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg py-1.5 text-xs transition-all"
                    :class="
                        currentStep === 1
                            ? 'bg-zinc-950 text-white shadow-2xs'
                            : 'text-zinc-600 hover:text-zinc-950'
                    "
                >
                    <User class="h-3.5 w-3.5" />
                    <span>1. Akun</span>
                </button>
                <button
                    type="button"
                    @click="goToStep2"
                    class="flex flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg py-1.5 text-xs transition-all"
                    :class="
                        currentStep === 2
                            ? 'bg-zinc-950 text-white shadow-2xs'
                            : 'text-zinc-600 hover:text-zinc-950'
                    "
                >
                    <GraduationCap class="h-3.5 w-3.5" />
                    <span>2. Institusi & CV</span>
                </button>
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-4">
                <!-- STEP 1 -->
                <div v-show="currentStep === 1" class="space-y-3.5">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Nama Lengkap *</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            placeholder="Afdanu Aprilian"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                        />
                        <span
                            v-if="form.errors.name"
                            class="text-[11px] text-rose-500"
                            >{{ form.errors.name }}</span
                        >
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Username *</label
                            >
                            <input
                                v-model="form.username"
                                type="text"
                                required
                                placeholder="afdanu"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                            />
                            <span
                                v-if="form.errors.username"
                                class="text-[11px] text-rose-500"
                                >{{ form.errors.username }}</span
                            >
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Email *</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                placeholder="email@contoh.com"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                            />
                            <span
                                v-if="form.errors.email"
                                class="text-[11px] text-rose-500"
                                >{{ form.errors.email }}</span
                            >
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Nomor WhatsApp *</label
                        >
                        <input
                            v-model="form.phone_number"
                            type="text"
                            required
                            placeholder="081234567890"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                        />
                        <span
                            v-if="form.errors.phone_number"
                            class="text-[11px] text-rose-500"
                            >{{ form.errors.phone_number }}</span
                        >
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Password *</label
                            >
                            <div class="relative">
                                <input
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    placeholder="Minimal 8 karakter"
                                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute top-2.5 right-3 text-zinc-400 hover:text-zinc-700"
                                >
                                    <Eye v-if="!showPassword" class="h-4 w-4" />
                                    <EyeOff v-else class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Ulangi Password *</label
                            >
                            <input
                                v-model="form.password_confirmation"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                placeholder="Konfirmasi password"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                            />
                        </div>
                    </div>

                    <Button
                        type="button"
                        @click="goToStep2"
                        class="mt-2 flex h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-950 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800"
                    >
                        <span>Lanjut ke Langkah 2</span>
                        <ArrowRight class="h-3.5 w-3.5" />
                    </Button>
                </div>

                <!-- STEP 2 -->
                <div v-show="currentStep === 2" class="space-y-3.5">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Asal Sekolah / Kampus *</label
                        >
                        <input
                            v-model="form.school_name"
                            type="text"
                            required
                            placeholder="SMKN 1 Surabaya"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                        />
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Jurusan *</label
                            >
                            <input
                                v-model="form.major_name"
                                type="text"
                                required
                                placeholder="Rekayasa Perangkat Lunak"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >NISN / NIM</label
                            >
                            <input
                                v-model="form.nisn_nim"
                                type="text"
                                placeholder="12345678"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50/50 px-3.5 py-2.5 text-xs text-zinc-900 transition-all focus:border-zinc-950 focus:bg-white focus:outline-none sm:text-sm"
                            />
                        </div>
                    </div>

                    <!-- Upload CV -->
                    <div class="space-y-1.5 pt-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Berkas CV (PDF) *</label
                        >
                        <div
                            v-if="!form.cv_file"
                            class="rounded-xl border-2 border-dashed border-zinc-200 bg-zinc-50/50 p-4 text-center transition-all hover:border-zinc-400"
                        >
                            <input
                                type="file"
                                accept=".pdf"
                                required
                                @change="handleFileUpload"
                                class="hidden"
                                id="cv-upload-min"
                            />
                            <label
                                for="cv-upload-min"
                                class="flex cursor-pointer flex-col items-center gap-1.5"
                            >
                                <Upload class="h-5 w-5 text-zinc-900" />
                                <p class="text-xs font-semibold text-zinc-800">
                                    Pilih berkas PDF CV (Maks 5MB)
                                </p>
                            </label>
                        </div>
                        <div
                            v-else
                            class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 p-3"
                        >
                            <div class="flex items-center gap-2.5 truncate">
                                <FileText
                                    class="h-4 w-4 shrink-0 text-zinc-950"
                                />
                                <span
                                    class="truncate text-xs font-medium text-zinc-800"
                                    >{{ form.cv_file.name }}</span
                                >
                            </div>
                            <button
                                type="button"
                                @click="removeFile"
                                class="text-zinc-400 hover:text-zinc-900"
                            >
                                <X class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <Button
                            type="button"
                            variant="outline"
                            @click="currentStep = 1"
                            class="flex h-11 cursor-pointer items-center gap-1 rounded-xl border-zinc-200 px-4 text-xs font-semibold text-zinc-700 transition-all hover:bg-zinc-100"
                        >
                            <ArrowLeft class="h-3.5 w-3.5" />
                            <span>Kembali</span>
                        </Button>

                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="flex h-11 flex-1 cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-950 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800 disabled:opacity-50"
                        >
                            <CheckCircle2 class="h-3.5 w-3.5" />
                            <span>Kirim Pendaftaran</span>
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
