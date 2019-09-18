<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeOfChecklistRequest;
use App\Http\Resources\TypeOfChecklistResource;
use App\TypeOfChecklist;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TypeOfChecklistController extends Controller
{

    /**
     * @param TypeOfChecklistRequest $request
     * @return mixed
     * @throws Exception
     */
    public function index(TypeOfChecklistRequest $request)
    {
        $title = $request->input('title');
        $typeOfChecklists = TypeOfChecklist::when($title, function ($query) use ($title){
            return $query->where('title', 'LIKE', "%$title%")->take(10);
        })
        ->get();

        return
            $title
                ? TypeOfChecklistResource::collection($typeOfChecklists)
                : datatables()->of(TypeOfChecklistResource::collection($typeOfChecklists))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })->toJson();
    }

    /**
     * @param TypeOfChecklistRequest $request
     * @return TypeOfChecklistResource
     */
    public function store(TypeOfChecklistRequest $request) : TypeOfChecklistResource
    {
        $typeOfChecklist = TypeOfChecklist::create($request->validated());
        return TypeOfChecklistResource::make($typeOfChecklist);
    }

    /**
     * @param TypeOfChecklist $typeOfChecklist
     * @return TypeOfChecklistResource
     */
    public function show(TypeOfChecklist $typeOfChecklist) : TypeOfChecklistResource
    {
        return TypeOfChecklistResource::make($typeOfChecklist);
    }

    /**
     * @param TypeOfChecklistRequest $request
     * @param TypeOfChecklist $typeOfChecklist
     * @return TypeOfChecklistResource
     */
    public function update(TypeOfChecklistRequest $request, TypeOfChecklist $typeOfChecklist) : TypeOfChecklistResource
    {
        $typeOfChecklist->fill($request->except('type_of_checklist_id'));
        $typeOfChecklist->save();
        return TypeOfChecklistResource::make($typeOfChecklist);
    }

    /**
     * @param TypeOfChecklist $typeOfChecklist
     * @return TypeOfChecklistResource
     * @throws Exception
     */
    public function destroy(TypeOfChecklist $typeOfChecklist) : TypeOfChecklistResource
    {
        $typeOfChecklist->delete();
        return TypeOfChecklistResource::make($typeOfChecklist);
    }
}
