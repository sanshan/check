<!-- Template Questions Modal -->

<div class="modal" id="templateQuestions" tabindex="-1" role="dialog" aria-labelledby="templateQuestionsTitle"
     aria-hidden="true">
    <div class="modal-dialog mw-100 w-75 modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateQuestionsTitle">Управление вопросами шаблона</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="dual-listbox">
                    <div style="flex-basis: 0; flex-grow: 1;">
                        <form id="questionsAddedForm" action="" method="post">
                            @method('DELETE')
                        </form>
                        <h4 class="text-center">Вопросы в разделе шаблона</h4>
                        <div id="questionsAdded_container" class="kt-scroll" data-scroll="true"
                             style="height: 75vh; overflow: hidden;">
                            <!--begin: Datatable -->
                            <table id="questionsAdded" class="table table-bordered table-hover table-checkable">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Вопрос</th>
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
                        <h4 class="text-center">Доступные для раздела вопросы</h4>
                        <div id="unAppliedQuestion_container" class="kt-scroll" data-scroll="true"
                             style="height: 75vh; overflow: hidden;">
                            <!--begin: Datatable -->
                            <table id="unAppliedQuestions" class="table table-bordered table-hover table-checkable">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Вопрос</th>
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

<!--end::Template Questions Modal-->

