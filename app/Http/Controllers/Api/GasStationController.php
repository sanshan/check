<?php

namespace App\Http\Controllers\Api;

use App\GasStation;
use App\Http\Controllers\Controller;
use App\Http\Requests\GasStationRequest;
use App\Http\Resources\GasStationResource;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection as AnonymousResourceCollectionAlias;

class GasStationController extends Controller
{
    /**
     * @param GasStationRequest $request
     * @return AnonymousResourceCollectionAlias
     * @throws Exception
     */
    public function index(GasStationRequest $request)
    {
        if($number = $request->input('number')) {
            $gasStations = GasStation::where('number', 'LIKE', "%$number%")->take(100)->get();
            return GasStationResource::collection($gasStations);
        }
        else {
            $gasStations = GasStation::with('region', 'type', 'users')->get();
            return datatables()->of(GasStationResource::collection($gasStations))
                ->addColumn('DT_RowId', function ($row) {
                    return 'row_' . $row['id'];
                })->toJson();
        }
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
        $gasStation->load('region', 'type');
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
