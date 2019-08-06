<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeOfGasStationRequest;
use App\Http\Resources\TypeOfGasStationResource;
use App\TypeOfGasStation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TypeOfGasStationController extends Controller
{

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function index() : JsonResponse
    {
        $typeOfGasStations = TypeOfGasStation::all();
        return datatables()->of(TypeOfGasStationResource::collection($typeOfGasStations))
            ->addColumn('DT_RowId', function($row){
                return 'row_'.$row['id'];
            })->toJson();
    }

    /**
     * @param TypeOfGasStationRequest $request
     * @return TypeOfGasStationResource
     */
    public function store(TypeOfGasStationRequest $request) : TypeOfGasStationResource
    {
        $typeOfGasStation = TypeOfGasStation::create($request->validated());
        return TypeOfGasStationResource::make($typeOfGasStation);
    }

    /**
     * @param TypeOfGasStation $typeOfGasStation
     * @return TypeOfGasStationResource
     */
    public function show(TypeOfGasStation $typeOfGasStation) : TypeOfGasStationResource
    {
        return TypeOfGasStationResource::make($typeOfGasStation);
    }

    /**
     * @param TypeOfGasStationRequest $request
     * @param TypeOfGasStation $typeOfGasStation
     * @return TypeOfGasStationResource
     */
    public function update(TypeOfGasStationRequest $request, TypeOfGasStation $typeOfGasStation) : TypeOfGasStationResource
    {
        $typeOfGasStation->fill($request->except('type_of_gas_station_id'));
        $typeOfGasStation->save();
        return TypeOfGasStationResource::make($typeOfGasStation);
    }

    /**
     * @param TypeOfGasStation $typeOfGasStation
     * @return TypeOfGasStationResource
     * @throws Exception
     */
    public function destroy(TypeOfGasStation $typeOfGasStation) : TypeOfGasStationResource
    {
        $typeOfGasStation->delete();
        return TypeOfGasStationResource::make($typeOfGasStation);
    }
}
