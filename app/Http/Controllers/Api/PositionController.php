<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Position\PositionIndexRequest;
use App\Http\Requests\Position\PositionStoreRequest;
use App\Http\Requests\Position\PositionUpdateRequest;
use App\Http\Resources\Position\PositionDTResource;
use App\Http\Resources\Position\PositionInfoResource;
use App\Http\Resources\Position\PositionResource;
use App\Http\Resources\Position\PositionSelect2Resource;
use App\Models\Position;


class PositionController extends BaseController
{

    public function index(PositionIndexRequest $request)
    {
        $positions = Position::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(PositionSelect2Resource::collection($positions), __('Data retrieved successfully.'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $positions = Position::get();

        return datatables()->of(PositionDTResource::collection($positions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();
    }

    /**
     * @param PositionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionStoreRequest $request)
    {
        $position = Position::create($request->validated());

        return $this->sendResponse(PositionInfoResource::make($position), __('Record created successfully.'));
    }

    /**
     * @param Position $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return $this->sendResponse(PositionResource::make($position), __('Data retrieved successfully.'));
    }

    /**
     * @param PositionUpdateRequest $request
     * @param Position $position
     * @return \Illuminate\Http\Response
     */
    public function update(PositionUpdateRequest $request, Position $position)
    {
        $position->fill($request->except('position_id'));
        $position->save();

        return $this->sendResponse(PositionInfoResource::make($position), __('Record updated successfully.'));
    }

    /**
     * @param Position $position
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return $this->sendResponse(PositionInfoResource::make($position), __('Record deleted successfully.'));
    }
}
