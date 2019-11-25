<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Template\TemplateIndexRequest;
use App\Http\Requests\Template\TemplateStoreRequest;
use App\Http\Requests\Template\TemplateUpdateRequest;
use App\Http\Resources\Template\TemplateDTResource;
use App\Http\Resources\Template\TemplateInfoResource;
use App\Http\Resources\Template\TemplateResource;
use App\Http\Resources\Template\TemplateSelect2Resource;
use App\Models\Template;
use App\Models\User;
use DB;

class TemplateController extends BaseController
{

//    /**
//     * @param TemplateIndexRequest $request
//     * @return \Illuminate\Http\Response
//     */
//    public function index(TemplateIndexRequest $request)
//    {
//        $templates = Template::filter($request)
//            ->take(10)
//            ->get();
//
//        return $this->sendResponse(TemplateSelect2Resource::collection($templates), __('Data retrieved successfully.'));
//    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {
        $templates = Template::with('regions', 'templateTypes', 'gasStationTypes')->withCount('sections')->get();
        return datatables()->of(TemplateDTResource::collection($templates))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->rawColumns(['link'])
            ->toJson();
    }

    /**
     * @param TemplateStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(TemplateStoreRequest $request)
    {
        $template = DB::transaction(function () use ($request) {
            $template = Template::create([
                'user_id'              => auth()->user()->id,
                'editor_id'            => auth()->user()->id,
                'type_of_checklist_id' => $request->type_of_checklist,
                'status'               => $request->status,
            ]);

            $template->gasStationTypes()->sync($request->types_of_gas_station);
            $template->regions()->sync($request->regions);

            return $template;
        });

        return $this->sendResponse(TemplateInfoResource::make($template), __('Record created successfully.'));
    }


    public function show(Template $template)
    {
        $template->load(['user.profile', 'editor.profile', 'gasStationTypes', 'templateTypes', 'regions']);

        return $this->sendResponse(TemplateResource::make($template), __('Data retrieved successfully.'));
    }

    /**
     * @param TemplateUpdateRequest $request
     * @param Template $template
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(TemplateUpdateRequest $request, Template $template)
    {
        $template = DB::transaction(function () use ($request, $template) {
            $template->editor_id = auth()->user()->id;
            $template->type_of_checklist_id = $request->type_of_checklist;
            $template->status = $request->status;
            $template->save();
            $template->gasStationTypes()->sync($request->types_of_gas_station);
            $template->regions()->sync($request->regions);

            return $template;
        });

        return $this->sendResponse(TemplateInfoResource::make($template), __('Record updated successfully.'));
    }

    /**
     * @param Template $template
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function destroy(Template $template)
    {
        $template = DB::transaction(function () use ($template) {
            $template->gasStationTypes()->detach();
            $template->regions()->detach();
            $template->delete();

            return $template;
        });

        return $this->sendResponse(TemplateInfoResource::make($template), __('Record deleted successfully.'));
    }

}
