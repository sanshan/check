@extends('lists.layouts.base')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="alert alert-light alert-elevate" role="alert">
            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
            <div class="alert-text">
                Управление шаблонами. <br>
                <u>Функционал:</u>
                <ul>
                    <li>Добавление / удаление / редактирование</li>
                    <li>росмотр вопросов в разделе</li>
                    <li>Проверка правильности заполнения формы (на клиенте и сервере)</li>
                    <li>Постраничный вывод</li>
                    <li>Поиск</li>
                    <li>Сортировка</li>
                    <li>Быстрая печать</li>
                    <li>Копирование в буффер обмена</li>
                    <li>Экспорт в Excel, CSV, PDF</li>
                </ul>
            </div>
        </div>
        <div id="templates" class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-line-chart"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Шаблоны
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <div class="dropdown dropdown-inline">
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Экспорт
                                </button>
                                <div id="buttons" style="padding-top:0!important;"
                                     class="dropdown-menu dropdown-menu-right">
                                </div>
                            </div>
                            &nbsp;
                            <a id="newTemplateButton" href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Новая запись
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table id="templatesTable" class="table table-sm table-bordered table-hover table-checkable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Номер шаблона</th>
                        <th>Тип ТЗК</th>
                        <th>Тип шаблона</th>
                        <th>Регионы</th>
                        <th>Разделов</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>

    <!-- Create/Edit Template Modal -->
    <div class="modal fade" id="createEditTemplateModal" tabindex="-1" role="dialog" aria-labelledby="createTemplateModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTemplateModalTitle">Шаблон</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form id="createEditTemplateModalForm" class="kt-form" action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Тип ТЗК:</label>
                                        <div class="col-lg-9">
                                            <select style="width:100%" class="form-control m-select2"
                                                    id="gas-station-types" name="types_of_gas_station[]"
                                                    multiple="multiple">
                                            </select>
                                            <span class="form-text text-muted">Выберите тип ТЗК</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Тип шаблона:</label>
                                        <div class="col-lg-6">
                                            <select style="width:100%" class="form-control m-select2"
                                                    id="type-of-checklist" name="type_of_checklist">
                                            </select>
                                            <span class="form-text text-muted">Выберите тип проверки</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Регионы:</label>
                                        <div class="col-lg-9">
                                            <select style="width:100%" class="form-control m-select2" id="regions"
                                                    name="regions[]" multiple="multiple">
                                            </select>
                                            <span class="form-text text-muted">Выберите регионы</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Статус:</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="status">
                                                <option disabled selected value>Выберите...</option>
                                                <option value="1">Да</option>
                                                <option value="0">Нет</option>
                                            </select>
                                            <span class="form-text text-muted">Шаблон активен?</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary form-submit">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->

    <!-- Show Template Modal -->
    <div class="modal" id="showTemplateModal" tabindex="-1" role="dialog" aria-labelledby="showTemplateModalTitle" aria-hidden="true">
        <div class="modal-dialog mw-100 w-50 modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showTemplateModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body kt-scroll" data-scroll="true">
                    <div class="kt-invoice-2">
                        <div class="kt-invoice__head">
                            <div class="row">
                                <div class="col-6">
                                    <div class="template-show kt-list-timeline">
                                        <div class="kt-list-timeline__items">
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Автор</span>
                                                <span id="author" class="kt-list-timeline__time"></span>
                                            </div>
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Дата</span>
                                                <span id="created_at" class="kt-list-timeline__time"></span>
                                            </div>
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Редактор</span>
                                                <span id="editor" class="kt-list-timeline__time"></span>
                                            </div>
                                            <div class="kt-list-timeline__item not-last">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Дата</span>
                                                <span id="updated_at" class="kt-list-timeline__time"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="kt-list-timeline">
                                        <div class="kt-list-timeline__items">
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Тип ТЗК</span>
                                                <span id="gasStationTypes" class="kt-list-timeline__time"></span>
                                            </div>
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Тип шаблона</span>
                                                <span id="templateTypes" class="kt-list-timeline__time"></span>
                                            </div>
                                            <div class="kt-list-timeline__item">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text">Статус</span>
                                                <span id="status" class="kt-list-timeline__time"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="template-show-regions kt-list-timeline">
                                        <div class="kt-list-timeline__items">
                                            <div class="kt-list-timeline__item single">
                                                <span class="kt-list-timeline__badge"></span>
                                                <span class="kt-list-timeline__text" style="width: 80px!important">Регион</span>
                                                <span id="regions" class="kt-list-timeline__time" style="width: 100%!important"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a id="showSectionsManagementModalButton" title="Добавить/удалить разделы" class="btn btn-secondary btn-square kt-margin-b-20" href="#" data-id="">Добавить/удалить разделы</a>
                        </div>
                    </div>
                    <!--begin: Datatable -->
                    <table id="templateSectionsList" class="table table-bordered table-hover table-checkable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Раздел</th>
                            <th>Вес</th>
                        </tr>
                        </thead>
                    </table>
                    <!--end: Datatable -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Template Show Modal-->

    <!-- Show Questions Modal -->
    <div class="modal" id="showQuestionsModal" tabindex="-1" role="dialog" aria-labelledby="showQuestionsModalTitle" aria-hidden="true">
        <div class="modal-dialog mw-100 w-50 modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showQuestionsModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body kt-scroll" data-scroll="true">
                    <div class="kt-invoice-2">
                        <div class="col-12 text-center">
                            <a id="showQuestionsManagementModalButton" title="Добавить/удалить вопросы" class="btn btn-secondary btn-square kt-margin-b-20" href="#" data-id="">Добавить/удалить вопросы</a>
                        </div>
                    </div>
                    <!--begin: Datatable -->
                    <table id="templateSectionsQuestionsList" class="table table-bordered table-hover table-checkable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Вопрос</th>
                            <th>Должности</th>
                        </tr>
                        </thead>
                    </table>
                    <!--end: Datatable -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Show Questions Modal-->

    <!-- Template Sections Modal -->
    <div class="modal" id="templateSections" tabindex="-1" role="dialog" aria-labelledby="templateSectionsTitle"
         aria-hidden="true">
        <div class="modal-dialog mw-100 w-75 modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateSectionsTitle">Управление разделами шаблона</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="dual-listbox">
                        <div style="flex-basis: 0; flex-grow: 1;">
                            <form id="sectionsAddedForm" action="" method="post">
                                @method('DELETE')
                            </form>
                            <h4 class="text-center">Разделы в шаблоне</h4>
                            <div id="sectionsAdded_container" class="kt-scroll" data-scroll="true"
                                 style="height: 75vh; overflow: hidden;">
                                <!--begin: Datatable -->
                                <table id="sectionsAdded" class="table table-bordered table-hover table-checkable">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Раздел</th>
                                    </tr>
                                    </thead>
                                </table>
                                <!--end: Datatable -->
                            </div>
                        </div>
                        <div class="dual-listbox__buttons">
                            <button id="addSectionButton" class="dual-listbox__button"><i class="flaticon2-back"></i>
                            </button>
                            <button id="removeSectionButton" class="dual-listbox__button"><i class="flaticon2-next"></i>
                            </button>
                        </div>
                        <div style="flex-basis: 0; flex-grow: 1;">
                            <form id="unAppliedSectionsForm" action="" method="post">
                            </form>
                            <h4 class="text-center">Доступные разделы</h4>
                            <div id="unAppliedSections_container" class="kt-scroll" data-scroll="true"
                                 style="height: 75vh; overflow: hidden;">
                                <!--begin: Datatable -->
                                <table id="unAppliedSections" class="table table-bordered table-hover table-checkable">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Раздел</th>
                                    </tr>
                                    </thead>
                                </table>
                                <!--end: Datatable -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Template Sections Modal-->

    <!-- Template Sections Weight Edit Modal -->
    <div id="templateSectionWeightEdit" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateQuestionsTitle">Вес раздела</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="weightEditForm" class="kt-form" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label class="kt-form__label" for="sectionWeight">Вес:</label>
                            <input id="sectionWeight" class="form-control" type="number" name="weight" value="">
                            <span class="form-text text-muted">Эта настройка будет сохранена только для этого шаблона.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="weightEditFormSubmitButton" type="button" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Template Sections Weight Edit Modal-->

    <!-- Template Positions Edit Modal -->
    <div id="templatePositionsModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templatePositionsModalTitle">Должности</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="templatePositionsForm" class="kt-form" action="" method="POST">
                        @csrf
                        <input type="hidden" name="template_id" value="">
                        <input type="hidden" name="question_id" value="">
                        <div class="form-group">
                            <label class="kt-form__label">Должности для этого вопроса:</label>
                            <select style="width:100%" class="form-control m-select2" id="positions" name="positions[]" multiple="multiple">
                            </select>
                            <span class="form-text text-muted">Эта настройка будет сохранена только для этого шаблона.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="positionsQuestionTemplateFormSubmitButton" type="button" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Template Positions Edit Modal-->

    <!-- Template Questions Management Modal -->
    <div class="modal" id="templateQuestionsManagement" tabindex="-1" role="dialog" aria-labelledby="templateQuestionsManagementTitle"
         aria-hidden="true">
        <div class="modal-dialog mw-100 w-75 modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateQuestionsManagementTitle">Управление вопросами в разделе шаблона</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="dual-listbox">
                        <div style="flex-basis: 0; flex-grow: 1;">
                            <form id="questionsAddedForm" action="" method="post">
                                @method('DELETE')
                            </form>
                            <h4 class="text-center">Вопросы в разделе</h4>
                            <div id="questionsAdded_container" class="kt-scroll" data-scroll="true"
                                 style="height: 75vh; overflow: hidden;">
                                <!--begin: Datatable -->
                                <table id="questionsAdded" class="table table-bordered table-hover table-checkable">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Раздел</th>
                                    </tr>
                                    </thead>
                                </table>
                                <!--end: Datatable -->
                            </div>
                        </div>
                        <div class="dual-listbox__buttons">
                            <button id="addQuestionButton" class="dual-listbox__button"><i class="flaticon2-back"></i>
                            </button>
                            <button id="removeQuestionButton" class="dual-listbox__button"><i class="flaticon2-next"></i>
                            </button>
                        </div>
                        <div style="flex-basis: 0; flex-grow: 1;">
                            <form id="unAppliedQuestionsForm" action="" method="post">
                            </form>
                            <h4 class="text-center">Доступные вопросы</h4>
                            <div id="unAppliedQuestions_container" class="kt-scroll" data-scroll="true"
                                 style="height: 75vh; overflow: hidden;">
                                <!--begin: Datatable -->
                                <table id="unAppliedQuestions" class="table table-bordered table-hover table-checkable">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Раздел</th>
                                    </tr>
                                    </thead>
                                </table>
                                <!--end: Datatable -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
    <!--end::Template Questions Management Modal-->

    <!-- end:: Content -->

