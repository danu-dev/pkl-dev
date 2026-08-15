<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Send, Image as ImageIcon } from '@lucide/vue';
import { ref } from 'vue';

defineProps<{
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
    form.post('/picket-report', {
        onSuccess: () => {
            showReportModal.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <Send class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Laporan Piket Kebersihan
                </h1>
                <p class="text-xs text-slate-500 mt-1">Kirimkan catatan & bukti foto kegiatan piket harian Anda.</p>
            </div>

            <button 
                @click="showReportModal = true"
                class="px-4 py-2.5 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-semibold rounded-xl text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 transition-all"
            >
                <Send class="w-4 h-4" />
                <span>Laporkan Piket Hari Ini</span>
            </button>
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
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Catatan Laporan</th>
                            <th class="px-5 py-3">Bukti Piket</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="report in myReports.data" :key="report.id" class="hover:bg-slate-50/50">
                            <td class="px-5 py-4 font-bold text-slate-900 whitespace-nowrap">{{ report.date }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ report.notes || '-' }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <a :href="`/storage/${report.proof_file}`" target="_blank" class="inline-block group">
                                    <img :src="`/storage/${report.proof_file}`" alt="Bukti Piket" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-xs group-hover:scale-105 transition-transform" />
                                </a>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize"
                                      :class="report.status === 'verified' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'">
                                    {{ report.status === 'verified' ? 'Terverifikasi' : 'Menunggu Review' }}
                                </span>
                            </td>
                        </tr>
                        <tr v-if="!myReports.data || myReports.data.length === 0">
                            <td colspan="4" class="px-5 py-8 text-center text-xs text-slate-400">
                                Belum ada laporan piket yang dikirimkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    </div>
</template>
