<?php

namespace App\Contracts\Repositories;

use Illuminate\Support\Collection;

interface LandingRepositoryInterface
{
    public function getAllSectionsGrouped(): array;

    public function getVisibleAlumniStories(): Collection;

    public function getVisibleGalleryItems(): Collection;

    public function getVisibleProcedures(): Collection;

    public function updateSection(string $key, ?string $value): void;

    public function saveAlumni(array $data, ?int $id = null): void;

    public function deleteAlumni(int $id): void;

    public function saveGallery(array $data, ?int $id = null): void;

    public function deleteGallery(int $id): void;

    public function saveProcedure(array $data, ?int $id = null): void;

    public function deleteProcedure(int $id): void;
}
