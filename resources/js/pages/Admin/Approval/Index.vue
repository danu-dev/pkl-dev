<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import {
    UserCheck,
    CheckCircle2,
    XCircle,
    FileText,
    Eye,
    Building,
    GraduationCap,
    Phone,
} from '@lucide/vue';
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
        <div
            class="flex items-center justify-between rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <div>
                <h1
                    class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
                >
                    <UserCheck class="h-5 w-5 text-zinc-900" />
                    Approval Pendaftaran Siswa PKL
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Verifikasi berkas pendaftaran dan CV siswa sebelum
                    menyetujui akses akun.
                </p>
            </div>
        </div>

        <!-- Tabel Antrian Approval -->
        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
        >
            <div class="border-b border-zinc-100 p-4">
                <h3 class="text-sm font-bold text-zinc-900">
                    Daftar Siswa Pending Approval
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 font-semibold text-zinc-600 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-3">Nama Siswa</th>
                            <th class="px-5 py-3">Username / Email</th>
                            <th class="px-5 py-3">Asal Sekolah & Jurusan</th>
                            <th class="px-5 py-3">Tipe Sesi</th>
                            <th class="px-5 py-3">Berkas CV PDF</th>
                            <th class="px-5 py-3 text-right">Aksi Approval</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="user in pendingUsers.data"
                            :key="user.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-5 py-4 font-bold text-zinc-900">
                                {{ user.name }}
                            </td>
                            <td class="px-5 py-4 text-zinc-600">
                                <p class="font-medium text-zinc-800">
                                    @{{ user.username }}
                                </p>
                                <p class="text-[11px] text-zinc-400">
                                    {{ user.email }}
                                </p>
                            </td>
                            <td class="px-5 py-4 text-zinc-700">
                                <p class="font-semibold">
                                    {{ user.profile?.school_name || '-' }}
                                </p>
                                <p class="text-[11px] text-zinc-500">
                                    {{ user.profile?.major_name || '-' }}
                                </p>
                            </td>
                            <td class="px-5 py-4">
                                <span
                                    class="inline-block rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-0.5 text-[10px] font-bold text-zinc-950 capitalize"
                                >
                                    {{ user.profile?.session_type }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <button
                                    @click="openPreviewModal(user)"
                                    class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg bg-zinc-100 px-3 py-1.5 text-xs font-semibold text-zinc-950 transition-all hover:bg-zinc-200"
                                >
                                    <Eye class="h-3.5 w-3.5" />
                                    <span>Preview CV</span>
                                </button>
                            </td>
                            <td class="space-x-2 px-5 py-4 text-right">
                                <button
                                    @click="approveUser(user.id)"
                                    class="inline-flex cursor-pointer items-center gap-1 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-2xs transition-all hover:bg-emerald-700"
                                >
                                    <CheckCircle2 class="h-3.5 w-3.5" />
                                    <span>Approve</span>
                                </button>
                                <button
                                    @click="rejectUser(user.id)"
                                    class="inline-flex cursor-pointer items-center gap-1 rounded-lg bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white shadow-2xs transition-all hover:bg-rose-700"
                                >
                                    <XCircle class="h-3.5 w-3.5" />
                                    <span>Tolak</span>
                                </button>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !pendingUsers.data ||
                                pendingUsers.data.length === 0
                            "
                        >
                            <td
                                colspan="6"
                                class="px-5 py-8 text-center text-xs text-zinc-400"
                            >
                                Tidak ada pendaftaran siswa yang menunggu
                                approval.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SPLIT MODAL PREVIEW CV PDF (Kebutuhan Spesifik User) -->
    <div
        v-if="showCvModal && selectedUser"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/50 p-4 backdrop-blur-sm"
    >
        <div
            class="flex h-[85vh] w-full max-w-4xl flex-col overflow-hidden rounded-2xl border border-zinc-100 bg-white shadow-2xl"
        >
            <!-- Modal Header -->
            <div
                class="flex items-center justify-between border-b border-zinc-100 bg-zinc-50 p-4"
            >
                <div>
                    <h3 class="text-base font-bold text-zinc-900">
                        Pratinjau CV & Verification Details
                    </h3>
                    <p class="text-xs text-zinc-500">
                        Pendaftar: {{ selectedUser.name }} (@{{
                            selectedUser.username
                        }})
                    </p>
                </div>
                <button
                    @click="showCvModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <!-- Modal Body Split 2 Columns -->
            <div class="grid flex-1 grid-cols-1 overflow-hidden md:grid-cols-3">
                <!-- Column Left: Student Info Details -->
                <div
                    class="space-y-4 overflow-y-auto border-r border-zinc-200 bg-white p-5"
                >
                    <h4
                        class="text-xs font-bold tracking-wider text-zinc-400 text-zinc-900 uppercase"
                    >
                        Detail Profil Siswa
                    </h4>

                    <div class="space-y-3 text-xs">
                        <div>
                            <p class="font-medium text-zinc-400">
                                Nama Lengkap:
                            </p>
                            <p class="text-sm font-bold text-zinc-900">
                                {{ selectedUser.name }}
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-zinc-400">
                                Email / WhatsApp:
                            </p>
                            <p class="font-semibold text-zinc-800">
                                {{ selectedUser.email }}
                            </p>
                            <p class="text-zinc-600">
                                {{ selectedUser.profile?.phone_number || '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-zinc-400">
                                Asal Sekolah / Kampus:
                            </p>
                            <p class="font-semibold text-zinc-800">
                                {{ selectedUser.profile?.school_name || '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-zinc-400">Jurusan:</p>
                            <p class="font-semibold text-zinc-800">
                                {{ selectedUser.profile?.major_name || '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="font-medium text-zinc-400">
                                Tipe Sesi PKL:
                            </p>
                            <p class="font-semibold text-zinc-950 uppercase">
                                {{ selectedUser.profile?.session_type }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-2 border-t border-zinc-100 pt-4">
                        <button
                            @click="approveUser(selectedUser.id)"
                            class="flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-xl bg-emerald-600 py-2.5 text-xs font-semibold text-white shadow-xs hover:bg-emerald-700"
                        >
                            <CheckCircle2 class="h-4 w-4" />
                            <span>Approve & Aktifkan Akun</span>
                        </button>
                        <button
                            @click="rejectUser(selectedUser.id)"
                            class="flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-xl bg-rose-600 py-2.5 text-xs font-semibold text-white hover:bg-rose-700"
                        >
                            <XCircle class="h-4 w-4" />
                            <span>Tolak Pendaftaran</span>
                        </button>
                    </div>
                </div>

                <!-- Column Right: Native PDF Viewer -->
                <div
                    class="flex flex-col items-center justify-center bg-zinc-100 md:col-span-2"
                >
                    <iframe
                        v-if="selectedUser.profile?.cv_path"
                        :src="`/storage/${selectedUser.profile.cv_path}`"
                        class="h-full w-full border-0"
                    ></iframe>
                    <div v-else class="p-6 text-center text-zinc-400">
                        <FileText class="mx-auto mb-2 h-10 w-10 opacity-50" />
                        <p class="text-xs font-semibold">
                            Berkas CV PDF tidak ditemukan atau belum diunggah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
