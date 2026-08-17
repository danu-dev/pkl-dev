<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import {
    BookOpen,
    Search,
    CheckCircle2,
    XCircle,
    FileText,
    Image as ImageIcon,
    Eye,
} from '@lucide/vue';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

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
    router.get(
        '/admin/journals',
        {
            search: search.value,
            date: date.value,
            status: status.value,
        },
        { preserveState: true },
    );
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
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs">
            <h1
                class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
            >
                <BookOpen class="h-5 w-5 text-zinc-900" />
                Rekap Pengisian Jurnal Siswa
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Monitoring status siswa yang sudah mengisi vs belum mengisi
                jurnal harian.
            </p>
        </div>

        <!-- Stats Bar -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-xs font-semibold text-zinc-500">
                    Total Siswa PKL Aktif
                </p>
                <p class="mt-1 text-2xl font-bold text-zinc-950">
                    {{ stats.total }}
                    <span class="text-xs font-medium text-zinc-400">Siswa</span>
                </p>
            </div>
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-xs font-semibold text-emerald-600">
                    Sudah Mengisi Jurnal
                </p>
                <p class="mt-1 text-2xl font-bold text-emerald-600">
                    {{ stats.filled }}
                    <span class="text-xs font-medium text-emerald-400"
                        >Siswa</span
                    >
                </p>
            </div>
            <div
                class="rounded-xl border border-zinc-200 bg-white p-4 text-center shadow-2xs"
            >
                <p class="text-xs font-semibold text-rose-600">
                    Belum Mengisi Jurnal
                </p>
                <p class="mt-1 text-2xl font-bold text-rose-600">
                    {{ stats.not_filled }}
                    <span class="text-xs font-medium text-rose-400">Siswa</span>
                </p>
            </div>
        </div>

        <!-- Filter Bar -->
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

            <!-- FILTER KHUSUS ISI vs BELUM ISI (Persis Sesuai Permintaan User) -->
            <select
                v-model="status"
                @change="applyFilter"
                class="rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs font-semibold text-zinc-700 focus:border-zinc-950 focus:outline-none"
            >
                <option value="">-- Semua Siswa --</option>
                <option value="filled">Sudah Mengisi Jurnal</option>
                <option value="not_filled">Belum Mengisi Jurnal</option>
            </select>
        </div>

        <!-- Journal Recap Table -->
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
                            <th class="px-5 py-3">Asal Sekolah & Jurusan</th>
                            <th class="px-5 py-3">Tanggal Checked</th>
                            <th class="px-5 py-3">Status Pengisian</th>
                            <th class="px-5 py-3 text-right">Detail Jurnal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="item in recapData"
                            :key="item.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-5 py-4 font-bold text-zinc-900">
                                <p>{{ item.name }}</p>
                                <p
                                    class="text-[11px] font-normal text-zinc-400"
                                >
                                    @{{ item.username }}
                                </p>
                            </td>
                            <td class="px-5 py-4 text-zinc-700">
                                <p class="font-semibold">
                                    {{ item.school_name }}
                                </p>
                                <p class="text-[11px] text-zinc-500">
                                    {{ item.major_name }}
                                </p>
                            </td>
                            <td
                                class="px-5 py-4 whitespace-nowrap text-zinc-700"
                            >
                                {{ item.date }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold"
                                    :class="
                                        item.has_filled
                                            ? 'border border-emerald-200 bg-emerald-50 text-emerald-700'
                                            : 'border border-rose-200 bg-rose-50 text-rose-700'
                                    "
                                >
                                    <CheckCircle2
                                        v-if="item.has_filled"
                                        class="h-3.5 w-3.5 text-emerald-600"
                                    />
                                    <XCircle
                                        v-else
                                        class="h-3.5 w-3.5 text-rose-600"
                                    />
                                    <span>{{
                                        item.has_filled
                                            ? 'Sudah Mengisi'
                                            : 'Belum Mengisi'
                                    }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <button
                                    v-if="item.has_filled"
                                    @click="openDetailModal(item)"
                                    class="inline-flex cursor-pointer items-center gap-1 rounded-lg bg-zinc-100 px-3 py-1.5 text-xs font-semibold text-zinc-950 transition-all hover:bg-zinc-200"
                                >
                                    <Eye class="h-3.5 w-3.5" />
                                    <span>Lihat Jurnal</span>
                                </button>
                                <span
                                    v-else
                                    class="font-italic text-[11px] text-zinc-400"
                                    >Tanpa Jurnal</span
                                >
                            </td>
                        </tr>
                        <tr v-if="!recapData || recapData.length === 0">
                            <td
                                colspan="5"
                                class="px-5 py-8 text-center text-zinc-400"
                            >
                                Tidak ada data siswa yang sesuai dengan filter.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Detail Jurnal Modal -->
    <div
        v-if="showDetailModal && selectedJournal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-lg space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <div>
                    <h3 class="text-base font-bold text-zinc-900">
                        Detail Jurnal Harian
                    </h3>
                    <p class="text-xs text-zinc-500">
                        Siswa: {{ selectedJournal.name }} ({{
                            selectedJournal.date
                        }})
                    </p>
                </div>
                <button
                    @click="showDetailModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <p class="font-medium text-zinc-400">Judul Kegiatan:</p>
                    <p class="mt-0.5 text-sm font-bold text-zinc-900">
                        {{ selectedJournal.journal?.title }}
                    </p>
                </div>

                <div>
                    <p class="font-medium text-zinc-400">Deskripsi Kegiatan:</p>
                    <p
                        class="mt-1 rounded-xl border border-zinc-100 bg-zinc-50 p-3 leading-relaxed whitespace-pre-line text-zinc-700"
                    >
                        {{ selectedJournal.journal?.description }}
                    </p>
                </div>

                <div v-if="selectedJournal.journal?.proof_file">
                    <p class="font-medium text-zinc-400">
                        Bukti Foto / Lampiran:
                    </p>
                    <a
                        :href="`/storage/${selectedJournal.journal.proof_file}`"
                        target="_blank"
                        class="mt-1 inline-flex items-center gap-1.5 font-semibold text-zinc-950 hover:underline"
                    >
                        <ImageIcon class="h-4 w-4" />
                        <span>Buka / Download File Bukti</span>
                    </a>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button
                    @click="showDetailModal = false"
                    class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-700"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</template>
