<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use Carbon\Carbon;

class TaskController extends BaseController
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with(['region', 'station', 'type', 'user.profile'])->get();

        return $this->sendResponse(TaskResource::collection($tasks), __('Data retrieved successfully.'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $tasks = Task::with(['region', 'station', 'type', 'user.profile']);
        //return response()->json($tasks);
        return datatables()->of($tasks)
            ->editColumn('start_date', function ($task) {
                return [
                    'display'   => $task->start_date->format('d/m/Y'),
                    'timestamp' => $task->start_date->timestamp
                ];
            })
            ->editColumn('end_date', function ($task) {
                return [
                    'display'   => $task->end_date->format('d/m/Y'),
                    'timestamp' => $task->end_date->timestamp
                ];
            })
            ->filterColumn('start_date', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(start_date,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
            })
            ->filterColumn('end_date', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(end_date,'%d/%m/%Y') LIKE ?", ["%$keyword%"]);
            })
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();
    }

    /**
     * @param TaskStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStoreRequest $request)
    {
        $gasStation = Task::create([
            'start_date'           => Carbon::make($request->start_date),
            'end_date'             => Carbon::make($request->end_date),
            'region_id'            => $request->region_id,
            'gas_station_id'       => $request->gas_station_id,
            'type_of_checklist_id' => $request->type_of_checklists_id,
            'user_id'              => $request->user_id,
        ]);

        return $this->sendResponse(TaskResource::make($gasStation), __('Data created successfully.'));
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $task->load(['region', 'station', 'type', 'user.profile']);

        return $this->sendResponse(TaskResource::make($task), __('Data retrieved successfully.'));
    }

    /**
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $task->start_date = Carbon::make($request->start_date);
        $task->end_date = Carbon::make($request->end_date);
        $task->region_id = $request->region_id;
        $task->gas_station_id = $request->gas_station_id;
        $task->type_of_checklist_id = $request->type_of_checklists_id;
        $task->user_id = $request->user_id;
        $task->save();

        return $this->sendResponse(TaskResource::make($task), __('Record updated successfully.'));
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return $this->sendResponse(TaskResource::make($task), __('Record deleted successfully.'));
    }
}
