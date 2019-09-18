@push('page-css')
    <link href="/assets/app/custom/templates/dual-questions-listbox.default.css" rel="stylesheet" type="text/css" />
@endpush

<!-- Template Questions Modal -->

<div class="modal" id="templateQuestions" tabindex="-1" role="dialog" aria-labelledby="templateQuestionsTitle" aria-hidden="true">
    <div class="modal-dialog mw-100 w-75 modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateQuestionsTitle">Управление вопросами шаблона</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="dual-listbox">
                    <div>
                        <form id="questionsAddedForm" action="" method="post">
                            @method('PUT')
                        </form>
                        <h4 class="text-center">Вопросы в шаблоне</h4>
                        <div id="questionsAdded_container" class="kt-scroll" data-scroll="true" style="height: 75vh; overflow: hidden;">
                            <!--begin: Datatable -->
                            <table id="questionsAdded" class="table table-bordered table-hover table-checkable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Вопрос</th>
                                        <th>Раздел</th>
                                    </tr>
                                </thead>
                            </table>
                            <!--end: Datatable -->
                        </div>
                    </div>
                    <div class="dual-listbox__buttons">
                        <button id="addQuestionButton" class="dual-listbox__button"><i class="flaticon2-back"></i></button>
                        <button id="removeQuestionButton" class="dual-listbox__button"><i class="flaticon2-next"></i></button>
                    </div>
                    <div>
                        <form id="unAppliedQuestionsForm" action="" method="post">
                            @method('PATCH')
                        </form>
                        <h4 class="text-center">Доступные вопросы</h4>
                        <div id="unAppliedQuestions_container" class="kt-scroll" data-scroll="true" style="height: 75vh; overflow: hidden;">
                            <!--begin: Datatable -->
                            <table id="unAppliedQuestions" class="table table-bordered table-hover table-checkable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>#</th>
                                        <th>Вопрос</th>
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

<!--end::Template Questions Modal-->

@push('scripts')
    <script type="text/javascript" src="/assets/app/custom/templates/select.js"></script>
@endpush

