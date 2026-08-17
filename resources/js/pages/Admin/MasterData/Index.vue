<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    FolderKanban,
    Plus,
    School as SchoolIcon,
    BookOpen,
    Users,
    Calendar,
} from '@lucide/vue';
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
const batchForm = useForm({
    name: '',
    start_date: '',
    end_date: '',
    quota: 50,
});
const supervisorForm = useForm({
    name: '',
    nip: '',
    email: '',
    phone_number: '',
    company_agency: '',
});

const submitDivision = () => {
    divisionForm.post('/admin/master-data/divisions', {
        onSuccess: () => divisionForm.reset(),
    });
};

const submitSchool = () => {
    schoolForm.post('/admin/master-data/schools', {
        onSuccess: () => schoolForm.reset(),
    });
};

const submitMajor = () => {
    majorForm.post('/admin/master-data/majors', {
        onSuccess: () => majorForm.reset(),
    });
};

const submitBatch = () => {
    batchForm.post('/admin/master-data/batches', {
        onSuccess: () => batchForm.reset(),
    });
};

const submitSupervisor = () => {
    supervisorForm.post('/admin/master-data/supervisors', {
        onSuccess: () => supervisorForm.reset(),
    });
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header section -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs">
            <h1
                class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
            >
                <FolderKanban class="h-5 w-5 text-zinc-900" />
                Manajemen Master Data Instansi & Gelombang
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Kelola data asal sekolah/kampus, jurusan, periode PKL, dan
                pembimbing lapangan.
            </p>
        </div>

        <!-- Tabs Header -->
        <div class="flex items-center gap-2 border-b border-zinc-200 pb-2">
            <button
                @click="activeTab = 'schools'"
                class="cursor-pointer rounded-xl px-4 py-2 text-xs font-semibold transition-all"
                :class="
                    activeTab === 'schools'
                        ? 'bg-zinc-950 text-white shadow-xs'
                        : 'bg-white text-zinc-600 hover:bg-zinc-100'
                "
            >
                Sekolah & Jurusan
            </button>
            <button
                @click="activeTab = 'divisions'"
                class="cursor-pointer rounded-xl px-4 py-2 text-xs font-semibold transition-all"
                :class="
                    activeTab === 'divisions'
                        ? 'bg-zinc-950 text-white shadow-xs'
                        : 'bg-white text-zinc-600 hover:bg-zinc-100'
                "
            >
                Data Divisi
            </button>
            <button
                @click="activeTab = 'batches'"
                class="cursor-pointer rounded-xl px-4 py-2 text-xs font-semibold transition-all"
                :class="
                    activeTab === 'batches'
                        ? 'bg-zinc-950 text-white shadow-xs'
                        : 'bg-white text-zinc-600 hover:bg-zinc-100'
                "
            >
                Gelombang / Periode PKL
            </button>
            <button
                @click="activeTab = 'supervisors'"
                class="cursor-pointer rounded-xl px-4 py-2 text-xs font-semibold transition-all"
                :class="
                    activeTab === 'supervisors'
                        ? 'bg-zinc-950 text-white shadow-xs'
                        : 'bg-white text-zinc-600 hover:bg-zinc-100'
                "
            >
                Data Pembimbing
            </button>
        </div>

        <!-- TAB 1: SCHOOLS & MAJORS -->
        <div
            v-if="activeTab === 'schools'"
            class="grid grid-cols-1 gap-6 lg:grid-cols-2"
        >
            <!-- Add School Card -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <h3
                    class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
                >
                    Tambah Data Sekolah / Kampus
                </h3>
                <form @submit.prevent="submitSchool" class="space-y-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Nama Sekolah / Kampus *</label
                        >
                        <input
                            v-model="schoolForm.name"
                            type="text"
                            required
                            placeholder="SMKN 1 Surabaya"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Kode Singkat</label
                        >
                        <input
                            v-model="schoolForm.code"
                            type="text"
                            placeholder="SMKN1SBY"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <button
                        type="submit"
                        :disabled="schoolForm.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Sekolah
                    </button>
                </form>
            </div>

            <!-- Add Major Card -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
            >
                <h3
                    class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
                >
                    Tambah Data Jurusan
                </h3>
                <form @submit.prevent="submitMajor" class="space-y-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Pilih Sekolah *</label
                        >
                        <select
                            v-model="majorForm.school_id"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        >
                            <option value="">-- Pilih Sekolah --</option>
                            <option
                                v-for="s in schools"
                                :key="s.id"
                                :value="s.id"
                            >
                                {{ s.name }}
                            </option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Nama Jurusan *</label
                        >
                        <input
                            v-model="majorForm.name"
                            type="text"
                            required
                            placeholder="Rekayasa Perangkat Lunak"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <button
                        type="submit"
                        :disabled="majorForm.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Jurusan
                    </button>
                </form>
            </div>
        </div>

        <!-- TAB DIVISIONS -->
        <div
            v-if="activeTab === 'divisions'"
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Tambah Data Divisi (Role/Posisi)
            </h3>
            <form
                @submit.prevent="submitDivision"
                class="grid grid-cols-1 gap-4 md:grid-cols-3"
            >
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Nama Divisi *</label
                    >
                    <input
                        v-model="divisionForm.name"
                        type="text"
                        required
                        placeholder="Contoh: Mobile Developer"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Kode Singkat</label
                    >
                    <input
                        v-model="divisionForm.code"
                        type="text"
                        placeholder="MOBILE"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="flex items-end space-y-1">
                    <button
                        type="submit"
                        :disabled="divisionForm.processing"
                        class="w-full cursor-pointer rounded-xl bg-zinc-950 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Divisi
                    </button>
                </div>
            </form>

            <div class="pt-4">
                <h4 class="mb-2 text-xs font-bold text-zinc-700">
                    Daftar Divisi Terdaftar:
                </h4>
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="d in divisions"
                        :key="d.id"
                        class="rounded-full border border-zinc-200 bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-950"
                    >
                        {{ d.name }}
                    </span>
                </div>
            </div>
        </div>
        <div
            v-if="activeTab === 'batches'"
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Tambah Gelombang / Periode PKL
            </h3>
            <form
                @submit.prevent="submitBatch"
                class="grid grid-cols-1 gap-4 md:grid-cols-4"
            >
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Nama Gelombang *</label
                    >
                    <input
                        v-model="batchForm.name"
                        type="text"
                        required
                        placeholder="Gelombang 1 - 2026"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Mulai *</label
                    >
                    <input
                        v-model="batchForm.start_date"
                        type="date"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Selesai *</label
                    >
                    <input
                        v-model="batchForm.end_date"
                        type="date"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="flex items-end space-y-1">
                    <button
                        type="submit"
                        :disabled="batchForm.processing"
                        class="w-full cursor-pointer rounded-xl bg-zinc-950 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Tambah Periode
                    </button>
                </div>
            </form>
        </div>

        <!-- TAB 3: SUPERVISORS -->
        <div
            v-if="activeTab === 'supervisors'"
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Tambah Data Pembimbing Lapangan
            </h3>
            <form
                @submit.prevent="submitSupervisor"
                class="grid grid-cols-1 gap-4 md:grid-cols-3"
            >
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Nama Pembimbing *</label
                    >
                    <input
                        v-model="supervisorForm.name"
                        type="text"
                        required
                        placeholder="Drs. Budi Santoso"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >NIP / NIK</label
                    >
                    <input
                        v-model="supervisorForm.nip"
                        type="text"
                        placeholder="19800101..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>
                <div class="flex items-end space-y-1">
                    <button
                        type="submit"
                        :disabled="supervisorForm.processing"
                        class="w-full cursor-pointer rounded-xl bg-zinc-950 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Pembimbing
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
