<?php

namespace App\Services;

use App\Interfaces\Services\UploadServiceInterface;
use App\Imports\EventEntryImport;
use App\Interfaces\Repositories\EventEntryRepositoryInterface;
use App\Traits\FileManagerTrait;
use Maatwebsite\Excel\Facades\Excel;

class UploadService implements UploadServiceInterface
{
    use FileManagerTrait;

    protected $eventEntryRepository;

    public function __construct(EventEntryRepositoryInterface $eventEntryRepository)
    {
        $this->eventEntryRepository = $eventEntryRepository;
    }

    public function uploadCsvFile($request)
    {
        Excel::import(new EventEntryImport, $request->file);

        return $this->eventEntryRepository->count();
    }

    public function getGraph(){
        require_once __DIR__.'/../Graphing/src/jpgraph.php';
        require_once __DIR__.'/../Graphing/src/jpgraph_line.php';

        $minimumInitTime = $this->eventEntryRepository->findMinimumInitTime();
        $maximumEndTime = $this->eventEntryRepository->findMaximumEndTime();

        $startInitTimeForCollisions = $minimumInitTime + 5;

        $collectionOfFiveSecondIntervalEventCollisions = [];
        $fiveSecondIntervalEventTimes = [];
        $maxIntervalValues = 0;
        $maxCollisions = 0;

        for($i = 0; $startInitTimeForCollisions <= $maximumEndTime; $i++){
            $hourlyCollisions = $this->eventEntryRepository->getHourlyEventCollisions($startInitTimeForCollisions);
            $collectionOfFiveSecondIntervalEventCollisions[] = $hourlyCollisions;
            $fiveSecondIntervalEventTimes[] = $startInitTimeForCollisions;

            if($hourlyCollisions > $maxCollisions){
                $maxCollisions = $hourlyCollisions;
            }

            $startInitTimeForCollisions += 5;
            $maxIntervalValues++;
        }

        $graph = new \Graph(1000, 800);
        $graph->SetScale('intlin');

        $lineplot=new \LinePlot($collectionOfFiveSecondIntervalEventCollisions, $fiveSecondIntervalEventTimes);
        $graph->Add($lineplot);

        return $graph->Stroke();
    }
}