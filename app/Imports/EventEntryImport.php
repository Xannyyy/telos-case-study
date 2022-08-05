<?php

namespace App\Imports;

use App\Models\EventEntry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EventEntryImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new EventEntry([
            'id' => $row['id'],
            'init_time' => $row['init_time'],
            'end_time' => $row['end_time'],
        ]);
    }
}
