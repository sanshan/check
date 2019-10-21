<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Region\RegionIndexRequest;
use App\Http\Requests\Region\RegionStoreRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use App\Http\Resources\Region\RegionInfoResource;
use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\Region\RegionSelect2Resource;
use App\Models\Region;


class RegionController extends BaseController
{

    /**
     * @param RegionIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(RegionIndexRequest $request)
    {
        $regions = Region::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(RegionSelect2Resource::collection($regions), __('Data retrieved successfully.'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $regions = Region::all();
        return datatables()->of(RegionResource::collection($regions))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();
    }

    /**
     * @param RegionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionStoreRequest $request)
    {
        $region = Region::create($request->validated());

        return $this->sendResponse(RegionInfoResource::make($region), __('Data created successfully.'));
    }


    /**
     * @param Region $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        return $this->sendResponse(RegionResource::make($region), __('Data retrieved successfully.'));
    }

    /**
     * @param RegionUpdateRequest $request
     * @param Region $region
     * @return \Illuminate\Http\Response
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        $region->fill($request->except(['region_id']));
        $region->save();

        return $this->sendResponse(RegionInfoResource::make($region), __('Record updated successfully.'));
    }

    /**
     * @param Region $region
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return $this->sendResponse(RegionInfoResource::make($region), __('Record deleted successfully.'));
    }
}
