<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Section;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SectionController extends Controller
{

    /**
     * @param SectionRequest $request
     * @return AnonymousResourceCollection
     * @throws Exception
     */
    public function index(SectionRequest $request)
    {
        if($title = $request->input('title')) {
            $sections = Section::where('title', 'LIKE', "%$title%")->with('questions', 'questions.positions')->withCount('questions')->get();
            return SectionResource::collection($sections);
        }
        else {
            $sections = Section::withCount('questions')->get();
            return datatables()->of(SectionResource::collection($sections))
                ->addColumn('DT_RowId', function($row){
                    return 'row_'.$row['id'];
                })
                ->addColumn('link', function($row){
                    return '<a title="'.$row['title'].'" href="'.route('audit.questions', ['section' => $row['id']]).'">'.$row['title'].'</a>';
                })
                ->rawColumns(['link'])
                ->toJson();
        }
    }

    /**
     * @param SectionRequest $request
     * @return SectionResource
     */
    public function store(SectionRequest $request) : SectionResource
    {
        $section = Section::create($request->validated());
        return SectionResource::make($section);
    }

    /**
     * @param Section $section
     * @return SectionResource
     */
    public function show(Section $section) : SectionResource
    {
        return SectionResource::make($section);
    }

    /**
     * @param SectionRequest $request
     * @param Section $section
     * @return SectionResource
     */
    public function update(SectionRequest $request, Section $section) : SectionResource
    {
        $section->fill($request->except('section_id'));
        $section->save();
        return SectionResource::make($section);
    }

    /**
     * @param Section $section
     * @return SectionResource
     * @throws Exception
     */
    public function destroy(Section $section) : SectionResource
    {
        $section->delete();
        return SectionResource::make($section);
    }
}
