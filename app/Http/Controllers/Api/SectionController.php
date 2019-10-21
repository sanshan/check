<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Section\SectionIndexRequest;
use App\Http\Requests\Section\SectionStoreRequest;
use App\Http\Requests\Section\SectionUpdateRequest;
use App\Http\Resources\Section\SectionDTResource;
use App\Http\Resources\Section\SectionInfoResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Section\SectionSelect2Resource;
use App\Models\Section;

class SectionController extends BaseController
{

    /**
     * @param SectionIndexRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(SectionIndexRequest $request)
    {
        $sections = Section::filter($request)
            ->take(10)
            ->get();

        return $this->sendResponse(SectionSelect2Resource::collection($sections), __('Data retrieved successfully.'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function dataTableIndex()
    {
        $sections = Section::withCount('questions')->get();

        return datatables()->of(SectionDTResource::collection($sections))
            ->addColumn('DT_RowId', function ($row) {
                return 'row_' . $row['id'];
            })
            ->addColumn('link', function ($row) {
                return '<a title="' . $row['title'] . '" href="' . route('audit.questions', ['section' => $row['id']]) . '">' . $row['title'] . '</a>';
            })
            ->rawColumns(['link'])
            ->toJson();

    }

    /**
     * @param SectionStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionStoreRequest $request)
    {
        $section = Section::create($request->validated());

        return $this->sendResponse(SectionInfoResource::make($section), __('Data created successfully.'));
    }

    /**
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return $this->sendResponse(SectionResource::make($section), __('Data retrieved successfully.'));
    }

    /**
     * @param SectionUpdateRequest $request
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request, Section $section)
    {
        $section->fill($request->except('section_id'));
        $section->save();

        return $this->sendResponse(SectionInfoResource::make($section), __('Record updated successfully.'));
    }

    /**
     * @param Section $section
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return $this->sendResponse(SectionInfoResource::make($section), __('Record deleted successfully.'));
    }
}
