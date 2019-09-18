<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Http\Requests\Template\TemplateQuestionsRequest;
use App\Http\Requests\Template\TemplateRequest;
use App\Http\Resources\PositionResource;
use App\Http\Resources\QuestionDTResource;
use App\Http\Resources\TemplateCollectionResource;
use App\Http\Resources\TemplateResource;
use App\Position;
use App\Question;
use App\QuestionTemplatePivot;
use App\Template;
use DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class TemplateController extends Controller
{

    /**
     * @return mixed
     * @throws Exception
     */
    public function index()
    {
        $templates = Template::with('regions', 'templateTypes', 'gasStationTypes')->withCount('questions')->get();
        return datatables()->of(TemplateCollectionResource::collection($templates))
            ->addColumn('DT_RowId', function($row){
                return 'row_'.$row['id'];
            })
            ->addColumn('link', function($row){
                    return '<a class="model-show font-weight-bold" title="Шаблон №'.$row['id'].'" href="#" data-id="'.$row['id'].'">'.$row['title'].'</a>';
            })
            ->rawColumns(['link'])
            ->toJson();
    }

    /**
     * @param TemplateRequest $request
     * @return TemplateResource
     * @throws Throwable
     */
    public function store(TemplateRequest $request) : TemplateResource
    {
        $template = DB::transaction(function () use($request) {
            $template = Template::create([
                'author_id' => 1,
                'editor_id' => 1,
                'type_of_checklist_id' => $request->type_of_checklist_id,
                'status' => $request->it_works,
            ]);

            $template->gasStationTypes()->sync($request->type_of_gas_station_id);
            $template->regions()->sync($request->region_id);

            return $template;
        });
        return TemplateResource::make($template);
    }

    /**
     * @param $id
     * @return TemplateResource
     */
    public function show($id) : TemplateResource
    {
        $template = Template::with(['author.profile', 'editor.profile', 'gasStationTypes', 'templateTypes', 'regions'])->withCount('questions')->findOrFail($id);
        return TemplateResource::make($template);
    }

    /**
     * @param TemplateRequest $request
     * @param Template $template
     * @return TemplateResource
     * @throws Throwable
     */
    public function update(TemplateRequest $request, Template $template) : TemplateResource
    {
        DB::transaction(function () use($request, $template) {
            $template->editor_id = 2;
            $template->type_of_checklist_id = $request->type_of_checklist_id;
            $template->status = $request->it_works;
            $template->save();
            $template->gasStationTypes()->sync($request->type_of_gas_station_id);
            $template->regions()->sync($request->region_id);
        });
        return TemplateResource::make($template);
    }


    /**
     * @param Template $template
     * @return TemplateResource
     * @throws Throwable
     */
    public function destroy(Template $template) : TemplateResource
    {
        DB::transaction(function () use($template) {
            $template->gasStationTypes()->detach();
            $template->regions()->detach();
            $template->questions()->detach();
            $template->delete();
        });
        return TemplateResource::make($template);
    }

    /**
     * @param Template $template
     * @return mixed
     * @throws Exception
     */
    public function questions(Template $template)
    {
        $questions = $template->questions()->with(['pivot.positions', 'positions', 'section'])->get()->sortBy('id');
        return datatables()->of(QuestionDTResource::collection($questions))
            ->addColumn('DT_RowId', function($row){
                return 'row_'.$row['id'];
            })
            ->toJson();
    }

    /**
     * @param TemplateQuestionsRequest $request
     * @param Template $template
     * @return JsonResponse
     */
    public function addQuestion(TemplateQuestionsRequest $request, Template $template) : JsonResponse
    {

        $template->questions()->attach($request->question_id);

        return response()->json(['message' => 'Вопросы добавлены в шаблон!']);
    }

    /**
     * @param TemplateQuestionsRequest $request
     * @param Template $template
     * @return JsonResponse
     */
    public function removeQuestion(TemplateQuestionsRequest $request, Template $template) : JsonResponse
    {
        $template->questions()->detach($request->question_id);

        return response()->json(['message' => 'Вопросы удалены из шаблона!']);
    }

    /**
     * @param TemplateRequest $request
     * @param Template $template
     * @param Question $question
     * @return JsonResponse
     */
    public function updatePositions(TemplateRequest $request, Template $template, Question $question) : JsonResponse
    {
        $pivot = QuestionTemplatePivot::where('question_id', $question->id)->where('template_id', $template->id)->firstOrFail();
        $pivot->positions()->sync($request->position_id);

        return response()->json(['message' => 'Проверяемые категории должностей изменены']);
    }

    /**
     * @param TemplateRequest $request
     * @param Template $template
     * @param Question $question
     * @return AnonymousResourceCollection
     */
    public function indexPositions(TemplateRequest $request, Template $template, Question $question)
    {
        $title = $request->input('title');

        $pivot = QuestionTemplatePivot::where('question_id', $question->id)->where('template_id', $template->id)->firstOrFail();

        $positions = $pivot->positions()
            ->when($title, function ($query) use ($title){
                return $query->where('title', 'LIKE', "%$title%")->take(10);
            })
            ->get();

        return PositionResource::collection($positions);
    }
}
