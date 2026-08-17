<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    BookOpen,
    Plus,
    Clock,
    FileText,
    CheckCircle2,
    AlertCircle,
    Edit3,
    Image as ImageIcon,
    Eye,
} from '@lucide/vue';
import { ref, computed } from 'vue';

const props = defineProps<{
    journals: any;
    canSubmit: boolean;
    operatingHours: {
        start: string;
        end: string;
    };
    today: string;
}>();

const showModal = ref(false);
const showDetailModal = ref(false);
const selectedDetailJournal = ref<any>(null);
const editingJournal = ref<any>(null);

const openDetailModal = (journal: any) => {
    selectedDetailJournal.value = journal;
    showDetailModal.value = true;
};

const form = useForm({
    title: '',
    description: '',
    proof_file: null as File | null,
});

const charCount = computed(() => form.description.length);

const openCreateModal = () => {
    editingJournal.value = null;
    form.reset();
    showModal.value = true;
};

const openEditModal = (journal: any) => {
    editingJournal.value = journal;
    form.title = journal.title;
    form.description = journal.description;
    form.proof_file = null;
    showModal.value = true;
};

const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.proof_file = target.files[0];
    }
};

const submitForm = () => {
    if (editingJournal.value) {
        form.post(`/jurnal/${editingJournal.value.id}`, {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
            },
        });
    } else {
        form.post('/jurnal', {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
            },
        });
    }
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
                    <BookOpen class="h-5 w-5 text-zinc-900" />
                    Jurnal Kegiatan Harian
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Isi dan catat bukti kegiatan praktek kerja lapangan Anda
                    secara rutin.
                </p>
            </div>

            <button
                @click="openCreateModal"
                :disabled="!canSubmit"
                class="flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-950 px-4 py-2.5 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-50"
            >
                <Plus class="h-4 w-4" />
                <span>Input Jurnal Baru</span>
            </button>
        </div>

        <!-- Lock / Restriction Notice -->
        <div
            v-if="!canSubmit"
            class="flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4 text-xs font-medium text-amber-900"
        >
            <Clock class="h-5 w-5 shrink-0 text-amber-600" />
            <div>
                <p class="font-bold">Pengisian Jurnal Dikunci Sementara</p>
                <p>
                    Sesuai aturan Admin, jurnal hanya dapat diisi / diperbarui
                    antara jam
                    <strong>{{ operatingHours.start }}</strong> sampai
                    <strong>{{ operatingHours.end }} WIB</strong>.
                </p>
            </div>
        </div>

        <!-- List Jurnal Table -->
        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 p-4"
            >
                <h3 class="text-sm font-bold text-zinc-950">
                    Riwayat Jurnal Kegiatan
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 text-xs font-semibold text-zinc-600 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Judul & Deskripsi</th>
                            <th class="px-5 py-3">Bukti</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="journal in journals.data"
                            :key="journal.id"
                            class="transition-all hover:bg-zinc-50/50"
                        >
                            <td
                                class="px-5 py-4 text-xs font-semibold whitespace-nowrap text-zinc-900"
                            >
                                {{ journal.date }}
                            </td>
                            <td
                                class="max-w-xs space-y-1 px-5 py-4 md:max-w-md"
                            >
                                <p class="text-sm font-bold text-zinc-900">
                                    {{ journal.title }}
                                </p>
                                <p class="line-clamp-2 text-xs text-zinc-600">
                                    {{ journal.description }}
                                </p>
                                <p
                                    class="text-[10px] font-medium text-zinc-400"
                                >
                                    {{ journal.description.length }} characters
                                </p>
                            </td>
                            <td class="px-5 py-4 text-xs whitespace-nowrap">
                                <a
                                    v-if="journal.proof_file"
                                    :href="`/storage/${journal.proof_file}`"
                                    target="_blank"
                                    class="group inline-block"
                                >
                                    <img
                                        :src="`/storage/${journal.proof_file}`"
                                        alt="Bukti Jurnal"
                                        class="h-12 w-12 rounded-xl border border-zinc-200 object-cover shadow-2xs transition-transform group-hover:scale-105"
                                    />
                                </a>
                                <span
                                    v-else
                                    class="font-italic text-xs text-zinc-400"
                                    >Tanpa Bukti</span
                                >
                            </td>
                            <td
                                class="space-x-1.5 px-5 py-4 text-right whitespace-nowrap"
                            >
                                <button
                                    @click="openDetailModal(journal)"
                                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-zinc-100 p-1.5 text-zinc-700 transition-all hover:bg-zinc-950 hover:text-white"
                                    title="Show Detail"
                                >
                                    <Eye class="h-4 w-4" />
                                </button>
                                <button
                                    @click="openEditModal(journal)"
                                    :disabled="!canSubmit"
                                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-zinc-100 p-1.5 text-zinc-700 transition-all hover:bg-zinc-950 hover:text-white disabled:opacity-40"
                                    title="Edit"
                                >
                                    <Edit3 class="h-4 w-4" />
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!journals.data || journals.data.length === 0">
                            <td
                                colspan="4"
                                class="px-5 py-8 text-center text-xs text-zinc-400"
                            >
                                Belum ada data jurnal kegiatan yang dimasukkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Show Detail Jurnal -->
        <div
            v-if="showDetailModal && selectedDetailJournal"
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
                            Detail Jurnal Kegiatan
                        </h3>
                        <p class="text-xs text-zinc-500">
                            Tanggal: {{ selectedDetailJournal.date }}
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
                            {{ selectedDetailJournal.title }}
                        </p>
                    </div>

                    <div>
                        <p class="font-medium text-zinc-400">
                            Deskripsi Kegiatan:
                        </p>
                        <p
                            class="mt-1 rounded-xl border border-zinc-100 bg-zinc-50 p-3 leading-relaxed whitespace-pre-line text-zinc-700"
                        >
                            {{ selectedDetailJournal.description }}
                        </p>
                    </div>

                    <div v-if="selectedDetailJournal.proof_file">
                        <p class="font-medium text-zinc-400">
                            Bukti Foto / PDF:
                        </p>
                        <a
                            :href="`/storage/${selectedDetailJournal.proof_file}`"
                            target="_blank"
                            class="mt-1 inline-block"
                        >
                            <img
                                :src="`/storage/${selectedDetailJournal.proof_file}`"
                                alt="Bukti Jurnal"
                                class="max-h-48 rounded-xl border border-zinc-200 shadow-2xs transition-opacity hover:opacity-90"
                            />
                        </a>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        @click="showDetailModal = false"
                        class="rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-700"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Create / Edit Jurnal -->
        <div
            v-if="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
        >
            <div
                class="w-full max-w-lg space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-100 pb-3"
                >
                    <h3 class="text-base font-bold text-zinc-900">
                        {{
                            editingJournal
                                ? 'Edit Jurnal Kegiatan'
                                : 'Input Jurnal Kegiatan Baru'
                        }}
                    </h3>
                    <button
                        @click="showModal = false"
                        class="text-sm text-zinc-400 hover:text-zinc-600"
                    >
                        ✕
                    </button>
                </div>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Judul Kegiatan *</label
                        >
                        <input
                            v-model="form.title"
                            type="text"
                            required
                            placeholder="Contoh: Membuat Modul Auth Laravel"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-xs text-zinc-900 focus:border-zinc-950 focus:outline-none sm:text-sm"
                        />
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Deskripsi Kegiatan *</label
                            >
                            <span class="text-[10px] font-bold text-zinc-400"
                                >{{ charCount }} characters</span
                            >
                        </div>
                        <textarea
                            v-model="form.description"
                            rows="4"
                            required
                            placeholder="Jelaskan detail pekerjaan yang dilakukan hari ini..."
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2.5 text-xs text-zinc-900 focus:border-zinc-950 focus:outline-none sm:text-sm"
                        ></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Upload Bukti (Foto / PDF)</label
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
                            @click="showModal = false"
                            class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-700"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
                        >
                            Simpan Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
