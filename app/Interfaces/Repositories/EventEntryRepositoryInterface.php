<?php

namespace App\Interfaces\Repositories;

interface EventEntryRepositoryInterface
{
    public function findMinimumInitTime();
    public function findMaximumEndTime();
    public function getHourlyEventCollisions($minInitTimePlusAnHour);
    public function count();
}