@push('scripts')
    <script>
        "use strict";
        let TemplateQuestionsManagement = function () {
            let modalTemplateQuestions = $('#templateQuestions');
            let modalTemplateQuestionsContent = modalTemplateQuestions.find('.modal-content');
            let questionsAddedElement = $('#questionsAdded');
            let unAppliedQuestionsElement = $('#unAppliedQuestions');
            let unAppliedQuestionsForm = $('#unAppliedQuestionsForm');
            let questionsAddedForm = $('#questionsAddedForm');

            let initQuestionsAddedTable = function (modelId) {
                let questionsAddedDataTable = questionsAddedElement.DataTable({
                    sPaginationType: 'listbox',
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '',
                    },

                    order: [[1, 'asc']],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json",
                        select: {
                            rows: {
                                '_': 'Вопросов выбрано: %d',
                                '0': '',
                                '1': 'Вопросов выбрано: %d'
                            }
                        }
                    },
                    columns: [
                        {data: 'DT_RowId'},
                        {data: 'id'},
                        {data: 'title'},
                    ],
                    select: {
                        style: 'multi',
                    },
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label class="kt-checkbox m-0 p-0"><input class="dt-checkboxes" type="checkbox"><span class="position-relative d-block"></span></label>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<label class="kt-checkbox m-0 p-0"><input class="dt-checkboxes" type="checkbox"><span class="position-relative d-block"></span></label>'
                            }
                        },
                        {
                            targets: 1,
                            width: '5%',
                        },
                    ],
                });

                questionsAddedElement.on('click', 'thead .dt-checkboxes-select-all', function (e) {
                    let $selectAll = $('input[type="checkbox"]', this);
                    setTimeout(function () {
                        questionsAddedElement.find('.group-checkbox').prop('checked', $selectAll.prop('checked'));
                    }, 0);
                });

                return questionsAddedDataTable;
            };

            let initUnAppliedQuestionsTable = function (modelId) {
                let unAppliedQuestionsDataTable = unAppliedQuestionsElement.DataTable({
                    sPaginationType: 'listbox',
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '',
                    },

                    order: [[1, 'asc']],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json",
                        select: {
                            rows: {
                                '_': 'Вопросов выбрано: %d',
                                '0': '',
                                '1': 'Вопросов выбрано: %d'
                            }
                        }
                    },
                    columns: [
                        {data: 'DT_RowId'},
                        {data: 'id'},
                        {data: 'title'},
                    ],
                    select: {
                        style: 'multi',
                    },
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<label class="kt-checkbox m-0 p-0"><input class="dt-checkboxes" type="checkbox"><span class="position-relative d-block"></span></label>';
                                }

                                return data;
                            },
                            'checkboxes': {
                                'selectRow': true,
                                'selectAllRender': '<label class="kt-checkbox m-0 p-0"><input class="dt-checkboxes" type="checkbox"><span class="position-relative d-block"></span></label>'
                            }
                        },
                        {
                            targets: 1,
                            width: '5%',
                        },
                    ],
                });

                unAppliedQuestionsElement.on('click', 'thead .dt-checkboxes-select-all', function (e) {
                    let $selectAll = $('input[type="checkbox"]', this);
                    setTimeout(function () {
                        unAppliedQuestionsElement.find('.group-checkbox').prop('checked', $selectAll.prop('checked'));
                    }, 0);
                });

                return unAppliedQuestionsDataTable;
            };

            let addQuestionButton = function () {
                modalTemplateQuestions.on('click', '#addQuestionButton', function (e) {
                    e.preventDefault();
                    unAppliedQuestionsForm.submit();
                })
            };

            let addQuestionFormSubmit = function (unAppliedTable, questionsAddedTable, modelId) {
                unAppliedQuestionsForm.off('submit').on('submit', function (e) {
                    e.preventDefault();
                    let form = this;
                    let rowsSelected = unAppliedTable.column(0).checkboxes.selected();
                    $.each(rowsSelected, function (index, rowId) {
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'sections[]')
                                .val(rowId.replace('row_', ''))
                        );
                    });

                    $(form).ajaxSubmit({
                        url: '',
                        success: function (response) {
                            unAppliedQuestionsForm.find("input[name='questions[]']").remove();
                            let values = 'Вопросы добавлены';
                            if (response.errors) {
                                let values = Object.keys(response.data).map(function (key) {
                                    return response.data[key] + '<br>';
                                });
                            }
                            if (response.message) {
                                values = response.message;
                            }
                            unAppliedTable.ajax.reload(function (data) {
                                unAppliedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            questionsAddedTable.ajax.reload(function (data) {
                                questionsAddedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            toastr.success(values, "Отлично!");
                        },
                        error: function (xhr, status, errorThrown) {
                            unAppliedQuestionsForm.find("input[name='questions[]']").remove();
                            let values = 'Что то пошло не так';
                            if (xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) {
                                    return errors[key] + '<br>';
                                });
                            }
                            if (xhr.responseJSON.message)
                                values = xhr.responseJSON.message;
                            toastr.error(values, 'Ошибка');
                        }
                    })
                })
            };

            let removeQuestionButton = function () {
                modalTemplateQuestions.on('click', '#removeQuestionButton', function (e) {
                    e.preventDefault();
                    questionsAddedForm.submit();
                })
            };

            let removeQuestionFormSubmit = function (unAppliedTable, questionsAddedTable, modelId) {
                questionsAddedForm.off('submit').on('submit', function (e) {
                    e.preventDefault();
                    let form = this;
                    let rowsSelected = questionsAddedTable.column(0).checkboxes.selected();
                    $.each(rowsSelected, function (index, rowId) {
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'questions[]')
                                .val(rowId.replace('row_', ''))
                        );
                    });

                    $(form).ajaxSubmit({
                        url: '',
                        success: function (response) {
                            questionsAddedForm.find("input[name='questions[]']").remove();
                            let values = 'Вопросы удалены из шаблона';
                            if (response.errors) {
                                let values = Object.keys(response.data).map(function (key) {
                                    return response.data[key] + '<br>';
                                });
                            }
                            if (response.message) {
                                values = response.message;
                            }
                            unAppliedTable.ajax.reload(function () {
                                unAppliedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            questionsAddedTable.ajax.reload(function () {
                                questionsAddedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            toastr.success(values, "Отлично!");
                        },
                        error: function (xhr, status, errorThrown) {
                            questionsAddedForm.find("input[name='question[]']").remove();
                            let values = 'Что то пошло не так';
                            if (xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) {
                                    return errors[key] + '<br>';
                                });
                            }
                            if (xhr.responseJSON.message)
                                values = xhr.responseJSON.message;
                            toastr.error(values, 'Ошибка');
                        }
                    })
                })
            };

            return {
                init: function () {
                    modalTemplateQuestions.on('show.bs.modal', function (event) {
                        let modelId = event.relatedTarget.dataset.id;
                        let questionsAddedDataTable = initQuestionsAddedTable(modelId);
                        let unAppliedQuestionsDataTable = initUnAppliedQuestionsTable(modelId);
                        addQuestionButton();
                        removeQuestionButton();
                        addQuestionFormSubmit(unAppliedQuestionsDataTable, questionsAddedDataTable, modelId);
                        removeQuestionFormSubmit(unAppliedQuestionsDataTable, questionsAddedDataTable, modelId);
                    });

                    modalTemplateQuestions.on('hide.bs.modal', function (event) {
                        questionsAddedElement.DataTable().clear();
                        questionsAddedElement.DataTable().destroy();
                        unAppliedQuestionsElement.DataTable().clear();
                        unAppliedQuestionsElement.DataTable().destroy();
                        let templateQuestionsDataTable = $('#' + $.fn.dataTable.tables()[1].id).DataTable();
                        templateQuestionsDataTable.ajax.reload(null, false);
                        modalTemplateQuestions.off('click', '#removeQuestionButton');
                        modalTemplateQuestions.off('click', '#addQuestionButton');
                    })
                },
            };
        }();
        jQuery(document).ready(function () {
            TemplateQuestionsManagement.init();
        });
    </script>
@endpush
