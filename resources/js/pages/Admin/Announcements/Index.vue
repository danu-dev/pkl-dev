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
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <Megaphone class="w-5 h-5 text-[rgb(93,135,255)]" />
                    Broadcast Pengumuman Dashboard
                </h1>
                <p class="text-xs text-slate-500 mt-1">Buat informasi & pengumuman penting yang akan muncul di dashboard siswa PKL.</p>
            </div>

            <!-- Form Broadcast -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Buat Pengumuman Baru</h3>
                <form @submit.prevent="submitAnnouncement" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Judul Pengumuman *</label>
                        <input v-model="form.title" type="text" required placeholder="Judul informasi..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700">Isi Pesan Pengumuman *</label>
                        <textarea v-model="form.content" rows="3" required placeholder="Detail pesan pengumuman..." class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm"></textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input v-model="form.is_pinned" type="checkbox" class="rounded text-[rgb(93,135,255)]" />
                            <span>Sematkan / Pin di Atas Dashboard</span>
                        </label>
                    </div>

                    <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white font-semibold rounded-xl text-xs shadow-md shadow-blue-500/20">Publikasikan Pengumuman</button>
                </form>
            </div>

            <!-- Announcement List -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 space-y-3">
                <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-2">Pengumuman Terpublikasi</h3>

                <div class="space-y-3">
                    <div v-for="item in announcements.data" :key="item.id" class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-slate-900 text-sm">{{ item.title }}</h4>
                                <span v-if="item.is_pinned" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Pinned</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ item.content }}</p>
                        </div>
                        <button @click="deleteAnnouncement(item.id)" class="text-rose-500 hover:text-rose-700 p-1">
                            <Trash2 class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
    </div>
</template>
