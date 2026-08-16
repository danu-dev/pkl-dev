<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { 
    Globe, 
    Save, 
    Plus, 
    Trash2, 
    Edit3, 
    CheckCircle2, 
    Sparkles, 
    Users, 
    Image, 
    ListOrdered, 
    PhoneCall, 
    HelpCircle,
    X,
    Upload
} from '@lucide/vue';

interface AlumniItem {
    id: number;
    name: string;
    username?: string;
    school_name: string;
    major_name?: string;
    division_name?: string;
    graduation_year?: string;
    current_position?: string;
    quote: string;
    photo_path?: string;
    order: number;
    is_visible: boolean;
}

interface GalleryItem {
    id: number;
    title: string;
    category: string;
    image_path: string;
    caption?: string;
    order: number;
    is_visible: boolean;
}

interface ProcedureItem {
    id: number;
    step_number: number;
    title: string;
    description: string;
    icon: string;
    is_visible: boolean;
}

const props = defineProps<{
    sections: Record<string, string>;
    alumni: AlumniItem[] | { data: AlumniItem[] };
    gallery: GalleryItem[] | { data: GalleryItem[] };
    procedures: ProcedureItem[] | { data: ProcedureItem[] };
}>();

const alumniList = computed<AlumniItem[]>(() => {
    if (Array.isArray(props.alumni)) return props.alumni;
    return (props.alumni as any)?.data || [];
});

const galleryList = computed<GalleryItem[]>(() => {
    if (Array.isArray(props.gallery)) return props.gallery;
    return (props.gallery as any)?.data || [];
});

const procedureList = computed<ProcedureItem[]>(() => {
    if (Array.isArray(props.procedures)) return props.procedures;
    return (props.procedures as any)?.data || [];
});

const activeTab = ref<'sections' | 'alumni' | 'gallery' | 'procedures'>('sections');

// Form 1: General Sections Form
const sectionForm = useForm({
    sections: {
        hero_badge: props.sections.hero_badge || '',
        hero_title: props.sections.hero_title || '',
        hero_subtitle: props.sections.hero_subtitle || '',
        about_title: props.sections.about_title || '',
        about_description: props.sections.about_description || '',
        about_stat_students: props.sections.about_stat_students || '500+',
        about_stat_schools: props.sections.about_stat_schools || '45+',
        about_stat_divisions: props.sections.about_stat_divisions || '12+',
        contact_address: props.sections.contact_address || '',
        contact_email: props.sections.contact_email || '',
        contact_phone: props.sections.contact_phone || '',
        contact_whatsapp: props.sections.contact_whatsapp || '',
        contact_hours: props.sections.contact_hours || '',
    }
});

const submitSections = () => {
    sectionForm.post('/admin/landing-cms/sections');
};

// Modal & Forms for Alumni CRUD
const isAlumniModalOpen = ref(false);
const alumniForm = useForm({
    id: null as number | null,
    name: '',
    username: '',
    school_name: '',
    major_name: '',
    division_name: '',
    graduation_year: '',
    current_position: '',
    quote: '',
    photo: null as File | null,
    order: 0,
    is_visible: true,
});

const openAlumniModal = (item?: AlumniItem) => {
    if (item) {
        alumniForm.id = item.id;
        alumniForm.name = item.name;
        alumniForm.username = item.username || '';
        alumniForm.school_name = item.school_name;
        alumniForm.major_name = item.major_name || '';
        alumniForm.division_name = item.division_name || '';
        alumniForm.graduation_year = item.graduation_year || '';
        alumniForm.current_position = item.current_position || '';
        alumniForm.quote = item.quote;
        alumniForm.photo = null;
        alumniForm.order = item.order;
        alumniForm.is_visible = item.is_visible;
    } else {
        alumniForm.reset();
        alumniForm.id = null;
    }
    isAlumniModalOpen.value = true;
};

const submitAlumni = () => {
    alumniForm.post('/admin/landing-cms/alumni', {
        onSuccess: () => {
            isAlumniModalOpen.value = false;
            alumniForm.reset();
        }
    });
};

const deleteAlumni = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus data alumni ini?')) {
        useForm({}).delete(`/admin/landing-cms/alumni/${id}`);
    }
};

