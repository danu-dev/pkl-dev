<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { UserCheck, CheckCircle2, XCircle, FileText, Eye, Building, GraduationCap, Phone } from '@lucide/vue';
import { ref } from 'vue';

defineProps<{
    pendingUsers: any;
}>();

const selectedUser = ref<any>(null);
const showCvModal = ref(false);

const openPreviewModal = (user: any) => {
    selectedUser.value = user;
    showCvModal.value = true;
};

const approveForm = useForm({});
const rejectForm = useForm({});

const approveUser = (userId: number) => {
    approveForm.post(`/admin/approvals/${userId}/approve`, {
        onSuccess: () => {
            showCvModal.value = false;
        },
    });
};

const rejectUser = (userId: number) => {
    rejectForm.post(`/admin/approvals/${userId}/reject`, {
        onSuccess: () => {
            showCvModal.value = false;
        },
    });
};
</script>

<template>
    <div class="space-y-6">
            <!-- Header section -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <UserCheck class="w-5 h-5 text-[rgb(93,135,255)]" />
                        Approval Pendaftaran Siswa PKL
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Verifikasi berkas pendaftaran dan CV siswa sebelum menyetujui akses akun.</p>
                </div>
            </div>

            <!-- Tabel Antrian Approval -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-900 text-sm">Daftar Siswa Pending Approval</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3">Username / Email</th>
                                <th class="px-5 py-3">Asal Sekolah & Jurusan</th>
                                <th class="px-5 py-3">Tipe Sesi</th>
                                <th class="px-5 py-3">Berkas CV PDF</th>
                                <th class="px-5 py-3 text-right">Aksi Approval</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="user in pendingUsers.data" :key="user.id" class="hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-bold text-slate-900">{{ user.name }}</td>
                                <td class="px-5 py-4 text-slate-600">
                                    <p class="font-medium text-slate-800">@{{ user.username }}</p>
                                    <p class="text-[11px] text-slate-400">{{ user.email }}</p>
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    <p class="font-semibold">{{ user.profile?.school_name || '-' }}</p>
                                    <p class="text-[11px] text-slate-500">{{ user.profile?.major_name || '-' }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-[rgb(93,135,255)] capitalize">
                                        {{ user.profile?.session_type }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <button 
                                        @click="openPreviewModal(user)"
                                        class="px-3 py-1.5 bg-blue-50 text-[rgb(93,135,255)] font-semibold rounded-lg text-xs hover:bg-blue-100 transition-all inline-flex items-center gap-1.5"
                                    >
                                        <Eye class="w-3.5 h-3.5" />
                                        <span>Preview CV</span>
                                    </button>
                                </td>
                                <td class="px-5 py-4 text-right space-x-2">
                                    <button 
                                        @click="approveUser(user.id)"
                                        class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-xs transition-all inline-flex items-center gap-1 shadow-sm"
                                    >
                                        <CheckCircle2 class="w-3.5 h-3.5" />
                                        <span>Approve</span>
                                    </button>
                                    <button 
                                        @click="rejectUser(user.id)"
                                        class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg text-xs transition-all inline-flex items-center gap-1 shadow-sm"
                                    >
                                        <XCircle class="w-3.5 h-3.5" />
                                        <span>Tolak</span>
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="!pendingUsers.data || pendingUsers.data.length === 0">
                                <td colspan="6" class="px-5 py-8 text-center text-xs text-slate-400">
                                    Tidak ada pendaftaran siswa yang menunggu approval.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SPLIT MODAL PREVIEW CV PDF (Kebutuhan Spesifik User) -->
        <div v-if="showCvModal && selectedUser" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-4xl w-full h-[85vh] flex flex-col shadow-2xl border border-slate-100 overflow-hidden">
                <!-- Modal Header -->
                <div class="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base">Pratinjau CV & Verification Details</h3>
                        <p class="text-xs text-slate-500">Pendaftar: {{ selectedUser.name }} (@{{ selectedUser.username }})</p>
                    </div>
                    <button @click="showCvModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <!-- Modal Body Split 2 Columns -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-3 overflow-hidden">
                    <!-- Column Left: Student Info Details -->
                    <div class="p-5 border-r border-slate-200 bg-white space-y-4 overflow-y-auto">
                        <h4 class="font-bold text-slate-900 text-xs uppercase tracking-wider text-slate-400">Detail Profil Siswa</h4>
                        
                        <div class="space-y-3 text-xs">
                            <div>
                                <p class="text-slate-400 font-medium">Nama Lengkap:</p>
                                <p class="font-bold text-slate-900 text-sm">{{ selectedUser.name }}</p>
                            </div>

                            <div>
                                <p class="text-slate-400 font-medium">Email / WhatsApp:</p>
                                <p class="font-semibold text-slate-800">{{ selectedUser.email }}</p>
                                <p class="text-slate-600">{{ selectedUser.profile?.phone_number || '-' }}</p>
                            </div>

                            <div>
                                <p class="text-slate-400 font-medium">Asal Sekolah / Kampus:</p>
                                <p class="font-semibold text-slate-800">{{ selectedUser.profile?.school_name || '-' }}</p>
                            </div>

                            <div>
                                <p class="text-slate-400 font-medium">Jurusan:</p>
                                <p class="font-semibold text-slate-800">{{ selectedUser.profile?.major_name || '-' }}</p>
                            </div>

                            <div>
                                <p class="text-slate-400 font-medium">Tipe Sesi PKL:</p>
                                <p class="font-semibold text-[rgb(93,135,255)] uppercase">{{ selectedUser.profile?.session_type }}</p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2">
                            <button @click="approveUser(selectedUser.id)" class="w-full py-2.5 bg-emerald-600 text-white font-semibold rounded-xl text-xs flex items-center justify-center gap-1.5 shadow-md shadow-emerald-500/20">
                                <CheckCircle2 class="w-4 h-4" />
                                <span>Approve & Aktifkan Akun</span>
                            </button>
                            <button @click="rejectUser(selectedUser.id)" class="w-full py-2.5 bg-rose-600 text-white font-semibold rounded-xl text-xs flex items-center justify-center gap-1.5">
                                <XCircle class="w-4 h-4" />
                                <span>Tolak Pendaftaran</span>
                            </button>
                        </div>
                    </div>

                    <!-- Column Right: Native PDF Viewer -->
                    <div class="md:col-span-2 bg-slate-100 flex flex-col justify-center items-center">
                        <iframe 
                            v-if="selectedUser.profile?.cv_path" 
                            :src="`/storage/${selectedUser.profile.cv_path}`" 
                            class="w-full h-full border-0"
                        ></iframe>
                        <div v-else class="text-center text-slate-400 p-6">
                            <FileText class="w-10 h-10 mx-auto mb-2 opacity-50" />
                            <p class="text-xs font-semibold">Berkas CV PDF tidak ditemukan atau belum diunggah.</p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
