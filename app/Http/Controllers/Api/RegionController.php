<?php

namespace App\Http\Controllers\Api;

use App\GasStation;
use App\Http\Requests\getUsersFromRegionRequest;
use App\Http\Requests\RegionRequest;
use App\Http\Resources\RegionResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\usersFromRegionResource;
use App\Region;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RegionController extends Controller
{

    /**
     * @param RegionRequest $request
     * @return AnonymousResourceCollection
     * @throws Exception
     */
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

    /**
     * @param getUsersFromRegionRequest $request
     * @return AnonymousResourceCollection
     */
    public function getUsers(getUsersFromRegionRequest $request)
    {
        $title = $request->input('title');
        $gasStation = GasStation::findOrFail($request->gas_station_id);
        $region = $gasStation->region;

        $users = $region->profiles()->when('title', function ($query) use ($title){
            return $query->where('full_name', 'LIKE', "%{$title}%");
        })->get();

        return usersFromRegionResource::collection($users);
    }
}
