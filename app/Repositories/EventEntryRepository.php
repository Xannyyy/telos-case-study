<?php

namespace App\Repositories;

use App\Interfaces\Repositories\EventEntryRepositoryInterface;
use App\Models\EventEntry;
use App\Repositories\BaseRepository;

class EventEntryRepository extends BaseRepository implements EventEntryRepositoryInterface
{
    protected $model;

    public function __construct(EventEntry $eventEntry)
    {
        parent::__construct($eventEntry);
    }

    public function findMinimumInitTime()
    {
        return $this->model->min('init_time');
    }

    public function findMaximumEndTime()
    {
        return $this->model->max('end_time');
    }

    public function getHourlyEventCollisions($minInitTimePlusAnHour,)
    {
        return $this->model->where('init_time', '>=', $minInitTimePlusAnHour)
                            ->where('end_time', '<=', $minInitTimePlusAnHour)
                            ->count();
    }

    public function count(){
        return $this->model->count();
    }
}