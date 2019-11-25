<?php


namespace App\Classes\Tasks;


use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ChecksGenerator
{
    protected $gasStations;

    public function __construct(Collection $models)
    {
        $this->gasStations = $models;
    }

    public function run()
    {
        $this->gasStations->each(function($item, $key){
            \Log::info($item);
        });
    }

//    private function createCheck($gasStation)
//    {
//        $task = Task::create([
//            'start_date'           => Carbon::make($request->start_date),
//            'end_date'             => Carbon::make($request->end_date),
//            'region_id'            => $request->region_id,
//            'gas_station_id'       => $request->gas_station_id,
//            'type_of_checklist_id' => $request->type_of_checklists_id,
//            'user_id'              => $request->user_id,
//        ]);
//    }

}