// Modal & Forms for Gallery CRUD
const isGalleryModalOpen = ref(false);
const galleryForm = useForm({
    id: null as number | null,
    title: '',
    category: 'Kegiatan',
    caption: '',
    image: null as File | null,
    image_url: '',
    order: 0,
    is_visible: true,
});

const openGalleryModal = (item?: GalleryItem) => {
    if (item) {
        galleryForm.id = item.id;
        galleryForm.title = item.title;
        galleryForm.category = item.category;
        galleryForm.caption = item.caption || '';
        galleryForm.image_url = item.image_path;
        galleryForm.image = null;
        galleryForm.order = item.order;
        galleryForm.is_visible = item.is_visible;
    } else {
        galleryForm.reset();
        galleryForm.id = null;
    }
    isGalleryModalOpen.value = true;
};

const submitGallery = () => {
    galleryForm.post('/admin/landing-cms/gallery', {
        onSuccess: () => {
            isGalleryModalOpen.value = false;
            galleryForm.reset();
        }
    });
};

const deleteGallery = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus foto galeri ini?')) {
        useForm({}).delete(`/admin/landing-cms/gallery/${id}`);
    }
};

// Modal & Forms for Procedure CRUD
const isProcedureModalOpen = ref(false);
const procedureForm = useForm({
    id: null as number | null,
    step_number: 1,
    title: '',
    description: '',
    icon: 'FileText',
    is_visible: true,
});

const openProcedureModal = (item?: ProcedureItem) => {
    if (item) {
        procedureForm.id = item.id;
        procedureForm.step_number = item.step_number;
        procedureForm.title = item.title;
        procedureForm.description = item.description;
        procedureForm.icon = item.icon;
        procedureForm.is_visible = item.is_visible;
    } else {
        procedureForm.reset();
        procedureForm.id = null;
    }
    isProcedureModalOpen.value = true;
};

const submitProcedure = () => {
    procedureForm.post('/admin/landing-cms/procedures', {
        onSuccess: () => {
            isProcedureModalOpen.value = false;
            procedureForm.reset();
        }
    });
};

const deleteProcedure = (id: number) => {
    if (confirm('Apakah Anda yakin ingin menghapus alur prosedur ini?')) {
        useForm({}).delete(`/admin/landing-cms/procedures/${id}`);
    }
};
</script>

