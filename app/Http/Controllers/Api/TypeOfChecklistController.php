<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeOfChecklist\TypeOfChecklistIndexRequest;
use App\Http\Requests\TypeOfChecklist\TypeOfChecklistStoreRequest;
use App\Http\Requests\TypeOfChecklist\TypeOfChecklistUpdateRequest;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistInfoResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistSelect2Resource;
use App\Models\TypeOfChecklist;

class TypeOfChecklistController extends Controller
{

    /**
     * @param TypeOfChecklistIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TypeOfChecklistIndexRequest $request)
    {
        $typeOfChecklists = TypeOfChecklist::filter($request)
            ->take(10)
            ->get();

        return TypeOfChecklistSelect2Resource::collection($typeOfChecklists);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $typeOfChecklists = TypeOfChecklist::get();

        return datatables()->of(TypeOfChecklistResource::collection($typeOfChecklists))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })->toJson();
    }

    /**
     * @param TypeOfChecklistStoreRequest $request
     * @return TypeOfChecklistInfoResource
     */
    public function store(TypeOfChecklistStoreRequest $request): TypeOfChecklistInfoResource
    {
        $typeOfChecklist = TypeOfChecklist::create($request->validated());
        return TypeOfChecklistInfoResource::make($typeOfChecklist);
    }

    /**
     * @param TypeOfChecklist $typeOfChecklist
     * @return TypeOfChecklistResource
     */
    public function show(TypeOfChecklist $typeOfChecklist): TypeOfChecklistResource
    {
        return TypeOfChecklistResource::make($typeOfChecklist);
    }

    /**
     * @param TypeOfChecklistUpdateRequest $request
     * @param TypeOfChecklist $typeOfChecklist
     * @return TypeOfChecklistInfoResource
     */
    public function update(TypeOfChecklistUpdateRequest $request, TypeOfChecklist $typeOfChecklist): TypeOfChecklistInfoResource
    {
        $typeOfChecklist->fill($request->except('type_of_checklist_id'));
        $typeOfChecklist->save();
        return TypeOfChecklistInfoResource::make($typeOfChecklist);
    }

    /**
     * @param TypeOfChecklist $typeOfChecklist
     * @return TypeOfChecklistInfoResource
     * @throws \Exception
     */
    public function destroy(TypeOfChecklist $typeOfChecklist): TypeOfChecklistInfoResource
    {
        $typeOfChecklist->delete();
        return TypeOfChecklistInfoResource::make($typeOfChecklist);
    }
}
