<script setup lang="ts">
import { useForm, router } from '@inertiajs/vue3';
import { Megaphone, Plus, Trash2 } from '@lucide/vue';

defineProps<{
    announcements: any;
}>();

const form = useForm({
    title: '',
    content: '',
    is_pinned: false,
    target_role: 'all',
});

const submitAnnouncement = () => {
    form.post('/admin/announcements', {
        onSuccess: () => form.reset(),
    });
};

const deleteAnnouncement = (id: number) => {
    if (confirm('Hapus pengumuman ini?')) {
        router.delete(`/admin/announcements/${id}`);
    }
};
</script>

<template>
    <div class="space-y-6">
        <!-- Header section -->
        <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs">
            <h1
                class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
            >
                <Megaphone class="h-5 w-5 text-zinc-900" />
                Broadcast Pengumuman Dashboard
            </h1>
            <p class="mt-1 text-xs text-zinc-500">
                Buat informasi & pengumuman penting yang akan muncul di
                dashboard siswa PKL.
            </p>
        </div>

        <!-- Form Broadcast -->
        <div
            class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Buat Pengumuman Baru
            </h3>
            <form @submit.prevent="submitAnnouncement" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Judul Pengumuman *</label
                    >
                    <input
                        v-model="form.title"
                        type="text"
                        required
                        placeholder="Judul informasi..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-zinc-700"
                        >Isi Pesan Pengumuman *</label
                    >
                    <textarea
                        v-model="form.content"
                        rows="3"
                        required
                        placeholder="Detail pesan pengumuman..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex items-center gap-4">
                    <label
                        class="flex cursor-pointer items-center gap-2 text-xs font-semibold text-zinc-700"
                    >
                        <input
                            v-model="form.is_pinned"
                            type="checkbox"
                            class="rounded text-zinc-950 focus:ring-zinc-950"
                        />
                        <span>Sematkan / Pin di Atas Dashboard</span>
                    </label>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-zinc-800"
                >
                    Publikasikan Pengumuman
                </button>
            </form>
        </div>

        <!-- Announcement List -->
        <div
            class="space-y-3 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
        >
            <h3
                class="border-b border-zinc-100 pb-2 text-sm font-bold text-zinc-900"
            >
                Pengumuman Terpublikasi
            </h3>

            <div class="space-y-3">
                <div
                    v-for="item in announcements.data"
                    :key="item.id"
                    class="flex items-start justify-between gap-4 rounded-xl border border-zinc-200 bg-zinc-50 p-4"
                >
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h4 class="text-sm font-bold text-zinc-900">
                                {{ item.title }}
                            </h4>
                            <span
                                v-if="item.is_pinned"
                                class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700"
                                >Pinned</span
                            >
                        </div>
                        <p class="text-xs leading-relaxed text-zinc-600">
                            {{ item.content }}
                        </p>
                    </div>
                    <button
                        @click="deleteAnnouncement(item.id)"
                        class="cursor-pointer p-1 text-rose-500 hover:text-rose-700"
                    >
                        <Trash2 class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
