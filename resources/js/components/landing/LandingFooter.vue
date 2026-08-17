<script setup lang="ts">
import { ArrowRight } from '@lucide/vue';

defineProps<{
    sections: Record<string, string>;
}>();

const footerLinks = [
    { label: 'Beranda', href: '#beranda' },
    { label: 'Fitur', href: '#fitur' },
    { label: 'Alur', href: '#prosedur' },
    { label: 'Alumni', href: '#alumni' },
    { label: 'Galeri', href: '#galeri' },
    { label: 'Kontak', href: '#kontak' },
];
</script>

<template>
    <section
        id="kontak"
        class="relative border-t border-zinc-800 bg-zinc-950 py-24 text-white"
    >
        <div class="mx-auto max-w-6xl space-y-20 px-4 sm:px-6 lg:px-8">
            <!-- Editorial Split Content -->
            <div
                class="grid grid-cols-1 items-start gap-12 lg:grid-cols-12 lg:gap-16"
            >
                <!-- Left: Info & Kantor -->
                <div class="space-y-6 sm:space-y-8 lg:col-span-7">
                    <div class="space-y-3 sm:space-y-4">
                        <h2
                            class="text-2xl leading-tight font-bold tracking-tight text-white sm:text-4xl md:text-5xl"
                        >
                            Punya Pertanyaan Seputar Program PKL?
                        </h2>
                        <p
                            class="max-w-xl text-xs leading-relaxed font-normal text-zinc-400 sm:text-base"
                        >
                            Hubungi tim koordinator untuk informasi kemitraan
                            instansi, verifikasi data sekolah, atau panduan
                            teknis portal sistem.
                        </p>
                    </div>

                    <div
                        class="max-w-lg space-y-4 border-t border-zinc-800/80 pt-6 text-xs leading-relaxed text-zinc-400"
                    >
                        <div class="space-y-1">
                            <div
                                class="text-[11px] font-semibold tracking-wider text-zinc-200 uppercase"
                            >
                                Kantor Pusat
                            </div>
                            <p>
                                {{
                                    sections.contact_address ||
                                    'Jl. Pendidikan No. 88, Gedung Pusat Pembinaan Vokasi, Surabaya'
                                }}
                            </p>
                        </div>
                        <div
                            class="flex flex-wrap gap-x-8 gap-y-2 pt-2 text-zinc-300"
                        >
                            <div>
                                <span class="text-zinc-500">Jam Layanan: </span>
                                <span>{{
                                    sections.contact_hours ||
                                    'Senin - Jumat, 08:00 - 16:00 WIB'
                                }}</span>
                            </div>
                            <div v-if="sections.contact_phone">
                                <span class="text-zinc-500">Telepon: </span>
                                <span>{{ sections.contact_phone }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Action Buttons -->
                <div class="space-y-4 pt-2 lg:col-span-5">
                    <a
                        :href="`https://wa.me/${(sections.contact_whatsapp || '081234567890').replace(/[^0-9]/g, '')}`"
                        target="_blank"
                        class="group flex items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-900/80 p-5 transition-all duration-200 hover:border-white hover:bg-white hover:text-zinc-950"
                    >
                        <div class="space-y-1">
                            <div
                                class="font-mono text-[11px] tracking-wider text-zinc-400 uppercase group-hover:text-zinc-600"
                            >
                                WhatsApp Direct
                            </div>
                            <div
                                class="text-sm font-bold text-white group-hover:text-zinc-950"
                            >
                                Chat via WhatsApp
                            </div>
                            <div
                                class="text-xs text-zinc-400 group-hover:text-zinc-700"
                            >
                                {{
                                    sections.contact_whatsapp ||
                                    '0812-3456-7890'
                                }}
                            </div>
                        </div>
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-zinc-800 text-zinc-300 transition-colors group-hover:bg-zinc-100 group-hover:text-zinc-950"
                        >
                            <ArrowRight
                                class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                            />
                        </div>
                    </a>

                    <a
                        :href="`mailto:${sections.contact_email || 'admin@sipkl.sch.id'}`"
                        class="group flex items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-900/80 p-5 transition-all duration-200 hover:border-white hover:bg-white hover:text-zinc-950"
                    >
                        <div class="space-y-1">
                            <div
                                class="font-mono text-[11px] tracking-wider text-zinc-400 uppercase group-hover:text-zinc-600"
                            >
                                Email Resmi
                            </div>
                            <div
                                class="text-sm font-bold text-white group-hover:text-zinc-950"
                            >
                                Kirim Email Resmi
                            </div>
                            <div
                                class="max-w-[220px] truncate text-xs text-zinc-400 group-hover:text-zinc-700"
                            >
                                {{
                                    sections.contact_email ||
                                    'admin@sipkl.sch.id'
                                }}
                            </div>
                        </div>
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-zinc-800 text-zinc-300 transition-colors group-hover:bg-zinc-100 group-hover:text-zinc-950"
                        >
                            <ArrowRight
                                class="h-4 w-4 transition-transform group-hover:translate-x-0.5"
                            />
                        </div>
                    </a>
                </div>
            </div>

            <!-- Footer Bar -->
            <div
                class="flex flex-col items-center justify-between gap-6 border-t border-zinc-800 pt-12 text-xs text-zinc-500 sm:flex-row"
            >
                <div class="flex items-center gap-2">
                    <span
                        class="text-sm font-extrabold tracking-tight text-white"
                    >
                        SIPKL.
                    </span>
                    <span class="text-zinc-500">•</span>
                    <span>© 2026 SIPKL.</span>
                </div>

                <div class="flex items-center gap-6 text-zinc-400">
                    <a
                        v-for="link in footerLinks"
                        :key="link.href"
                        :href="link.href"
                        class="transition-colors hover:text-white"
                    >
                        {{ link.label }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
