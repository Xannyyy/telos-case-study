<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\EventEntryRepositoryInterface;
use App\Interfaces\Services\GraphServiceInterface;
use App\Interfaces\Services\UploadServiceInterface;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private $uploadService;
    private $eventEntryRepository;

    public function __construct(
        UploadServiceInterface $uploadService,
        EventEntryRepositoryInterface $eventEntryRepository
    )
    {
        $this->uploadService = $uploadService;
        $this->eventEntryRepository = $eventEntryRepository;
    }

    public function uploadCsvForm()
    {
        $hasEntries = $this->eventEntryRepository->count();

        return view('file.uploadCSV', compact('hasEntries'));
    }

    public function uploadCSV(Request $request)
    {
        $hasEntries = $this->uploadService->uploadCsvFile($request);

        return view('file.uploadCSV', compact('hasEntries'));
    }

    public function generateGraph(){

        return 'zani';
    }
}
