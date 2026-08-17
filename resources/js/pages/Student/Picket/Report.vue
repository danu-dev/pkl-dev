<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Send, Image as ImageIcon } from '@lucide/vue';
import { ref } from 'vue';

defineProps<{
    myReports: any;
    todayDate: string;
}>();

const showReportModal = ref(false);

const form = useForm({
    notes: '',
    proof_file: null as File | null,
});

const handleFileUpload = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.proof_file = target.files[0];
    }
};

const submitReport = () => {
    form.post('/picket-report', {
        onSuccess: () => {
            showReportModal.value = false;
            form.reset();
        },
    });
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
                    <Send class="h-5 w-5 text-zinc-900" />
                    Laporan Piket Kebersihan
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Kirimkan catatan & bukti foto kegiatan piket harian Anda.
                </p>
            </div>

            <button
                @click="showReportModal = true"
                class="flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-zinc-950 px-4 py-2.5 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800"
            >
                <Send class="h-4 w-4" />
                <span>Laporkan Piket Hari Ini</span>
            </button>
        </div>

        <!-- Tabel Riwayat Laporan Piket -->
        <div
            class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
        >
            <div class="border-b border-zinc-100 p-4">
                <h3 class="text-sm font-bold text-zinc-950">
                    Riwayat Laporan Piket Anda
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead
                        class="border-b border-zinc-200 bg-zinc-50 font-semibold text-zinc-600 uppercase"
                    >
                        <tr>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Catatan Laporan</th>
                            <th class="px-5 py-3">Bukti Piket</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="report in myReports.data"
                            :key="report.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td
                                class="px-5 py-4 font-bold whitespace-nowrap text-zinc-900"
                            >
                                {{ report.date }}
                            </td>
                            <td class="px-5 py-4 text-zinc-600">
                                {{ report.notes || '-' }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <a
                                    :href="`/storage/${report.proof_file}`"
                                    target="_blank"
                                    class="group inline-block"
                                >
                                    <img
                                        :src="`/storage/${report.proof_file}`"
                                        alt="Bukti Piket"
                                        class="h-12 w-12 rounded-xl border border-zinc-200 object-cover shadow-2xs transition-transform group-hover:scale-105"
                                    />
                                </a>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span
                                    class="inline-block rounded-full px-2.5 py-0.5 text-[10px] font-bold capitalize"
                                    :class="
                                        report.status === 'verified'
                                            ? 'border border-emerald-200 bg-emerald-50 text-emerald-700'
                                            : 'border border-amber-200 bg-amber-50 text-amber-700'
                                    "
                                >
                                    {{
                                        report.status === 'verified'
                                            ? 'Terverifikasi'
                                            : 'Menunggu Review'
                                    }}
                                </span>
                            </td>
                        </tr>
                        <tr
                            v-if="
                                !myReports.data || myReports.data.length === 0
                            "
                        >
                            <td
                                colspan="4"
                                class="px-5 py-8 text-center text-zinc-400"
                            >
                                Belum ada laporan piket yang dikirimkan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Form Laporkan Piket -->
        <div
            v-if="showReportModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
        >
            <div
                class="w-full max-w-md space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
            >
                <div
                    class="flex items-center justify-between border-b border-zinc-100 pb-3"
                >
                    <h3 class="text-base font-bold text-zinc-900">
                        Laporkan Piket Kebersihan
                    </h3>
                    <button
                        @click="showReportModal = false"
                        class="text-sm text-zinc-400 hover:text-zinc-600"
                    >
                        ✕
                    </button>
                </div>

                <form @submit.prevent="submitReport" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Catatan Laporan Piket</label
                        >
                        <textarea
                            v-model="form.notes"
                            rows="3"
                            placeholder="Sapu dan pel area ruangan..."
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                        ></textarea>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Bukti Foto Piket (Format Foto JPG/PNG) *</label
                        >
                        <input
                            type="file"
                            accept="image/*"
                            required
                            @change="handleFileUpload"
                            class="w-full text-xs text-zinc-500 file:mr-4 file:rounded-xl file:border-0 file:bg-zinc-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-zinc-950 hover:file:bg-zinc-200"
                        />
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button
                            type="button"
                            @click="showReportModal = false"
                            class="rounded-xl bg-zinc-100 px-4 py-2 text-xs font-semibold text-zinc-600"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
                        >
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
