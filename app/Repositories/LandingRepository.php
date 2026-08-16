<?php

namespace App\Repositories;

use App\Contracts\Repositories\LandingRepositoryInterface;
use App\Models\AlumniStory;
use App\Models\GalleryItem;
use App\Models\LandingSection;
use App\Models\Procedure;
use Illuminate\Support\Collection;

class LandingRepository implements LandingRepositoryInterface
{
    public function getAllSectionsGrouped(): array
    {
        $sections = LandingSection::all();
        $grouped = [];

        foreach ($sections as $section) {
            $grouped[$section->key] = $section->value;
        }

        return $grouped;
    }

    public function getVisibleAlumniStories(): Collection
    {
        return AlumniStory::where('is_visible', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function getVisibleGalleryItems(): Collection
    {
        return GalleryItem::where('is_visible', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function getVisibleProcedures(): Collection
    {
        return Procedure::where('is_visible', true)
            ->orderBy('step_number', 'asc')
            ->get();
    }

    public function updateSection(string $key, ?string $value): void
    {
        LandingSection::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public function saveAlumni(array $data, ?int $id = null): void
    {
        if ($id) {
            $alumni = AlumniStory::findOrFail($id);
            $alumni->update($data);
        } else {
            AlumniStory::create($data);
        }
    }

    public function deleteAlumni(int $id): void
    {
        AlumniStory::destroy($id);
    }

    public function saveGallery(array $data, ?int $id = null): void
    {
        if ($id) {
            $item = GalleryItem::findOrFail($id);
            $item->update($data);
        } else {
            GalleryItem::create($data);
        }
    }

    public function deleteGallery(int $id): void
    {
        GalleryItem::destroy($id);
    }

    public function saveProcedure(array $data, ?int $id = null): void
    {
        if ($id) {
            $procedure = Procedure::findOrFail($id);
            $procedure->update($data);
        } else {
            Procedure::create($data);
        }
    }

    public function deleteProcedure(int $id): void
    {
        Procedure::destroy($id);
    }
}
