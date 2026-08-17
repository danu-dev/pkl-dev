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
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs sm:flex-row sm:items-center"
        >
            <div>
                <h1
                    class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
                >
                    <Calendar class="h-5 w-5 text-zinc-900" />
                    Jadwal Piket Kebersihan
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Periksa pembagian jadwal tugas piket harian Anda (Shift Pagi
                    & Sore).
                </p>
            </div>
            <span
                class="self-start rounded-xl border border-zinc-200 bg-zinc-100 px-3.5 py-1.5 text-xs font-semibold text-zinc-900 sm:self-auto"
            >
                Hari Ini: {{ todayDate }}
            </span>
        </div>

        <!-- TAMPILAN JADWAL PIKET MINGGUAN -->
        <div
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
        >
            <div class="border-b border-zinc-100 pb-3">
                <h3 class="text-base font-bold text-zinc-950">
                    Dashboard Jadwal Piket Mingguan
                </h3>
                <p class="text-xs text-zinc-500">
                    Daftar siswa piket Senin sampai Jum'at
                </p>
            </div>

            <!-- Days Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                <div
                    v-for="(name, key) in dayNames"
                    :key="key"
                    class="space-y-3 rounded-xl border border-zinc-200 bg-zinc-50 p-4"
                >
                    <h4
                        class="rounded-lg border-b border-zinc-200 bg-white py-1.5 pb-2 text-center text-sm font-bold text-zinc-900 shadow-2xs"
                    >
                        {{ name }}
                    </h4>

                    <!-- Shift Pagi -->
                    <div class="space-y-1">
                        <p
                            class="text-[10px] font-bold tracking-wider text-zinc-400 uppercase"
                        >
                            Pagi
                        </p>
                        <div
                            v-if="
                                schedules[key]?.pagi &&
                                schedules[key].pagi.length > 0
                            "
                            class="space-y-1"
                        >
                            <div
                                v-for="(person, idx) in schedules[key].pagi"
                                :key="idx"
                                class="rounded-lg border border-zinc-100 bg-white p-2 text-xs font-semibold text-zinc-800 shadow-2xs"
                            >
                                {{ person }}
                            </div>
                        </div>
                        <p
                            v-else
                            class="font-italic rounded bg-white/60 py-1 text-center text-[11px] text-zinc-400"
                        >
                            Belum Ada data
                        </p>
                    </div>

                    <!-- Shift Sore -->
                    <div class="space-y-1 pt-1">
                        <p
                            class="text-[10px] font-bold tracking-wider text-zinc-400 uppercase"
                        >
                            Sore
                        </p>
                        <div
                            v-if="
                                schedules[key]?.sore &&
                                schedules[key].sore.length > 0
                            "
                            class="space-y-1"
                        >
                            <div
                                v-for="(person, idx) in schedules[key].sore"
                                :key="idx"
                                class="rounded-lg border border-zinc-100 bg-white p-2 text-xs font-semibold text-zinc-800 shadow-2xs"
                            >
                                {{ person }}
                            </div>
                        </div>
                        <p
                            v-else
                            class="font-italic rounded bg-white/60 py-1 text-center text-[11px] text-zinc-400"
                        >
                            Belum Ada data
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
