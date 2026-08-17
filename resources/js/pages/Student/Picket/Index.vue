<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    Sparkles,
    Upload,
    Send,
    Calendar,
    CheckCircle2,
    AlertCircle,
} from '@lucide/vue';
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
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs sm:flex-row sm:items-center"
        >
            <div>
                <h1
                    class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
                >
                    <Sparkles class="h-5 w-5 text-zinc-900" />
                    Jadwal & Laporan Piket Siswa
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Periksa jadwal tugas piket kebersihan & laporkan bukti
                    kegiatan harian Anda.
                </p>
            </div>

            <button
                @click="showReportModal = true"
                class="flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-950 px-4 py-2.5 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800"
            >
                <Send class="h-4 w-4" />
                <span>Laporkan Piket Hari Ini</span>
            </button>
        </div>

        <!-- TAMPILAN JADWAL PIKET (Persis Format yang Diminta User) -->
        <div
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <div>
                    <h3 class="text-base font-bold text-zinc-950">
                        Dashboard Jadwal Piket Mingguan
                    </h3>
                    <p class="text-xs text-zinc-500">
                        Shift Pagi & Sore (Senin - Jum'at)
                    </p>
                </div>
                <span
                    class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-900"
                >
                    Hari Ini: {{ todayDate }}
                </span>
            </div>

            <!-- Days Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                <div
                    v-for="(name, key) in dayNames"
                    :key="key"
                    class="space-y-3 rounded-xl border border-zinc-200 bg-zinc-50 p-4"
                >
                    <h4
                        class="rounded-lg border-b border-zinc-200 bg-white py-1 pb-2 text-center text-sm font-bold text-zinc-900 shadow-2xs"
                    >
                        {{ name }}
                    </h4>

                    <!-- Shift Pagi -->
                    <div class="space-y-1">
                        <p
                            class="text-[10px] font-bold tracking-wider text-zinc-400 uppercase"
                        >
                            Pagi
                        </p>
                        <div
                            v-if="
                                schedules[key]?.pagi &&
                                schedules[key].pagi.length > 0
                            "
                            class="space-y-1"
                        >
                            <div
                                v-for="(person, idx) in schedules[key].pagi"
                                :key="idx"
                                class="rounded-lg border border-zinc-100 bg-white p-2 text-xs font-semibold text-zinc-800 shadow-2xs"
                            >
                                {{ person }}
                            </div>
                        </div>
                        <p
                            v-else
                            class="font-italic rounded bg-white/60 py-1 text-center text-[11px] text-zinc-400"
                        >
                            Belum Ada data
                        </p>
                    </div>

                    <!-- Shift Sore -->
                    <div class="space-y-1 pt-1">
                        <p
                            class="text-[10px] font-bold tracking-wider text-zinc-400 uppercase"
                        >
                            Sore
                        </p>
                        <div
                            v-if="
                                schedules[key]?.sore &&
                                schedules[key].sore.length > 0
                            "
                            class="space-y-1"
                        >
                            <div
                                v-for="(person, idx) in schedules[key].sore"
                                :key="idx"
                                class="rounded-lg border border-zinc-100 bg-white p-2 text-xs font-semibold text-zinc-800 shadow-2xs"
                            >
                                {{ person }}
                            </div>
                        </div>
                        <p
                            v-else
                            class="font-italic rounded bg-white/60 py-1 text-center text-[11px] text-zinc-400"
                        >
                            Belum Ada data
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Laporan Piket -->
        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
        >
            <div class="border-b border-zinc-100 p-4">
                <h3 class="text-sm font-bold text-zinc-950">
                    Riwayat Laporan Piket Anda
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 font-semibold text-zinc-600 uppercase"
                    >
                        <tr>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Catatan Laporan</th>
                            <th class="px-4 py-3">Bukti Piket</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="report in myReports.data"
                            :key="report.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td
                                class="px-4 py-3.5 font-bold whitespace-nowrap text-zinc-900"
                            >
                                {{ report.date }}
                            </td>
                            <td class="px-4 py-3.5 text-zinc-600">
                                {{ report.notes || '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <a
                                    :href="`/storage/${report.proof_file}`"
                                    target="_blank"
                                    class="font-semibold text-zinc-950 hover:underline"
                                >
                                    Lihat Bukti Foto
                                </a>
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold capitalize"
                                    :class="
                                        report.status === 'verified'
                                            ? 'border border-emerald-200 bg-emerald-50 text-emerald-700'
                                            : 'border border-amber-200 bg-amber-50 text-amber-700'
                                    "
                                >
                                    {{
                                        report.status === 'verified'
                                            ? 'Terverifikasi'
                                            : 'Menunggu Review'
                                    }}
                                </span>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !myReports.data || myReports.data.length === 0
                            "
                        >
                            <td
                                colspan="4"
                                class="px-4 py-6 text-center text-zinc-400"
                            >
                                Belum ada laporan piket yang dikirimkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form Laporkan Piket -->
    <div
        v-if="showReportModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-md space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-base font-bold text-zinc-900">
                    Laporkan Piket Kebersihan
                </h3>
                <button
                    @click="showReportModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitReport" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Catatan Laporan Piket</label
                    >
                    <textarea
                        v-model="form.notes"
                        rows="3"
                        placeholder="Sapu dan pel area ruangan..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Bukti Foto Piket (Format Foto JPG/PNG) *</label
                    >
                    <input
                        type="file"
                        accept="image/*"
                        required
                        @change="handleFileUpload"
                        class="w-full text-xs text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-zinc-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-zinc-950 hover:file:bg-zinc-200"
                    />
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="showReportModal = false"
                        class="rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-600"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
                    >
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
