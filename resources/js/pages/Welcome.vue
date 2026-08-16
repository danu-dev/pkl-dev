<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    Sparkles, 
    ArrowRight, 
    ShieldCheck, 
    Clock, 
    BookOpen, 
    Users, 
    Building2, 
    GraduationCap, 
    MapPin, 
    Mail, 
    Phone, 
    MessageSquare, 
    CheckCircle2,
    CalendarCheck,
    Award,
    UserPlus,
    Building,
    FileText,
    ChevronRight,
    Menu,
    X,
    LogIn
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
}

interface GalleryItem {
    id: number;
    title: string;
    category: string;
    image_path: string;
    caption?: string;
}

interface ProcedureItem {
    id: number;
    step_number: number;
    title: string;
    description: string;
    icon: string;
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

const isMobileMenuOpen = ref(false);
const activeGalleryCategory = ref('Semua');

const galleryCategories = ['Semua', 'Orientasi', 'Kegiatan', 'Evaluasi'];

const filteredGallery = computed(() => {
    if (activeGalleryCategory.value === 'Semua') {
        return galleryList.value;
    }
    return galleryList.value.filter(item => item.category === activeGalleryCategory.value);
});

const getProcedureIcon = (iconName: string) => {
    switch (iconName) {
        case 'UserPlus': return UserPlus;
        case 'ShieldCheck': return ShieldCheck;
        case 'Building': return Building;
        case 'CalendarCheck': return CalendarCheck;
        case 'Award': return Award;
        default: return FileText;
    }
};
</script>

<template>
    <Head title="SIPKL - Portal Monitoring & Jurnal PKL" />

    <div class="min-h-screen bg-slate-50 text-slate-800 font-sans selection:bg-[rgb(93,135,255)] selection:text-white">
        <!-- 1. STICKY NAVBAR (CERAH & ELEGAN) -->
        <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <!-- Logo Brand -->
                <a href="#beranda" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-[rgb(93,135,255)] to-blue-500 text-white flex items-center justify-center font-extrabold text-xl shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform">
                        PKL
                    </div>
                    <div>
                        <span class="font-extrabold text-lg text-slate-900 tracking-tight leading-none block">SIPKL System</span>
                        <span class="text-xs text-slate-500 font-medium mt-0.5 block">Portal Monitoring Vokasi</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-600">
                    <a href="#beranda" class="hover:text-[rgb(93,135,255)] transition-colors">Beranda</a>
                    <a href="#tentang" class="hover:text-[rgb(93,135,255)] transition-colors">Tentang</a>
                    <a href="#alumni" class="hover:text-[rgb(93,135,255)] transition-colors">Alumni</a>
                    <a href="#galeri" class="hover:text-[rgb(93,135,255)] transition-colors">Galeri</a>
                    <a href="#prosedur" class="hover:text-[rgb(93,135,255)] transition-colors">Prosedur</a>
                    <a href="#kontak" class="hover:text-[rgb(93,135,255)] transition-colors">Hubungi Kami</a>
                </nav>

                <!-- Action Button (HANYA TOMBOL LOGIN) -->
                <div class="hidden md:flex items-center gap-3">
                    <Link 
                        href="/login" 
                        class="px-5 py-2.5 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/25 flex items-center gap-2 text-xs transition-all hover:scale-105 active:scale-95"
                    >
                        <LogIn class="w-4 h-4" />
                        <span>Login Portal</span>
                    </Link>
                </div>

                <!-- Mobile Menu Button -->
                <button 
                    @click="isMobileMenuOpen = !isMobileMenuOpen"
                    class="md:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl bg-slate-100 border border-slate-200"
                >
                    <Menu v-if="!isMobileMenuOpen" class="w-6 h-6" />
                    <X v-else class="w-6 h-6" />
                </button>
            </div>

