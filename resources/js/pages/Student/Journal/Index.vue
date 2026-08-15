<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { BookOpen, Plus, Clock, FileText, CheckCircle2, AlertCircle, Edit3, Image as ImageIcon, Eye } from '@lucide/vue';
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
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <BookOpen class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Jurnal Kegiatan Harian
                </h1>
                <p class="text-xs text-slate-500 mt-1">Isi dan catat bukti kegiatan praktek kerja lapangan Anda secara rutin.</p>
            </div>

            <button 
                @click="openCreateModal"
                :disabled="!canSubmit"
                class="px-4 py-2.5 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-semibold rounded-xl text-xs flex items-center justify-center gap-2 shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <Plus class="w-4 h-4" />
                <span>Input Jurnal Baru</span>
            </button>
        </div>

        <!-- Lock / Restriction Notice -->
        <div v-if="!canSubmit" class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-medium flex items-center gap-3">
            <Clock class="w-5 h-5 text-amber-600 shrink-0" />
            <div>
                <p class="font-bold">Pengisian Jurnal Dikunci Sementara</p>
                <p>Sesuai aturan Admin, jurnal hanya dapat diisi / diperbarui antara jam <strong>{{ operatingHours.start }}</strong> sampai <strong>{{ operatingHours.end }} WIB</strong>.</p>
            </div>
        </div>

        <!-- List Jurnal Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Riwayat Jurnal Kegiatan</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 text-xs uppercase font-semibold border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Judul & Deskripsi</th>
                            <th class="px-5 py-3">Bukti</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="journal in journals.data" :key="journal.id" class="hover:bg-slate-50/50 transition-all">
                            <td class="px-5 py-4 font-semibold text-slate-900 text-xs whitespace-nowrap">
                                {{ journal.date }}
                            </td>
                            <td class="px-5 py-4 space-y-1 max-w-xs md:max-w-md">
                                <p class="font-bold text-slate-900 text-sm">{{ journal.title }}</p>
                                <p class="text-xs text-slate-600 line-clamp-2">{{ journal.description }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">{{ journal.description.length }} characters</p>
                            </td>
                            <td class="px-5 py-4 text-xs whitespace-nowrap">
                                <a v-if="journal.proof_file" :href="`/storage/${journal.proof_file}`" target="_blank" class="inline-block group">
                                    <img :src="`/storage/${journal.proof_file}`" alt="Bukti Jurnal" class="w-12 h-12 object-cover rounded-xl border border-slate-200 shadow-xs group-hover:scale-105 transition-transform" />
                                </a>
                                <span v-else class="text-slate-400 font-italic text-xs">Tanpa Bukti</span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                <button 
                                    @click="openDetailModal(journal)"
                                    class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-[rgb(93,135,255)] text-slate-600 rounded-lg transition-all inline-flex items-center justify-center"
                                    title="Show Detail"
                                >
                                    <Eye class="w-4 h-4" />
                                </button>
                                <button 
                                    @click="openEditModal(journal)"
                                    :disabled="!canSubmit"
                                    class="p-1.5 bg-slate-100 hover:bg-[rgb(93,135,255)] hover:text-white text-slate-600 rounded-lg transition-all inline-flex items-center justify-center disabled:opacity-40"
                                    title="Edit"
                                >
                                    <Edit3 class="w-4 h-4" />
                                </button>
                            </td>
                        </tr>
                        <tr v-if="!journals.data || journals.data.length === 0">
                            <td colspan="4" class="px-5 py-8 text-center text-xs text-slate-400">
                                Belum ada data jurnal kegiatan yang dimasukkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Show Detail Jurnal -->
        <div v-if="showDetailModal && selectedDetailJournal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Detail Jurnal Kegiatan</h3>
                        <p class="text-xs text-slate-500">Tanggal: {{ selectedDetailJournal.date }}</p>
                    </div>
                    <button @click="showDetailModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <p class="text-slate-400 font-medium">Judul Kegiatan:</p>
                        <p class="font-bold text-slate-900 text-sm mt-0.5">{{ selectedDetailJournal.title }}</p>
                    </div>

                    <div>
                        <p class="text-slate-400 font-medium">Deskripsi Kegiatan:</p>
                        <p class="text-slate-700 whitespace-pre-line bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed mt-1">
                            {{ selectedDetailJournal.description }}
                        </p>
                    </div>

                    <div v-if="selectedDetailJournal.proof_file">
                        <p class="text-slate-400 font-medium">Bukti Foto / PDF:</p>
                        <a :href="`/storage/${selectedDetailJournal.proof_file}`" target="_blank" class="inline-block mt-1">
                            <img :src="`/storage/${selectedDetailJournal.proof_file}`" alt="Bukti Jurnal" class="max-h-48 rounded-xl border border-slate-200 shadow-sm hover:opacity-90 transition-opacity" />
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

        <!-- Modal Create / Edit Jurnal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-base">
                        {{ editingJournal ? 'Edit Jurnal Kegiatan' : 'Input Jurnal Kegiatan Baru' }}
                    </h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Judul Kegiatan *</label>
                        <input v-model="form.title" type="text" required placeholder="Contoh: Membuat Modul Auth Laravel" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]" />
                    </div>

                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-semibold text-slate-700">Deskripsi Kegiatan *</label>
                            <span class="text-[10px] font-bold text-slate-400">{{ charCount }} characters</span>
                        </div>
                        <textarea v-model="form.description" rows="4" required placeholder="Jelaskan detail pekerjaan yang dilakukan hari ini..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-[rgb(93,135,255)]"></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Upload Bukti (Foto / PDF)</label>
                        <input type="file" accept="image/*,.pdf" @change="handleFileUpload" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[rgb(93,135,255)] hover:file:bg-blue-100" />
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs shadow-md shadow-blue-500/20">Simpan Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
