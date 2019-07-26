<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PositionRequest;
use App\Http\Resources\PositionResource;
use App\Position;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PositionController extends Controller
{

    /**
     * @return AnonymousResourceCollection
     */
    public function index() : AnonymousResourceCollection
    {
        $positions = Position::all();
        return PositionResource::collection($positions);
    }

    /**
     * @param PositionRequest $request
     * @return PositionResource
     */
    public function store(PositionRequest $request) : PositionResource
    {
        $region = Position::create($request->validated());
        return PositionResource::make($region);
    }

    /**
     * @param Position $position
     * @return PositionResource
     */
    public function show(Position $position) : PositionResource
    {
        return PositionResource::make($position);
    }

    /**
     * @param PositionRequest $request
     * @param Position $position
     * @return PositionResource
     */
    public function update(PositionRequest $request, Position $position) : PositionResource
    {
        $position->fill($request->except('position_id'));
        $position->save();
        return PositionResource::make($position);
    }

    /**
     * @param Position $position
     * @return PositionResource
     * @throws Exception
     */
    public function destroy(Position $position) : PositionResource
    {
        $position->delete();
        return PositionResource::make($position);
    }
}
