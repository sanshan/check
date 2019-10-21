<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TypeOfGasStation\TypeOfGasStationIndexRequest;
use App\Http\Requests\TypeOfGasStation\TypeOfGasStationStoreRequest;
use App\Http\Requests\TypeOfGasStation\TypeOfGasStationUpdateRequest;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationInfoResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationResource;
use App\Http\Resources\TypeOfGasStation\TypeOfGasStationSelect2Resource;
use App\Models\TypeOfGasStation;

class TypeOfGasStationController extends BaseController
{

    /**
     * @param TypeOfGasStationIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(TypeOfGasStationIndexRequest $request)
    {
        $typeOfGasStations = TypeOfGasStation::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(TypeOfGasStationSelect2Resource::collection($typeOfGasStations), __('Data retrieved successfully.'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(TypeOfGasStationStoreRequest $request)
    {
        $typeOfGasStation = TypeOfGasStation::create($request->validated());

        return $this->sendResponse(TypeOfGasStationInfoResource::make($typeOfGasStation), __('Data created successfully.'));
    }

    /**
     * @param TypeOfGasStation $typeOfGasStation
     * @return \Illuminate\Http\Response
     */
    public function show(TypeOfGasStation $typeOfGasStation)
    {
        return $this->sendResponse(TypeOfGasStationResource::make($typeOfGasStation), __('Data retrieved successfully.'));
    }

    /**
     * @param TypeOfGasStationUpdateRequest $request
     * @param TypeOfGasStation $typeOfGasStation
     * @return \Illuminate\Http\Response
     */
    public function update(TypeOfGasStationUpdateRequest $request, TypeOfGasStation $typeOfGasStation)
    {
        $typeOfGasStation->fill($request->except('type_of_gas_station_id'));
        $typeOfGasStation->save();

        return $this->sendResponse(TypeOfGasStationInfoResource::make($typeOfGasStation), __('Record updated successfully.'));
    }

    /**
     * @param TypeOfGasStation $typeOfGasStation
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TypeOfGasStation $typeOfGasStation)
    {
        $typeOfGasStation->delete();

        return $this->sendResponse(TypeOfGasStationInfoResource::make($typeOfGasStation), __('Record deleted successfully.'));
    }
}
