<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { Sparkles, Plus, Trash2 } from '@lucide/vue';
import { ref } from 'vue';

const props = defineProps<{
    students: any[];
    schedules: any;
    reports: any;
}>();

const form = useForm({
    user_id: '',
    day: 'senin',
    shift: 'pagi',
});

const submitSchedule = () => {
    form.post('/admin/picket/schedule', {
        onSuccess: () => form.reset(),
    });
};

const deleteSchedule = (id: number) => {
    if (confirm('Hapus petugas ini dari jadwal piket?')) {
        router.delete(`/admin/picket/schedule/${id}`);
    }
};

const dayNames: Record<string, string> = {
    senin: 'Senin',
    selasa: 'Selasa',
    rabu: 'Rabu',
    kamis: 'Kamis',
    jumat: "Jum'at",
};
</script>

<template>
    <div class="space-y-6">
            <!-- Header section -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <Sparkles class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Kelola Jadwal & Laporan Piket Siswa
                </h1>
                <p class="text-xs text-slate-500 mt-1">Ploting petugas piket harian dan tinjau laporan foto piket yang dikirimkan.</p>
            </div>

            <!-- Form Ploting Jadwal -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Ploting Petugas Piket Baru</h3>
                <form @submit.prevent="submitSchedule" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Pilih Siswa *</label>
                        <select v-model="form.user_id" required class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <option value="">-- Pilih Siswa --</option>
                            <option v-for="s in students" :key="s.id" :value="s.id">{{ s.name }}</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Hari Piket *</label>
                        <select v-model="form.day" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <option value="senin">Senin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="kamis">Kamis</option>
                            <option value="jumat">Jum'at</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Shift *</label>
                        <select v-model="form.shift" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <option value="pagi">Pagi</option>
                            <option value="sore">Sore</option>
                        </select>
                    </div>

                    <div class="space-y-1 flex items-end">
                        <button type="submit" :disabled="form.processing" class="w-full py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs">Simpan ke Jadwal</button>
                    </div>
                </form>
            </div>

            <!-- Tampilan Grid Jadwal Piket Mingguan -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Jadwal Piket Mingguan Terdaftar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div v-for="(name, key) in dayNames" :key="key" class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                        <h4 class="font-bold text-slate-900 text-xs text-center bg-white py-1 rounded-lg border border-slate-100 shadow-2xs">{{ name }}</h4>

                        <!-- Pagi -->
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Shift Pagi</p>
                            <div v-for="item in schedules[key]?.pagi" :key="item.id" class="p-2 bg-white rounded-lg text-xs font-semibold flex items-center justify-between border border-slate-100">
                                <span class="truncate">{{ item.user?.name }}</span>
                                <button @click="deleteSchedule(item.id)" class="text-rose-500 hover:text-rose-700 text-[10px]">✕</button>
                            </div>
                        </div>

                        <!-- Sore -->
                        <div class="space-y-1 pt-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Shift Sore</p>
                            <div v-for="item in schedules[key]?.sore" :key="item.id" class="p-2 bg-white rounded-lg text-xs font-semibold flex items-center justify-between border border-slate-100">
                                <span class="truncate">{{ item.user?.name }}</span>
                                <button @click="deleteSchedule(item.id)" class="text-rose-500 hover:text-rose-700 text-[10px]">✕</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>