            <!-- Mobile Nav Dropdown -->
            <div v-if="isMobileMenuOpen" class="md:hidden bg-white border-b border-slate-200 px-6 py-5 space-y-4">
                <nav class="flex flex-col space-y-3 text-sm font-semibold text-slate-600">
                    <a @click="isMobileMenuOpen = false" href="#beranda" class="hover:text-[rgb(93,135,255)]">Beranda</a>
                    <a @click="isMobileMenuOpen = false" href="#tentang" class="hover:text-[rgb(93,135,255)]">Tentang</a>
                    <a @click="isMobileMenuOpen = false" href="#alumni" class="hover:text-[rgb(93,135,255)]">Alumni</a>
                    <a @click="isMobileMenuOpen = false" href="#galeri" class="hover:text-[rgb(93,135,255)]">Galeri</a>
                    <a @click="isMobileMenuOpen = false" href="#prosedur" class="hover:text-[rgb(93,135,255)]">Prosedur</a>
                    <a @click="isMobileMenuOpen = false" href="#kontak" class="hover:text-[rgb(93,135,255)]">Hubungi Kami</a>
                </nav>
                <div class="pt-3 border-t border-slate-100">
                    <Link 
                        href="/login" 
                        class="w-full py-3 bg-[rgb(93,135,255)] text-white font-bold rounded-xl flex items-center justify-center gap-2 text-xs shadow-lg shadow-blue-500/25"
                    >
                        <LogIn class="w-4 h-4" />
                        <span>Login Portal</span>
                    </Link>
                </div>
            </div>
        </header>

