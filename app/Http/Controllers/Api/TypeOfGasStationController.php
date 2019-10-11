<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeOfGasStation\TypeOfGasStationIndexRequest;
use App\Http\Requests\TypeOfGasStation\TypeOfGasStationStoreRequest;
use App\Http\Requests\TypeOfGasStation\TypeOfGasStationUpdateRequest;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationInfoResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationSelect2Resource;
use App\Models\TypeOfGasStation;

class TypeOfGasStationController extends Controller
{
    public function index(TypeOfGasStationIndexRequest $request)
    {
        $typeOfGasStations = TypeOfGasStation::filter($request)
            ->take(10)
            ->get();
        return TypeOfGasStationSelect2Resource::collection($typeOfGasStations);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $typeOfGasStations = TypeOfGasStation::all();
        return datatables()->of(TypeOfGasStationResource::collection($typeOfGasStations))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();
    }

    /**
     * @param TypeOfGasStationStoreRequest $request
     * @return TypeOfGasStationInfoResource
     */
    public function store(TypeOfGasStationStoreRequest $request): TypeOfGasStationInfoResource
    {
        $typeOfGasStation = TypeOfGasStation::create($request->validated());
        return TypeOfGasStationInfoResource::make($typeOfGasStation);
    }

    /**
     * @param TypeOfGasStation $typeOfGasStation
     * @return TypeOfGasStationResource
     */
    public function show(TypeOfGasStation $typeOfGasStation): TypeOfGasStationResource
    {
        return TypeOfGasStationResource::make($typeOfGasStation);
    }

    /**
     * @param TypeOfGasStationUpdateRequest $request
     * @param TypeOfGasStation $typeOfGasStation
     * @return TypeOfGasStationInfoResource
     */
    public function update(TypeOfGasStationUpdateRequest $request, TypeOfGasStation $typeOfGasStation): TypeOfGasStationInfoResource
    {
        $typeOfGasStation->fill($request->except('type_of_gas_station_id'));
        $typeOfGasStation->save();
        return TypeOfGasStationInfoResource::make($typeOfGasStation);
    }

    /**
     * @param TypeOfGasStation $typeOfGasStation
     * @return TypeOfGasStationInfoResource
     * @throws \Exception
     */
    public function destroy(TypeOfGasStation $typeOfGasStation): TypeOfGasStationInfoResource
    {
        $typeOfGasStation->delete();
        return TypeOfGasStationInfoResource::make($typeOfGasStation);
    }
}
