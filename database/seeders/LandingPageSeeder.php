<?php

namespace Database\Seeders;

use App\Models\AlumniStory;
use App\Models\GalleryItem;
use App\Models\LandingSection;
use App\Models\Procedure;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            // Beranda (Hero)
            ['key' => 'hero_badge', 'value' => 'Pendaftaran Siswa PKL Tahun 2026/2027 Dibuka', 'group' => 'hero'],
            ['key' => 'hero_title', 'value' => 'Sistem Informasi & Portal Monitoring Praktek Kerja Lapangan', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Platform terpadu absensi presisi, pelaporan jurnal harian digital, dan evaluasi kinerja siswa PKL secara real-time dan terstruktur.', 'group' => 'hero'],

            // Tentang (About)
            ['key' => 'about_title', 'value' => 'Transformasi Digital Pengelolaan Praktik Kerja Lapangan', 'group' => 'about'],
            ['key' => 'about_description', 'value' => 'SIPKL dirancang khusus untuk mempermudah kolaborasi antara Siswa PKL, Pembimbing Sekolah, dan Instansi/Perusahaan. Kami menyediakan transparansi penuh dalam pencatatan kehadiran, verifikasi kegiatan harian, serta penilaian komprehensif.', 'group' => 'about'],
            ['key' => 'about_stat_students', 'value' => '500+', 'group' => 'about'],
            ['key' => 'about_stat_schools', 'value' => '45+', 'group' => 'about'],
            ['key' => 'about_stat_divisions', 'value' => '12+', 'group' => 'about'],

            // Hubungi Kami (Contact)
            ['key' => 'contact_address', 'value' => 'Jl. Pendidikan No. 88, Gedung Pusat Pembinaan Vokasi, Surabaya', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'admin@sipkl.sch.id', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+62 31 8765432', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '081234567890', 'group' => 'contact'],
            ['key' => 'contact_hours', 'value' => 'Senin - Jumat: 08:00 - 16:00 WIB', 'group' => 'contact'],
        ];

        foreach ($sections as $section) {
            LandingSection::updateOrCreate(['key' => $section['key']], $section);
        }

        // Procedures (Alur/Prosedur)
        $procedures = [
            [
                'step_number' => 1,
                'title' => 'Pendaftaran Akun',
                'description' => 'Calon siswa PKL mengisi formulir pendaftaran online dan mengunggah CV format PDF.',
                'icon' => 'UserPlus',
                'is_visible' => true,
            ],
            [
                'step_number' => 2,
                'title' => 'Verifikasi Admin',
                'description' => 'Tim Admin mereview data registrasi serta berkas CV untuk persetujuan akun.',
                'icon' => 'ShieldCheck',
                'is_visible' => true,
            ],
            [
                'step_number' => 3,
                'title' => 'Penempatan Divisi',
                'description' => 'Siswa yang disetujui ditempatkan pada divisi kerja dan pembimbing yang sesuai.',
                'icon' => 'Building',
                'is_visible' => true,
            ],
            [
                'step_number' => 4,
                'title' => 'Pelaksanaan & Jurnal',
                'description' => 'Siswa melakukan absensi 1-klik harian dan mengisi jurnal kegiatan berkala.',
                'icon' => 'CalendarCheck',
                'is_visible' => true,
            ],
            [
                'step_number' => 5,
                'title' => 'Penilaian & Sertifikat',
                'description' => 'Evaluasi akhir oleh pembimbing dan penerbitan sertifikat kelulusan PKL.',
                'icon' => 'Award',
                'is_visible' => true,
            ],
        ];

        foreach ($procedures as $proc) {
            Procedure::updateOrCreate(['step_number' => $proc['step_number']], $proc);
        }

        // Alumni Stories (Diselaraskan dengan Sampel Gambar Pengguna)
        $alumni = [
            [
                'name' => 'Rival',
                'username' => '@rival_dev',
                'school_name' => 'SMK PGRI Singosari',
                'major_name' => 'Rekayasa Perangkat Lunak',
                'division_name' => 'Software Team',
                'graduation_year' => '2025',
                'current_position' => 'Frontend Developer',
                'quote' => 'Program PKL melatih kedisiplinan dan teknis secara profesional.',
                'photo_path' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'name' => 'Zanuar',
                'username' => '@zanuar_net',
                'school_name' => 'SMK PGRI 3 Malang',
                'major_name' => 'Teknik Komputer & Jaringan',
                'division_name' => 'Network Team',
                'graduation_year' => '2025',
                'current_position' => 'Network Specialist',
                'quote' => 'Pengalaman magang yang sangat berharga dengan bimbingan terstruktur.',
                'photo_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'name' => 'Wira',
                'username' => '@wira_infra',
                'school_name' => 'SMK PGRI 3 Malang',
                'major_name' => 'Teknik Komputer & Jaringan',
                'division_name' => 'Cloud Team',
                'graduation_year' => '2025',
                'current_position' => 'DevOps Engineer',
                'quote' => 'Sistem absensi dan jurnal online di SIPKL sangat mudah digunakan.',
                'photo_path' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'order' => 3,
                'is_visible' => true,
            ],
            [
                'name' => 'Rendi',
                'username' => '@rendi_design',
                'school_name' => 'SMK PGRI 2 Ponorogo',
                'major_name' => 'Multimedia',
                'division_name' => 'Design Team',
                'graduation_year' => '2025',
                'current_position' => 'UI/UX Designer',
                'quote' => 'Banyak ilmu baru yang didapatkan selama mengikuti kegiatan PKL.',
                'photo_path' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?auto=format&fit=crop&w=600&q=80',
                'order' => 4,
                'is_visible' => true,
            ],
        ];

        foreach ($alumni as $item) {
            AlumniStory::updateOrCreate(['name' => $item['name']], $item);
        }

        // Gallery Items
        $gallery = [
            [
                'title' => 'Pengenalan & Briefing Peserta PKL Baru',
                'category' => 'Orientasi',
                'image_path' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Sesi pembekalan awal orientasi budaya kerja dan pengenalan divisi.',
                'order' => 1,
                'is_visible' => true,
            ],
            [
                'title' => 'Kolaborasi Project Coding Bersama Mentor',
                'category' => 'Kegiatan',
                'image_path' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Diskusi teknis arsitektur perangkat lunak dan code review harian.',
                'order' => 2,
                'is_visible' => true,
            ],
            [
                'title' => 'Presentasi Hasil Akhir & Evaluasi Jurnal',
                'category' => 'Evaluasi',
                'image_path' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80',
                'caption' => 'Penyampaian rekapitulasi pencapaian kerja selama masa PKL.',
                'order' => 3,
                'is_visible' => true,
            ],
        ];

        foreach ($gallery as $gal) {
            GalleryItem::updateOrCreate(['title' => $gal['title']], $gal);
        }
    }
}
