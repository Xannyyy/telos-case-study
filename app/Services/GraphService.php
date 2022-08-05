<?php

namespace App\Services;

use App\Enums\GraphSettings;
use App\Interfaces\Repositories\EventEntryRepositoryInterface;
use App\Interfaces\Services\GraphServiceInterface;

class GraphService implements GraphServiceInterface
{
    protected $eventEntryRepository;

    public function __construct(EventEntryRepositoryInterface $eventEntryRepository)
    {
        $this->eventEntryRepository = $eventEntryRepository;
    }

    public function generateGraph($zoom, $min = null, $max = null){
        require_once __DIR__.'/../Graphing/src/jpgraph.php';
        require_once __DIR__.'/../Graphing/src/jpgraph_line.php';

        $minimumInitTime = $min ?? $this->eventEntryRepository->findMinimumInitTime();
        $maximumEndTime = $max ?? $this->eventEntryRepository->findMaximumEndTime();
        $startInitTimeForCollisions = $minimumInitTime + 5;

        $graphData = $this->getGraphData($startInitTimeForCollisions, $maximumEndTime);
        $graph = new \Graph(GraphSettings::WIDTH, GraphSettings::HEIGHT);
        $graph->SetScale('intlin');

        if($zoom){
            array_splice($graphData['collectionOfFiveSecondIntervalEventCollisions'], 0, -$zoom);
            array_splice($graphData['fiveSecondIntervalEventTimes'], 0, -$zoom);
        }

        $lineplot = new \LinePlot($graphData['collectionOfFiveSecondIntervalEventCollisions'], $graphData['fiveSecondIntervalEventTimes']);
        $graph->Add($lineplot);

        return $graph->Stroke();
    }

    private function getGraphData($startInitTimeForCollisions, $maximumEndTime){
        $collectionOfFiveSecondIntervalEventCollisions = [];
        $fiveSecondIntervalEventTimes = [];

        for($i = 0; $startInitTimeForCollisions <= $maximumEndTime; $i++){
            $hourlyCollisions = $this->eventEntryRepository->getHourlyEventCollisions($startInitTimeForCollisions);
            $collectionOfFiveSecondIntervalEventCollisions[] = $hourlyCollisions;
            $fiveSecondIntervalEventTimes[] = $startInitTimeForCollisions;

            $startInitTimeForCollisions += 5;
        }

        return [
            'fiveSecondIntervalEventTimes' => $fiveSecondIntervalEventTimes,
            'collectionOfFiveSecondIntervalEventCollisions' => $collectionOfFiveSecondIntervalEventCollisions
        ];
    }

    public function generateLinearRegression() {
        require_once __DIR__.'/../Graphing/src/jpgraph.php';
        require_once __DIR__.'/../Graphing/src/jpgraph_scatter.php';
        require_once __DIR__.'/../Graphing/src/jpgraph_line.php';
        require_once __DIR__.'/../Graphing/src/jpgraph_utils.inc.php';

        $minimumInitTime = $this->eventEntryRepository->findMinimumInitTime();
        $maximumEndTime = $this->eventEntryRepository->findMaximumEndTime();
        $startInitTimeForCollisions = $minimumInitTime + 5;

        $graphData = $this->getGraphData($startInitTimeForCollisions, $maximumEndTime);


        $lr = new \LinearRegression($graphData['collectionOfFiveSecondIntervalEventCollisions'], $graphData['fiveSecondIntervalEventTimes']);
        list( $stderr, $corr ) = $lr->GetStat();
        list( $xd, $yd ) = $lr->GetY(0,19);

        $graph = new \Graph(GraphSettings::WIDTH,GraphSettings::HEIGHT);
        $graph->SetScale('linlin');

        $graph->title->Set("Linear regression");
        $graph->title->SetFont(FF_ARIAL,FS_BOLD,14);

        $graph->subtitle->Set('(stderr='.sprintf('%.2f',$stderr).', corr='.sprintf('%.2f',$corr).')');
        $graph->subtitle->SetFont(FF_ARIAL,FS_NORMAL,12);

        $graph->xaxis->SetPos('min');

        $sp1 = new \ScatterPlot($graphData['fiveSecondIntervalEventTimes'], $graphData['collectionOfFiveSecondIntervalEventCollisions']);
        $sp1->mark->SetType(MARK_FILLEDCIRCLE);
        $sp1->mark->SetFillColor("red");
        $sp1->SetColor("blue");
        $sp1->SetWeight(3);
        $sp1->mark->SetWidth(4);

        $lplot = new \LinePlot($yd);
        $lplot->SetWeight(2);
        $lplot->SetColor('navy');

        $graph->Add($sp1);
        $graph->Add($lplot);

        $graph->Stroke();
    }

    public function generateInterpolationGraph(){
        require_once __DIR__.'/../Graphing/src/jpgraph.php';
        require_once __DIR__.'/../Graphing/src/jpgraph_contour.php';

        $data = array(
            array ( 12,7,3,15 ),
            array ( 18,5,1, 9 ),
            array ( 13,9,5,12),
            array (  5,3,8, 9 ),
            array (  1,8,5, 7 ));

        $graph = new \Graph(350,250);
        $graph->SetScale('intint');

        $graph->SetAxisStyle(AXSTYLE_BOXOUT);

        $graph->SetMargin(30,100,40,30);

        $graph->title->Set('Basic contour plot with multiple axis');
        $graph->title->SetFont(FF_ARIAL,FS_BOLD,12);

        $cp = new \ContourPlot($data,10,1);

        $cp->ShowLegend();

        $graph->Add($cp);

        $graph->Stroke();

    }
}