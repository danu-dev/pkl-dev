<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { Users, Search, Edit2, Trash2, Filter } from '@lucide/vue';
import { ref } from 'vue';

const props = defineProps<{
    students: any;
    filters: any;
    schools: any[];
    majors: any[];
    divisions: any[];
    batches: any[];
    supervisors: any[];
}>();

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

const applyFilter = () => {
    router.get(
        '/admin/students',
        { search: search.value, status: status.value },
        { preserveState: true },
    );
};

const showEditModal = ref(false);
const selectedStudent = ref<any>(null);

const form = useForm({
    name: '',
    email: '',
    session_type: 'full_day',
    division_id: '' as any,
    status: 'approved',
});

const openEditModal = (student: any) => {
    selectedStudent.value = student;
    form.name = student.name;
    form.email = student.email;
    form.session_type = student.profile?.session_type || 'full_day';
    form.division_id = student.profile?.division_id || '';
    form.status = student.status;
    showEditModal.value = true;
};

const submitUpdate = () => {
    form.put(`/admin/students/${selectedStudent.value.id}`, {
        onSuccess: () => {
            showEditModal.value = false;
        },
    });
};

const deleteStudent = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
        router.delete(`/admin/students/${id}`);
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
                    <Users class="h-5 w-5 text-zinc-900" />
                    Master Data Semua Siswa PKL
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Kelola data profil, sesi latihan, dan status keaktifan akun
                    siswa PKL.
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
                    placeholder="Cari nama, username, atau email..."
                    class="w-full rounded-xl border border-zinc-200 bg-zinc-50 py-2 pr-4 pl-9 text-xs focus:border-zinc-950 focus:outline-none"
                />
            </div>

            <select
                v-model="status"
                @change="applyFilter"
                class="rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
            >
                <option value="">-- Semua Status --</option>
                <option value="approved">Approved / Aktif</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <!-- Master Table -->
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
                            <th class="px-5 py-3">Divisi / Badge</th>
                            <th class="px-5 py-3">Sesi PKL</th>
                            <th class="px-5 py-3">Status Akun</th>
                            <th class="px-5 py-3 text-right">Aksi Edit</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="student in students.data"
                            :key="student.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-5 py-4 font-bold text-zinc-900">
                                <p>{{ student.name }}</p>
                                <p
                                    class="text-[11px] font-normal text-zinc-400"
                                >
                                    @{{ student.username }} •
                                    {{ student.email }}
                                </p>
                            </td>
                            <td class="px-5 py-4 text-zinc-700">
                                <p class="font-semibold">
                                    {{ student.profile?.school_name || '-' }}
                                </p>
                                <p class="text-[11px] text-zinc-500">
                                    {{ student.profile?.major_name || '-' }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                <span
                                    v-if="student.profile?.division_name"
                                    class="inline-block rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-0.5 text-[10px] font-bold text-zinc-950"
                                >
                                    {{ student.profile.division_name }}
                                </span>
                                <span
                                    v-else
                                    class="font-italic text-[11px] text-zinc-400"
                                    >Belum Di-assign</span
                                >
                            </td>
                            <td
                                class="px-5 py-4 font-semibold text-zinc-950 uppercase"
                            >
                                {{ student.profile?.session_type }}
                            </td>
                            <td class="px-5 py-4">
                                <span
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold capitalize"
                                    :class="{
                                        'bg-emerald-50 text-emerald-700':
                                            student.status === 'approved',
                                        'bg-amber-50 text-amber-700':
                                            student.status === 'pending',
                                        'bg-rose-50 text-rose-700':
                                            student.status === 'rejected',
                                    }"
                                >
                                    {{ student.status }}
                                </span>
                            </td>
                            <td class="space-x-2 px-5 py-4 text-right">
                                <button
                                    @click="openEditModal(student)"
                                    class="cursor-pointer rounded-lg bg-zinc-100 p-1.5 text-zinc-700 hover:bg-zinc-200"
                                >
                                    <Edit2 class="h-3.5 w-3.5" />
                                </button>
                                <button
                                    @click="deleteStudent(student.id)"
                                    class="cursor-pointer rounded-lg bg-rose-50 p-1.5 text-rose-600 hover:bg-rose-100"
                                >
                                    <Trash2 class="h-3.5 w-3.5" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div
        v-if="showEditModal && selectedStudent"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-md space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-base font-bold text-zinc-900">
                    Edit Akun Siswa PKL
                </h3>
                <button
                    @click="showEditModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitUpdate" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Nama Lengkap</label
                    >
                    <input
                        v-model="form.name"
                        type="text"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Email</label
                    >
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Divisi / Role Posisi (Badge)</label
                    >
                    <select
                        v-model="form.division_id"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="">-- Pilih Divisi --</option>
                        <option
                            v-for="d in divisions"
                            :key="d.id"
                            :value="d.id"
                        >
                            {{ d.name }}
                        </option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Tipe Sesi PKL</label
                    >
                    <select
                        v-model="form.session_type"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="full_day">Full Day</option>
                        <option value="persesi_pagi">Shift Pagi</option>
                        <option value="persesi_sore">Shift Sore</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Status Akun</label
                    >
                    <select
                        v-model="form.status"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="showEditModal = false"
                        class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-600"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
