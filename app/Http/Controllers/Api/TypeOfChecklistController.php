<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TypeOfChecklist\TypeOfChecklistIndexRequest;
use App\Http\Requests\TypeOfChecklist\TypeOfChecklistStoreRequest;
use App\Http\Requests\TypeOfChecklist\TypeOfChecklistUpdateRequest;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistInfoResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistResource;
use App\Http\Resources\TypeOfChecklist\TypeOfChecklistSelect2Resource;
use App\Models\TypeOfChecklist;

class TypeOfChecklistController extends BaseController
{

    /**
     * @param TypeOfChecklistIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(TypeOfChecklistIndexRequest $request)
    {
        $typeOfChecklists = TypeOfChecklist::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(TypeOfChecklistSelect2Resource::collection($typeOfChecklists), __('Data retrieved successfully.'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(TypeOfChecklistStoreRequest $request)
    {
        $typeOfChecklist = TypeOfChecklist::create($request->validated());

        return $this->sendResponse(TypeOfChecklistInfoResource::make($typeOfChecklist), __('Data created successfully.'));
    }

    /**
     * @param TypeOfChecklist $typeOfChecklist
     * @return \Illuminate\Http\Response
     */
    public function show(TypeOfChecklist $typeOfChecklist)
    {
        return $this->sendResponse(TypeOfChecklistResource::make($typeOfChecklist), __('Data retrieved successfully.'));
    }

    /**
     * @param TypeOfChecklistUpdateRequest $request
     * @param TypeOfChecklist $typeOfChecklist
     * @return \Illuminate\Http\Response
     */
    public function update(TypeOfChecklistUpdateRequest $request, TypeOfChecklist $typeOfChecklist)
    {
        $typeOfChecklist->fill($request->except('type_of_checklist_id'));
        $typeOfChecklist->save();

        return $this->sendResponse(TypeOfChecklistInfoResource::make($typeOfChecklist), __('Record updated successfully.'));
    }

    /**
     * @param TypeOfChecklist $typeOfChecklist
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TypeOfChecklist $typeOfChecklist)
    {
        $typeOfChecklist->delete();

        return $this->sendResponse(TypeOfChecklistInfoResource::make($typeOfChecklist), __('Record deleted successfully.'));
    }
}
