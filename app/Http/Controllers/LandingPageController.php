<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\LandingRepositoryInterface;
use App\Http\Resources\AlumniStoryResource;
use App\Http\Resources\GalleryItemResource;
use App\Http\Resources\ProcedureResource;
use Inertia\Inertia;
use Inertia\Response;

class LandingPageController extends Controller
{
    public function __construct(
        protected LandingRepositoryInterface $landingRepository
    ) {}

    public function __invoke(): Response
    {
        return Inertia::render('Welcome', [
            'sections' => $this->landingRepository->getAllSectionsGrouped(),
            'alumni' => AlumniStoryResource::collection($this->landingRepository->getVisibleAlumniStories()),
            'gallery' => GalleryItemResource::collection($this->landingRepository->getVisibleGalleryItems()),
            'procedures' => ProcedureResource::collection($this->landingRepository->getVisibleProcedures()),
        ]);
    }
}