@push('scripts')
    <script>
        "use strict";
        let TemplateQuestionsManagement = function() {
            let modalTemplateQuestionsShowButton = $('#questionsButton');
            let modalTemplateQuestions = $('#templateQuestions');
            let modalTemplateQuestionsContent = modalTemplateQuestions.find('.modal-content');
            let questionsAddedElement = $('#questionsAdded');
            let unAppliedQuestionsElement = $('#unAppliedQuestions');
            let unAppliedQuestionsForm = $('#unAppliedQuestionsForm');
            let questionsAddedForm = $('#questionsAddedForm');

            let initQuestionsAddedTable = function(modelId) {
                let questionsAddedDataTable = questionsAddedElement.DataTable({
                    sPaginationType: 'listbox',
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '/api/templates/'+modelId+'/questions',
                    orderFixed: [1, 'asc'],
                    order: [[1, 'asc']],
                    fnPreDrawCallback:function(){
                        //$('#questionsAdded_container').block();
                    },
                    fnInitComplete:function(){
                        //$('#questionsAdded_container').unblock();
                    },
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
                    rowGroup: {
                        dataSrc: 'section.resource.title',
                        startRender: function(rows, group) {
                            // Assign class name to all child rows
                            var groupName = 'group-' + group.replace(/[^A-Za-z0-9]/g, '');
                            var rowNodes = rows.nodes();
                            rowNodes.to$().addClass(groupName);

                            // Get selected checkboxes
                            var checkboxesSelected = $('.dt-checkboxes:checked', rowNodes);

                            // Parent checkbox is selected when all child checkboxes are selected
                            var isSelected = (checkboxesSelected.length === rowNodes.length);

                            return '<div class="group-checkbox__container"><div class="group-checkbox__wrapper">' +
                                        '<label class="kt-checkbox kt-checkbox--brand"><input class="group-checkbox" type="checkbox" data-group-name="' + groupName + '"' + (isSelected ? ' checked' : '') +'>&nbsp;<span></span></label>'+
                                    '</div>' +
                                    '<div class="group-checkbox__title"> ' + group + ' (' + rows.count() + ')</div></div>';
                        }
                    },
                    columns: [
                        {
                            data: 'DT_RowId',
                            checkboxes: {
                                selectRow: true
                            }
                        },
                        {data: 'id'},
                        {data: 'title'},
                        {data: 'section.resource.title'},
                    ],
                    select: {
                        style: 'multi',
                    },
                    columnDefs: [
                        { "orderable": false, "targets": 0 },
                        {
                            targets: 1,
                            width: '5%',
                        },
                        {
                            targets: -1,
                            visible: false,
                        },
                    ],
                });

                questionsAddedElement.on('click', '.group-checkbox', function(e){
                    let groupName = $(this).data('group-name');
                    questionsAddedDataTable.cells('tr.' + groupName, 0).checkboxes.select(this.checked);
                });

                questionsAddedElement.on('click', 'thead .dt-checkboxes-select-all', function(e){
                    let $selectAll = $('input[type="checkbox"]', this);
                    setTimeout(function(){
                        questionsAddedElement.find('.group-checkbox').prop('checked', $selectAll.prop('checked'));
                    }, 0);
                });

                return questionsAddedDataTable;
            };

            let initUnAppliedQuestionsTable = function(modelId) {
                let unAppliedQuestionsDataTable = unAppliedQuestionsElement.DataTable({
                    sPaginationType: 'listbox',
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '/api/templates/'+modelId+'/questions/available',
                    orderFixed: [1, 'asc'],
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
                    fnPreDrawCallback:function(){
                        //$('#unAppliedQuestions_container').block();
                    },
                    fnInitComplete:function(){
                        //$('#unAppliedQuestions_container').unblock();
                    },
                    rowGroup: {
                        dataSrc: 'section.resource.title',
                        startRender: function(rows, group) {
                            // Assign class name to all child rows
                            var groupName = 'group-' + group.replace(/[^A-Za-z0-9]/g, '');
                            var rowNodes = rows.nodes();
                            rowNodes.to$().addClass(groupName);

                            // Get selected checkboxes
                            var checkboxesSelected = $('.dt-checkboxes:checked', rowNodes);

                            // Parent checkbox is selected when all child checkboxes are selected
                            var isSelected = (checkboxesSelected.length === rowNodes.length);

                            return '<div class="group-checkbox__container"><div class="group-checkbox__wrapper">' +
                                '<label class="kt-checkbox kt-checkbox--brand"><input class="group-checkbox" type="checkbox" data-group-name="' + groupName + '"' + (isSelected ? ' checked' : '') +'>&nbsp;<span></span></label>'+
                                '</div>' +
                                '<div class="group-checkbox__title"> ' + group + ' (' + rows.count() + ')</div></div>';
                        }
                    },
                    columns: [
                        {
                            data: 'DT_RowId',
                            checkboxes: {
                                selectRow: true
                            }
                        },
                        {data: 'id'},
                        {data: 'title'},
                        {data: 'section.resource.title'},
                    ],
                    select: {
                        style: 'multi',
                    },
                    columnDefs: [
                        { "orderable": false, "targets": 0 },
                        {
                            targets: 1,
                            width: '5%',
                        },
                        {
                            targets: -1,
                            visible: false,
                        },
                    ],
                });

                unAppliedQuestionsElement.on('click', '.group-checkbox', function(e){
                    let groupName = $(this).data('group-name');
                    unAppliedQuestionsDataTable.cells('tr.' + groupName, 0).checkboxes.select(this.checked);
                });

                unAppliedQuestionsElement.on('click', 'thead .dt-checkboxes-select-all', function(e){
                    let $selectAll = $('input[type="checkbox"]', this);
                    setTimeout(function(){
                        unAppliedQuestionsElement.find('.group-checkbox').prop('checked', $selectAll.prop('checked'));
                    }, 0);
                });

                return unAppliedQuestionsDataTable;
            };

            let addQuestionButton = function() {
                modalTemplateQuestions.on('click', '#addQuestionButton', function (e) {
                    e.preventDefault();
                    console.log('Добавить');
                    unAppliedQuestionsForm.submit();
                })
            };

            let addQuestionFormSubmit = function(unAppliedTable, questionsAddedTable, modelId) {
                unAppliedQuestionsForm.off('submit').on('submit', function (e) {
                    e.preventDefault();
                    //console.log(modelId);
                    let form = this;
                    let rowsSelected = unAppliedTable.column(0).checkboxes.selected();
                    $.each(rowsSelected, function(index, rowId){
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'question_id[]')
                                .val(rowId.replace('row_',''))
                        );
                    });

                    $(form).ajaxSubmit({
                        url: '/api/templates/'+modelId+'/questions/add',
                        data: {'template_id': modelId},
                        success: function(response) {
                            unAppliedQuestionsForm.find("input[name='question_id[]']").remove();
                            let values = 'Вопросы добавлены';
                            if(response.errors) {
                                let values = Object.keys(response.data).map(function (key) {
                                    return response.data[key] + '<br>';
                                });
                            }
                            if(response.message) {
                                values = response.message;
                            }
                            unAppliedTable.ajax.reload(function(data){
                                unAppliedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            questionsAddedTable.ajax.reload(function(data){
                                questionsAddedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            toastr.success(values, "Отлично!");
                        },
                        error: function(xhr, status, errorThrown) {
                            unAppliedQuestionsForm.find("input[name='question_id[]']").remove();
                            let values = 'Что то пошло не так';
                            if(xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) {
                                    return errors[key] + '<br>';
                                });
                            }
                            if(xhr.responseJSON.message)
                                values = xhr.responseJSON.message;
                            toastr.error(values, 'Ошибка');
                        }
                    })
                })
            };

            let removeQuestionButton = function() {
                modalTemplateQuestions.on('click', '#removeQuestionButton', function (e) {
                    e.preventDefault();
                    console.log('Удалить');
                    questionsAddedForm.submit();
                })
            };

            let removeQuestionFormSubmit = function(unAppliedTable, questionsAddedTable, modelId) {
                questionsAddedForm.off('submit').on('submit', function (e) {
                    e.preventDefault();
                    let form = this;
                    let rowsSelected = questionsAddedTable.column(0).checkboxes.selected();
                    $.each(rowsSelected, function(index, rowId){
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'question_id[]')
                                .val(rowId.replace('row_',''))
                        );
                    });

                    $(form).ajaxSubmit({
                        url: '/api/templates/'+modelId+'/questions/remove',
                        data: {'template_id': modelId},
                        success: function(response) {
                            questionsAddedForm.find("input[name='question_id[]']").remove();
                            let values = 'Вопросы удалены из шаблона';
                            if(response.errors) {
                                let values = Object.keys(response.data).map(function (key) {
                                    return response.data[key] + '<br>';
                                });
                            }
                            if(response.message) {
                                values = response.message;
                            }
                            unAppliedTable.ajax.reload(function(){
                                unAppliedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            questionsAddedTable.ajax.reload(function(){
                                questionsAddedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            toastr.success(values, "Отлично!");
                        },
                        error: function(xhr, status, errorThrown) {
                            questionsAddedForm.find("input[name='question_id[]']").remove();
                            let values = 'Что то пошло не так';
                            if(xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) {
                                    return errors[key] + '<br>';
                                });
                            }
                            if(xhr.responseJSON.message)
                                values = xhr.responseJSON.message;
                            toastr.error(values, 'Ошибка');
                        }
                    })
                })
            };

            return {
                init: function() {
                    modalTemplateQuestions.on('show.bs.modal', function (event) {
                        let modelId = event.relatedTarget.dataset.id;
                        let questionsAddedDataTable = initQuestionsAddedTable(modelId);
                        let unAppliedQuestionsDataTable = initUnAppliedQuestionsTable(modelId);
                        addQuestionButton();
                        removeQuestionButton();
                        addQuestionFormSubmit(unAppliedQuestionsDataTable, questionsAddedDataTable, modelId);
                        removeQuestionFormSubmit(unAppliedQuestionsDataTable, questionsAddedDataTable, modelId);
                    });

                    modalTemplateQuestionsShowButton.on('click', function (e) {
                        e.preventDefault();
                        modalTemplateQuestions.modal('show', this);
                    });

                    modalTemplateQuestions.on('hide.bs.modal', function (event) {
                        questionsAddedElement.DataTable().clear();
                        questionsAddedElement.DataTable().destroy();
                        unAppliedQuestionsElement.DataTable().clear();
                        unAppliedQuestionsElement.DataTable().destroy();
                        unAppliedQuestionsElement.DataTable().clear();
                        unAppliedQuestionsElement.DataTable().destroy();
                        let templateQuestionsDataTable = $('#'+$.fn.dataTable.tables()[1].id).DataTable();
                        templateQuestionsDataTable.ajax.reload(null, false);
                        modalTemplateQuestions.off('click', '#removeQuestionButton');
                        modalTemplateQuestions.off('click', '#addQuestionButton');
                    })
                },
            };
        }();
        jQuery(document).ready(function() {
            TemplateQuestionsManagement.init();
        });
    </script>
@endpush
