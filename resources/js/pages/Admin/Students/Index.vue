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
    router.get('/admin/students', { search: search.value, status: status.value }, { preserveState: true });
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
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <Users class="w-5 h-5 text-[rgb(93,135,255)]" />
                        Master Data Semua Siswa PKL
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Kelola data profil, sesi latihan, dan status keaktifan akun siswa PKL.</p>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-wrap items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" />
                    <input v-model="search" @input="applyFilter" type="text" placeholder="Cari nama, username, atau email..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-[rgb(93,135,255)]" />
                </div>

                <select v-model="status" @change="applyFilter" class="px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    <option value="">-- Semua Status --</option>
                    <option value="approved">Approved / Aktif</option>
                    <option value="pending">Pending</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <!-- Master Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3">Asal Sekolah & Jurusan</th>
                                <th class="px-5 py-3">Divisi / Badge</th>
                                <th class="px-5 py-3">Sesi PKL</th>
                                <th class="px-5 py-3">Status Akun</th>
                                <th class="px-5 py-3 text-right">Aksi Edit</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="student in students.data" :key="student.id" class="hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    <p>{{ student.name }}</p>
                                    <p class="text-[11px] font-normal text-slate-400">@{{ student.username }} • {{ student.email }}</p>
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    <p class="font-semibold">{{ student.profile?.school_name || '-' }}</p>
                                    <p class="text-[11px] text-slate-500">{{ student.profile?.major_name || '-' }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span v-if="student.profile?.division_name" class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        {{ student.profile.division_name }}
                                    </span>
                                    <span v-else class="text-slate-400 font-italic text-[11px]">Belum Di-assign</span>
                                </td>
                                <td class="px-5 py-4 font-semibold text-[rgb(93,135,255)] uppercase">
                                    {{ student.profile?.session_type }}
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize"
                                          :class="{
                                              'bg-emerald-50 text-emerald-700': student.status === 'approved',
                                              'bg-amber-50 text-amber-700': student.status === 'pending',
                                              'bg-rose-50 text-rose-700': student.status === 'rejected',
                                          }">
                                        {{ student.status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right space-x-2">
                                    <button @click="openEditModal(student)" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg">
                                        <Edit2 class="w-3.5 h-3.5" />
                                    </button>
                                    <button @click="deleteStudent(student.id)" class="p-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg">
                                        <Trash2 class="w-3.5 h-3.5" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div v-if="showEditModal && selectedStudent" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-base">Edit Akun Siswa PKL</h3>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <form @submit.prevent="submitUpdate" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Nama Lengkap</label>
                        <input v-model="form.name" type="text" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Email</label>
                        <input v-model="form.email" type="email" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Divisi / Role Posisi (Badge)</label>
                        <select v-model="form.division_id" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="">-- Pilih Divisi --</option>
                            <option v-for="d in divisions" :key="d.id" :value="d.id">{{ d.name }}</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Tipe Sesi PKL</label>
                        <select v-model="form.session_type" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="full_day">Full Day</option>
                            <option value="persesi_pagi">Shift Pagi</option>
                            <option value="persesi_sore">Shift Sore</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Status Akun</label>
                        <select v-model="form.status" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
    </div>
</template>
