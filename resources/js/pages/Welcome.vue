<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

import LandingAlumni from '@/components/landing/LandingAlumni.vue';
import LandingFeatures from '@/components/landing/LandingFeatures.vue';
import LandingFooter from '@/components/landing/LandingFooter.vue';
import LandingGallery from '@/components/landing/LandingGallery.vue';
import LandingHero from '@/components/landing/LandingHero.vue';
import LandingNavbar from '@/components/landing/LandingNavbar.vue';
import LandingProcedures from '@/components/landing/LandingProcedures.vue';
import type { AlumniItem, GalleryItem, ProcedureItem } from '@/types/landing';

const props = defineProps<{
    sections: Record<string, string>;
    alumni: AlumniItem[] | { data: AlumniItem[] };
    gallery: GalleryItem[] | { data: GalleryItem[] };
    procedures: ProcedureItem[] | { data: ProcedureItem[] };
}>();

const page = usePage();
const isAuthenticated = computed(() => !!page.props.auth?.user);

const userDashboardUrl = computed(() => {
    const role = (page.props.auth as any)?.user?.role;
    if (role === 'admin' || role === 'pembimbing_sekolah') {
        return '/admin/dashboard';
    }
    return '/dashboard';
});

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
</script>

<template>
    <Head title="SIPKL - Portal Sistem Informasi Praktek Kerja Lapangan" />

    <div
        class="min-h-screen bg-white font-sans text-zinc-950 antialiased selection:bg-zinc-900 selection:text-white"
    >
        <!-- 1. Header & Navbar -->
        <LandingNavbar
            :is-authenticated="isAuthenticated"
            :user-dashboard-url="userDashboardUrl"
        />

        <!-- 2. Hero Section with Mouse & Scroll Parallax -->
        <LandingHero
            :sections="sections"
            :is-authenticated="isAuthenticated"
            :user-dashboard-url="userDashboardUrl"
        />

        <!-- 3. Features Bento Grid -->
        <LandingFeatures :sections="sections" />

        <!-- 4. Procedures / Steps -->
        <LandingProcedures :procedures="procedureList" />

        <!-- 5. Alumni Stories & Testimonials -->
        <LandingAlumni :alumni="alumniList" />

        <!-- 6. Gallery & Lightbox Dialog -->
        <LandingGallery :gallery="galleryList" />

        <!-- 7. Contact Section & Footer -->
        <LandingFooter :sections="sections" />
    </div>
</template>