@endsection

@push('scripts')
    <script src="/js/template.js"></script>
    <script type="text/javascript" src="/assets/app/custom/templates/select.js"></script>
@endpush

@push('page-css')
    <link href="/assets/app/custom/templates/dual-questions-listbox.default.css" rel="stylesheet" type="text/css"/>
@endpush

@push('global-config')
    <script>
        $.blockUI.defaults.overlayCSS.backgroundColor = '#fff';
        $.blockUI.defaults.overlayCSS.opacity = 1;
        $.blockUI.defaults.fadeIn = 0;
        $.blockUI.defaults.fadeOut = 0;
        $.blockUI.defaults.css.border = 'none';
        $.blockUI.defaults.message = '<div class="blockui "><span>Обработка данных...</span><span><div class="kt-spinner kt-spinner--v2 kt-spinner--primary "></div></span></div>';

        $.fn.select2.amd.define('select2/i18n/ru', [], function () {
            // Russian
            return {
                errorLoading: function () {
                    return 'Результат не может быть загружен.';
                },
                inputTooLong: function (args) {
                    var overChars = args.input.length - args.maximum;
                    var message = 'Пожалуйста, удалите ' + overChars + ' символ';
                    if (overChars >= 2 && overChars <= 4) {
                        message += 'а';
                    } else if (overChars >= 5) {
                        message += 'ов';
                    }
                    return message;
                },
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    var message = 'Пожалуйста, введите ' + remainingChars + ' или более символов';

                    return message;
                },
                loadingMore: function () {
                    return 'Загружаем ещё ресурсы…';
                },
                maximumSelected: function (args) {
                    var message = 'Вы можете выбрать ' + args.maximum + ' элемент';

                    if (args.maximum >= 2 && args.maximum <= 4) {
                        message += 'а';
                    } else if (args.maximum >= 5) {
                        message += 'ов';
                    }

                    return message;
                },
                noResults: function () {
                    return 'Ничего не найдено';
                },
                searching: function () {
                    return 'Поиск…';
                }
            };
        });
    </script>
@endpush
