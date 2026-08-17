<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Clock, Save, Lock, AlertCircle } from '@lucide/vue';

const props = defineProps<{
    settings: {
        journal_start_time: string;
        journal_end_time: string;
        attendance_in_start: string;
        attendance_in_end: string;
        attendance_out_start: string;
        attendance_out_end: string;
        is_holiday_mode: string;
    };
}>();

const form = useForm({
    journal_start_time: props.settings.journal_start_time || '04:00',
    journal_end_time: props.settings.journal_end_time || '23:59',
    attendance_in_start: props.settings.attendance_in_start || '06:00',
    attendance_in_end: props.settings.attendance_in_end || '09:00',
    attendance_out_start: props.settings.attendance_out_start || '15:00',
    attendance_out_end: props.settings.attendance_out_end || '18:00',
    is_holiday_mode: props.settings.is_holiday_mode || 'false',
});

const submitSettings = () => {
    form.post('/admin/settings');
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header section (PERSIS FITUR DUA ARAH YANG DIINGINKAN USER) -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs">
            <h1
                class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
            >
                <Clock class="h-5 w-5 text-zinc-900" />
                Pengaturan Waktu Operasional Jurnal & Absensi (Admin Control)
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Atur jam buka & jam tutup pengisian jurnal harian serta batasan
                jam tombol absensi 1-klik untuk seluruh siswa.
            </p>
        </div>

        <!-- Form Dynamic Time Constraints -->
        <form @submit.prevent="submitSettings" class="space-y-6">
            <!-- 1. PENGATURAN JAM JURNAL -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
            >
                <div class="border-b border-zinc-100 pb-3">
                    <h3
                        class="flex items-center gap-2 text-sm font-bold text-zinc-900"
                    >
                        <Clock class="h-4 w-4 text-zinc-900" />
                        Batasan Jam Pengisian Jurnal Harian
                    </h3>
                    <p class="mt-0.5 text-xs text-zinc-500">
                        Contoh: Buka jam 04:00 (Sore/Pagi) dan Stop maksimal jam
                        23:59 (12.00 malam).
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Jam Mulai Bisa Diisi Jurnal (Buka)</label
                        >
                        <input
                            v-model="form.journal_start_time"
                            type="time"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-sm font-semibold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Maksimal Jam Boleh Diisi Jurnal (Stop)</label
                        >
                        <input
                            v-model="form.journal_end_time"
                            type="time"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-sm font-semibold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>
            </div>

            <!-- 2. PENGATURAN JAM TOMBOL ABSENSI 1-KLIK -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
            >
                <div class="border-b border-zinc-100 pb-3">
                    <h3
                        class="flex items-center gap-2 text-sm font-bold text-zinc-900"
                    >
                        <Clock class="h-4 w-4 text-emerald-600" />
                        Batasan Jam Tombol Absensi 1-Klik (Masuk & Pulang)
                    </h3>
                    <p class="mt-0.5 text-xs text-zinc-500">
                        Tombol Absen Masuk/Pulang di halaman siswa akan terkunci
                        otomatis di luar jam ini.
                    </p>
                </div>

                <!-- Absen Masuk -->
                <div class="space-y-2">
                    <p
                        class="text-xs font-bold tracking-wider text-zinc-800 uppercase"
                    >
                        A. Window Jam Absen Masuk
                    </p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Jam Mulai Buka Absen Masuk</label
                            >
                            <input
                                v-model="form.attendance_in_start"
                                type="time"
                                required
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-sm font-semibold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Jam Stop / Batas Akhir Masuk</label
                            >
                            <input
                                v-model="form.attendance_in_end"
                                type="time"
                                required
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-sm font-semibold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>

                <!-- Absen Pulang -->
                <div class="space-y-2 border-t border-zinc-100 pt-2">
                    <p
                        class="text-xs font-bold tracking-wider text-zinc-800 uppercase"
                    >
                        B. Window Jam Absen Pulang
                    </p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Jam Mulai Buka Absen Pulang</label
                            >
                            <input
                                v-model="form.attendance_out_start"
                                type="time"
                                required
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-sm font-semibold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Jam Stop / Batas Akhir Pulang</label
                            >
                            <input
                                v-model="form.attendance_out_end"
                                type="time"
                                required
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-sm font-semibold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex cursor-pointer items-center gap-2 rounded-xl bg-zinc-950 px-6 py-3 text-sm font-bold text-white shadow-xs transition-all hover:bg-zinc-800"
                >
                    <Save class="h-4 w-4" />
                    <span>Simpan Pengaturan Jam Operasional</span>
                </button>
            </div>
        </form>
    </div>
</template>
