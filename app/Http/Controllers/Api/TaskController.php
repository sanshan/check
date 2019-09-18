<?php

namespace App\Http\Controllers\Api;

use App\GasStation;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Task;
use Carbon\Carbon;
use Exception;

class TaskController extends Controller
{

    /**
     * @return mixed
     * @throws Exception
     */
    public function index()
    {
        $tasks = Task::with(['region', 'station', 'type', 'user.profile']);
        return datatables()->of($tasks)
            ->editColumn('start_date', function ($task) {
                return [
                    'display' => $task->start_date->format('d/m/Y'),
                    'timestamp' => $task->start_date->timestamp
                ];
            })
            ->editColumn('end_date', function ($task) {
                return [
                    'display' => $task->end_date->format('d/m/Y'),
                    'timestamp' => $task->end_date->timestamp
                ];
            })
            ->filterColumn('start_date', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(start_date,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
            })
            ->filterColumn('end_date', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(end_date,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
            })
            ->addColumn('DT_RowId', function($row){
                return 'row_'.$row['id'];
            })->toJson();
    }

    /**
     * @param TaskRequest $request
     * @return TaskResource
     */
    public function store(TaskRequest $request) : TaskResource
    {
        $gasStation = Task::create([
            'start_date'                => Carbon::make($request->start_date),
            'end_date'                  => Carbon::make($request->end_date),
            'region_id'                 => GasStation::findOrFail($request->gas_station_id)->region->id,
            'gas_station_id'            => $request->gas_station_id,
            'type_of_checklist_id'      => $request->type_of_checklists_id,
            'user_id'                   => $request->user_id,
        ]);
        return TaskResource::make($gasStation);
    }

    /**
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task) : TaskResource
    {
        $task->load(['region', 'station', 'type', 'user.profile']);
        return TaskResource::make($task);
    }

    /**
     * @param TaskRequest $request
     * @param Task $task
     * @return TaskResource
     */
    public function update(TaskRequest $request, Task $task) : TaskResource
    {
        $task->start_date                = Carbon::make($request->start_date);
        $task->end_date                  = Carbon::make($request->end_date);
        $task->region_id                 = GasStation::findOrFail($request->gas_station_id)->region->id;
        $task->gas_station_id            = $request->gas_station_id;
        $task->type_of_checklist_id      = $request->type_of_checklists_id;
        $task->user_id                   = $request->user_id;
        $task->save();
        return TaskResource::make($task);
    }

    /**
     * @param Task $task
     * @return TaskResource
     * @throws Exception
     */
    public function destroy(Task $task) : TaskResource
    {
        $task->delete();
        return TaskResource::make($task);
    }
}