        <!-- 2. SEKSI BERANDA (HERO SECTION CERAH) -->
        <section id="beranda" class="relative pt-16 pb-24 lg:pt-28 lg:pb-36 overflow-hidden bg-gradient-to-b from-blue-50/50 via-white to-slate-50">
            <!-- Background Soft Elements -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#00000008_1px,transparent_1px),linear-gradient(to_bottom,#00000008_1px,transparent_1px)] bg-[size:32px_32px]"></div>
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] bg-blue-400/15 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-8">
                <!-- Badge Pengumuman -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-200/80 text-xs font-semibold text-[rgb(93,135,255)] shadow-xs">
                    <Sparkles class="w-4 h-4 text-amber-500 animate-pulse" />
                    <span>{{ sections.hero_badge || 'Pendaftaran Siswa PKL Tahun 2026/2027 Dibuka' }}</span>
                </div>

                <!-- Headline Main -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-900 max-w-4xl mx-auto leading-[1.1]">
                    {{ sections.hero_title || 'Sistem Informasi & Portal Monitoring Praktek Kerja Lapangan' }}
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-normal leading-relaxed">
                    {{ sections.hero_subtitle || 'Platform terpadu absensi presisi, pelaporan jurnal harian digital, dan evaluasi kinerja siswa PKL secara real-time dan terstruktur.' }}
                </p>

                <!-- Call to Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <Link 
                        href="/login" 
                        class="w-full sm:w-auto px-8 py-4 bg-[rgb(93,135,255)] hover:bg-blue-600 text-white font-extrabold rounded-2xl shadow-xl shadow-blue-500/25 flex items-center justify-center gap-3 text-sm transition-all hover:scale-105 active:scale-95"
                    >
                        <span>Masuk ke Portal SIPKL</span>
                        <ArrowRight class="w-5 h-5" />
                    </Link>

                    <a 
                        href="#prosedur" 
                        class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-slate-50 text-slate-800 border border-slate-200 shadow-sm font-bold rounded-2xl flex items-center justify-center gap-2 text-sm transition-all"
                    >
                        <span>Pelajari Prosedur</span>
                        <ChevronRight class="w-4 h-4 text-slate-400" />
                    </a>
                </div>

                <!-- Showcase Metrics Bar -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto pt-12">
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                        <div class="text-2xl sm:text-3xl font-black text-slate-900">{{ sections.about_stat_students || '500+' }}</div>
                        <div class="text-xs text-slate-500 font-medium mt-1">Siswa PKL Aktif</div>
                    </div>

                    <div class="p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                        <div class="text-2xl sm:text-3xl font-black text-[rgb(93,135,255)]">{{ sections.about_stat_schools || '45+' }}</div>
                        <div class="text-xs text-slate-500 font-medium mt-1">Sekolah & Kampus Mitra</div>
                    </div>

                    <div class="col-span-2 md:col-span-1 p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                        <div class="text-2xl sm:text-3xl font-black text-emerald-600">{{ sections.about_stat_divisions || '12+' }}</div>
                        <div class="text-xs text-slate-500 font-medium mt-1">Divisi Penempatan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. SEKSI TENTANG KAMI (CERAH) -->
        <section id="tentang" class="py-20 bg-white border-y border-slate-200/80 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-6 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-xs font-bold text-[rgb(93,135,255)] uppercase tracking-wider">
                            Tentang SIPKL
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                            {{ sections.about_title || 'Transformasi Digital Pengelolaan Praktik Kerja Lapangan' }}
                        </h2>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            {{ sections.about_description || 'SIPKL dirancang khusus untuk mempermudah kolaborasi antara Siswa PKL, Pembimbing Sekolah, dan Instansi/Perusahaan. Kami menyediakan transparansi penuh dalam pencatatan kehadiran, verifikasi kegiatan harian, serta penilaian komprehensif.' }}
                        </p>

                        <div class="space-y-3 pt-2">
                            <div class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                                <span class="text-xs font-semibold text-slate-700">Pencatatan Absensi 1-Klik berbasis jam operasional real-time.</span>
                            </div>
                            <div class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                                <span class="text-xs font-semibold text-slate-700">Verifikasi Jurnal Harian oleh Pembimbing Instansi & Admin.</span>
                            </div>
                            <div class="flex items-center gap-3 p-3.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
                                <span class="text-xs font-semibold text-slate-700">Rekapitulasi Penilaian & Penerbitan Sertifikat Kelulusan PKL.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Visual Cards Grid -->
                    <div class="lg:col-span-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3 hover:border-blue-200 transition-all">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-[rgb(93,135,255)] flex items-center justify-center">
                                <Clock class="w-6 h-6" />
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Presisi Kehadiran</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Sistem memverifikasi jam masuk, jam pulang, dan pengajuan izin sakit siswa secara akurat.</p>
                        </div>

                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3 sm:mt-6 hover:border-emerald-200 transition-all">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <BookOpen class="w-6 h-6" />
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Jurnal Digital</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Pengisian log aktivitas harian lengkap dengan lampiran bukti foto pekerjaan.</p>
                        </div>

                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3 hover:border-amber-200 transition-all">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                <ShieldCheck class="w-6 h-6" />
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Approval Terstruktur</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Pendaftaran siswa dan rekapitulasi diproses melalui persetujuan multi-level admin.</p>
                        </div>

                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3 sm:mt-6 hover:border-purple-200 transition-all">
                            <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                <Award class="w-6 h-6" />
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Evaluasi Vokasi</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">Penilaian performa sikap, kedisiplinan, dan capaian teknis berbasis rubrik standar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SEKSI ALUMNI & TESTIMONI (CARD PERSIS GAMBAR: FOTO BESAR + FLOATING BADGE NAMA & SEKOLAH) -->
        <section id="alumni" class="py-20 relative bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center space-y-3 max-w-2xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-[rgb(93,135,255)] uppercase tracking-wider">
                        Alumni PKL
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Semua Alumni Magang <span class="text-[rgb(93,135,255)]">SIPKL</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600">Jejak prestasi dan dokumentasi peserta yang telah menyelesaikan program PKL.</p>
                </div>

                <!-- Grid Card Alumni Persis Referensi Gambar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div 
                        v-for="item in alumniList" 
                        :key="item.id" 
                        class="relative rounded-3xl bg-white border border-slate-200/80 shadow-md shadow-slate-200/40 overflow-hidden hover:shadow-xl hover:-translate-y-1.5 transition-all flex flex-col justify-end group h-80 sm:h-96"
                    >
                        <!-- Background Foto Alumni (Full Height Image with Overlay) -->
                        <div class="absolute inset-0 bg-slate-100">
                            <img 
                                v-if="item.photo_path" 
                                :src="item.photo_path.startsWith('http') ? item.photo_path : `/storage/${item.photo_path}`" 
                                :alt="item.name" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                            />
                            <!-- Placeholder Image / Initial if no photo -->
                            <div v-else class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-blue-100 to-indigo-50 text-[rgb(93,135,255)]">
                                <span class="text-5xl font-black">{{ item?.username ? item.username.replace('@', '').charAt(0).toUpperCase() : (item?.name ? item.name.charAt(0).toUpperCase() : 'A') }}</span>
                                <span class="text-xs font-semibold text-slate-400 mt-2 font-mono">{{ item.username || '@alumni_pkl' }}</span>
                            </div>
                        </div>

                        <!-- Badge Tag Divisi / Team di Pojok Kiri Atas -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[11px] font-bold text-slate-700 shadow-xs border border-white/40">
                                <Users class="w-3.5 h-3.5 text-[rgb(93,135,255)]" />
                                <span>{{ item.division_name || 'Team PKL' }}</span>
                            </span>
                        </div>

                        <!-- Floating Bottom Info Box (Persis Gambar: Nama Besar & Asal Sekolah / Divisi Biru) -->
                        <div class="relative z-10 m-3 p-4 bg-white/95 backdrop-blur-md rounded-2xl border border-slate-100 shadow-md text-center space-y-1">
                            <h4 class="font-extrabold text-slate-900 text-base sm:text-lg tracking-tight truncate">
                                {{ item.name }}
                            </h4>
                            <p class="text-xs font-bold text-[rgb(93,135,255)] truncate">
                                {{ item.school_name }}
                            </p>
                            <p v-if="item.username" class="text-[10px] text-slate-400 font-mono">
                                {{ item.username.startsWith('@') ? item.username : '@' + item.username }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. SEKSI GALERI KEGIATAN (CERAH) -->
        <section id="galeri" class="py-20 bg-white border-y border-slate-200/80 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-3 max-w-xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-50 border border-purple-200 text-xs font-bold text-purple-700 uppercase tracking-wider">
                            Dokumentasi
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Galeri Kegiatan PKL</h2>
                        <p class="text-xs sm:text-sm text-slate-600">Potret aktivitas harian, pembelajaran teknis, dan momen orientasi siswa PKL.</p>
                    </div>

                    <!-- Category Filter Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <button 
                            v-for="cat in galleryCategories" 
                            :key="cat"
                            @click="activeGalleryCategory = cat"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer"
                            :class="activeGalleryCategory === cat ? 'bg-[rgb(93,135,255)] text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        >
                            {{ cat }}
                        </button>
                    </div>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="item in filteredGallery" 
                        :key="item.id" 
                        class="group rounded-3xl bg-slate-50 border border-slate-200/80 overflow-hidden hover:shadow-lg transition-all flex flex-col"
                    >
                        <div class="relative h-48 overflow-hidden bg-slate-200">
                            <img 
                                :src="item.image_path" 
                                :alt="item.title" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                            />
                            <span class="absolute top-3 left-3 px-3 py-1 bg-white/90 backdrop-blur-md border border-slate-200 rounded-full text-[10px] font-bold text-[rgb(93,135,255)] shadow-xs">
                                {{ item.category }}
                            </span>
                        </div>
                        <div class="p-5 space-y-1 flex-1 flex flex-col justify-between bg-white">
                            <h3 class="font-bold text-slate-900 text-sm group-hover:text-[rgb(93,135,255)] transition-colors">{{ item.title }}</h3>
                            <p v-if="item.caption" class="text-xs text-slate-500 leading-relaxed">{{ item.caption }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. SEKSI PROSEDUR & ALUR (CERAH) -->
        <section id="prosedur" class="py-20 relative bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center space-y-3 max-w-2xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-xs font-bold text-amber-700 uppercase tracking-wider">
                        Panduan Langkah
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Prosedur & Alur PKL</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Langkah-langkah sistematis pendaftaran siswa hingga penyelesaian magang.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div 
                        v-for="proc in procedureList" 
                        :key="proc.id" 
                        class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition-all space-y-4 relative flex flex-col justify-between"
                    >
                        <div class="flex items-center justify-between">
                            <span class="w-8 h-8 rounded-full bg-blue-50 text-[rgb(93,135,255)] font-black text-sm flex items-center justify-center border border-blue-200">
                                {{ proc.step_number }}
                            </span>
                            <component :is="getProcedureIcon(proc.icon)" class="w-5 h-5 text-slate-400" />
                        </div>

                        <div class="space-y-1.5">
                            <h3 class="font-bold text-slate-900 text-sm">{{ proc.title }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ proc.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. SEKSI HUBUNGI KAMI & FOOTER (CERAH + CONTRAST CALLOUT) -->
        <section id="kontak" class="py-20 bg-white border-t border-slate-200/80 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <!-- Left Info -->
                    <div class="lg:col-span-5 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-[rgb(93,135,255)] uppercase tracking-wider">
                            Hubungi Kami
                        </div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Informasi Layanan & Kontak</h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            Punya pertanyaan seputar pendaftaran PKL atau bantuan teknis portal? Tim admin kami siap membantu Anda.
                        </p>

                        <div class="space-y-4 pt-2">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[rgb(93,135,255)] flex items-center justify-center shrink-0 border border-blue-100">
                                    <MapPin class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Alamat Pusat</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">{{ sections.contact_address || 'Jl. Pendidikan No. 88, Surabaya' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                                    <Mail class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Email Resmi</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">{{ sections.contact_email || 'admin@sipkl.sch.id' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100">
                                    <Phone class="w-5 h-5" />
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Telepon & WhatsApp</h4>
                                    <p class="text-xs text-slate-600 mt-0.5">{{ sections.contact_phone || '+62 31 8765432' }} (WA: {{ sections.contact_whatsapp || '081234567890' }})</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Quick Login Callout Card -->
                    <div class="lg:col-span-7 p-8 sm:p-10 rounded-3xl bg-gradient-to-br from-[rgb(93,135,255)] via-blue-600 to-indigo-900 text-white space-y-6 flex flex-col justify-between shadow-xl shadow-blue-500/20 relative overflow-hidden">
                        <!-- Background Mesh -->
                        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-[size:24px_24px]"></div>

                        <div class="space-y-3 relative z-10">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center font-extrabold text-xl shadow-md">
                                PKL
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-black">Siap Mengakses Portal SIPKL?</h3>
                            <p class="text-xs sm:text-sm text-blue-100/90 leading-relaxed">
                                Silakan masuk menggunakan akun siswa PKL atau akun administrator yang telah terverifikasi untuk melanjutkan absensi dan pelaporan jurnal.
                            </p>
                        </div>

                        <div class="pt-4 relative z-10">
                            <Link 
                                href="/login" 
                                class="w-full py-4 bg-white hover:bg-slate-100 text-[rgb(93,135,255)] font-extrabold rounded-2xl shadow-xl flex items-center justify-center gap-3 text-sm transition-all hover:scale-[1.01]"
                            >
                                <span>Masuk Sekarang ke Halaman Login</span>
                                <ArrowRight class="w-5 h-5 text-[rgb(93,135,255)]" />
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="pt-12 border-t border-slate-200 text-center text-xs text-slate-500">
                    <p>© 2026 SIPKL Application System. Built with SOLID Laravel & Inertia.js.</p>
                </div>
            </div>
        </section>
    </div>
</template>
