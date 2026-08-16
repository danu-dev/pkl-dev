<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\LandingRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroyAlumniRequest;
use App\Http\Requests\Admin\DestroyGalleryRequest;
use App\Http\Requests\Admin\DestroyProcedureRequest;
use App\Http\Requests\Admin\StoreAlumniRequest;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\StoreProcedureRequest;
use App\Http\Requests\Admin\UpdateLandingSectionRequest;
use App\Http\Resources\AlumniStoryResource;
use App\Http\Resources\GalleryItemResource;
use App\Http\Resources\ProcedureResource;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class LandingCmsController extends Controller
{
    public function __construct(
        protected LandingRepositoryInterface $landingRepository,
        protected FileUploadService $fileUploadService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/LandingCms/Index', [
            'sections' => $this->landingRepository->getAllSectionsGrouped(),
            'alumni' => AlumniStoryResource::collection($this->landingRepository->getVisibleAlumniStories()),
            'gallery' => GalleryItemResource::collection($this->landingRepository->getVisibleGalleryItems()),
            'procedures' => ProcedureResource::collection($this->landingRepository->getVisibleProcedures()),
        ]);
    }

    public function updateSections(UpdateLandingSectionRequest $request): RedirectResponse
    {
        foreach ($request->validated('sections') as $key => $value) {
            $this->landingRepository->updateSection($key, $value);
        }

        return redirect()->back()->with('success', 'Konten seksi landing page berhasil diperbarui.');
    }

    public function storeAlumni(StoreAlumniRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $this->fileUploadService->uploadImage($request->file('photo'), 'alumni');
        }

        unset($validated['photo']);

        $this->landingRepository->saveAlumni($validated, $request->input('id'));

        return redirect()->back()->with('success', 'Data alumni berhasil disimpan.');
    }

    public function destroyAlumni(DestroyAlumniRequest $request, int $id): RedirectResponse
    {
        $this->landingRepository->deleteAlumni($id);

        return redirect()->back()->with('success', 'Data alumni berhasil dihapus.');
    }

    public function storeGallery(StoreGalleryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->fileUploadService->uploadImage($request->file('image'), 'gallery');
        } elseif ($request->filled('image_url')) {
            $validated['image_path'] = $request->input('image_url');
        }

        unset($validated['image'], $validated['image_url']);

        $this->landingRepository->saveGallery($validated, $request->input('id'));

        return redirect()->back()->with('success', 'Item galeri berhasil disimpan.');
    }

    public function destroyGallery(DestroyGalleryRequest $request, int $id): RedirectResponse
    {
        $this->landingRepository->deleteGallery($id);

        return redirect()->back()->with('success', 'Item galeri berhasil dihapus.');
    }

    public function storeProcedure(StoreProcedureRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $this->landingRepository->saveProcedure($validated, $request->input('id'));

        return redirect()->back()->with('success', 'Prosedur berhasil disimpan.');
    }

    public function destroyProcedure(DestroyProcedureRequest $request, int $id): RedirectResponse
    {
        $this->landingRepository->deleteProcedure($id);

        return redirect()->back()->with('success', 'Prosedur berhasil dihapus.');
    }
}
