<?php

namespace App\Http\Controllers\Api;

use App\GasStation;
use App\Http\Controllers\Controller;
use App\Http\Requests\GasStationRequest;
use App\Http\Resources\GasStationResource;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GasStationController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index() : AnonymousResourceCollection
    {
        $gasStations = GasStation::all();
        return GasStationResource::collection($gasStations);
    }

    /**
     * @param GasStationRequest $request
     * @return GasStationResource
     */
    public function store(GasStationRequest $request) : GasStationResource
    {
        $gasStation = GasStation::create($request->validated());
        return GasStationResource::make($gasStation);
    }

    /**
     * @param GasStation $gasStation
     * @return GasStationResource
     */
    public function show(GasStation $gasStation) : GasStationResource
    {
        return GasStationResource::make($gasStation);
    }

    /**
     * @param GasStationRequest $request
     * @param GasStation $gasStation
     * @return GasStationResource
     */
    public function update(GasStationRequest $request, GasStation $gasStation) : GasStationResource
    {
        $gasStation->fill($request->except('gas_station_id'));
        $gasStation->save();
        return GasStationResource::make($gasStation);
    }

    /**
     * @param GasStation $gasStation
     * @return GasStationResource
     * @throws Exception
     */
    public function destroy(GasStation $gasStation) : GasStationResource
    {
        $gasStation->delete();
        return GasStationResource::make($gasStation);
    }
}
