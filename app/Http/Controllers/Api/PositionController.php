<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Position\PositionIndexRequest;
use App\Http\Requests\Position\PositionStoreRequest;
use App\Http\Requests\Position\PositionUpdateRequest;
use App\Http\Resources\Position\PositionDTResource;
use App\Http\Resources\Position\PositionInfoResource;
use App\Http\Resources\Position\PositionResource;
use App\Http\Resources\Position\PositionSelect2Resource;
use App\Models\Position;


class PositionController extends Controller
{

    public function index(PositionIndexRequest $request)
    {
        $positions = Position::filter($request)
            ->take(10)
            ->get();

        return PositionSelect2Resource::collection($positions);
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
     * @return PositionInfoResource
     */
    public function store(PositionStoreRequest $request)
    {
        $position = Position::create($request->validated());
        return PositionInfoResource::make($position);
    }

    /**
     * @param Position $position
     * @return PositionResource
     */
    public function show(Position $position): PositionResource
    {
        return PositionResource::make($position);
    }

    /**
     * @param PositionUpdateRequest $request
     * @param Position $position
     * @return PositionInfoResource
     */
    public function update(PositionUpdateRequest $request, Position $position)
    {
        $position->fill($request->except('position_id'));
        $position->save();
        return PositionInfoResource::make($position);
    }

    /**
     * @param Position $position
     * @return PositionInfoResource
     * @throws \Exception
     */
    public function destroy(Position $position)
    {
        $position->delete();
        return PositionInfoResource::make($position);
    }
}
