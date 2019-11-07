@push('page-css')
    <link href="/assets/app/custom/invoices/invoice-v2.default.css" rel="stylesheet" type="text/css" />
@endpush

<!-- Template Show Modal -->

<div class="modal" id="model-show" tabindex="-1" role="dialog" aria-labelledby="modelShowTitle" aria-hidden="true">
    <div class="modal-dialog mw-100 w-50 modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelShowTitle"></h5>
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

<!-- Template Show Questions -->

<div class="modal" id="templateShowQuestions" tabindex="-1" role="dialog" aria-labelledby="templateShowQuestionsTitle" aria-hidden="true">
    <div class="modal-dialog mw-100 w-50 modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateShowQuestionsTitle"></h5>
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
                <table id="templateQuestionsList" class="table table-bordered table-hover table-checkable">
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

<!--end::Template Show Questions-->

@push('page-css')
    <link href="/assets/app/custom/templates/dual-questions-listbox.default.css" rel="stylesheet" type="text/css"/>
@endpush

@push('scripts')
    <script type="text/javascript" src="/assets/app/custom/templates/select.js"></script>
@endpush

@include('audit.templates._sections')
@include('audit.templates._questions')
