<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Sparkles, Upload, Send, Calendar, CheckCircle2, AlertCircle } from '@lucide/vue';
import { ref } from 'vue';

const props = defineProps<{
    schedules: any;
    mySchedule: any[];
    myReports: any;
    todayDate: string;
}>();

const showReportModal = ref(false);

const form = useForm({
    notes: '',
    proof_file: null as File | null,
});

const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.proof_file = target.files[0];
    }
};

const submitReport = () => {
    form.post('/picket/report', {
        onSuccess: () => {
            showReportModal.value = false;
            form.reset();
        },
    });
};

const dayNames: Record<string, string> = {
    senin: 'Senin',
    selasa: 'Selasa',
    rabu: 'Rabu',
    kamis: 'Kamis',
    jumat: "Jum'at",
};
</script>

<template>
    <div class="space-y-6">
            <!-- Header section -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <Sparkles class="w-5 h-5 text-[rgb(93,135,255)]" />
                        Jadwal & Laporan Piket Siswa
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Periksa jadwal tugas piket kebersihan & laporkan bukti kegiatan harian Anda.</p>
                </div>

                <button 
                    @click="showReportModal = true"
                    class="px-4 py-2.5 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-semibold rounded-xl text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 transition-all"
                >
                    <Send class="w-4 h-4" />
                    <span>Laporkan Piket Hari Ini</span>
                </button>
            </div>

            <!-- TAMPILAN JADWAL PIKET (Persis Format yang Diminta User) -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Dashboard Jadwal Piket Mingguan</h3>
                        <p class="text-xs text-slate-500">Shift Pagi & Sore (Senin - Jum'at)</p>
                    </div>
                    <span class="text-xs font-semibold px-3 py-1 bg-blue-50 text-[rgb(93,135,255)] rounded-full">
                        Hari Ini: {{ todayDate }}
                    </span>
                </div>

                <!-- Days Grid -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div v-for="(name, key) in dayNames" :key="key" class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                        <h4 class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-2 text-center bg-white py-1 rounded-lg shadow-xs">
                            {{ name }}
                        </h4>

                        <!-- Shift Pagi -->
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pagi</p>
                            <div v-if="schedules[key]?.pagi && schedules[key].pagi.length > 0" class="space-y-1">
                                <div v-for="(person, idx) in schedules[key].pagi" :key="idx" class="p-2 bg-white rounded-lg text-xs font-semibold text-slate-800 border border-slate-100 shadow-xs">
                                    {{ person }}
                                </div>
                            </div>
                            <p v-else class="text-[11px] text-slate-400 font-italic py-1 text-center bg-white/60 rounded">Belum Ada data</p>
                        </div>

                        <!-- Shift Sore -->
                        <div class="space-y-1 pt-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sore</p>
                            <div v-if="schedules[key]?.sore && schedules[key].sore.length > 0" class="space-y-1">
                                <div v-for="(person, idx) in schedules[key].sore" :key="idx" class="p-2 bg-white rounded-lg text-xs font-semibold text-slate-800 border border-slate-100 shadow-xs">
                                    {{ person }}
                                </div>
                            </div>
                            <p v-else class="text-[11px] text-slate-400 font-italic py-1 text-center bg-white/60 rounded">Belum Ada data</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Laporan Piket -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Riwayat Laporan Piket Anda</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Catatan Laporan</th>
                                <th class="px-4 py-3">Bukti Piket</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="report in myReports.data" :key="report.id" class="hover:bg-slate-50/50">
                                <td class="px-4 py-3.5 font-bold text-slate-900 whitespace-nowrap">{{ report.date }}</td>
                                <td class="px-4 py-3.5 text-slate-600">{{ report.notes || '-' }}</td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <a :href="`/storage/${report.proof_file}`" target="_blank" class="text-[rgb(93,135,255)] font-semibold hover:underline">
                                        Lihat Bukti Foto
                                    </a>
                                </td>
                                <td class="px-4 py-3.5 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize"
                                          :class="report.status === 'verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'">
                                        {{ report.status === 'verified' ? 'Terverifikasi' : 'Menunggu Review' }}
                                    </span>
                                </td>
                            </tr>
                            <tr v-if="!myReports.data || myReports.data.length === 0">
                                <td colspan="4" class="px-4 py-6 text-center text-slate-400">
                                    Belum ada laporan piket yang dikirimkan.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Form Laporkan Piket -->
        <div v-if="showReportModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-base">Laporkan Piket Kebersihan</h3>
                    <button @click="showReportModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <form @submit.prevent="submitReport" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Catatan Laporan Piket</label>
                        <textarea v-model="form.notes" rows="3" placeholder="Sapu dan pel area ruangan..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Bukti Foto Piket (Format Foto JPG/PNG) *</label>
                        <input type="file" accept="image/*" required @change="handleFileUpload" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[rgb(93,135,255)]" />
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="showReportModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs shadow-md shadow-blue-500/20">Kirim Laporan</button>
                    </div>
                </form>
            </div>
    </div>
</template>
