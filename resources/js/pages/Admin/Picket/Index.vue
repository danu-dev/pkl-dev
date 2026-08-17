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
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs">
            <h1
                class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
            >
                <Sparkles class="h-5 w-5 text-zinc-900" />
                Kelola Jadwal & Laporan Piket Siswa
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Ploting petugas piket harian dan tinjau laporan foto piket yang
                dikirimkan.
            </p>
        </div>

        <!-- Form Ploting Jadwal -->
        <div
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Ploting Petugas Piket Baru
            </h3>
            <form
                @submit.prevent="submitSchedule"
                class="grid grid-cols-1 gap-4 sm:grid-cols-4"
            >
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Pilih Siswa *</label
                    >
                    <select
                        v-model="form.user_id"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="">-- Pilih Siswa --</option>
                        <option v-for="s in students" :key="s.id" :value="s.id">
                            {{ s.name }}
                        </option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Hari Piket *</label
                    >
                    <select
                        v-model="form.day"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="rabu">Rabu</option>
                        <option value="kamis">Kamis</option>
                        <option value="jumat">Jum'at</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Shift *</label
                    >
                    <select
                        v-model="form.shift"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-xs focus:border-zinc-950 focus:outline-none"
                    >
                        <option value="pagi">Pagi</option>
                        <option value="sore">Sore</option>
                    </select>
                </div>

                <div class="flex items-end space-y-1">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full cursor-pointer rounded-xl bg-zinc-950 py-2 text-xs font-semibold text-white hover:bg-zinc-800"
                    >
                        Simpan ke Jadwal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tampilan Grid Jadwal Piket Mingguan -->
        <div
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Jadwal Piket Mingguan Terdaftar
            </h3>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                <div
                    v-for="(name, key) in dayNames"
                    :key="key"
                    class="space-y-3 rounded-xl border border-zinc-200 bg-zinc-50 p-3.5"
                >
                    <h4
                        class="rounded-lg border border-zinc-100 bg-white py-1 text-center text-xs font-bold text-zinc-900 shadow-2xs"
                    >
                        {{ name }}
                    </h4>

                    <!-- Pagi -->
                    <div class="space-y-1">
                        <p
                            class="text-[10px] font-bold text-zinc-400 uppercase"
                        >
                            Shift Pagi
                        </p>
                        <div
                            v-for="item in schedules[key]?.pagi"
                            :key="item.id"
                            class="flex items-center justify-between rounded-lg border border-zinc-100 bg-white p-2 text-xs font-semibold"
                        >
                            <span class="truncate text-zinc-900">{{
                                item.user?.name
                            }}</span>
                            <button
                                @click="deleteSchedule(item.id)"
                                class="cursor-pointer text-[10px] text-rose-500 hover:text-rose-700"
                            >
                                ✕
                            </button>
                        </div>
                    </div>

                    <!-- Sore -->
                    <div class="space-y-1 pt-1">
                        <p
                            class="text-[10px] font-bold text-zinc-400 uppercase"
                        >
                            Shift Sore
                        </p>
                        <div
                            v-for="item in schedules[key]?.sore"
                            :key="item.id"
                            class="flex items-center justify-between rounded-lg border border-zinc-100 bg-white p-2 text-xs font-semibold"
                        >
                            <span class="truncate text-zinc-900">{{
                                item.user?.name
                            }}</span>
                            <button
                                @click="deleteSchedule(item.id)"
                                class="cursor-pointer text-[10px] text-rose-500 hover:text-rose-700"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
