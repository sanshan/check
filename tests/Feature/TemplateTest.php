<?php

namespace Tests\Feature;

use App\Models\Position;
use App\Models\Question;
use App\Models\Region;
use App\Models\Section;
use App\Models\Template;
use App\Models\TemplateSectionPivot;
use App\Models\TemplateSectionQuestionPivot;
use App\Models\TypeOfChecklist;
use App\Models\TypeOfGasStation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Monolog\Formatter\LogglyFormatter;
use Tests\TestCase;
use function foo\func;


class TemplateTest extends TestCase
{
    use RefreshDatabase;

    protected $_user;
    protected $_template;
    protected $_token;
    protected $_headers;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        //Create User
        $this->_user = factory(User::class)->create();
        $this->_token = auth('api')->login($this->_user);
        $this->_headers = [
            'Authorization' => 'bearer ' . $this->_token,
        ];

        //Create Types for Template
        factory(TypeOfChecklist::class)->create();

        //User create Template
        $this->_template = $this->_user->templates()->save(
            factory(Template::class)->make()
        );

    }

    /**
     * @test
     */
    public function user_can_create_template()
    {
        $params = [
            'types_of_gas_station' => factory(TypeOfGasStation::class, 2)->create()->pluck('id')->toArray(),
            'type_of_checklist'    => factory(TypeOfChecklist::class)->create()->id,
            'regions'              => factory(Region::class, 3)->create()->pluck('id')->toArray(),
            'status'               => rand(0, 1),
        ];

        $this->json(
            'POST',
            route('templates.store'),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Record created successfully.'),
            ]);

        tap(Template::orderBy('id', 'desc')->first(), function ($template) use ($params) {
            $this->assertEquals($params['types_of_gas_station'], $template->gasStationTypes->pluck('id')->toArray());
            $this->assertEquals($params['type_of_checklist'], $template->templateTypes->id);
            $this->assertEquals($params['regions'], $template->regions->pluck('id')->toArray());
            $this->assertEquals((int)$params['status'], (int)$template->status);
        });

    }

    /**
     * @test
     */
    public function user_can_create_template_only_with_correct_type_of_gas_station()
    {
        $params = [
            'types_of_gas_station' => [1000],
            'type_of_checklist'    => factory(TypeOfChecklist::class)->create()->id,
            'regions'              => factory(Region::class, 3)->create()->pluck('id')->toArray(),
            'status'               => rand(0, 1),
        ];
        $this->json(
            'POST',
            route('templates.store'),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_create_template_only_with_correct_type_of_checklist()
    {
        $params = [
            'types_of_gas_station' => factory(TypeOfGasStation::class, 2)->create()->pluck('id')->toArray(),
            'type_of_checklist'    => 1000,
            'regions'              => factory(Region::class, 3)->create()->pluck('id')->toArray(),
            'status'               => rand(0, 1),
        ];
        $this->json(
            'POST',
            route('templates.store'),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_create_template_only_with_correct_regions()
    {
        $params = [
            'types_of_gas_station' => factory(TypeOfGasStation::class, 2)->create()->pluck('id')->toArray(),
            'type_of_checklist'    => factory(TypeOfChecklist::class)->create()->id,
            'regions'              => [1000],
            'status'               => rand(0, 1),
        ];
        $this->json(
            'POST',
            route('templates.store'),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_create_template_only_with_correct_status()
    {
        $params = [
            'types_of_gas_station' => factory(TypeOfGasStation::class, 2)->create()->pluck('id')->toArray(),
            'type_of_checklist'    => factory(TypeOfChecklist::class)->create()->id,
            'regions'              => factory(Region::class, 3)->create()->pluck('id')->toArray(),
            'status'               => 3,
        ];
        $this->json(
            'POST',
            route('templates.store'),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_update_template()
    {
        $params = [
            'types_of_gas_station' => factory(TypeOfGasStation::class, 2)->create()->pluck('id')->toArray(),
            'type_of_checklist'    => factory(TypeOfChecklist::class)->create()->id,
            'regions'              => factory(Region::class, 3)->create()->pluck('id')->toArray(),
            'status'               => 1,
        ];
        $this->json(
            'PUT',
            route('templates.update', ['template' => $this->_template->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Record updated successfully.'),
            ]);

        tap(Template::find($this->_template->id), function ($template) use ($params) {
            $this->assertEquals($params['types_of_gas_station'], $template->gasStationTypes->pluck('id')->toArray());
            $this->assertEquals($params['type_of_checklist'], $template->templateTypes->id);
            $this->assertEquals($params['regions'], $template->regions->pluck('id')->toArray());
            $this->assertEquals((int)$params['status'], (int)$template->status);
        });

    }

    /**
     * @test
     */
    public function user_can_list_sections_from_the_template()
    {
        $sections1 = factory(Section::class, 2)->create();
        factory(Section::class, 2)->create();

        $this->_template->sections()->attach($sections1);

        $sections = $this->_template->sections->map(function ($section) {
            return $section->only(['id', 'title']);
        });

        $params = [
            'present_in_template' => $this->_template->id,
        ];
        $this->json(
            'GET',
            route('templates.sections.index', ['template' => $this->_template->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'data' => $sections->toArray(),
            ]);

    }

    /**
     * @test
     */
    public function user_can_list_non_template_sections()
    {
        $sections1 = factory(Section::class, 2)->create();
        $sections2 = factory(Section::class, 5)->create();

        $this->_template->sections()->attach($sections1);

        $sections = $sections2->map(function ($section) {
            return $section->only(['id', 'title']);
        });

        $params = [
            'missing_in_template' => $this->_template->id,
        ];
        $this->json(
            'GET',
            route('sections.index.datatable'),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJson([
                'data' => $sections->toArray(),
            ]);

    }

    /**
     * @test
     */
    public function user_can_add_sections_to_the_template()
    {

        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();

        $params = [
            'sections' => [
                $section1->id,
                $section2->id,
            ],
        ];
        $this->json(
            'POST',
            route('templates.sections.store', ['template' => $this->_template->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Sections added to the template.'),
            ]);

        $this->assertEquals(2, $this->_template->sections()->count());
    }

    /**
     * @test
     */
    public function user_can_add_only_unique_sections_to_the_template()
    {
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();

        $this->_template->sections()->attach([
            $section1->id,
            $section2->id,
        ]);

        $params = [
            'sections' => [
                $section1->id,
            ],
        ];
        $this->json(
            'POST',
            route('templates.sections.store', ['template' => $this->_template->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_remove_sections_from_template()
    {
        $this->withoutExceptionHandling();

        $sections = factory(Section::class, 3)->create()->each(function ($r) {
            $r->questions()->saveMany(factory(Question::class, 10)->make());
        });
        factory(Position::class, 15)->create();
        $deletingPositionId = $sections->first()->id;
        Question::all()->each(function ($r) {
            $r->positions()->attach(
                Position::where('to_rate', 1)->get()->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $this->_template->sections()->attach($sections);

        $params = [
            'sections' => [
                $deletingPositionId,
            ],
        ];
        $this->json(
            'DELETE',
            route('templates.sections.destroy', ['template' => $this->_template->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Sections removed from the template.'),
            ]);

        $this->assertEquals(2, $this->_template->sections()->count());
        $this->assertEquals(0, $this->_template->sections()->where('sections.id', $deletingPositionId)->get()->count());

    }

    /**
     * @test
     */
    public function user_can_remove_only_present_sections_from_the_template()
    {
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();
        $section3 = factory(Section::class)->create();

        $this->_template->sections()->attach([
            $section1->id,
            $section2->id,
        ]);

        $params = [
            'sections' => [
                $section2->id,
                $section3->id,
            ],
        ];
        $this->json(
            'DELETE',
            route('templates.sections.destroy', ['template' => $this->_template->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function questions_from_the_section_are_transferred_to_the_template()
    {
        //Создаю 10 разделов. В каждом разделе 40 вопросов.
        $sections = factory(Section::class, 10)->create()->each(function ($r) {
            $r->questions()->saveMany(factory(Question::class, 40)->make());
        });

        // Для каждого вопроса создаю 3 должности
        Question::all()->each(function ($r) {
            $r->positions()->saveMany(factory(Position::class, 3)->make());
        });

        // Берём случайный раздел
        $section = $sections->random();

        // Аттачим $section к шаблону
        $this->_template->attachSections([$section->id]);

        //Сравниваем количество вопросов в разделе шаблона и количество вопросов в разделе
        $this->assertEquals($this->_template->sections()->where('sections.id', $section->id)->first()->pivot->questions()->count(), 40);

    }

    /**
     * @test
     */
    public function positions_from_the_question_are_transferred_to_the_template()
    {
        //Создаю 10 разделов. В каждом разделе 40 вопросов.
        $sections = factory(Section::class, 10)->create()->each(function ($r) {
            $r->questions()->saveMany(factory(Question::class, 40)->make());
        });

        // Для каждого вопроса создаю 3 должности
        Question::all()->each(function ($r) {
            $r->positions()->saveMany(factory(Position::class, 3)->make());
        });

        // Берём случайный раздел
        $section = $sections->random();

        // Берём случайный вопрос из раздела
        $question = $section->questions->random();

        // Аттачим $section к шаблону
        $this->_template->attachSections([$section->id]);

        //Сравниваем количество должностей из в вопросе из раздела шаблона и количество вопросов из вопроса
        $this->assertEquals(
            $this->_template->sections()
                ->where('sections.id', $section->id)
                ->first()
                ->pivot
                ->questions()
                ->where('questions.id', $question->id)
                ->first()
                ->pivot
                ->positions()
                ->count(),
            3);

    }

    /**
     * @test
     */
    public function user_can_list_questions_in_section_from_the_template()
    {
        // Создаю раздел
        $section = factory(Section::class)->create();

        // Создаю в разделе 10 вопросов
        $section->questions()->saveMany(factory(Question::class, 10)->make());

        // Создаю массив состоящий из id и title созданных вопросов
        $questions = $section->questions->map(function ($question) {
            return $question->only(['id', 'title']);
        });

        // Добавляю раздел в шаблон
        $this->_template->attachSections([$section->id]);

        // Беру добавленный раздел из шаблона
        $ts = $this->_template->sections()->where('sections.id', $section->id)->first()->pivot;

        // Отправляю запрос на получение списка вопросов из раздела шаблона
        $this->json(
            'GET',
            route(
                'templates.sections.questions.index',
                [
                    'template' => $this->_template->id,
                    'ts'       => $ts->id,
                ]
            ),
            [],
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJson([
                'data' => $questions->toArray(),   // Сравниваю список вопросов с ответом на запрос
            ]);
    }

    /**
     * @test
     */
    public function user_can_see_the_list_of_questions_available_for_adding_to_the_template_section()
    {
        // Создаём раздел
        $section = factory(Section::class)->create();

        // Создаём в разделе 10 вопросов
        $section->questions()->saveMany(factory(Question::class, 10)->make());

        // Беру 3 случайных ID вопросов из раздела
        $randomQuestionsId = $section->questions->random(3)->pluck('id')->toArray();

        // Добавляю раздел в шаблон
        $this->_template->attachSections([$section->id]);

        // Удаляю 3 случайных вопроса из раздела в шаблоне
        $this->_template->sections()->where('sections.id', $section->id)->first()->pivot->questions()->detach($randomQuestionsId);

        // Подготавливаю параметры для фильтра
        $params = [
            'missing_in_section_template' => $this->_template->sections()->where('sections.id', $section->id)->first()->pivot->id,
        ];

        // Отправляю запрос на получения списка доступных для добавления в шаблон вопросов для раздела
        $this->json(
            'GET',
            route('sections.questions.index.datatable', ['section' => $section->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');

    }

    /**
     * @test
     */
    public function user_can_remove_questions_from_template()
    {
        // Создаю 10 секции по 5 вопросов в каждой
        $sections = factory(Section::class, 10)->create()->each(function ($section) {
            $section->questions()->saveMany(factory(Question::class, 5)->make());
        });

        // Создаю 5 должностей
        factory(Position::class, 5)->create();

        // К каждому вопросу привязываю до 3 вопросов с 'to_rate' == 1 или ничего
        Question::all()->each(function ($question) {
            $question->positions()->attach(
                Position::where('to_rate', 1)->inRandomOrder()->limit(3)->get()->pluck('id')->toArray() ?? []
            );
        });

        // Беру ID двух случайных раздела
        $sectionsID = $sections->take(2)->pluck('id')->toArray();

        // Добавляю два раздела с вопросами и должностями в шаблон
        $this->_template->attachSections($sectionsID);

        // Беру случайный раздел из шаблона
        $sectionInTemplate = $this->_template->sections()->inRandomOrder()->first()->pivot;

        // Беру до двух случайных вопросов в случайном разделе из шаблона записываю ID в массив
        $questionsID = $sectionInTemplate->questions()
            ->inRandomOrder()
            ->limit(2)
            ->get()
            ->pluck('id')
            ->toArray();

        // Передаю массив с ID вопросов в качестве параметра в запрос
        $params = [
            'questions' => $questionsID,
        ];

        //Отправляю запрос на удаление вопросов из раздела шаблона, при этом из шаблона должны успешно удалиться привязанные к этим вопросам должности
        $this->json(
            'DELETE',
            route('templates.sections.questions.destroy', ['template' => $this->_template->id, 'ts' => $sectionInTemplate->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Questions removed from the template.'),
            ]);

        // Проверяю количество оставшихся в разделе шаблона вопросов. Сравниваю количество оставшихся после запроса вопросов с разностью исходного количества и длины $questionsID
        $this->assertEquals($sectionInTemplate->questions->count(), 5 - count($sectionsID));
    }

    /**
     * @test
     */
    public function user_can_remove_only_present_questions_from_template()
    {
        // Создаю первый раздел
        $section1 = factory(Section::class)->create();

        // Создаю второй раздел
        $section2 = factory(Section::class)->create();

        // Создаю в первом разделе 5 вопросов
        $section1->questions()->saveMany(factory(Question::class, 5)->make());

        // Создаю во втором разделе 5 вопросов
        $section2->questions()->saveMany(factory(Question::class, 5)->make());

        // Добавляю первый раздел в шаблон
        $this->_template->attachSections([$section1->id]);

        // Беру добавленный в шаблон раздел
        $ts = $this->_template->sections()->where('sections.id', $section1->id)->first()->pivot;

        // Беру первый вопрос из второго раздела (его нет в шаблоне)
        $question = $section2->questions->first();

        // Подготавливаю параметры запроса. Массив ID вопросов
        $params = [
            'questions' => [
                $question->id,
            ],
        ];

        // Отправляю запрос на удаление недобавленного вопроса из раздела шаблона.
        $this->json(
            'DELETE',
            route('templates.sections.questions.destroy', ['template' => $this->_template->id, 'ts' => $ts->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_add_questions_to_template()
    {
        // Создаю раздел с десятью вопросами
        $section = factory(Section::class)->create();

        // Добавляю 10 вопросов в раздел
        $section->questions()->saveMany(factory(Question::class, 10)->make());

        // Добавляю раздел в шаблон
        $this->_template->attachSections([$section->id]);

        // Создаю ещё два вопроса в разделе и сохраняю их ID в массив
        $newQuestionsID = $section->questions()
            ->saveMany(
                factory(Question::class, 2)->make()
            )
            ->pluck('id')
            ->toArray();

        // Беру раздел из шаблона
        $sectionInTemplate = $this->_template->sections()->where('sections.id', $section->id)->first()->pivot;

        // Подготавливаю параметр для запроса
        $params = [
            'questions' => $newQuestionsID,
        ];

        // Отправляю запрос на добавление вопросов в раздел шаблона с массивом ID
        $this->json(
            'POST',
            route('templates.sections.questions.store', ['template' => $this->_template->id, 'ts' => $sectionInTemplate->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Questions added to the template.'),
            ]);

        $this->assertEquals($sectionInTemplate->questions()->count(), 12);

    }

    /**
     * @test
     */
    public function user_can_add_only_unique_questions_to_the_template()
    {
        // Создаю раздел
        $section = factory(Section::class)->create();

        // Создаю в разделе 10 вопросов
        $section->questions()->saveMany(
            factory(Question::class, 10)->make()
        );

        // Добавляю раздел в шаблон
        $this->_template->attachSections([$section->id]);

        // Беру добавленный раздел из шаблона
        $ts = $this->_template->sections()->where('sections.id', $section->id)->first()->pivot;

        // Беру ID двух вопросов из раздела (они уже добавленны в шаблон)
        $newQuestionsID = $section->questions()
            ->take(2)
            ->get()
            ->pluck('id')
            ->toArray();

        // Подготавливаю параметры запроса. Массив с ID добавляемых вопросов.
        $params = [
            'questions' => $newQuestionsID,
        ];

        // Отправляю запрос на повторное добавление вопросов
        $this->json(
            'POST',
            route('templates.sections.questions.store', ['template' => $this->_template->id, 'ts' => $ts->id]),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_sync_only_present_positions_in_the_template()
    {
        // Создаю раздел
        $section = factory(Section::class)->create();

        // Создаю в в разделе вопрос
        $question = $section->questions()->save(factory(Question::class)->make());

        // Создаю в вопросе 5 должностей
        $question->positions()->saveMany(factory(Position::class, 5)->make());

        // Добавляю раздел в шаблон
        $this->_template->attachSections([$section->id]);

        // Беру добавленный в шаблон раздел
        $ts = $this->_template->sections()->where('sections.id', $section->id)->first()->pivot;

        // Беру добавленный в раздел шаблона вопрос
        $tsq = $ts->questions()->where('questions.id', $question->id)->first()->pivot;

        // Подготавливаю массив с несуществующими ID вопросов
        $params = [
            'positions' => [
                100,
                200,
            ],
        ];

        // Отправляю запрос на добавление несуществующих вопросов в раздел шаблона
        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $this->_template->id,
                    'ts'       => $ts->id,
                    'tsq'      => $tsq->id
                ]
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_use_only_correct_section_id_when_deleting_questions()
    {
        // Создаю первый раздел
        $section1 = factory(Section::class)->create();

        // Создаю второй раздел
        $section2 = factory(Section::class)->create();

        // Создаю вопрос в первом разделе
        $question = $section1->questions()->save(factory(Question::class)->make());

        // Добавляю раздел в шаблон
        $this->_template->attachSections([$section1->id, $section2->id]);

        // Беру второй добавленный в шаблон раздел
        $ts2 = $this->_template->sections()->where('sections.id', $section2->id)->first()->pivot;

        // Подготавливаю параметры запроса. Массив с ID удаляемых вопросов
        $params = [
            'questions' => [
                $question->id,
            ]
        ];

        // Отправляю запрос на удаление вопросов из первого раздела, с указанием ID второго добавленного раздела(неверный запрос)
        $this->json(
            'DELETE',
            route(
                'templates.sections.questions.destroy',
                [
                    'template' => $this->_template->id,
                    'ts'       => $ts2->id,
                ]
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_use_only_correct_section_id_when_adding_questions()
    {
        // Создаю первый раздел
        $section1 = factory(Section::class)->create();

        // Создаю второй раздел
        $section2 = factory(Section::class)->create();

        // Создаю вопрос в первом разделе
        $section1->questions()->save(factory(Question::class)->make());

        // Добавляю оба зардела в шаблон
        $this->_template->attachSections([$section1->id, $section2->id]);

        // Создаю ещё один вопрос в первом разделе (сейчас его нет в разделе шаблона)
        $question2 = $section1->questions()->save(factory(Question::class)->make());

        // Беру второй раздел добавленный в шаблон
        $ts2 = $this->_template->sections()->where('sections.id', $section2->id)->first()->pivot;

        // Подготавливаю параметры для запроса. Массив с ID добавляемых вопросов
        $params = [
            'questions' => [
                $question2->id,
            ]
        ];

        // Отправляю запрос на добавление вопроса из первого раздела во второй раздел шаблона (это неправильный запрос)
        $this->json(
            'POST',
            route('templates.sections.questions.store', [
                'template' => $this->_template->id,
                'ts'       => $ts2->id,
            ]),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_use_only_correct_section_when_sync_positions()
    {
        //Создаём два раздела
        $section1 = factory(Section::class)->create();
        $section2 = factory(Section::class)->create();

        // В первом разделе создаём один вопрос
        $question = $section1->questions()->save(factory(Question::class)->make());

        // В вопросе создаём 5 должностей
        $positions = $question->positions()->saveMany(factory(Position::class, 5)->make());

        // Добавляем в шаблон раздел №1
        $this->_template->attachSections([$section1->id]);

        //Добавляем в шаблон раздел №2
        $this->_template->attachSections([$section2->id]);

        // Формируем неправильные параметры для маршрута. Неправльный ID раздела на синхронизацию должностей для вопроса из раздела №1 в шаблоне
        $routeParams = [
            'template' => $this->_template->id,
            'ts'       => $this->_template->sections()->where('sections.id', $section2->id)->first()->pivot->id,
            'tsq'      => $this->_template->sections()->where('sections.id', $section1->id)->first()->pivot->questions()->where('questions.id', $question->id)->first()->pivot->id,
        ];

        // Берём две должности из вопроса в разделе №1
        $params = [
            'positions' => $positions->take(2)->pluck('id')->toArray(),
        ];
        // Отправляем POST на обновление должностей в шаблоне
        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                $routeParams
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function user_can_use_only_correct_question_id_when_sync_positions()
    {
        // Создаю первый раздел
        $section1 = factory(Section::class)->create();

        // Создаю второй раздел
        $section2 = factory(Section::class)->create();

        // Создаю первый вопрос в первом разделе
        $question1 = $section1->questions()->save(factory(Question::class)->make());

        // Создаю второй вопрос во втором разделе
        $question2 = $section2->questions()->save(factory(Question::class)->make());

        // Создаю 5 должностей в первом вопросе
        $positions1 = $question1->positions()->saveMany(factory(Position::class, 5)->make());

        // Создаю 5 должностей во втором вопросе
        $positions2 = $question1->positions()->saveMany(factory(Position::class, 5)->make());

        // Добавляю оба раздела в шаблон
        $this->_template->attachSections([$section1->id, $section2->id]);

        // Беру первый добавленный в шаблон раздел
        $ts1 = $this->_template->sections()->where('sections.id', $section1->id)->first()->pivot;

        // Беру второй добавленный в шаблон раздел
        $ts2 = $this->_template->sections()->where('sections.id', $section2->id)->first()->pivot;

        // Беру первый добавленый вопрос в первом добавленном в шаблон разделе
        $tsq1 = $ts1->questions()->where('questions.id', $question1->id)->first()->pivot;

        // Беру второй добавленый вопрос во втором добавленном в шаблон разделе
        $tsq2 = $ts2->questions()->where('questions.id', $question2->id)->first()->pivot;

        // Подготавливаю параметры для запроса. Массив ID двух вопросов. Теперь у вопроса должно стать 2 должности
        $params = [
            'positions' => $positions1->take(2)->pluck('id')->toArray(),
        ];

        // Отправляю запрос на синхронизацию должностей первого вопроса, указав маршруте ID второго вопроса (неправильный запрос)
        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $this->_template->id,
                    'ts'       => $ts1->id,
                    'tsq'      => $tsq2->id
                ]
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(422);

    }

    /**
     * @test
     */
    public function user_can_edit_section_weight()
    {
        $section = factory(Section::class)->create();
        $section->questions()->saveMany(factory(Question::class, 10)->make());
        factory(Position::class, 20)->create();

        $section->questions->each(function ($question) {
            $question->positions()->attach(Position::where('to_rate', 1)->get()->random(rand(1, 3))->pluck('id')->toArray());
        });

        $this->_template->sections()->attach($section);

        $params = [
            'weight' => 20,
        ];
        $this->json(
            'PATCH',
            route(
                'templates.sections.update',
                [
                    'template' => $this->_template->id,
                    'section'  => $section->id,
                ]
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Section weight updated'),
            ]);

        tap($this->_template->sections()->where('sections.id', $section->id)->first()->pivot->pluck('weight'), function ($weight) use ($params) {
            $this->assertEquals($weight[0], $params['weight']);
        });

    }

    /**
     * @test
     */
    public function user_can_edit_section_weight_only_with_correct_value()
    {
        $section = factory(Section::class)->create();
        $section->questions()->saveMany(factory(Question::class, 10)->make());
        factory(Position::class, 20)->create();

        $section->questions->each(function ($question) {
            $question->positions()->attach(Position::where('to_rate', 1)->get()->random(rand(1, 3))->pluck('id')->toArray());
        });

        $this->_template->sections()->attach($section);

        $params = [
            'weight' => 'test',
        ];
        $this->json(
            'PATCH',
            route(
                'templates.sections.update',
                [
                    'template' => $this->_template->id,
                    'section'  => $section->id,
                ]
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(422);
    }

    /**
     * @test
     */
    public function user_can_get_positions_from_question_in_template()
    {
        // Создаю раздел
        $section = factory(Section::class)->create();

        // Создаю 20 вопросов в разделе
        $section->questions()->saveMany(factory(Question::class, 20)->make());

        // Создаю 5 должностей
        factory(Position::class, 20)->create();

        // Добавляю должности с "to_rate" = 1 в вопросы
        $section->questions->each(function ($question) {
            $question->positions()->attach(Position::where('to_rate', 1)->get()->random(rand(1, 3))->pluck('id')->toArray());
        });

        // Беру случайный вопрос из раздела
        $question = $section->questions()->inRandomOrder()->first();

        // Добавляю раздел с вопросами и должностями в шаблон
        $this->_template->attachSections([$section->id]);

        // Беру добавленный раздел из шаблона
        $ts = $this->_template->sections()->where('sections.id', $section->id)->first()->pivot;

        // Беру добавленный вопрос из раздела шаблона
        $tsq = $ts->questions()->where('questions.id', $question->id)->first()->pivot;

        // Подготавливаю параметры для маршрута
        $params = [
            'template' => $this->_template->id,
            'ts'       => $ts->id,
            'tsq'      => $tsq->id,
        ];

        // Отправляю запрос на получение списка должностей вопроса из раздела шаблона
        $this->json(
            'GET',
            route('templates.sections.questions.positions.index',
                $params
            ),
            [],
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Data retrieved successfully.'),
            ])
            ->assertJsonCount($tsq->positions->count(), 'data'); // Сравниваю количество должностей из вопроса раздела шаблона, с количеством должностей, которые вернул запрос

    }

    /**
     * @test
     */
    public function user_can_sync_positions_in_the_template()
    {
        // Создаю раздел
        $section = factory(Section::class)->create();

        // Добавляю в раздел 3 вопроса и беру первый из них
        $question = $section->questions()
            ->saveMany(factory(Question::class, 3)->make())
            ->first();

        // Добавляю к вопросу 5 должностей
        $positions = $question->positions()->saveMany(factory(Position::class, 5)->make());

        // Добавляю в шаблон раздел с вопросами и должностями
        $this->_template->attachSections([$section->id]);

        // Беру вервый раздел из шаблона
        $ts = $this->_template->sections()->where('sections.id', $section->id)->first()->pivot;

        // Беру первый вопрос из первого раздела шаблона
        $tsq = $ts->questions()->where('questions.id', $question->id)->first()->pivot;

        // Подготавливаю параметры для запроса. Беру две из пяти созданных должностей
        $params = [
            'positions' => $positions->take(2)->pluck('id')->toArray(),
        ];

        // Отправляю запрос на синхронизацию должностей в вопросе раздела шаблона
        $this->json(
            'POST',
            route(
                'templates.sections.questions.positions.update',
                [
                    'template' => $this->_template->id,
                    'ts'       => $ts->id,
                    'tsq'      => $tsq->id,
                ]
            ),
            $params,
            $this->_headers
        )
            ->assertStatus(200)
            ->assertJson([
                'message' => __('Positions synced.'),
            ]);

        // Сравниваю количество должностей первого вопроса, первого раздела в шаблоне с количеством должностей которое вернул запрос
        $this->assertEquals(
            $this->_template->sections()
                ->where('sections.id', $section->id)
                ->first()
                ->pivot
                ->questions()
                ->where('questions.id', $question->id)
                ->first()
                ->pivot
                ->positions()
                ->count(),
            2
        );

    }

}
