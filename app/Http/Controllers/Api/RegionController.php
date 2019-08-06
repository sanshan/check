<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegionRequest;
use App\Http\Resources\RegionResource;
use App\Http\Controllers\Controller;
use App\Region;
use Exception;

class RegionController extends Controller
{

    public function index(RegionRequest $request)
    {
        if($title = $request->input('title')) {
            $regions = Region::where('title', 'LIKE', "%$title%")->get();
            return RegionResource::collection($regions);
        }
        else {
            $regions = Region::all();
            return datatables()->of(RegionResource::collection($regions))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })->toJson();
        }
    }

    /**
     * @param RegionRequest $request
     * @return RegionResource
     */
    public function store(RegionRequest $request) : RegionResource
    {
        $region = Region::create($request->validated());
        return RegionResource::make($region);
    }

    /**
     * @param Region $region
     * @return RegionResource
     */
    public function show(Region $region) : RegionResource
    {
        return RegionResource::make($region);
    }

    /**
     * @param RegionRequest $request
     * @param Region $region
     * @return RegionResource
     */
    public function update(RegionRequest $request, Region $region) : RegionResource
    {
        $region->fill($request->except(['region_id']));
        $region->save();
        return RegionResource::make($region);
    }

    /**
     * @param Region $region
     * @return RegionResource
     * @throws Exception
     */
    public function destroy(Region $region) : RegionResource
    {
        $region->delete();
        return RegionResource::make($region);
    }
}
