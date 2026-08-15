<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { FolderKanban, Plus, School as SchoolIcon, BookOpen, Users, Calendar } from '@lucide/vue';
import { ref } from 'vue';

defineProps<{
    schools: any[];
    divisions: any[];
    batches: any[];
    supervisors: any[];
}>();

const activeTab = ref('schools');

// Forms
const schoolForm = useForm({ name: '', code: '', address: '' });
const majorForm = useForm({ school_id: '', name: '', code: '' });
const divisionForm = useForm({ name: '', code: '', description: '' });
const batchForm = useForm({ name: '', start_date: '', end_date: '', quota: 50 });
const supervisorForm = useForm({ name: '', nip: '', email: '', phone_number: '', company_agency: '' });

const submitDivision = () => {
    divisionForm.post('/admin/master-data/divisions', { onSuccess: () => divisionForm.reset() });
};

const submitSchool = () => {
    schoolForm.post('/admin/master-data/schools', { onSuccess: () => schoolForm.reset() });
};

const submitMajor = () => {
    majorForm.post('/admin/master-data/majors', { onSuccess: () => majorForm.reset() });
};

const submitBatch = () => {
    batchForm.post('/admin/master-data/batches', { onSuccess: () => batchForm.reset() });
};

const submitSupervisor = () => {
    supervisorForm.post('/admin/master-data/supervisors', { onSuccess: () => supervisorForm.reset() });
};
</script>

<template>
    <div class="space-y-6">
            <!-- Header section -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <FolderKanban class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Manajemen Master Data Instansi & Gelombang
                </h1>
                <p class="text-xs text-slate-500 mt-1">Kelola data asal sekolah/kampus, jurusan, periode PKL, dan pembimbing lapangan.</p>
            </div>

            <!-- Tabs Header -->
            <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                <button 
                    @click="activeTab = 'schools'" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all"
                    :class="activeTab === 'schools' ? 'bg-[rgb(93,135,255)] text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 hover:bg-slate-100'"
                >
                    Sekolah & Jurusan
                </button>
                <button 
                    @click="activeTab = 'divisions'" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all"
                    :class="activeTab === 'divisions' ? 'bg-[rgb(93,135,255)] text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 hover:bg-slate-100'"
                >
                    Data Divisi
                </button>
                <button 
                    @click="activeTab = 'batches'" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all"
                    :class="activeTab === 'batches' ? 'bg-[rgb(93,135,255)] text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 hover:bg-slate-100'"
                >
                    Gelombang / Periode PKL
                </button>
                <button 
                    @click="activeTab = 'supervisors'" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all"
                    :class="activeTab === 'supervisors' ? 'bg-[rgb(93,135,255)] text-white shadow-md shadow-blue-500/20' : 'bg-white text-slate-600 hover:bg-slate-100'"
                >
                    Data Pembimbing
                </button>
            </div>

            <!-- TAB 1: SCHOOLS & MAJORS -->
            <div v-if="activeTab === 'schools'" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Add School Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Tambah Data Sekolah / Kampus</h3>
                    <form @submit.prevent="submitSchool" class="space-y-3">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Nama Sekolah / Kampus *</label>
                            <input v-model="schoolForm.name" type="text" required placeholder="SMKN 1 Surabaya" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Kode Singkat</label>
                            <input v-model="schoolForm.code" type="text" placeholder="SMKN1SBY" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <button type="submit" :disabled="schoolForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Sekolah</button>
                    </form>
                </div>

                <!-- Add Major Card -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Tambah Data Jurusan</h3>
                    <form @submit.prevent="submitMajor" class="space-y-3">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Pilih Sekolah *</label>
                            <select v-model="majorForm.school_id" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="">-- Pilih Sekolah --</option>
                                <option v-for="s in schools" :key="s.id" :value="s.id">{{ s.name }}</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Nama Jurusan *</label>
                            <input v-model="majorForm.name" type="text" required placeholder="Rekayasa Perangkat Lunak" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <button type="submit" :disabled="majorForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Jurusan</button>
                    </form>
                </div>
            </div>

            <!-- TAB DIVISIONS -->
            <div v-if="activeTab === 'divisions'" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Tambah Data Divisi (Role/Posisi)</h3>
                <form @submit.prevent="submitDivision" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Nama Divisi *</label>
                        <input v-model="divisionForm.name" type="text" required placeholder="Contoh: Mobile Developer" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Kode Singkat</label>
                        <input v-model="divisionForm.code" type="text" placeholder="MOBILE" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1 flex items-end">
                        <button type="submit" :disabled="divisionForm.processing" class="w-full py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Divisi</button>
                    </div>
                </form>

                <div class="pt-4">
                    <h4 class="font-bold text-xs text-slate-700 mb-2">Daftar Divisi Terdaftar:</h4>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="d in divisions" :key="d.id" class="px-3 py-1 bg-blue-50 text-[rgb(93,135,255)] border border-blue-100 rounded-full text-xs font-semibold">
                            {{ d.name }}
                        </span>
                    </div>
                </div>
            </div>
            <div v-if="activeTab === 'batches'" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Tambah Gelombang / Periode PKL</h3>
                <form @submit.prevent="submitBatch" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Nama Gelombang *</label>
                        <input v-model="batchForm.name" type="text" required placeholder="Gelombang 1 - 2026" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Mulai *</label>
                        <input v-model="batchForm.start_date" type="date" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Selesai *</label>
                        <input v-model="batchForm.end_date" type="date" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1 flex items-end">
                        <button type="submit" :disabled="batchForm.processing" class="w-full py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Tambah Periode</button>
                    </div>
                </form>
            </div>

            <!-- TAB 3: SUPERVISORS -->
            <div v-if="activeTab === 'supervisors'" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Tambah Data Pembimbing Lapangan</h3>
                <form @submit.prevent="submitSupervisor" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Nama Pembimbing *</label>
                        <input v-model="supervisorForm.name" type="text" required placeholder="Drs. Budi Santoso" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">NIP / NIK</label>
                        <input v-model="supervisorForm.nip" type="text" placeholder="19800101..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>
                    <div class="space-y-1 flex items-end">
                        <button type="submit" :disabled="supervisorForm.processing" class="w-full py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Pembimbing</button>
                    </div>
                </form>
            </div>
    </div>
</template>
