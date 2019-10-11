<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Region\RegionIndexRequest;
use App\Http\Requests\Region\RegionStoreRequest;
use App\Http\Requests\Region\RegionUpdateRequest;
use App\Http\Resources\Region\RegionInfoResource;
use App\Http\Resources\Region\RegionResource;
use App\Http\Resources\Region\RegionSelect2Resource;
use App\Http\Resources\Region\usersFromRegionResource;
use App\Models\Region;
use Illuminate\Http\Request;


class RegionController extends Controller
{

    public function index(RegionIndexRequest $request)
    {
        $regions = Region::filter($request)
            ->take(10)
            ->get();
        return RegionSelect2Resource::collection($regions);
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
     * @return RegionInfoResource
     */
    public function store(RegionStoreRequest $request)
    {
        $region = Region::create($request->validated());
        return RegionInfoResource::make($region);
    }


    /**
     * @param Region $region
     * @return RegionResource
     */
    public function show(Region $region): RegionResource
    {
        return RegionResource::make($region);
    }

    /**
     * @param RegionUpdateRequest $request
     * @param Region $region
     * @return RegionInfoResource
     */
    public function update(RegionUpdateRequest $request, Region $region)
    {
        $region->fill($request->except(['region_id']));
        $region->save();
        return RegionInfoResource::make($region);
    }

    /**
     * @param Region $region
     * @return RegionInfoResource
     * @throws \Exception
     */
    public function destroy(Region $region)
    {
        $region->delete();
        return RegionInfoResource::make($region);
    }

    // Этот метод не нужен. Надо добавить фильтр и использовать UserController@index
    public function getUsers(Request $request, Region $region)
    {
        $title = $request->input('title');

        $users = $region->profiles()->when('title', function ($query) use ($title) {
            return $query->where('full_name', 'LIKE', "%{$title}%");
        })->get();

        return usersFromRegionResource::collection($users);
    }
}
