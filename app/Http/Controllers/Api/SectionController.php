<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Section\SectionIndexRequest;
use App\Http\Requests\Section\SectionStoreRequest;
use App\Http\Requests\Section\SectionUpdateRequest;
use App\Http\Resources\Section\SectionDTResource;
use App\Http\Resources\Section\SectionInfoResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Section\SectionSelect2Resource;
use App\Models\Section;

class SectionController extends Controller
{

    public function index(SectionIndexRequest $request)
    {
        $sections = Section::filter($request)
            ->take(10)
            ->get();

        return SectionSelect2Resource::collection($sections);
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
     * @return SectionInfoResource
     */
    public function store(SectionStoreRequest $request): SectionInfoResource
    {
        $section = Section::create($request->validated());
        return SectionInfoResource::make($section);
    }

    /**
     * @param Section $section
     * @return SectionResource
     */
    public function show(Section $section): SectionResource
    {
        return SectionResource::make($section);
    }

    /**
     * @param SectionUpdateRequest $request
     * @param Section $section
     * @return SectionInfoResource
     */
    public function update(SectionUpdateRequest $request, Section $section): SectionInfoResource
    {
        $section->fill($request->except('section_id'));
        $section->save();
        return SectionInfoResource::make($section);
    }

    /**
     * @param Section $section
     * @return SectionInfoResource
     * @throws \Exception
     */
    public function destroy(Section $section): SectionInfoResource
    {
        $section->delete();
        return SectionInfoResource::make($section);
    }
}
