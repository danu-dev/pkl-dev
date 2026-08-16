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
    CheckCircle2, 
    Award, 
    UserPlus, 
    Building, 
    FileText, 
    ChevronRight, 
    Menu, 
    X, 
    LogIn,
    CalendarCheck,
    MessageCircle
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

    <div class="min-h-screen bg-slate-50 text-slate-800 font-sans selection:bg-[#2563EB] selection:text-white">
        <!-- 1. STICKY NAVBAR -->
        <header class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <!-- Logo Brand Resmi -->
                <a href="#beranda" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl overflow-hidden shadow-sm bg-white border border-slate-100 flex items-center justify-center shrink-0">
                        <img src="/images/app-icon.png" alt="SIPKL" class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <span class="font-black text-xl text-slate-900 tracking-tight leading-none block">SIPKL</span>
                        <span class="text-[10px] text-slate-500 font-bold tracking-widest uppercase mt-0.5 block">Sistem Informasi PKL</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-xs font-semibold text-slate-600">
                    <a href="#beranda" class="hover:text-[#2563EB] transition-colors">Beranda</a>
                    <a href="#tentang" class="hover:text-[#2563EB] transition-colors">Tentang</a>
                    <a href="#alumni" class="hover:text-[#2563EB] transition-colors">Alumni</a>
                    <a href="#galeri" class="hover:text-[#2563EB] transition-colors">Galeri</a>
                    <a href="#prosedur" class="hover:text-[#2563EB] transition-colors">Prosedur</a>
                    <a href="#kontak" class="hover:text-[#2563EB] transition-colors">Hubungi Kami</a>
                </nav>

                <!-- Action Button (HANYA TOMBOL LOGIN) -->
                <div class="hidden md:flex items-center gap-3">
                    <Link 
                        href="/login" 
                        class="px-5 py-2.5 bg-[#2563EB] hover:bg-[#1E3A8A] text-white font-bold rounded-xl shadow-md shadow-blue-500/20 flex items-center gap-2 text-xs transition-all active:scale-95 cursor-pointer"
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
                    <a @click="isMobileMenuOpen = false" href="#beranda" class="hover:text-[#2563EB]">Beranda</a>
                    <a @click="isMobileMenuOpen = false" href="#tentang" class="hover:text-[#2563EB]">Tentang</a>
                    <a @click="isMobileMenuOpen = false" href="#alumni" class="hover:text-[#2563EB]">Alumni</a>
                    <a @click="isMobileMenuOpen = false" href="#galeri" class="hover:text-[#2563EB]">Galeri</a>
                    <a @click="isMobileMenuOpen = false" href="#prosedur" class="hover:text-[#2563EB]">Prosedur</a>
                    <a @click="isMobileMenuOpen = false" href="#kontak" class="hover:text-[#2563EB]">Hubungi Kami</a>
                </nav>
                <div class="pt-3 border-t border-slate-100">
                    <Link 
                        href="/login" 
                        class="w-full py-3 bg-[#2563EB] text-white font-bold rounded-xl flex items-center justify-center gap-2 text-xs shadow-md shadow-blue-500/20"
                    >
                        <LogIn class="w-4 h-4" />
                        <span>Login Portal</span>
                    </Link>
                </div>
            </div>
        </header>

        <!-- 2. SEKSI BERANDA (SOLID COLOR CLEAN PALETTE) -->
        <section id="beranda" class="relative pt-16 pb-20 lg:pt-24 lg:pb-32 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                <!-- Badge Pengumuman -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-blue-700">
                    <Sparkles class="w-4 h-4 text-blue-600" />
                    <span>{{ sections.hero_badge || 'Pendaftaran Siswa PKL Tahun 2026/2027 Dibuka' }}</span>
                </div>

                <!-- Headline Main -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-slate-900 max-w-4xl mx-auto leading-[1.15]">
                    {{ sections.hero_title || 'Sistem Informasi & Portal Monitoring Praktek Kerja Lapangan' }}
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto font-normal leading-relaxed">
                    {{ sections.hero_subtitle || 'Platform terpadu absensi presisi, pelaporan jurnal harian digital, dan evaluasi kinerja siswa PKL secara real-time dan terstruktur.' }}
                </p>

                <!-- Call to Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                    <Link 
                        href="/login" 
                        class="w-full sm:w-auto px-8 py-4 bg-[#2563EB] hover:bg-[#1E3A8A] text-white font-extrabold rounded-2xl shadow-lg shadow-blue-500/20 flex items-center justify-center gap-3 text-sm transition-all active:scale-95 cursor-pointer"
                    >
                        <span>Masuk ke Portal SIPKL</span>
                        <ArrowRight class="w-5 h-5" />
                    </Link>

                    <a 
                        href="#prosedur" 
                        class="w-full sm:w-auto px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 font-bold rounded-2xl flex items-center justify-center gap-2 text-sm transition-all"
                    >
                        <span>Pelajari Prosedur</span>
                        <ChevronRight class="w-4 h-4 text-slate-500" />
                    </a>
                </div>

                <!-- Showcase Metrics Bar (Solid Colors) -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto pt-10">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-3xl font-black text-slate-900">{{ sections.about_stat_students || '500+' }}</div>
                        <div class="text-xs text-slate-500 font-semibold mt-1">Siswa PKL Aktif</div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-3xl font-black text-blue-600">{{ sections.about_stat_schools || '45+' }}</div>
                        <div class="text-xs text-slate-500 font-semibold mt-1">Sekolah & Kampus Mitra</div>
                    </div>

                    <div class="col-span-2 md:col-span-1 p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <div class="text-3xl font-black text-blue-900">{{ sections.about_stat_divisions || '12+' }}</div>
                        <div class="text-xs text-slate-500 font-semibold mt-1">Divisi Penempatan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. SEKSI TENTANG KAMI (SOLID CLEAN BENTO) -->
        <section id="tentang" class="py-24 bg-slate-50 border-b border-slate-200 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <!-- Section Header -->
                <div class="text-center space-y-4 max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-blue-700 uppercase tracking-wider">
                        Tentang SIPKL
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                        {{ sections.about_title || 'Transformasi Digital Pengelolaan Praktik Kerja Lapangan' }}
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                        {{ sections.about_description || 'SIPKL dirancang khusus untuk mempermudah kolaborasi antara Siswa PKL, Pembimbing Sekolah, dan Instansi/Perusahaan. Kami menyediakan transparansi penuh dalam pencatatan kehadiran, verifikasi kegiatan harian, serta penilaian komprehensif.' }}
                    </p>
                </div>

                <!-- Feature Cards Grid (Solid Clean White) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-8 rounded-3xl bg-white border border-slate-200 hover:border-blue-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between space-y-6">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center">
                            <Clock class="w-6 h-6" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-900 text-xl tracking-tight">Presisi Kehadiran 1-Klik</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Sistem memverifikasi jam masuk, jam pulang, dan pengajuan izin/sakit secara akurat sesuai batasan jam operasional yang ditentukan.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-blue-600">
                            <CheckCircle2 class="w-4 h-4 text-blue-600" />
                            <span>Terkunci Otomatis di Luar Jam Kerja</span>
                        </div>
                    </div>

                    <div class="p-8 rounded-3xl bg-white border border-slate-200 hover:border-blue-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between space-y-6">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center">
                            <BookOpen class="w-6 h-6" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-900 text-xl tracking-tight">Jurnal Kegiatan Digital</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Pengisian log aktivitas harian lengkap dengan lampiran bukti foto atau berkas pekerjaan yang langsung diverifikasi pembimbing.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-blue-600">
                            <CheckCircle2 class="w-4 h-4 text-blue-600" />
                            <span>Verifikasi Berjenjang Admin & Mentor</span>
                        </div>
                    </div>

                    <div class="p-8 rounded-3xl bg-white border border-slate-200 hover:border-blue-500 hover:shadow-lg transition-all duration-200 flex flex-col justify-between space-y-6">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center">
                            <Award class="w-6 h-6" />
                        </div>
                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-900 text-xl tracking-tight">Evaluasi Nilai & Sertifikat</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Penilaian komprehensif mencakup disiplin, teknis, jurnal, dan sikap dengan perhitungan grade otomatis berstandar vokasi.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold text-blue-600">
                            <CheckCircle2 class="w-4 h-4 text-blue-600" />
                            <span>Kalkulasi Otomatis Grade A/B/C/D</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SEKSI ALUMNI & TESTIMONI (CARD SESUAI REFERENSI GAMBAR) -->
        <section id="alumni" class="py-24 relative bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center space-y-4 max-w-2xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-blue-700 uppercase tracking-wider">
                        Alumni PKL
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">
                        Semua Alumni Magang <span class="text-[#2563EB]">SIPKL</span>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600">Jejak prestasi dan dokumentasi peserta yang telah menyelesaikan program PKL.</p>
                </div>

                <!-- Grid Card Alumni Persis Referensi Gambar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div 
                        v-for="item in alumniList" 
                        :key="item.id" 
                        class="relative rounded-3xl bg-white border border-slate-200 shadow-md overflow-hidden hover:shadow-xl hover:-translate-y-1.5 transition-all duration-200 flex flex-col justify-end group h-80 sm:h-96"
                    >
                        <!-- Background Foto Alumni -->
                        <div class="absolute inset-0 bg-slate-100">
                            <img 
                                v-if="item.photo_path" 
                                :src="item.photo_path.startsWith('http') ? item.photo_path : `/storage/${item.photo_path}`" 
                                :alt="item.name" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                            />
                            <div v-else class="w-full h-full flex flex-col items-center justify-center bg-blue-50 text-blue-700">
                                <span class="text-5xl font-black">{{ item?.username ? item.username.replace('@', '').charAt(0).toUpperCase() : (item?.name ? item.name.charAt(0).toUpperCase() : 'A') }}</span>
                                <span class="text-xs font-semibold text-slate-400 mt-2 font-mono">{{ item.username || '@alumni_pkl' }}</span>
                            </div>
                        </div>

                        <!-- Badge Tag Divisi / Team di Pojok Kiri Atas -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-[11px] font-bold text-slate-700 shadow-xs border border-slate-200">
                                <Users class="w-3.5 h-3.5 text-blue-600" />
                                <span>{{ item.division_name || 'Team PKL' }}</span>
                            </span>
                        </div>

                        <!-- Floating Bottom Info Box -->
                        <div class="relative z-10 m-3 p-4 bg-white rounded-2xl border border-slate-100 shadow-md text-center space-y-1">
                            <h4 class="font-extrabold text-slate-900 text-base sm:text-lg tracking-tight truncate">
                                {{ item.name }}
                            </h4>
                            <p class="text-xs font-bold text-blue-600 truncate">
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

        <!-- 5. SEKSI GALERI KEGIATAN (SOLID COLOR PHOTO SHOWCASE) -->
        <section id="galeri" class="py-24 bg-slate-50 border-b border-slate-200 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-3 max-w-xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-blue-700 uppercase tracking-wider">
                            Dokumentasi & Galeri
                        </div>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">Galeri Kegiatan PKL</h2>
                        <p class="text-xs sm:text-sm text-slate-600">Potret aktivitas harian, pembelajaran teknis, dan momen berharga peserta PKL.</p>
                    </div>

                    <!-- Category Filter Buttons (Solid Color) -->
                    <div class="flex flex-wrap gap-2 p-1.5 bg-white rounded-2xl border border-slate-200">
                        <button 
                            v-for="cat in galleryCategories" 
                            :key="cat"
                            @click="activeGalleryCategory = cat"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer"
                            :class="activeGalleryCategory === cat ? 'bg-[#2563EB] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                        >
                            {{ cat }}
                        </button>
                    </div>
                </div>

                <!-- Gallery Grid (Clean Solid Cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="item in filteredGallery" 
                        :key="item.id" 
                        class="group rounded-3xl bg-white border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-200 flex flex-col justify-between"
                    >
                        <div class="relative h-56 overflow-hidden bg-slate-100">
                            <img 
                                :src="item.image_path" 
                                :alt="item.title" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                            />
                            <!-- Category Badge Solid -->
                            <span class="absolute top-3 left-3 px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-blue-700 shadow-xs">
                                {{ item.category }}
                            </span>
                        </div>
                        <div class="p-6 space-y-1.5 bg-white">
                            <h3 class="font-extrabold text-slate-900 text-base group-hover:text-blue-600 transition-colors leading-snug">{{ item.title }}</h3>
                            <p v-if="item.caption" class="text-xs text-slate-500 leading-relaxed">{{ item.caption }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. SEKSI PROSEDUR & ALUR PKL (SOLID BLUE ACCENTS) -->
        <section id="prosedur" class="py-24 relative bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="text-center space-y-4 max-w-2xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-blue-700 uppercase tracking-wider">
                        Panduan Langkah
                    </div>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight">Prosedur & Alur PKL</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Langkah-langkah sistematis pendaftaran siswa hingga penyelesaian magang dan sertifikasi.</p>
                </div>

                <!-- 5 Steps Flow Grid (Clean Solid Colors) -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
                    <div 
                        v-for="proc in procedureList" 
                        :key="proc.id" 
                        class="p-6 rounded-3xl bg-slate-50 border border-slate-200 hover:border-blue-500 hover:bg-white hover:shadow-md transition-all duration-200 space-y-5 flex flex-col justify-between group"
                    >
                        <div class="flex items-center justify-between">
                            <!-- Solid Blue Step Number -->
                            <span class="w-10 h-10 rounded-2xl bg-[#2563EB] text-white font-black text-sm flex items-center justify-center shadow-xs">
                                {{ proc.step_number }}
                            </span>
                            <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center">
                                <component :is="getProcedureIcon(proc.icon)" class="w-4 h-4" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="font-extrabold text-slate-900 text-base tracking-tight leading-snug">{{ proc.title }}</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ proc.description }}</p>
                        </div>

                        <div class="pt-2 border-t border-slate-200 flex items-center gap-1.5 text-[11px] font-bold text-blue-600">
                            <span>Tahap {{ proc.step_number }}</span>
                            <ChevronRight class="w-3.5 h-3.5" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. SEKSI HUBUNGI KAMI (SOLID COLORS HARMONY) -->
        <section id="kontak" class="py-24 bg-slate-50 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">
                    <!-- Left Contact Info -->
                    <div class="lg:col-span-6 space-y-6 flex flex-col justify-between">
                        <div class="space-y-4">
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-xs font-bold text-blue-700 uppercase tracking-wider">
                                Hubungi Kami
                            </div>
                            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Informasi Layanan & Bantuan</h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Punya pertanyaan seputar pendaftaran PKL, teknis jurnal, atau kemitraan sekolah? Tim kami siap membantu Anda setiap hari kerja.
                            </p>
                        </div>

                        <!-- Contact Cards (Clean Solid) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- WhatsApp -->
                            <a 
                                :href="`https://wa.me/${(sections.contact_whatsapp || '081234567890').replace(/[^0-9]/g, '')}`" 
                                target="_blank"
                                class="p-5 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 hover:shadow-sm transition-all group"
                            >
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                                        <MessageCircle class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Chat WhatsApp</h4>
                                        <p class="text-xs text-emerald-600 font-semibold mt-0.5">{{ sections.contact_whatsapp || '081234567890' }}</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Email -->
                            <a 
                                :href="`mailto:${sections.contact_email || 'admin@sipkl.sch.id'}`"
                                class="p-5 rounded-2xl bg-white border border-slate-200 hover:border-blue-500 hover:shadow-sm transition-all group"
                            >
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#2563EB] text-white flex items-center justify-center shrink-0">
                                        <Mail class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Email Resmi</h4>
                                        <p class="text-xs text-blue-600 font-semibold mt-0.5 truncate">{{ sections.contact_email || 'admin@sipkl.sch.id' }}</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Phone -->
                            <div class="p-5 rounded-2xl bg-white border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center shrink-0">
                                        <Phone class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Telepon Kantor</h4>
                                        <p class="text-xs text-slate-600 font-semibold mt-0.5">{{ sections.contact_phone || '+62 31 8765432' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Office Hours -->
                            <div class="p-5 rounded-2xl bg-white border border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center shrink-0">
                                        <Clock class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Jam Operasional</h4>
                                        <p class="text-xs text-slate-600 mt-0.5">{{ sections.contact_hours || 'Senin - Jumat: 08:00 - 16:00' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 text-[#2563EB] flex items-center justify-center shrink-0">
                                <MapPin class="w-5 h-5" />
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Alamat Kantor Pusat</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">{{ sections.contact_address || 'Jl. Pendidikan No. 88, Gedung Pusat Pembinaan Vokasi, Surabaya' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Quick Access Card (Solid Deep Navy #1E3A8A) -->
                    <div class="lg:col-span-6 p-8 sm:p-12 rounded-3xl bg-[#1E3A8A] text-white space-y-8 flex flex-col justify-between shadow-xl relative overflow-hidden">
                        <div class="space-y-4 relative z-10">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-sm flex items-center justify-center bg-white p-1">
                                <img src="/images/app-icon.png" alt="SIPKL" class="w-full h-full object-contain" />
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-black leading-tight">Siap Memulai Praktik Kerja Lapangan?</h3>
                            <p class="text-xs sm:text-sm text-blue-100 leading-relaxed font-normal">
                                Akses portal SIPKL sekarang untuk mulai melakukan absensi harian presisi, menyusun jurnal berkala, dan memantau penilaian pembimbing.
                            </p>
                        </div>

                        <div class="space-y-3 relative z-10 pt-4">
                            <Link 
                                href="/login" 
                                class="w-full py-4 bg-[#2563EB] hover:bg-blue-600 text-white font-extrabold rounded-2xl shadow-md flex items-center justify-center gap-3 text-sm transition-all active:scale-95 cursor-pointer"
                            >
                                <LogIn class="w-5 h-5 text-white" />
                                <span>Masuk ke Akun Portal</span>
                            </Link>

                            <p class="text-center text-xs text-blue-200">
                                <span>Belum terdaftar? Silakan </span>
                                <Link href="/login" class="underline font-bold text-white hover:text-blue-100">Masuk ke Halaman Login</Link>
                                <span> untuk mendaftar akun baru.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="pt-12 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                    <p>© 2026 SIPKL Application System. Built with SOLID Laravel & Inertia.js.</p>
                    <div class="flex items-center gap-6 font-semibold">
                        <a href="#beranda" class="hover:text-[#2563EB]">Beranda</a>
                        <a href="#tentang" class="hover:text-[#2563EB]">Tentang</a>
                        <a href="#alumni" class="hover:text-[#2563EB]">Alumni</a>
                        <a href="#galeri" class="hover:text-[#2563EB]">Galeri</a>
                        <a href="#prosedur" class="hover:text-[#2563EB]">Prosedur</a>
                        <a href="#kontak" class="hover:text-[#2563EB]">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
