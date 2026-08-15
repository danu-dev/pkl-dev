<script setup lang="ts">
import { Sparkles, Calendar } from '@lucide/vue';

defineProps<{
    schedules: any;
    todayDate: string;
}>();

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
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <Calendar class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Jadwal Piket Kebersihan
                </h1>
                <p class="text-xs text-slate-500 mt-1">Periksa pembagian jadwal tugas piket harian Anda (Shift Pagi & Sore).</p>
            </div>
            <span class="text-xs font-semibold px-3.5 py-1.5 bg-blue-50 text-[rgb(93,135,255)] rounded-xl border border-blue-100 self-start sm:self-auto">
                Hari Ini: {{ todayDate }}
            </span>
        </div>

        <!-- TAMPILAN JADWAL PIKET MINGGUAN -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-base">Dashboard Jadwal Piket Mingguan</h3>
                <p class="text-xs text-slate-500">Daftar siswa piket Senin sampai Jum'at</p>
            </div>

            <!-- Days Grid -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div v-for="(name, key) in dayNames" :key="key" class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                    <h4 class="font-bold text-slate-900 text-sm border-b border-slate-200 pb-2 text-center bg-white py-1.5 rounded-lg shadow-xs">
                        {{ name }}
                    </h4>

                    <!-- Shift Pagi -->
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pagi</p>
                        <div v-if="schedules[key]?.pagi && schedules[key].pagi.length > 0" class="space-y-1">
                            <div v-for="(person, idx) in schedules[key].pagi" :key="idx" class="p-2 bg-white rounded-lg text-xs font-semibold text-slate-800 border border-slate-100 shadow-xs">
                                {{ person }}
                            </div>
                        </div>
                        <p v-else class="text-[11px] text-slate-400 font-italic py-1 text-center bg-white/60 rounded">Belum Ada data</p>
                    </div>

                    <!-- Shift Sore -->
                    <div class="space-y-1 pt-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sore</p>
                        <div v-if="schedules[key]?.sore && schedules[key].sore.length > 0" class="space-y-1">
                            <div v-for="(person, idx) in schedules[key].sore" :key="idx" class="p-2 bg-white rounded-lg text-xs font-semibold text-slate-800 border border-slate-100 shadow-xs">
                                {{ person }}
                            </div>
                        </div>
                        <p v-else class="text-[11px] text-slate-400 font-italic py-1 text-center bg-white/60 rounded">Belum Ada data</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
