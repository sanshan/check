<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GasStation\GasStationIndexRequest;
use App\Http\Requests\GasStation\GasStationStoreRequest;
use App\Http\Requests\GasStation\GasStationUpdateRequest;
use App\Http\Resources\GasStation\GasStationInfoResource;
use App\Http\Resources\GasStation\GasStationResource;
use App\Http\Resources\GasStation\GasStationSelect2Resource;
use App\Models\GasStation;
use DB;
use Exception;
use Yajra\DataTables\Facades\DataTables;


class GasStationController extends BaseController
{

    /**
     * @param GasStationIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(GasStationIndexRequest $request)
    {
        $gasStations = GasStation::with('region')
            ->filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(GasStationSelect2Resource::collection($gasStations), __('Data retrieved successfully.'));
    }

    /**
     * @return mixed
     */
    // Этот метод надо дорабатывать
    public function dataTableIndex()
    {
        $gasStations = GasStation::select([
            'id',
            'number',
            'address',
            'is_shop',
            'it_works',
            'region_id',
            'type_of_gas_station_id',
            DB::raw("CONCAT(dir_name,' ',dir_patronymic,' ',dir_surname) as dir_full_name"),
            'email',
            'phone',
        ])->with('region', 'type');

        return DataTables::eloquent($gasStations)
            ->addColumn('region', function (GasStation $gasStation) {
                return $gasStation->region->title;
            })
            ->addColumn('type', function (GasStation $gasStation) {
                return $gasStation->type->abbreviation;
            })
            ->filterColumn('dir_full_name', function ($query, $keyword) {
                $sql = "CONCAT(dir_name,' ',dir_patronymic,' ',dir_surname) like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();

    }


    /**
     * @param GasStationStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GasStationStoreRequest $request)
    {
        $gasStation = GasStation::create($request->validated());

        return $this->sendResponse(GasStationInfoResource::make($gasStation), __('Data created successfully.'));
    }

    /**
     * @param GasStation $gasStation
     * @return \Illuminate\Http\Response
     */
    public function show(GasStation $gasStation)
    {
        $gasStation->load('region', 'type');

        return $this->sendResponse(GasStationResource::make($gasStation), __('Data retrieved successfully.'));
    }

    /**
     * @param GasStationUpdateRequest $request
     * @param GasStation $gasStation
     * @return \Illuminate\Http\Response
     */
    public function update(GasStationUpdateRequest $request, GasStation $gasStation)
    {
        $gasStation->fill($request->except('gas_station_id'));
        $gasStation->save();

        return $this->sendResponse(GasStationInfoResource::make($gasStation), __('Record updated successfully.'));
    }

    /**
     * @param GasStation $gasStation
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy(GasStation $gasStation)
    {
        $gasStation->delete();

        return $this->sendResponse(GasStationInfoResource::make($gasStation), __('Record deleted successfully.'));
    }
}
