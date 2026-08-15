<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { CalendarCheck, CheckCircle2, Clock, AlertTriangle, FileUp, Sparkles, UserX, UserCheck } from '@lucide/vue';
import { ref } from 'vue';

const props = defineProps<{
    stats: {
        total: number;
        hadir: number;
        izin_sakit: number;
        alpha: number;
    };
    todayAttendance: any;
    canClockIn: boolean;
    canClockOut: boolean;
    operatingHours: {
        inStart: string;
        inEnd: string;
        outStart: string;
        outEnd: string;
    };
    attendances: any;
    leaveRequests: any[];
    studentName: string;
}>();

const showLeaveModal = ref(false);

const leaveForm = useForm({
    type: 'izin',
    start_date: '',
    end_date: '',
    reason: '',
    attachment: null as File | null,
});

const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        leaveForm.attachment = target.files[0];
    }
};

const clockInForm = useForm({});
const clockOutForm = useForm({});

const submitClockIn = () => {
    clockInForm.post('/absensi/clock-in');
};

const submitClockOut = () => {
    clockOutForm.post('/absensi/clock-out');
};

const submitLeave = () => {
    leaveForm.post('/absensi/leave', {
        onSuccess: () => {
            showLeaveModal.value = false;
            leaveForm.reset();
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
                        <CalendarCheck class="w-5 h-5 text-[rgb(93,135,255)]" />
                        Absensi Siswa PKL
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Lakukan presensi harian secara mudah dalam jendela jam operasional.</p>
                </div>

            <button 
                @click="showLeaveModal = true"
                class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs flex items-center justify-center gap-2 transition-all"
            >
                <FileUp class="w-4 h-4 text-slate-600" />
                <span>Pengajuan Izin / Sakit</span>
            </button>
        </div>

        <!-- 4 STATISTIK CARDS (Persis sesuai spesifikasi user) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-1">
                <p class="text-xs font-semibold text-slate-500">Total Absensi</p>
                <p class="text-2xl font-bold text-slate-900">{{ stats.total }} <span class="text-xs font-medium text-slate-400">Kali</span></p>
                <p class="text-[11px] text-slate-400">Absensi Terdaftar</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-1">
                <p class="text-xs font-semibold text-emerald-600">Total Hadir</p>
                <p class="text-2xl font-bold text-emerald-600">{{ stats.hadir }} <span class="text-xs font-medium text-emerald-400">Kali</span></p>
                <p class="text-[11px] text-slate-400">Absensi Tepat Waktu</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-1">
                <p class="text-xs font-semibold text-amber-600">Total Izin & Sakit</p>
                <p class="text-2xl font-bold text-amber-600">{{ stats.izin_sakit }} <span class="text-xs font-medium text-amber-400">Kali</span></p>
                <p class="text-[11px] text-slate-400">Surat Disetujui</p>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-1">
                <p class="text-xs font-semibold text-rose-600">Total Alpha</p>
                <p class="text-2xl font-bold text-rose-600">{{ stats.alpha }} <span class="text-xs font-medium text-rose-400">Kali</span></p>
                <p class="text-[11px] text-slate-400">Tanpa Keterangan</p>
            </div>
        </div>

        <!-- CARD ABSENSI 1-KLIK HEROBOX -->
        <div class="bg-gradient-to-br from-white to-blue-50/50 rounded-2xl p-6 border border-blue-100 shadow-sm space-y-5">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-blue-100/60 pb-4">
                <div>
                    <span class="text-[11px] font-bold tracking-wider uppercase text-[rgb(93,135,255)] bg-blue-100/60 px-3 py-1 rounded-full">Tombol Absensi Real-Time</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-2">Presensi Hari Ini (1-Klik)</h3>
                    <p class="text-xs text-slate-500">Jam Masuk: <strong>{{ operatingHours.inStart }} - {{ operatingHours.inEnd }} WIB</strong> | Jam Pulang: <strong>{{ operatingHours.outStart }} - {{ operatingHours.outEnd }} WIB</strong></p>
                </div>

                <div class="flex items-center gap-2">
                    <div v-if="todayAttendance?.time_in" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold border border-emerald-200 flex items-center gap-1.5">
                        <CheckCircle2 class="w-4 h-4 text-emerald-600" />
                        <span>Masuk: {{ todayAttendance.time_in }}</span>
                    </div>
                    <div v-if="todayAttendance?.time_out" class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl text-xs font-bold border border-blue-200 flex items-center gap-1.5">
                        <CheckCircle2 class="w-4 h-4 text-blue-600" />
                        <span>Pulang: {{ todayAttendance.time_out }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons 1-Klik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Absen Masuk Button -->
                <form @submit.prevent="submitClockIn">
                    <button 
                        type="submit"
                        :disabled="!canClockIn || !!todayAttendance?.time_in"
                        class="w-full p-5 rounded-2xl font-bold text-sm flex flex-col items-center justify-center gap-2 transition-all shadow-md"
                        :class="[
                            todayAttendance?.time_in
                                ? 'bg-slate-100 text-slate-400 border border-slate-200 shadow-none cursor-not-allowed'
                                : (canClockIn 
                                    ? 'bg-[rgb(93,135,255)] text-white hover:bg-blue-600 shadow-blue-500/25 ring-4 ring-blue-500/10' 
                                    : 'bg-slate-100 text-slate-400 border border-slate-200 shadow-none cursor-not-allowed')
                        ]"
                    >
                        <UserCheck class="w-7 h-7" />
                        <span>{{ todayAttendance?.time_in ? 'Sudah Absen Masuk' : 'KLIK ABSEN MASUK SEKARANG' }}</span>
                        <span class="text-[11px] font-normal opacity-80" v-if="!canClockIn && !todayAttendance?.time_in">Jendela Absen Belum Dibuka / Berakhir</span>
                    </button>
                </form>

                <!-- Absen Pulang Button -->
                <form @submit.prevent="submitClockOut">
                    <button 
                        type="submit"
                        :disabled="!canClockOut || !todayAttendance?.time_in || !!todayAttendance?.time_out"
                        class="w-full p-5 rounded-2xl font-bold text-sm flex flex-col items-center justify-center gap-2 transition-all shadow-md"
                        :class="[
                            todayAttendance?.time_out
                                ? 'bg-slate-100 text-slate-400 border border-slate-200 shadow-none cursor-not-allowed'
                                : (canClockOut && todayAttendance?.time_in
                                    ? 'bg-emerald-600 text-white hover:bg-emerald-700 shadow-emerald-500/25 ring-4 ring-emerald-500/10' 
                                    : 'bg-slate-100 text-slate-400 border border-slate-200 shadow-none cursor-not-allowed')
                        ]"
                    >
                        <UserCheck class="w-7 h-7" />
                        <span>{{ todayAttendance?.time_out ? 'Sudah Absen Pulang' : 'KLIK ABSEN PULANG SEKARANG' }}</span>
                        <span class="text-[11px] font-normal opacity-80" v-if="!canClockOut && !todayAttendance?.time_out">Jendela Pulang Belum Dibuka / Berakhir</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- LOG TABEL ABSENSI (Persis Format yang Diberikan User) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-900 text-sm">Riwayat & Log Absensi Harian</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3">Masuk</th>
                            <th class="px-4 py-3">Istirahat</th>
                            <th class="px-4 py-3">Kembali</th>
                            <th class="px-4 py-3">Pulang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="att in attendances.data" :key="att.id" class="hover:bg-slate-50/50">
                            <td class="px-4 py-3.5 font-bold text-slate-900">{{ studentName }}</td>
                            <td class="px-4 py-3.5 text-slate-700 whitespace-nowrap">{{ att.date }}</td>
                            <td class="px-4 py-3.5">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold capitalize"
                                      :class="{
                                          'bg-emerald-50 text-emerald-700': att.status === 'hadir',
                                          'bg-amber-50 text-amber-700': att.status === 'izin' || att.status === 'sakit',
                                          'bg-rose-50 text-rose-700': att.status === 'alpha'
                                      }">
                                    {{ att.status }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-medium text-slate-800">{{ att.time_in || '-' }}</td>
                            <td class="px-4 py-3.5 font-medium text-slate-500">{{ att.time_break || '-' }}</td>
                            <td class="px-4 py-3.5 font-medium text-slate-500">{{ att.time_return || '-' }}</td>
                            <td class="px-4 py-3.5 font-medium text-slate-800">{{ att.time_out || '-' }}</td>
                        </tr>
                        <tr v-if="!attendances.data || attendances.data.length === 0">
                            <td colspan="7" class="px-4 py-6 text-center text-slate-400">
                                Belum ada catatan riwayat absensi.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form Pengajuan Izin/Sakit -->
    <div v-if="showLeaveModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-base">Pengajuan Surat Izin / Sakit</h3>
                <button @click="showLeaveModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
            </div>

            <form @submit.prevent="submitLeave" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Tipe Pengajuan *</label>
                    <select v-model="leaveForm.type" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]">
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Mulai Tanggal *</label>
                        <input v-model="leaveForm.start_date" type="date" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Sampai Tanggal *</label>
                        <input v-model="leaveForm.end_date" type="date" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Alasan Izin / Sakit *</label>
                    <textarea v-model="leaveForm.reason" rows="3" required placeholder="Tuliskan keterangan detail alasan izin/sakit..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none"></textarea>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700">Lampiran Surat Dokter / Surat Izin</label>
                    <input type="file" accept="image/*,.pdf" @change="handleFileUpload" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[rgb(93,135,255)]" />
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" @click="showLeaveModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                    <button type="submit" :disabled="leaveForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs shadow-md shadow-blue-500/20">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
</template>
