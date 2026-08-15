<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import { BookOpen, Search, CheckCircle2, XCircle, FileText, Image as ImageIcon, Eye } from '@lucide/vue';
import { ref } from 'vue';

const props = defineProps<{
    recapData: any[];
    filters: {
        search: string;
        date: string;
        status: string;
    };
    stats: {
        total: number;
        filled: number;
        not_filled: number;
    };
}>();

const search = ref(props.filters.search || '');
const date = ref(props.filters.date || '');
const status = ref(props.filters.status || '');

const applyFilter = () => {
    router.get('/admin/journals', { 
        search: search.value, 
        date: date.value, 
        status: status.value 
    }, { preserveState: true });
};

const selectedJournal = ref<any>(null);
const showDetailModal = ref(false);

const openDetailModal = (item: any) => {
    selectedJournal.value = item;
    showDetailModal.value = true;
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header section -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <BookOpen class="w-5 h-5 text-[rgb(93,135,255)]" />
                Rekap Pengisian Jurnal Siswa
            </h1>
            <p class="text-xs text-slate-500 mt-1">Monitoring status siswa yang sudah mengisi vs belum mengisi jurnal harian.</p>
        </div>

        <!-- Stats Bar -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                <p class="text-xs font-semibold text-slate-500">Total Siswa PKL Aktif</p>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ stats.total }} <span class="text-xs font-medium text-slate-400">Siswa</span></p>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                <p class="text-xs font-semibold text-emerald-600">Sudah Mengisi Jurnal</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ stats.filled }} <span class="text-xs font-medium text-emerald-400">Siswa</span></p>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                <p class="text-xs font-semibold text-rose-600">Belum Mengisi Jurnal</p>
                <p class="text-2xl font-bold text-rose-600 mt-1">{{ stats.not_filled }} <span class="text-xs font-medium text-rose-400">Siswa</span></p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" />
                <input v-model="search" @input="applyFilter" type="text" placeholder="Cari nama siswa..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[rgb(93,135,255)]" />
            </div>

            <input v-model="date" @change="applyFilter" type="date" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none" />

            <!-- FILTER KHUSUS ISI vs BELUM ISI (Persis Sesuai Permintaan User) -->
            <select v-model="status" @change="applyFilter" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none font-semibold text-slate-700">
                <option value="">-- Semua Siswa --</option>
                <option value="filled">Sudah Mengisi Jurnal</option>
                <option value="not_filled">Belum Mengisi Jurnal</option>
            </select>
        </div>

        <!-- Journal Recap Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">Nama Siswa</th>
                            <th class="px-5 py-3">Asal Sekolah & Jurusan</th>
                            <th class="px-5 py-3">Tanggal Checked</th>
                            <th class="px-5 py-3">Status Pengisian</th>
                            <th class="px-5 py-3 text-right">Detail Jurnal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="item in recapData" :key="item.id" class="hover:bg-slate-50/50">
                            <td class="px-5 py-4 font-bold text-slate-900">
                                <p>{{ item.name }}</p>
                                <p class="text-[11px] font-normal text-slate-400">@{{ item.username }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-700">
                                <p class="font-semibold">{{ item.school_name }}</p>
                                <p class="text-[11px] text-slate-500">{{ item.major_name }}</p>
                            </td>
                            <td class="px-5 py-4 text-slate-700 whitespace-nowrap">{{ item.date }}</td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold"
                                      :class="item.has_filled ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200'">
                                    <CheckCircle2 v-if="item.has_filled" class="w-3.5 h-3.5 text-emerald-600" />
                                    <XCircle v-else class="w-3.5 h-3.5 text-rose-600" />
                                    <span>{{ item.has_filled ? 'Sudah Mengisi' : 'Belum Mengisi' }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <button 
                                    v-if="item.has_filled"
                                    @click="openDetailModal(item)"
                                    class="px-3 py-1.5 bg-blue-50 text-[rgb(93,135,255)] font-semibold rounded-lg text-xs hover:bg-blue-100 transition-all inline-flex items-center gap-1"
                                >
                                    <Eye class="w-3.5 h-3.5" />
                                    <span>Lihat Jurnal</span>
                                </button>
                                <span v-else class="text-slate-400 font-italic text-[11px]">Tanpa Jurnal</span>
                            </td>
                        </tr>
                        <tr v-if="!recapData || recapData.length === 0">
                            <td colspan="5" class="px-5 py-8 text-center text-xs text-slate-400">
                                Tidak ada data siswa yang sesuai dengan filter.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Jurnal Modal -->
    <div v-if="showDetailModal && selectedJournal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Detail Jurnal Harian</h3>
                    <p class="text-xs text-slate-500">Siswa: {{ selectedJournal.name }} ({{ selectedJournal.date }})</p>
                </div>
                <button @click="showDetailModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <p class="text-slate-400 font-medium">Judul Kegiatan:</p>
                    <p class="font-bold text-slate-900 text-sm mt-0.5">{{ selectedJournal.journal?.title }}</p>
                </div>

                <div>
                    <p class="text-slate-400 font-medium">Deskripsi Kegiatan:</p>
                    <p class="text-slate-700 whitespace-pre-line bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed mt-1">
                        {{ selectedJournal.journal?.description }}
                    </p>
                </div>

                <div v-if="selectedJournal.journal?.proof_file">
                    <p class="text-slate-400 font-medium">Bukti Foto / Lampiran:</p>
                    <a :href="`/storage/${selectedJournal.journal.proof_file}`" target="_blank" class="inline-flex items-center gap-1.5 text-[rgb(93,135,255)] font-semibold hover:underline mt-1">
                        <ImageIcon class="w-4 h-4" />
                        <span>Buka / Download File Bukti</span>
                    </a>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button @click="showDetailModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 font-semibold rounded-xl text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</template>
