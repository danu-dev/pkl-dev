<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { FileText, CheckCircle2, XCircle, Download } from '@lucide/vue';
import { ref } from 'vue';

defineProps<{
    leaveRequests: any;
}>();

const selectedLeave = ref<any>(null);
const showModal = ref(false);

const form = useForm({
    status: 'approved',
    admin_note: '',
});

const openModal = (leave: any) => {
    selectedLeave.value = leave;
    form.status = leave.status === 'rejected' ? 'rejected' : 'approved';
    form.admin_note = leave.admin_note || '';
    showModal.value = true;
};

const submitUpdate = () => {
    form.post(`/admin/leave-requests/${selectedLeave.value.id}`, {
        onSuccess: () => {
            showModal.value = false;
        },
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
                <FileText class="h-5 w-5 text-zinc-900" />
                Kelola Pengajuan Izin / Sakit Siswa
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Tinjau permohonan surat izin dan surat dokter yang dikirimkan
                oleh siswa PKL.
            </p>
        </div>

        <!-- Table -->
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
                            <th class="px-5 py-3">Tipe</th>
                            <th class="px-5 py-3">Rentang Tanggal</th>
                            <th class="px-5 py-3">Alasan</th>
                            <th class="px-5 py-3">Lampiran Surat</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi Review</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="leave in leaveRequests.data"
                            :key="leave.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-5 py-4 font-bold text-zinc-900">
                                <p>{{ leave.user?.name }}</p>
                                <p
                                    class="text-[11px] font-normal text-zinc-400"
                                >
                                    {{ leave.user?.profile?.school_name }}
                                </p>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase"
                                    :class="
                                        leave.type === 'sakit'
                                            ? 'bg-rose-50 text-rose-700'
                                            : 'bg-amber-50 text-amber-700'
                                    "
                                >
                                    {{ leave.type }}
                                </span>
                            </td>
                            <td
                                class="px-5 py-4 font-medium whitespace-nowrap text-zinc-700"
                            >
                                {{ leave.start_date }} s/d {{ leave.end_date }}
                            </td>
                            <td class="max-w-xs px-5 py-4 text-zinc-600">
                                {{ leave.reason }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <a
                                    v-if="leave.attachment"
                                    :href="`/storage/${leave.attachment}`"
                                    target="_blank"
                                    class="inline-flex items-center gap-1 font-semibold text-zinc-950 hover:underline"
                                >
                                    <Download class="h-3.5 w-3.5" />
                                    <span>Lihat Lampiran</span>
                                </a>
                                <span v-else class="text-zinc-400">-</span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold capitalize"
                                    :class="{
                                        'bg-emerald-50 text-emerald-700':
                                            leave.status === 'approved',
                                        'bg-amber-50 text-amber-700':
                                            leave.status === 'pending',
                                        'bg-rose-50 text-rose-700':
                                            leave.status === 'rejected',
                                    }"
                                >
                                    {{ leave.status }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <button
                                    @click="openModal(leave)"
                                    class="cursor-pointer rounded-lg bg-zinc-100 px-3 py-1.5 text-xs font-semibold text-zinc-950 hover:bg-zinc-200"
                                >
                                    Review
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Review -->
    <div
        v-if="showModal && selectedLeave"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-md space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-base font-bold text-zinc-900">
                    Review Pengajuan Izin / Sakit
                </h3>
                <button
                    @click="showModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitUpdate" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Pilih Keputusan Admin</label
                    >
                    <select
                        v-model="form.status"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="approved">Approve / Setujui</option>
                        <option value="rejected">Reject / Tolak</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Catatan Admin</label
                    >
                    <textarea
                        v-model="form.admin_note"
                        rows="3"
                        placeholder="Catatan respon..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="showModal = false"
                        class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-600"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
