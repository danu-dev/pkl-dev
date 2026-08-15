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
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <Award class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Penilaian & Sertifikat Akhir PKL
                </h1>
                <p class="text-xs text-slate-500 mt-1">Input nilai parameter performa siswa untuk kalkulasi otomatis nilai akhir dan predikat sertifikat.</p>
            </div>

            <!-- Student Grades Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-semibold border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3">Nama Siswa</th>
                                <th class="px-5 py-3">Asal Sekolah</th>
                                <th class="px-5 py-3">Nilai Akhir</th>
                                <th class="px-5 py-3">Predikat</th>
                                <th class="px-5 py-3 text-right">Aksi Penilaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-for="student in students" :key="student.id" class="hover:bg-slate-50/50">
                                <td class="px-5 py-4 font-bold text-slate-900">{{ student.name }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ student.profile?.school_name }}</td>
                                <td class="px-5 py-4 font-bold text-slate-900 text-sm">
                                    {{ student.grade?.final_score || '-' }}
                                </td>
                                <td class="px-5 py-4">
                                    <span v-if="student.grade" class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-[rgb(93,135,255)]">
                                        Nilai {{ student.grade.grade_letter }}
                                    </span>
                                    <span v-else class="text-slate-400">Belum Dinilai</span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <button @click="openGradeModal(student)" class="px-3 py-1.5 bg-blue-50 text-[rgb(93,135,255)] font-semibold rounded-lg text-xs hover:bg-blue-100">
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
        <div v-if="showModal && selectedStudent" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-base">Input Nilai: {{ selectedStudent.name }}</h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
                </div>

                <form @submit.prevent="submitGrade" class="space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Kedisiplinan (20%) *</label>
                            <input v-model.number="form.discipline_score" type="number" min="0" max="100" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Keahlian Teknis (30%) *</label>
                            <input v-model.number="form.technical_score" type="number" min="0" max="100" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Jurnal Kegiatan (20%) *</label>
                            <input v-model.number="form.journal_score" type="number" min="0" max="100" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-slate-700">Kehadiran (15%) *</label>
                            <input v-model.number="form.attendance_score" type="number" min="0" max="100" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Sikap & Etika (15%) *</label>
                        <input v-model.number="form.attitude_score" type="number" min="0" max="100" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Catatan Evaluasi Admin</label>
                        <textarea v-model="form.notes" rows="2" placeholder="Catatan masukan..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs"></textarea>
                    </div>

                    <div class="pt-2 flex justify-end gap-2">
                        <button type="button" @click="showModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-semibold rounded-xl text-xs">Batal</button>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan Penilaian</button>
                    </div>
                </form>
            </div>
    </div>
</template>