<template>
    <div class="space-y-6">
            <!-- Header Section -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <Globe class="w-5 h-5 text-[rgb(93,135,255)]" />
                        Pengaturan Konten Landing Page (Admin CMS)
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Kelola teks seksi beranda, tentang, testimoni alumni, foto galeri, alur prosedur, serta informasi kontak publik.
                    </p>
                </div>

                <a 
                    href="/" 
                    target="_blank" 
                    class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl text-xs flex items-center gap-1.5 transition-all self-start sm:self-auto"
                >
                    <Globe class="w-4 h-4 text-blue-400" />
                    <span>Lihat Website Landing</span>
                </a>
            </div>

            <!-- Tab Navigation Buttons -->
            <div class="flex items-center gap-2 p-1.5 bg-slate-100 rounded-2xl border border-slate-200 overflow-x-auto">
                <button 
                    @click="activeTab = 'sections'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2"
                    :class="activeTab === 'sections' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                    <Sparkles class="w-4 h-4 text-[rgb(93,135,255)]" />
                    <span>Teks Seksi Utama & Kontak</span>
                </button>

                <button 
                    @click="activeTab = 'alumni'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2"
                    :class="activeTab === 'alumni' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                    <Users class="w-4 h-4 text-emerald-600" />
                    <span>Testimoni Alumni ({{ alumniList.length }})</span>
                </button>

                <button 
                    @click="activeTab = 'gallery'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2"
                    :class="activeTab === 'gallery' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                    <Image class="w-4 h-4 text-purple-600" />
                    <span>Galeri Kegiatan ({{ galleryList.length }})</span>
                </button>

                <button 
                    @click="activeTab = 'procedures'"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all whitespace-nowrap flex items-center gap-2"
                    :class="activeTab === 'procedures' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                >
                    <ListOrdered class="w-4 h-4 text-amber-600" />
                    <span>Prosedur & Alur ({{ procedureList.length }})</span>
                </button>
            </div>

            <!-- TAB 1: GENERAL SECTIONS & CONTACT FORM -->
            <form v-if="activeTab === 'sections'" @submit.prevent="submitSections" class="space-y-6">
                <!-- 1. Seksi Beranda (Hero) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <Sparkles class="w-4 h-4 text-[rgb(93,135,255)]" />
                        1. Konten Seksi Beranda (Hero Banner)
                    </h3>

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Badge Pengumuman Atas</label>
                            <input v-model="sectionForm.sections.hero_badge" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:border-[rgb(93,135,255)]" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Judul Utama (Headline)</label>
                            <input v-model="sectionForm.sections.hero_title" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold focus:border-[rgb(93,135,255)]" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Subjudul Deskripsi</label>
                            <textarea v-model="sectionForm.sections.hero_subtitle" rows="3" class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-[rgb(93,135,255)]"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Seksi Tentang & Statistik -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <Globe class="w-4 h-4 text-emerald-600" />
                        2. Konten Seksi Tentang Kami & Angka Statistik
                    </h3>

                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Judul Seksi Tentang</label>
                            <input v-model="sectionForm.sections.about_title" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Penjelasan Deskripsi</label>
                            <textarea v-model="sectionForm.sections.about_description" rows="3" class="w-full p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700">Angka Statistik Siswa</label>
                                <input v-model="sectionForm.sections.about_stat_students" type="text" placeholder="500+" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-blue-600" />
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700">Angka Statistik Sekolah</label>
                                <input v-model="sectionForm.sections.about_stat_schools" type="text" placeholder="45+" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-blue-600" />
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-slate-700">Angka Statistik Divisi</label>
                                <input v-model="sectionForm.sections.about_stat_divisions" type="text" placeholder="12+" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-blue-600" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Seksi Hubungi Kami -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="font-bold text-slate-900 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                        <PhoneCall class="w-4 h-4 text-purple-600" />
                        3. Informasi Kontak & Alamat
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5 sm:col-span-2">
                            <label class="text-xs font-semibold text-slate-700">Alamat Lengkap Pusat</label>
                            <input v-model="sectionForm.sections.contact_address" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Email Resmi</label>
                            <input v-model="sectionForm.sections.contact_email" type="email" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Telepon Kantor</label>
                            <input v-model="sectionForm.sections.contact_phone" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Nomor WhatsApp Direct</label>
                            <input v-model="sectionForm.sections.contact_whatsapp" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700">Jam Operasional Layanan</label>
                            <input v-model="sectionForm.sections.contact_hours" type="text" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        :disabled="sectionForm.processing"
                        class="px-6 py-3 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/20 flex items-center gap-2 text-xs transition-all disabled:opacity-50"
                    >
                        <Save class="w-4 h-4" />
                        <span>Simpan Perubahan Seksi Landing</span>
                    </button>
                </div>
            </form>

            <!-- TAB 2: ALUMNI MANAGEMENT -->
            <div v-if="activeTab === 'alumni'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-base">Daftar Testimoni Alumni PKL</h3>
                    <button 
                        @click="openAlumniModal()" 
                        class="px-4 py-2 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 shadow-sm transition-all"
                    >
                        <Plus class="w-4 h-4" />
                        <span>Tambah Alumni Baru</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div v-for="item in alumniList" :key="item.id" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-blue-50 text-[rgb(93,135,255)] flex items-center justify-center font-bold text-sm shrink-0 border border-blue-100">
                                    <img v-if="item.photo_path" :src="item.photo_path.startsWith('http') ? item.photo_path : `/storage/${item.photo_path}`" :alt="item.name" class="w-full h-full object-cover" />
                                    <span v-else>{{ item?.username ? item.username.replace('@', '').charAt(0).toUpperCase() : (item?.name ? item.name.charAt(0).toUpperCase() : 'A') }}</span>
                                </div>
                                <div class="truncate">
                                    <h4 class="font-bold text-slate-900 text-sm truncate flex items-center gap-1">
                                        <span>{{ item.name }}</span>
                                        <span v-if="item.username" class="text-xs text-blue-500 font-mono">({{ item.username.startsWith('@') ? item.username : '@' + item.username }})</span>
                                    </h4>
                                    <p v-if="item.division_name" class="text-xs font-semibold text-[rgb(93,135,255)] truncate">Divisi: {{ item.division_name }}</p>
                                    <p v-else class="text-xs text-slate-500 truncate">{{ item.current_position || 'Alumni PKL' }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 italic">"{{ item.quote }}"</p>
                            <p class="text-[11px] text-slate-400">{{ item.school_name }} • {{ item.graduation_year }}</p>
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                            <button @click="openAlumniModal(item)" class="p-1.5 text-slate-600 hover:text-blue-600 rounded-lg hover:bg-slate-100">
                                <Edit3 class="w-4 h-4" />
                            </button>
                            <button @click="deleteAlumni(item.id)" class="p-1.5 text-slate-600 hover:text-rose-600 rounded-lg hover:bg-slate-100">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: GALLERY MANAGEMENT -->
            <div v-if="activeTab === 'gallery'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-base">Foto & Dokumentasi Galeri</h3>
                    <button 
                        @click="openGalleryModal()" 
                        class="px-4 py-2 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 shadow-sm transition-all"
                    >
                        <Plus class="w-4 h-4" />
                        <span>Tambah Foto Galeri</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div v-for="item in galleryList" :key="item.id" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between">
                        <div>
                            <div class="h-40 bg-slate-100 overflow-hidden relative">
                                <img :src="item.image_path" :alt="item.title" class="w-full h-full object-cover" />
                                <span class="absolute top-2 left-2 px-2.5 py-0.5 bg-slate-900/80 text-white rounded-full text-[10px] font-bold">
                                    {{ item.category }}
                                </span>
                            </div>
                            <div class="p-4 space-y-1">
                                <h4 class="font-bold text-slate-900 text-sm">{{ item.title }}</h4>
                                <p class="text-xs text-slate-500 line-clamp-2">{{ item.caption }}</p>
                            </div>
                        </div>

                        <div class="p-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                            <button @click="openGalleryModal(item)" class="p-1.5 text-slate-600 hover:text-blue-600 rounded-lg hover:bg-white">
                                <Edit3 class="w-4 h-4" />
                            </button>
                            <button @click="deleteGallery(item.id)" class="p-1.5 text-slate-600 hover:text-rose-600 rounded-lg hover:bg-white">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 4: PROCEDURES MANAGEMENT -->
            <div v-if="activeTab === 'procedures'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-base">Alur & Prosedur Pendaftaran PKL</h3>
                    <button 
                        @click="openProcedureModal()" 
                        class="px-4 py-2 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 shadow-sm transition-all"
                    >
                        <Plus class="w-4 h-4" />
                        <span>Tambah Langkah Prosedur</span>
                    </button>
                </div>

                <div class="space-y-3">
                    <div v-for="proc in procedureList" :key="proc.id" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-[rgb(93,135,255)] font-black text-sm flex items-center justify-center border border-blue-100 shrink-0">
                                {{ proc.step_number }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                    <span>{{ proc.title }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-100 font-normal text-slate-500">Icon: {{ proc.icon }}</span>
                                </h4>
                                <p class="text-xs text-slate-500 mt-0.5">{{ proc.description }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button @click="openProcedureModal(proc)" class="p-1.5 text-slate-600 hover:text-blue-600 rounded-lg hover:bg-slate-50">
                                <Edit3 class="w-4 h-4" />
                            </button>
                            <button @click="deleteProcedure(proc.id)" class="p-1.5 text-slate-600 hover:text-rose-600 rounded-lg hover:bg-slate-50">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL ALUMNI -->
        <div v-if="isAlumniModalOpen" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden space-y-4 p-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm">{{ alumniForm.id ? 'Edit Testimoni Alumni' : 'Tambah Testimoni Alumni Baru' }}</h3>
                    <button @click="isAlumniModalOpen = false" class="text-slate-400 hover:text-slate-600"><X class="w-5 h-5" /></button>
                </div>

                <form @submit.prevent="submitAlumni" class="space-y-4 text-xs">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Nama Alumni *</label>
                            <input v-model="alumniForm.name" type="text" required placeholder="Afdanu Aprilian" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Username (Opsional)</label>
                            <input v-model="alumniForm.username" type="text" placeholder="@afdanu_dev" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-mono" />
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Nama Divisi PKL</label>
                            <input v-model="alumniForm.division_name" type="text" placeholder="Software Engineering" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Asal Sekolah / Kampus *</label>
                            <input v-model="alumniForm.school_name" type="text" required placeholder="SMKN 1 Surabaya" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Jurusan</label>
                            <input v-model="alumniForm.major_name" type="text" placeholder="Rekayasa Perangkat Lunak" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Tahun Lulus</label>
                            <input v-model="alumniForm.graduation_year" type="text" placeholder="2025" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                        <div class="space-y-1 col-span-2">
                            <label class="font-semibold text-slate-700">Posisi / Pekerjaan Sekarang</label>
                            <input v-model="alumniForm.current_position" type="text" placeholder="Junior Software Engineer" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700">Kutipan / Testimoni *</label>
                        <textarea v-model="alumniForm.quote" rows="3" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="isAlumniModalOpen = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-semibold">Batal</button>
                        <button type="submit" :disabled="alumniForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white rounded-xl font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL GALLERY -->
        <div v-if="isGalleryModalOpen" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden space-y-4 p-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm">{{ galleryForm.id ? 'Edit Item Galeri' : 'Tambah Item Galeri Baru' }}</h3>
                    <button @click="isGalleryModalOpen = false" class="text-slate-400 hover:text-slate-600"><X class="w-5 h-5" /></button>
                </div>

                <form @submit.prevent="submitGallery" class="space-y-4 text-xs">
                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700">Judul Foto / Kegiatan *</label>
                        <input v-model="galleryForm.title" type="text" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Kategori *</label>
                            <select v-model="galleryForm.category" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                                <option value="Orientasi">Orientasi</option>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Evaluasi">Evaluasi</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Urutan Tampil</label>
                            <input v-model="galleryForm.order" type="number" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700">URL Gambar (atau Unggah File)</label>
                        <input v-model="galleryForm.image_url" type="text" placeholder="https://..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                    </div>

                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700">Caption / Deskripsi Singkat</label>
                        <textarea v-model="galleryForm.caption" rows="2" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="isGalleryModalOpen = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-semibold">Batal</button>
                        <button type="submit" :disabled="galleryForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white rounded-xl font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL PROCEDURE -->
        <div v-if="isProcedureModalOpen" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl overflow-hidden space-y-4 p-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-900 text-sm">{{ procedureForm.id ? 'Edit Prosedur' : 'Tambah Langkah Prosedur' }}</h3>
                    <button @click="isProcedureModalOpen = false" class="text-slate-400 hover:text-slate-600"><X class="w-5 h-5" /></button>
                </div>

                <form @submit.prevent="submitProcedure" class="space-y-4 text-xs">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="font-semibold text-slate-700">Nomor Langkah *</label>
                            <input v-model="procedureForm.step_number" type="number" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                        </div>
                        <div class="space-y-1 col-span-2">
                            <label class="font-semibold text-slate-700">Icon Name *</label>
                            <select v-model="procedureForm.icon" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                                <option value="UserPlus">UserPlus</option>
                                <option value="ShieldCheck">ShieldCheck</option>
                                <option value="Building">Building</option>
                                <option value="CalendarCheck">CalendarCheck</option>
                                <option value="Award">Award</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700">Judul Langkah *</label>
                        <input v-model="procedureForm.title" type="text" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl" />
                    </div>

                    <div class="space-y-1">
                        <label class="font-semibold text-slate-700">Deskripsi *</label>
                        <textarea v-model="procedureForm.description" rows="3" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl"></textarea>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="isProcedureModalOpen = false" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-semibold">Batal</button>
                        <button type="submit" :disabled="procedureForm.processing" class="px-4 py-2 bg-[rgb(93,135,255)] text-white rounded-xl font-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
</template>
