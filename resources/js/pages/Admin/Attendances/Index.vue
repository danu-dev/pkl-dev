<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { ClipboardList, Search, Plus, CalendarCheck, UserCheck } from '@lucide/vue';
import { ref } from 'vue';

const props = defineProps<{
    attendances: any;
    stats: any;
    filters: any;
    allStudents: any[];
}>();

const search = ref(props.filters.search || '');
const date = ref(props.filters.date || '');
const status = ref(props.filters.status || '');

const applyFilter = () => {
    router.get('/admin/attendances', { search: search.value, date: date.value, status: status.value }, { preserveState: true });
};

const showManualModal = ref(false);

const manualForm = useForm({
    user_id: '',
    date: new Date().toISOString().split('T')[0],
    status: 'hadir',
    time_in: '08:00',
    time_out: '16:00',
    notes: 'Koreksi Admin Manual',
});

const submitManual = () => {
    manualForm.post('/admin/attendances/manual', {
        onSuccess: () => {
            showManualModal.value = false;
        },
    });
};
</script>

<template>
    <div class="space-y-6">
            <!-- Header section TERPISAH (Kebutuhan Spesifik User) -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <ClipboardList class="w-5 h-5 text-[rgb(93,135,255)]" />
                        Halaman Rekapitulasi Absensi Siswa (Terpisah)
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Rekap log presensi harian, override absensi manual, dan laporan kehadiran seluruh siswa.</p>
                </div>

                <button @click="showManualModal = true" class="px-4 py-2.5 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs flex items-center gap-2 shadow-md shadow-blue-500/20">
                    <Plus class="w-4 h-4" />
                    <span>Input Absensi Manual</span>
                </button>
            </div>

            <!-- Stats Mini Bar -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[11px] font-semibold text-slate-400">Total Siswa PKL</p>
                    <p class="text-xl font-bold text-slate-900 mt-0.5">{{ stats.total_students }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[11px] font-semibold text-emerald-600">Hadir Hari Ini</p>
                    <p class="text-xl font-bold text-emerald-600 mt-0.5">{{ stats.today_hadir }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[11px] font-semibold text-amber-600">Izin / Sakit Hari Ini</p>
                    <p class="text-xl font-bold text-amber-600 mt-0.5">{{ stats.today_izin_sakit }}</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[11px] font-semibold text-rose-600">Alpha Hari Ini</p>
                    <p class="text-xl font-bold text-rose-600 mt-0.5">{{ stats.today_alpha }}</p>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" />
                    <input v-model="search" @input="applyFilter" type="text" placeholder="Cari nama siswa..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[rgb(93,135,255)]" />
                </div>

                <input v-model="date" @change="applyFilter" type="date" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none" />

                <select v-model="status" @change="applyFilter" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    <option value="">-- Semua Status --</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>

            <!-- Attendance Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3">Tanggal</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Jam Masuk</th>
                                <th class="px-5 py-3">Jam Pulang</th>
                                <th class="px-5 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="att in attendances.data" :key="att.id" class="hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    <p>{{ att.user?.name }}</p>
                                    <p class="text-[11px] font-normal text-slate-400">{{ att.user?.profile?.school_name }}</p>
                                </td>
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap">{{ att.date }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize"
                                          :class="{
                                              'bg-emerald-50 text-emerald-700': att.status === 'hadir',
                                              'bg-amber-50 text-amber-700': att.status === 'izin' || att.status === 'sakit',
                                              'bg-rose-50 text-rose-700': att.status === 'alpha',
                                          }">
                                        {{ att.status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">{{ att.time_in || '-' }}</td>
                                <td class="px-5 py-4 font-medium text-slate-800">{{ att.time_out || '-' }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ att.notes || '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Manual Override Modal -->
        <div v-if="showManualModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-base">Input / Override Absensi Manual</h3>
                    <button @click="showManualModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <form @submit.prevent="submitManual" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Pilih Siswa *</label>
                        <select v-model="manualForm.user_id" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="">-- Pilih Siswa --</option>
                            <option v-for="s in allStudents" :key="s.id" :value="s.id">{{ s.name }}</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Tanggal *</label>
                            <input v-model="manualForm.date" type="date" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Status *</label>
                            <select v-model="manualForm.status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="alpha">Alpha</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Jam Masuk</label>
                            <input v-model="manualForm.time_in" type="time" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Jam Pulang</label>
                            <input v-model="manualForm.time_out" type="time" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Catatan</label>
                        <input v-model="manualForm.notes" type="text" placeholder="Catatan perbaikan..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="showManualModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                        <button type="submit" :disabled="manualForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Data Absensi</button>
                    </div>
                </form>
            </div>
    </div>
</template>
