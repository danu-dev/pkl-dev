<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    CalendarCheck,
    CheckCircle2,
    Clock,
    AlertTriangle,
    FileUp,
    Sparkles,
    UserX,
    UserCheck,
} from '@lucide/vue';
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
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs sm:flex-row sm:items-center"
        >
            <div>
                <h1
                    class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
                >
                    <CalendarCheck class="h-5 w-5 text-zinc-900" />
                    Absensi Siswa PKL
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Lakukan presensi harian secara mudah dalam jendela jam
                    operasional.
                </p>
            </div>

            <button
                @click="showLeaveModal = true"
                class="flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-100 px-4 py-2.5 text-xs font-semibold text-zinc-800 transition-all hover:bg-zinc-200"
            >
                <FileUp class="h-4 w-4 text-zinc-700" />
                <span>Pengajuan Izin / Sakit</span>
            </button>
        </div>

        <!-- 4 STATISTIK CARDS -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div
                class="space-y-1 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <p class="text-xs font-semibold text-zinc-500">Total Absensi</p>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.total }}
                    <span class="text-xs font-medium text-zinc-400">Kali</span>
                </p>
                <p class="text-[11px] text-zinc-400">Absensi Terdaftar</p>
            </div>

            <div
                class="space-y-1 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <p class="text-xs font-semibold text-zinc-700">Total Hadir</p>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.hadir }}
                    <span class="text-xs font-medium text-zinc-400">Kali</span>
                </p>
                <p class="text-[11px] text-zinc-400">Absensi Tepat Waktu</p>
            </div>

            <div
                class="space-y-1 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <p class="text-xs font-semibold text-zinc-700">
                    Total Izin & Sakit
                </p>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.izin_sakit }}
                    <span class="text-xs font-medium text-zinc-400">Kali</span>
                </p>
                <p class="text-[11px] text-zinc-400">Surat Disetujui</p>
            </div>

            <div
                class="space-y-1 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <p class="text-xs font-semibold text-zinc-700">Total Alpha</p>
                <p class="text-2xl font-bold text-zinc-950">
                    {{ stats.alpha }}
                    <span class="text-xs font-medium text-zinc-400">Kali</span>
                </p>
                <p class="text-[11px] text-zinc-400">Tanpa Keterangan</p>
            </div>
        </div>

        <!-- CARD ABSENSI 1-KLIK HEROBOX -->
        <div
            class="space-y-5 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
        >
            <div
                class="flex flex-col justify-between gap-4 border-b border-zinc-100 pb-4 md:flex-row md:items-center"
            >
                <div>
                    <span
                        class="rounded-md bg-zinc-100 px-3 py-1 text-[10px] font-bold tracking-wider text-zinc-950 uppercase"
                        >Tombol Absensi Real-Time</span
                    >
                    <h3 class="mt-2 text-lg font-bold text-zinc-950">
                        Presensi Hari Ini (1-Klik)
                    </h3>
                    <p class="text-xs text-zinc-500">
                        Jam Masuk:
                        <strong
                            >{{ operatingHours.inStart }} -
                            {{ operatingHours.inEnd }} WIB</strong
                        >
                        | Jam Pulang:
                        <strong
                            >{{ operatingHours.outStart }} -
                            {{ operatingHours.outEnd }} WIB</strong
                        >
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <div
                        v-if="todayAttendance?.time_in"
                        class="flex items-center gap-1.5 rounded-xl bg-zinc-950 px-3 py-1.5 text-xs font-bold text-white shadow-2xs"
                    >
                        <CheckCircle2 class="h-4 w-4 text-emerald-400" />
                        <span>Masuk: {{ todayAttendance.time_in }}</span>
                    </div>
                    <div
                        v-if="todayAttendance?.time_out"
                        class="flex items-center gap-1.5 rounded-xl border border-zinc-200 bg-zinc-100 px-3 py-1.5 text-xs font-bold text-zinc-950"
                    >
                        <CheckCircle2 class="h-4 w-4 text-emerald-600" />
                        <span>Pulang: {{ todayAttendance.time_out }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons 1-Klik -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- Absen Masuk Button -->
                <form @submit.prevent="submitClockIn">
                    <button
                        type="submit"
                        :disabled="!canClockIn || !!todayAttendance?.time_in"
                        class="flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl p-5 text-sm font-bold transition-all"
                        :class="[
                            todayAttendance?.time_in
                                ? 'cursor-not-allowed border border-zinc-200 bg-zinc-100 text-zinc-400'
                                : canClockIn
                                  ? 'bg-zinc-950 text-white shadow-xs hover:bg-zinc-800'
                                  : 'cursor-not-allowed border border-zinc-200 bg-zinc-100 text-zinc-400',
                        ]"
                    >
                        <UserCheck class="h-7 w-7" />
                        <span>{{
                            todayAttendance?.time_in
                                ? 'Sudah Absen Masuk'
                                : 'KLIK ABSEN MASUK SEKARANG'
                        }}</span>
                        <span
                            class="text-[11px] font-normal opacity-80"
                            v-if="!canClockIn && !todayAttendance?.time_in"
                            >Jendela Absen Belum Dibuka / Berakhir</span
                        >
                    </button>
                </form>

                <!-- Absen Pulang Button -->
                <form @submit.prevent="submitClockOut">
                    <button
                        type="submit"
                        :disabled="
                            !canClockOut ||
                            !todayAttendance?.time_in ||
                            !!todayAttendance?.time_out
                        "
                        class="flex w-full cursor-pointer flex-col items-center justify-center gap-2 rounded-2xl p-5 text-sm font-bold transition-all"
                        :class="[
                            todayAttendance?.time_out
                                ? 'cursor-not-allowed border border-zinc-200 bg-zinc-100 text-zinc-400'
                                : canClockOut && todayAttendance?.time_in
                                  ? 'bg-zinc-950 text-white shadow-xs hover:bg-zinc-800'
                                  : 'cursor-not-allowed border border-zinc-200 bg-zinc-100 text-zinc-400',
                        ]"
                    >
                        <UserCheck class="h-7 w-7" />
                        <span>{{
                            todayAttendance?.time_out
                                ? 'Sudah Absen Pulang'
                                : 'KLIK ABSEN PULANG SEKARANG'
                        }}</span>
                        <span
                            class="text-[11px] font-normal opacity-80"
                            v-if="!canClockOut && !todayAttendance?.time_out"
                            >Jendela Pulang Belum Dibuka / Berakhir</span
                        >
                    </button>
                </form>
            </div>
        </div>

        <!-- LOG TABEL ABSENSI -->
        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
        >
            <div class="border-b border-zinc-100 p-4">
                <h3 class="text-sm font-bold text-zinc-950">
                    Riwayat & Log Absensi Harian
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 font-semibold text-zinc-600 uppercase"
                    >
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
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="att in attendances.data"
                            :key="att.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-4 py-3.5 font-bold text-zinc-900">
                                {{ studentName }}
                            </td>
                            <td
                                class="px-4 py-3.5 whitespace-nowrap text-zinc-700"
                            >
                                {{ att.date }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-block rounded-full px-2 py-0.5 text-[10px] font-bold capitalize"
                                    :class="{
                                        'bg-emerald-50 text-emerald-700':
                                            att.status === 'hadir',
                                        'bg-amber-50 text-amber-700':
                                            att.status === 'izin' ||
                                            att.status === 'sakit',
                                        'bg-rose-50 text-rose-700':
                                            att.status === 'alpha',
                                    }"
                                >
                                    {{ att.status }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-medium text-zinc-800">
                                {{ att.time_in || '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-zinc-500">
                                {{ att.time_break || '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-zinc-500">
                                {{ att.time_return || '-' }}
                            </td>
                            <td class="px-4 py-3.5 font-medium text-zinc-800">
                                {{ att.time_out || '-' }}
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !attendances.data ||
                                attendances.data.length === 0
                            "
                        >
                            <td
                                colspan="7"
                                class="px-4 py-6 text-center text-zinc-400"
                            >
                                Belum ada catatan riwayat absensi.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form Pengajuan Izin/Sakit -->
    <div
        v-if="showLeaveModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-md space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-base font-bold text-zinc-900">
                    Pengajuan Surat Izin / Sakit
                </h3>
                <button
                    @click="showLeaveModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitLeave" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Tipe Pengajuan *</label
                    >
                    <select
                        v-model="leaveForm.type"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Mulai Tanggal *</label
                        >
                        <input
                            v-model="leaveForm.start_date"
                            type="date"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Sampai Tanggal *</label
                        >
                        <input
                            v-model="leaveForm.end_date"
                            type="date"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Alasan Izin / Sakit *</label
                    >
                    <textarea
                        v-model="leaveForm.reason"
                        rows="3"
                        required
                        placeholder="Tuliskan keterangan detail alasan izin/sakit..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Lampiran Surat Dokter / Surat Izin</label
                    >
                    <input
                        type="file"
                        accept="image/*,.pdf"
                        @change="handleFileUpload"
                        class="w-full text-xs text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-zinc-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-zinc-950 hover:file:bg-zinc-200"
                    />
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="showLeaveModal = false"
                        class="rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-700"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="leaveForm.processing"
                        class="rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
                    >
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
