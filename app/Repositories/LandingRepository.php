<?php

namespace App\Repositories;

use App\Contracts\Repositories\LandingRepositoryInterface;
use App\Models\AlumniStory;
use App\Models\GalleryItem;
use App\Models\LandingSection;
use App\Models\Procedure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LandingRepository implements LandingRepositoryInterface
{
    protected const CACHE_TTL_SECONDS = 3600; // 1 hour in-memory cache for ultra-fast response under high load

    public function getAllSectionsGrouped(): array
    {
        return Cache::remember('landing_sections_grouped', self::CACHE_TTL_SECONDS, function () {
            $sections = LandingSection::all();
            $grouped = [];

            foreach ($sections as $section) {
                $grouped[$section->key] = $section->value;
            }

            return $grouped;
        });
    }

    public function getVisibleAlumniStories(): Collection
    {
        return Cache::remember('landing_alumni_stories', self::CACHE_TTL_SECONDS, function () {
            return AlumniStory::where('is_visible', true)
                ->orderBy('order', 'asc')
                ->get();
        });
    }

    public function getVisibleGalleryItems(): Collection
    {
        return Cache::remember('landing_gallery_items', self::CACHE_TTL_SECONDS, function () {
            return GalleryItem::where('is_visible', true)
                ->orderBy('order', 'asc')
                ->get();
        });
    }

    public function getVisibleProcedures(): Collection
    {
        return Cache::remember('landing_procedures', self::CACHE_TTL_SECONDS, function () {
            return Procedure::where('is_visible', true)
                ->orderBy('step_number', 'asc')
                ->get();
        });
    }

    public function updateSection(string $key, ?string $value): void
    {
        LandingSection::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget('landing_sections_grouped');
    }

    public function saveAlumni(array $data, ?int $id = null): void
    {
        if ($id) {
            $alumni = AlumniStory::findOrFail($id);
            $alumni->update($data);
        } else {
            AlumniStory::create($data);
        }

        Cache::forget('landing_alumni_stories');
    }

    public function deleteAlumni(int $id): void
    {
        AlumniStory::destroy($id);
        Cache::forget('landing_alumni_stories');
    }

    public function saveGallery(array $data, ?int $id = null): void
    {
        if ($id) {
            $item = GalleryItem::findOrFail($id);
            $item->update($data);
        } else {
            GalleryItem::create($data);
        }

        Cache::forget('landing_gallery_items');
    }

    public function deleteGallery(int $id): void
    {
        GalleryItem::destroy($id);
        Cache::forget('landing_gallery_items');
    }

    public function saveProcedure(array $data, ?int $id = null): void
    {
        if ($id) {
            $procedure = Procedure::findOrFail($id);
            $procedure->update($data);
        } else {
            Procedure::create($data);
        }

        Cache::forget('landing_procedures');
    }

    public function deleteProcedure(int $id): void
    {
        Procedure::destroy($id);
        Cache::forget('landing_procedures');
    }
}
