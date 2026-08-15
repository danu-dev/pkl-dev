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
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <Clock class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Pengaturan Waktu Operasional Jurnal & Absensi (Admin Control)
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Atur jam buka & jam tutup pengisian jurnal harian serta batasan jam tombol absensi 1-klik untuk seluruh siswa.
                </p>
            </div>

            <!-- Form Dynamic Time Constraints -->
            <form @submit.prevent="submitSettings" class="space-y-6">
                <!-- 1. PENGATURAN JAM JURNAL -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <Clock class="w-4 h-4 text-[rgb(93,135,255)]" />
                            Batasan Jam Pengisian Jurnal Harian
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Contoh: Buka jam 04:00 (Sore/Pagi) dan Stop maksimal jam 23:59 (12.00 malam).</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Jam Mulai Bisa Diisi Jurnal (Buka)</label>
                            <input v-model="form.journal_start_time" type="time" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:border-[rgb(93,135,255)]" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Maksimal Jam Boleh Diisi Jurnal (Stop)</label>
                            <input v-model="form.journal_end_time" type="time" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold focus:border-[rgb(93,135,255)]" />
                        </div>
                    </div>
                </div>

                <!-- 2. PENGATURAN JAM TOMBOL ABSENSI 1-KLIK -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <Clock class="w-4 h-4 text-emerald-600" />
                            Batasan Jam Tombol Absensi 1-Klik (Masuk & Pulang)
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tombol Absen Masuk/Pulang di halaman siswa akan terkunci otomatis di luar jam ini.</p>
                    </div>

                    <!-- Absen Masuk -->
                    <div class="space-y-2">
                        <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">A. Window Jam Absen Masuk</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Jam Mulai Buka Absen Masuk</label>
                                <input v-model="form.attendance_in_start" type="time" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Jam Stop / Batas Akhir Masuk</label>
                                <input v-model="form.attendance_in_end" type="time" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold" />
                            </div>
                        </div>
                    </div>

                    <!-- Absen Pulang -->
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-800 uppercase tracking-wider">B. Window Jam Absen Pulang</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Jam Mulai Buka Absen Pulang</label>
                                <input v-model="form.attendance_out_start" type="time" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold" />
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700">Jam Stop / Batas Akhir Pulang</label>
                                <input v-model="form.attendance_out_end" type="time" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        :disabled="form.processing"
                        class="px-6 py-3 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 flex items-center gap-2 text-sm transition-all"
                    >
                        <Save class="w-4 h-4" />
                        <span>Simpan Pengaturan Jam Operasional</span>
                    </button>
                </div>
            </form>
    </div>
</template>
