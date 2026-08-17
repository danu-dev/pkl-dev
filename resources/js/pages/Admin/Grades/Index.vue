<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Award, Edit } from '@lucide/vue';
import { ref } from 'vue';

defineProps<{
    students: any[];
}>();

const selectedStudent = ref<any>(null);
const showModal = ref(false);

const form = useForm({
    user_id: '',
    discipline_score: 85,
    technical_score: 85,
    journal_score: 85,
    attendance_score: 85,
    attitude_score: 85,
    notes: '',
});

const openGradeModal = (student: any) => {
    selectedStudent.value = student;
    form.user_id = student.id;

    if (student.grade) {
        form.discipline_score = student.grade.discipline_score;
        form.technical_score = student.grade.technical_score;
        form.journal_score = student.grade.journal_score;
        form.attendance_score = student.grade.attendance_score;
        form.attitude_score = student.grade.attitude_score;
        form.notes = student.grade.notes || '';
    }

    showModal.value = true;
};

const submitGrade = () => {
    form.post('/admin/grades', {
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
                <Award class="h-5 w-5 text-zinc-900" />
                Penilaian & Sertifikat Akhir PKL
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Input nilai parameter performa siswa untuk kalkulasi otomatis
                nilai akhir dan predikat sertifikat.
            </p>
        </div>

        <!-- Student Grades Table -->
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
                            <th class="px-5 py-3">Asal Sekolah</th>
                            <th class="px-5 py-3">Nilai Akhir</th>
                            <th class="px-5 py-3">Predikat</th>
                            <th class="px-5 py-3 text-right">Aksi Penilaian</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100">
                        <tr
                            v-for="student in students"
                            :key="student.id"
                            class="hover:bg-zinc-50/50"
                        >
                            <td class="px-5 py-4 font-bold text-zinc-900">
                                {{ student.name }}
                            </td>
                            <td class="px-5 py-4 text-zinc-600">
                                {{ student.profile?.school_name }}
                            </td>
                            <td
                                class="px-5 py-4 text-sm font-bold text-zinc-900"
                            >
                                {{ student.grade?.final_score || '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <span
                                    v-if="student.grade"
                                    class="rounded-full border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-bold text-zinc-950"
                                >
                                    Nilai {{ student.grade.grade_letter }}
                                </span>
                                <span v-else class="text-zinc-400"
                                    >Belum Dinilai</span
                                >
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button
                                    @click="openGradeModal(student)"
                                    class="cursor-pointer rounded-lg bg-zinc-100 px-3 py-1.5 text-xs font-semibold text-zinc-950 hover:bg-zinc-200"
                                >
                                    Input / Edit Nilai
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grade Input Modal -->
    <div
        v-if="showModal && selectedStudent"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-lg space-y-4 rounded-2xl border border-zinc-100 bg-white p-6 shadow-2xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-base font-bold text-zinc-900">
                    Input Nilai: {{ selectedStudent.name }}
                </h3>
                <button
                    @click="showModal = false"
                    class="text-sm text-zinc-400 hover:text-zinc-600"
                >
                    ✕
                </button>
            </div>

            <form @submit.prevent="submitGrade" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Kedisiplinan (20%) *</label
                        >
                        <input
                            v-model.number="form.discipline_score"
                            type="number"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Keahlian Teknis (30%) *</label
                        >
                        <input
                            v-model.number="form.technical_score"
                            type="number"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Jurnal Kegiatan (20%) *</label
                        >
                        <input
                            v-model.number="form.journal_score"
                            type="number"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Kehadiran (15%) *</label
                        >
                        <input
                            v-model.number="form.attendance_score"
                            type="number"
                            min="0"
                            max="100"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Sikap & Etika (15%) *</label
                    >
                    <input
                        v-model.number="form.attitude_score"
                        type="number"
                        min="0"
                        max="100"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Catatan Evaluasi Admin</label
                    >
                    <textarea
                        v-model="form.notes"
                        rows="2"
                        placeholder="Catatan masukan..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
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
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
