<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\EventEntryRepositoryInterface;
use App\Interfaces\Services\GraphServiceInterface;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    private $graphService;
    private $eventEntryRepository;

    public function __construct(
        EventEntryRepositoryInterface $eventEntryRepository,
        GraphServiceInterface $graphService
    )
    {
        $this->eventEntryRepository = $eventEntryRepository;
        $this->graphService = $graphService;
    }

    public function generateGraph(Request $request){
        $this->graphService->generateGraph($request->get('zoom'));
    }

    public function generateLinearRegression(){
        $this->graphService->generateLinearRegression();
    }

    public function viewGraph(){
        return view('graph');
    }
}
