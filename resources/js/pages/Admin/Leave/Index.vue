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
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <FileText class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Kelola Pengajuan Izin / Sakit Siswa
                </h1>
                <p class="text-xs text-slate-500 mt-1">Tinjau permohonan surat izin dan surat dokter yang dikirimkan oleh siswa PKL.</p>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
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
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="leave in leaveRequests.data" :key="leave.id" class="hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-bold text-slate-900">
                                    <p>{{ leave.user?.name }}</p>
                                    <p class="text-[11px] font-normal text-slate-400">{{ leave.user?.profile?.school_name }}</p>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                          :class="leave.type === 'sakit' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700'">
                                        {{ leave.type }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-700 whitespace-nowrap font-medium">
                                    {{ leave.start_date }} s/d {{ leave.end_date }}
                                </td>
                                <td class="px-5 py-4 text-slate-600 max-w-xs">
                                    {{ leave.reason }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <a v-if="leave.attachment" :href="`/storage/${leave.attachment}`" target="_blank" class="text-[rgb(93,135,255)] font-semibold hover:underline inline-flex items-center gap-1">
                                        <Download class="w-3.5 h-3.5" />
                                        <span>Lihat Lampiran</span>
                                    </a>
                                    <span v-else class="text-slate-400">-</span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold capitalize"
                                          :class="{
                                              'bg-emerald-50 text-emerald-700': leave.status === 'approved',
                                              'bg-amber-50 text-amber-700': leave.status === 'pending',
                                              'bg-rose-50 text-rose-700': leave.status === 'rejected',
                                          }">
                                        {{ leave.status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <button @click="openModal(leave)" class="px-3 py-1.5 bg-blue-50 text-[rgb(93,135,255)] font-semibold rounded-lg text-xs hover:bg-blue-100">
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
        <div v-if="showModal && selectedLeave" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-base">Review Pengajuan Izin / Sakit</h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <form @submit.prevent="submitUpdate" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Pilih Keputusan Admin</label>
                        <select v-model="form.status" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                            <option value="approved">Approve / Setujui</option>
                            <option value="rejected">Reject / Tolak</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Catatan Admin</label>
                        <textarea v-model="form.admin_note" rows="3" placeholder="Catatan respon..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Keputusan</button>
                    </div>
                </form>
            </div>
    </div>
</template>
