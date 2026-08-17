<script setup lang="ts">
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
    Upload,
} from '@lucide/vue';
import { ref, computed } from 'vue';

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
    if (Array.isArray(props.alumni)) {
        return props.alumni;
    }

    return (props.alumni as any)?.data || [];
});

const galleryList = computed<GalleryItem[]>(() => {
    if (Array.isArray(props.gallery)) {
        return props.gallery;
    }

    return (props.gallery as any)?.data || [];
});

const procedureList = computed<ProcedureItem[]>(() => {
    if (Array.isArray(props.procedures)) {
        return props.procedures;
    }

    return (props.procedures as any)?.data || [];
});

const activeTab = ref<'sections' | 'alumni' | 'gallery' | 'procedures'>(
    'sections',
);

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
    },
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
        },
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
        },
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
        },
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
        <div
            class="flex flex-col justify-between gap-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs sm:flex-row sm:items-center"
        >
            <div>
                <h1
                    class="flex items-center gap-2 text-xl font-bold tracking-tight text-zinc-950"
                >
                    <Globe class="h-5 w-5 text-zinc-900" />
                    Pengaturan Konten Landing Page (Admin CMS)
                </h1>
                <p class="mt-1 text-xs text-zinc-500">
                    Kelola teks seksi beranda, tentang, testimoni alumni, foto
                    galeri, alur prosedur, serta informasi kontak publik.
                </p>
            </div>

            <a
                href="/"
                target="_blank"
                class="flex cursor-pointer items-center gap-1.5 self-start rounded-xl bg-zinc-950 px-4 py-2 text-xs font-semibold text-white shadow-xs transition-all hover:bg-zinc-800 sm:self-auto"
            >
                <Globe class="h-4 w-4 text-zinc-300" />
                <span>Lihat Website Landing</span>
            </a>
        </div>

        <!-- Tab Navigation Buttons -->
        <div
            class="flex items-center gap-2 overflow-x-auto rounded-2xl border border-zinc-200 bg-zinc-100 p-1.5"
        >
            <button
                @click="activeTab = 'sections'"
                class="flex cursor-pointer items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold whitespace-nowrap transition-all"
                :class="
                    activeTab === 'sections'
                        ? 'bg-white text-zinc-900 shadow-2xs'
                        : 'text-zinc-600 hover:text-zinc-900'
                "
            >
                <Sparkles class="h-4 w-4 text-zinc-900" />
                <span>Teks Seksi Utama & Kontak</span>
            </button>

            <button
                @click="activeTab = 'alumni'"
                class="flex cursor-pointer items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold whitespace-nowrap transition-all"
                :class="
                    activeTab === 'alumni'
                        ? 'bg-white text-zinc-900 shadow-2xs'
                        : 'text-zinc-600 hover:text-zinc-900'
                "
            >
                <Users class="h-4 w-4 text-emerald-600" />
                <span>Testimoni Alumni ({{ alumniList.length }})</span>
            </button>

            <button
                @click="activeTab = 'gallery'"
                class="flex cursor-pointer items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold whitespace-nowrap transition-all"
                :class="
                    activeTab === 'gallery'
                        ? 'bg-white text-zinc-900 shadow-2xs'
                        : 'text-zinc-600 hover:text-zinc-900'
                "
            >
                <Image class="h-4 w-4 text-purple-600" />
                <span>Galeri Kegiatan ({{ galleryList.length }})</span>
            </button>

            <button
                @click="activeTab = 'procedures'"
                class="flex cursor-pointer items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold whitespace-nowrap transition-all"
                :class="
                    activeTab === 'procedures'
                        ? 'bg-white text-zinc-900 shadow-2xs'
                        : 'text-zinc-600 hover:text-zinc-900'
                "
            >
                <ListOrdered class="h-4 w-4 text-amber-600" />
                <span>Prosedur & Alur ({{ procedureList.length }})</span>
            </button>
        </div>

        <!-- TAB 1: GENERAL SECTIONS & CONTACT FORM -->
        <form
            v-if="activeTab === 'sections'"
            @submit.prevent="submitSections"
            class="space-y-6"
        >
            <!-- 1. Seksi Beranda (Hero) -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
            >
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-bold text-zinc-900"
                >
                    <Sparkles class="h-4 w-4 text-zinc-900" />
                    1. Konten Seksi Beranda (Hero Banner)
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Badge Pengumuman Atas</label
                        >
                        <input
                            v-model="sectionForm.sections.hero_badge"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm font-medium text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Judul Utama (Headline)</label
                        >
                        <input
                            v-model="sectionForm.sections.hero_title"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm font-bold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Subjudul Deskripsi</label
                        >
                        <textarea
                            v-model="sectionForm.sections.hero_subtitle"
                            rows="3"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 p-3.5 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        ></textarea>
                    </div>
                </div>
            </div>

            <!-- 2. Seksi Tentang & Statistik -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
            >
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-bold text-zinc-900"
                >
                    <Globe class="h-4 w-4 text-emerald-600" />
                    2. Konten Seksi Tentang Kami & Angka Statistik
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Judul Seksi Tentang</label
                        >
                        <input
                            v-model="sectionForm.sections.about_title"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm font-bold text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Penjelasan Deskripsi</label
                        >
                        <textarea
                            v-model="sectionForm.sections.about_description"
                            rows="3"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 p-3.5 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 gap-4 pt-2 sm:grid-cols-3">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Angka Statistik Siswa</label
                            >
                            <input
                                v-model="
                                    sectionForm.sections.about_stat_students
                                "
                                type="text"
                                placeholder="500+"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm font-bold text-zinc-950 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Angka Statistik Sekolah</label
                            >
                            <input
                                v-model="
                                    sectionForm.sections.about_stat_schools
                                "
                                type="text"
                                placeholder="45+"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm font-bold text-zinc-950 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-zinc-700"
                                >Angka Statistik Divisi</label
                            >
                            <input
                                v-model="
                                    sectionForm.sections.about_stat_divisions
                                "
                                type="text"
                                placeholder="12+"
                                class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm font-bold text-zinc-950 focus:border-zinc-950 focus:outline-none"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Seksi Hubungi Kami -->
            <div
                class="space-y-4 rounded-2xl border border-zinc-200 bg-white p-6 shadow-2xs"
            >
                <h3
                    class="flex items-center gap-2 border-b border-zinc-100 pb-3 text-sm font-bold text-zinc-900"
                >
                    <PhoneCall class="h-4 w-4 text-purple-600" />
                    3. Informasi Kontak & Alamat
                </h3>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5 sm:col-span-2">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Alamat Lengkap Pusat</label
                        >
                        <input
                            v-model="sectionForm.sections.contact_address"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Email Resmi</label
                        >
                        <input
                            v-model="sectionForm.sections.contact_email"
                            type="email"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Telepon Kantor</label
                        >
                        <input
                            v-model="sectionForm.sections.contact_phone"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Nomor WhatsApp Direct</label
                        >
                        <input
                            v-model="sectionForm.sections.contact_whatsapp"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-zinc-700"
                            >Jam Operasional Layanan</label
                        >
                        <input
                            v-model="sectionForm.sections.contact_hours"
                            type="text"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3.5 py-2 text-sm text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    :disabled="sectionForm.processing"
                    class="flex cursor-pointer items-center gap-2 rounded-xl bg-zinc-950 px-6 py-3 text-xs font-bold text-white shadow-xs transition-all hover:bg-zinc-800 disabled:opacity-50"
                >
                    <Save class="h-4 w-4" />
                    <span>Simpan Perubahan Seksi Landing</span>
                </button>
            </div>
        </form>

        <!-- TAB 2: ALUMNI MANAGEMENT -->
        <div v-if="activeTab === 'alumni'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-zinc-900">
                    Daftar Testimoni Alumni PKL
                </h3>
                <button
                    @click="openAlumniModal()"
                    class="flex cursor-pointer items-center gap-1.5 rounded-xl bg-zinc-950 px-4 py-2 text-xs font-bold text-white shadow-xs transition-all hover:bg-zinc-800"
                >
                    <Plus class="h-4 w-4" />
                    <span>Tambah Alumni Baru</span>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div
                    v-for="item in alumniList"
                    :key="item.id"
                    class="flex flex-col justify-between space-y-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
                >
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 text-sm font-bold text-zinc-950"
                            >
                                <img
                                    v-if="item.photo_path"
                                    :src="
                                        item.photo_path.startsWith('http')
                                            ? item.photo_path
                                            : `/storage/${item.photo_path}`
                                    "
                                    :alt="item.name"
                                    class="h-full w-full object-cover"
                                />
                                <span v-else>{{
                                    item?.username
                                        ? item.username
                                              .replace('@', '')
                                              .charAt(0)
                                              .toUpperCase()
                                        : item?.name
                                          ? item.name.charAt(0).toUpperCase()
                                          : 'A'
                                }}</span>
                            </div>
                            <div class="truncate">
                                <h4
                                    class="flex items-center gap-1 truncate text-sm font-bold text-zinc-900"
                                >
                                    <span>{{ item.name }}</span>
                                    <span
                                        v-if="item.username"
                                        class="font-mono text-xs text-zinc-500"
                                        >({{
                                            item.username.startsWith('@')
                                                ? item.username
                                                : '@' + item.username
                                        }})</span
                                    >
                                </h4>
                                <p
                                    v-if="item.division_name"
                                    class="truncate text-xs font-semibold text-zinc-950"
                                >
                                    Divisi: {{ item.division_name }}
                                </p>
                                <p
                                    v-else
                                    class="truncate text-xs text-zinc-500"
                                >
                                    {{ item.current_position || 'Alumni PKL' }}
                                </p>
                            </div>
                        </div>
                        <p class="text-xs text-zinc-600 italic">
                            "{{ item.quote }}"
                        </p>
                        <p class="text-[11px] text-zinc-400">
                            {{ item.school_name }} • {{ item.graduation_year }}
                        </p>
                    </div>

                    <div
                        class="flex items-center justify-end gap-2 border-t border-zinc-100 pt-3"
                    >
                        <button
                            @click="openAlumniModal(item)"
                            class="cursor-pointer rounded-lg p-1.5 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950"
                        >
                            <Edit3 class="h-4 w-4" />
                        </button>
                        <button
                            @click="deleteAlumni(item.id)"
                            class="cursor-pointer rounded-lg p-1.5 text-zinc-600 hover:bg-zinc-100 hover:text-rose-600"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: GALLERY MANAGEMENT -->
        <div v-if="activeTab === 'gallery'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-zinc-900">
                    Foto & Dokumentasi Galeri
                </h3>
                <button
                    @click="openGalleryModal()"
                    class="flex cursor-pointer items-center gap-1.5 rounded-xl bg-zinc-950 px-4 py-2 text-xs font-bold text-white shadow-xs transition-all hover:bg-zinc-800"
                >
                    <Plus class="h-4 w-4" />
                    <span>Tambah Foto Galeri</span>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div
                    v-for="item in galleryList"
                    :key="item.id"
                    class="flex flex-col justify-between overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-2xs"
                >
                    <div>
                        <div class="relative h-40 overflow-hidden bg-zinc-100">
                            <img
                                :src="item.image_path"
                                :alt="item.title"
                                class="h-full w-full object-cover"
                            />
                            <span
                                class="absolute top-2 left-2 rounded-full bg-zinc-950/80 px-2.5 py-0.5 text-[10px] font-bold text-white"
                            >
                                {{ item.category }}
                            </span>
                        </div>
                        <div class="space-y-1 p-4">
                            <h4 class="text-sm font-bold text-zinc-900">
                                {{ item.title }}
                            </h4>
                            <p class="line-clamp-2 text-xs text-zinc-500">
                                {{ item.caption }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end gap-2 border-t border-zinc-100 bg-zinc-50 p-3"
                    >
                        <button
                            @click="openGalleryModal(item)"
                            class="cursor-pointer rounded-lg p-1.5 text-zinc-600 hover:bg-white hover:text-zinc-950"
                        >
                            <Edit3 class="h-4 w-4" />
                        </button>
                        <button
                            @click="deleteGallery(item.id)"
                            class="cursor-pointer rounded-lg p-1.5 text-zinc-600 hover:bg-white hover:text-rose-600"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: PROCEDURES MANAGEMENT -->
        <div v-if="activeTab === 'procedures'" class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-zinc-900">
                    Alur & Prosedur Pendaftaran PKL
                </h3>
                <button
                    @click="openProcedureModal()"
                    class="flex cursor-pointer items-center gap-1.5 rounded-xl bg-zinc-950 px-4 py-2 text-xs font-bold text-white shadow-xs transition-all hover:bg-zinc-800"
                >
                    <Plus class="h-4 w-4" />
                    <span>Tambah Langkah Prosedur</span>
                </button>
            </div>

            <div class="space-y-3">
                <div
                    v-for="proc in procedureList"
                    :key="proc.id"
                    class="flex items-center justify-between gap-4 rounded-2xl border border-zinc-200 bg-white p-5 shadow-2xs"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-zinc-200 bg-zinc-100 text-sm font-black text-zinc-950"
                        >
                            {{ proc.step_number }}
                        </div>
                        <div>
                            <h4
                                class="flex items-center gap-2 text-sm font-bold text-zinc-900"
                            >
                                <span>{{ proc.title }}</span>
                                <span
                                    class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-normal text-zinc-500"
                                    >Icon: {{ proc.icon }}</span
                                >
                            </h4>
                            <p class="mt-0.5 text-xs text-zinc-500">
                                {{ proc.description }}
                            </p>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-2">
                        <button
                            @click="openProcedureModal(proc)"
                            class="cursor-pointer rounded-lg p-1.5 text-zinc-600 hover:bg-zinc-50 hover:text-zinc-950"
                        >
                            <Edit3 class="h-4 w-4" />
                        </button>
                        <button
                            @click="deleteProcedure(proc.id)"
                            class="cursor-pointer rounded-lg p-1.5 text-zinc-600 hover:bg-zinc-50 hover:text-rose-600"
                        >
                            <Trash2 class="h-4 w-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ALUMNI -->
    <div
        v-if="isAlumniModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-lg space-y-4 overflow-hidden rounded-2xl border border-zinc-100 bg-white p-6 shadow-xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-sm font-bold text-zinc-900">
                    {{
                        alumniForm.id
                            ? 'Edit Testimoni Alumni'
                            : 'Tambah Testimoni Alumni Baru'
                    }}
                </h3>
                <button
                    @click="isAlumniModalOpen = false"
                    class="cursor-pointer text-zinc-400 hover:text-zinc-600"
                >
                    <X class="h-5 w-5" />
                </button>
            </div>

            <form @submit.prevent="submitAlumni" class="space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Nama Alumni *</label
                        >
                        <input
                            v-model="alumniForm.name"
                            type="text"
                            required
                            placeholder="Afdanu Aprilian"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Username (Opsional)</label
                        >
                        <input
                            v-model="alumniForm.username"
                            type="text"
                            placeholder="@afdanu_dev"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 font-mono text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Nama Divisi PKL</label
                        >
                        <input
                            v-model="alumniForm.division_name"
                            type="text"
                            placeholder="Software Engineering"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Asal Sekolah / Kampus *</label
                        >
                        <input
                            v-model="alumniForm.school_name"
                            type="text"
                            required
                            placeholder="SMKN 1 Surabaya"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Jurusan</label
                        >
                        <input
                            v-model="alumniForm.major_name"
                            type="text"
                            placeholder="Rekayasa Perangkat Lunak"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Tahun Lulus</label
                        >
                        <input
                            v-model="alumniForm.graduation_year"
                            type="text"
                            placeholder="2025"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="col-span-2 space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Posisi / Pekerjaan Sekarang</label
                        >
                        <input
                            v-model="alumniForm.current_position"
                            type="text"
                            placeholder="Junior Software Engineer"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-zinc-700"
                        >Kutipan / Testimoni *</label
                    >
                    <textarea
                        v-model="alumniForm.quote"
                        rows="3"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 p-3 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="isAlumniModalOpen = false"
                        class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 font-semibold text-zinc-700"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="alumniForm.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 font-bold text-white hover:bg-zinc-800"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL GALLERY -->
    <div
        v-if="isGalleryModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-lg space-y-4 overflow-hidden rounded-2xl border border-zinc-100 bg-white p-6 shadow-xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-sm font-bold text-zinc-900">
                    {{
                        galleryForm.id
                            ? 'Edit Item Galeri'
                            : 'Tambah Item Galeri Baru'
                    }}
                </h3>
                <button
                    @click="isGalleryModalOpen = false"
                    class="cursor-pointer text-zinc-400 hover:text-zinc-600"
                >
                    <X class="h-5 w-5" />
                </button>
            </div>

            <form @submit.prevent="submitGallery" class="space-y-4 text-xs">
                <div class="space-y-1">
                    <label class="font-semibold text-zinc-700"
                        >Judul Foto / Kegiatan *</label
                    >
                    <input
                        v-model="galleryForm.title"
                        type="text"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Kategori *</label
                        >
                        <select
                            v-model="galleryForm.category"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 font-medium text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        >
                            <option value="Orientasi">Orientasi</option>
                            <option value="Kegiatan">Kegiatan</option>
                            <option value="Evaluasi">Evaluasi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Urutan Tampil</label
                        >
                        <input
                            v-model="galleryForm.order"
                            type="number"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-zinc-700"
                        >URL Gambar (atau Unggah File)</label
                    >
                    <input
                        v-model="galleryForm.image_url"
                        type="text"
                        placeholder="https://..."
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-zinc-700"
                        >Caption / Deskripsi Singkat</label
                    >
                    <textarea
                        v-model="galleryForm.caption"
                        rows="2"
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 p-3 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="isGalleryModalOpen = false"
                        class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 font-semibold text-zinc-700"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="galleryForm.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 font-bold text-white hover:bg-zinc-800"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PROCEDURE -->
    <div
        v-if="isProcedureModalOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-900/60 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-lg space-y-4 overflow-hidden rounded-2xl border border-zinc-100 bg-white p-6 shadow-xl"
        >
            <div
                class="flex items-center justify-between border-b border-zinc-100 pb-3"
            >
                <h3 class="text-sm font-bold text-zinc-900">
                    {{
                        procedureForm.id
                            ? 'Edit Prosedur'
                            : 'Tambah Langkah Prosedur'
                    }}
                </h3>
                <button
                    @click="isProcedureModalOpen = false"
                    class="cursor-pointer text-zinc-400 hover:text-zinc-600"
                >
                    <X class="h-5 w-5" />
                </button>
            </div>

            <form @submit.prevent="submitProcedure" class="space-y-4 text-xs">
                <div class="grid grid-cols-3 gap-3">
                    <div class="space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Nomor Langkah *</label
                        >
                        <input
                            v-model="procedureForm.step_number"
                            type="number"
                            required
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        />
                    </div>
                    <div class="col-span-2 space-y-1">
                        <label class="font-semibold text-zinc-700"
                            >Icon Name *</label
                        >
                        <select
                            v-model="procedureForm.icon"
                            class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 font-medium text-zinc-900 focus:border-zinc-950 focus:outline-none"
                        >
                            <option value="UserPlus">UserPlus</option>
                            <option value="ShieldCheck">ShieldCheck</option>
                            <option value="Building">Building</option>
                            <option value="CalendarCheck">CalendarCheck</option>
                            <option value="Award">Award</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-zinc-700"
                        >Judul Langkah *</label
                    >
                    <input
                        v-model="procedureForm.title"
                        type="text"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                    />
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-zinc-700"
                        >Deskripsi *</label
                    >
                    <textarea
                        v-model="procedureForm.description"
                        rows="3"
                        required
                        class="w-full rounded-xl border border-zinc-200 bg-zinc-50 p-3 text-zinc-900 focus:border-zinc-950 focus:outline-none"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button
                        type="button"
                        @click="isProcedureModalOpen = false"
                        class="cursor-pointer rounded-xl bg-zinc-100 px-4 py-2 font-semibold text-zinc-700"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        :disabled="procedureForm.processing"
                        class="cursor-pointer rounded-xl bg-zinc-950 px-4 py-2 font-bold text-white hover:bg-zinc-800"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
