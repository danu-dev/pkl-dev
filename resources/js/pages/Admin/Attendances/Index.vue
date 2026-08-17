<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import {
    ClipboardList,
    Search,
    Plus,
    CalendarCheck,
    UserCheck,
} from '@lucide/vue';
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
    router.get(
        '/admin/attendances',
        { search: search.value, date: date.value, status: status.value },
        { preserveState: true },
    );
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
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs sm:flex-row sm:items-center"
        >
            <div>
                <h1
                    class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
                >
                    <ClipboardList class="h-5 w-5 text-zinc-900" />
                    Halaman Rekapitulasi Absensi Siswa (Terpisah)
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Rekap log presensi harian, override absensi manual, dan
                    laporan kehadiran seluruh siswa.
                </p>
            </div>

            <button
                @click="showManualModal = true"
                class="flex cursor-pointer items-center gap-2 rounded-xl bg-zinc-950 px-4 py-2.5 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
            >
                <Plus class="h-4 w-4" />
                <span>Input Absensi Manual</span>
            </button>
        </div>

        <!-- Stats Mini Bar -->
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-[11px] font-semibold text-zinc-400">
                    Total Siswa PKL
                </p>
                <p class="mt-0.5 text-xl font-bold text-zinc-950">
                    {{ stats.total_students }}
                </p>
            </div>
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-[11px] font-semibold text-emerald-600">
                    Hadir Hari Ini
                </p>
                <p class="mt-0.5 text-xl font-bold text-emerald-600">
                    {{ stats.today_hadir }}
                </p>
            </div>
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-[11px] font-semibold text-amber-600">
                    Izin / Sakit Hari Ini
                </p>
                <p class="mt-0.5 text-xl font-bold text-amber-600">
                    {{ stats.today_izin_sakit }}
                </p>
            </div>
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-[11px] font-semibold text-rose-600">
                    Alpha Hari Ini
                </p>
                <p class="mt-0.5 text-xl font-bold text-rose-600">
                    {{ stats.today_alpha }}
                </p>
            </div>
        </div>

        <!-- Filter Controls -->
        <div
            class="flex flex-wrap items-center gap-3 rounded-2xl border border-zinc-200 bg-white p-4 shadow-2xs"
        >
            <div class="relative min-w-[200px] flex-1">
                <Search class="absolute top-3 left-3.5 h-4 w-4 text-zinc-400" />
                <input
                    v-model="search"
                    @input="applyFilter"
                    type="text"
                    placeholder="Cari nama siswa..."
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 py-2 pr-4 pl-9 text-xs focus:border-zinc-950 focus:outline-none"
                />
            </div>

            <input
                v-model="date"
                @change="applyFilter"
                type="date"
                class="rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
            />

            <select
                v-model="status"
                @change="applyFilter"
                class="rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
            >
                <option value="">-- Semua Status --</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </select>
        </div>

        <!-- Attendance Table -->
        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 font-semibold text-zinc-600 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-3">Nama Siswa</th>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Jam Masuk</th>
                            <th class="px-5 py-3">Jam Pulang</th>
                            <th class="px-5 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="att in attendances.data"
                            :key="att.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-5 py-4 font-bold text-zinc-900">
                                <p>{{ att.user?.name }}</p>
                                <p
                                    class="text-[11px] font-normal text-zinc-400"
                                >
                                    {{ att.user?.profile?.school_name }}
                                </p>
                            </td>
                            <td
                                class="px-5 py-4 whitespace-nowrap text-zinc-700"
                            >
                                {{ att.date }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold capitalize"
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
                            <td class="px-5 py-4 font-medium text-zinc-800">
                                {{ att.time_in || '-' }}
                            </td>
                            <td class="px-5 py-4 font-medium text-zinc-800">
                                {{ att.time_out || '-' }}
                            </td>
                            <td class="px-5 py-4 text-zinc-500">
                                {{ att.notes || '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Manual Override Modal -->
    <div
        v-if="showManualModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-md space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-base font-bold text-zinc-900">
                    Input / Override Absensi Manual
                </h3>
                <button
                    @click="showManualModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitManual" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Pilih Siswa *</label
                    >
                    <select
                        v-model="manualForm.user_id"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="">-- Pilih Siswa --</option>
                        <option
                            v-for="s in allStudents"
                            :key="s.id"
                            :value="s.id"
                        >
                            {{ s.name }}
                        </option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Tanggal *</label
                        >
                        <input
                            v-model="manualForm.date"
                            type="date"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Status *</label
                        >
                        <select
                            v-model="manualForm.status"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        >
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Jam Masuk</label
                        >
                        <input
                            v-model="manualForm.time_in"
                            type="time"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Jam Pulang</label
                        >
                        <input
                            v-model="manualForm.time_out"
                            type="time"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Catatan</label
                    >
                    <input
                        v-model="manualForm.notes"
                        type="text"
                        placeholder="Catatan perbaikan..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="showManualModal = false"
                        class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-600"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="manualForm.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Data Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
