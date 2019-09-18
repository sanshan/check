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
        <div id="#kt_page_portlet" class="kt-portlet kt-portlet--mobile">
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
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Экспорт
                                </button>
                                <div id="buttons" style="padding-top:0!important;" class="dropdown-menu dropdown-menu-right">
                                </div>
                            </div>
                            &nbsp;
                            <a id="newRecordsButton" href="#" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                Новая запись
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <!--begin: Datatable -->
                <table id="recordsTable" class="table table-sm table-bordered table-hover table-checkable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Номер шаблона</th>
                        <th>Тип ТЗК</th>
                        <th>Тип шаблона</th>
                        <th>Регионы</th>
                        <th>Вопросов</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                    </thead>
                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <!-- end:: Content -->

    <!-- Modal -->
    <div class="modal fade" id="recordsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle">Шаблон</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <form id="recordsForm" class="kt-form" action="" method="POST">
                        @csrf
                        @method('POST')
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Тип ТЗК:</label>
                                        <div class="col-lg-9">
                                            <select style="width:100%" class="form-control m-select2" id="gas-station-types" name="type_of_gas_station_id[]" multiple="multiple">
                                            </select>
                                            <span class="form-text text-muted">Выберите тип ТЗК</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Тип шаблона:</label>
                                            <div class="col-lg-6">
                                                <select style="width:100%" class="form-control m-select2" id="type-of-checklist" name="type_of_checklist_id">
                                                </select>
                                                <span class="form-text text-muted">Выберите тип проверки</span>
                                            </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Регионы:</label>
                                        <div class="col-lg-9">
                                            <select style="width:100%" class="form-control m-select2" id="regions" name="region_id[]" multiple="multiple">
                                            </select>
                                            <span class="form-text text-muted">Выберите регионы</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Статус:</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" name="it_works">
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
                    <button id="recordsFormSubmit" type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!--end::Modal-->

    @include('audit.templates._show')
    @include('audit.templates._position-edit')

@endsection

@push('scripts')
    <script>
        "use strict";
        let KTDatatablesDataSourceAjaxServer = function() {

            let table = $('#recordsTable');
            let form = $('#recordsForm');
            let buttonSubmit = $('#recordsFormSubmit');
            let modal = $('#recordsModal');
            let newButton = $('#newRecordsButton');

            let modalShow = $('#model-show');
            let modalShowContent = modalShow.find('.modal-content');

            let templateQuestionsList = $('#templateQuestionsList');
            let templateQuestionsEditPositions = $('#templateQuestionsEditPositions');
            let templateQuestionsEditPositionsForm = $('#templateQuestionsEditPositions form');
            let positionsQuestionTemplateFormSubmitButton = $('#positionsQuestionTemplateFormSubmitButton', templateQuestionsEditPositions);


            let initTable = function() {

                let DTtable = table.DataTable({
                    deferRender: true,
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('templates.index') }}',
                    language: {
                        buttons: {
                            copyTitle: 'Копировать в буфер обмена',
                            copySuccess: {
                                _: 'Скопировано %d строк',
                                1: '1 строка скопирована'
                            }
                        },
                        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'link'},
                        {
                            data: 'type_of_gas_station.resource',
                            render: function(d){
                                if(d !== null){
                                    let temp_table = '';
                                    $.each(d, function(k, v){
                                        temp_table += '<abbr title="' + v.title + '">' + v.abbreviation + '</abbr> ';
                                    });
                                    return temp_table;
                                }else{
                                    return '';
                                }
                            }
                        },
                        {data: 'type_of_checklist.resource.title'},
                        {
                            data: 'regions.resource',
                            render: function(d){
                                if(d !== null){
                                    let temp_table = '';
                                    $.each(d, function(k, v){
                                        temp_table += '<span class="kt-badge kt-shape-bg-color-1 kt-badge--inline">'+v.title+'</span> ';
                                    });
                                    return temp_table;
                                }else{
                                    return '';
                                }
                            }
                        },
                        {data: 'questions_count'},
                        {data: 'status'},
                        {data: '', responsivePriority: -1},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '5%',
                        },
                        {
                            targets: -1,
                            width: '5%',
                            title: '',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item positionsDelete" href="#"><i class="la la-trash"></i> Удалить</a>
                                <a class="dropdown-item positionsEdit" href="#" title="View"><i class="la la-edit"></i>  Редактировать</a>
                            </div>
                        </span>`;
                            },
                        },
                        {
                            targets: -2,
                            width: '10%',
                            render: function(data, type, full, meta) {
                                let status = {
                                    1: {'title': 'Вкл.', 'class': 'kt-badge--success'},
                                    0: {'title': 'Выкл.', 'class': ' kt-badge--danger'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                            },
                        },
                    ],
                });


                let buttons = new $.fn.dataTable.Buttons(table, {
                    dom: {
                        container: {
                            tag: 'ul',
                            className: 'kt-nav',
                        },
                        buttonContainer: {
                            tag: 'li',
                            className: 'kt-nav__item'
                        },
                        button: {
                            tag: 'a',
                            className: 'kt-nav__link',
                        }
                    },
                    buttons: [
                        {
                            extend: 'print',
                            text: '<i class="kt-nav__link-icon la la-print"></i> <span class="kt-nav__link-text">Распечатать</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'copyHtml5',
                            text: '<i class="kt-nav__link-icon la la-copy"></i> <span class="kt-nav__link-text">Копировать</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-excel-o"></i> <span class="kt-nav__link-text">Excel</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-text-o"></i> <span class="kt-nav__link-text">CSV</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-pdf-o"></i> <span class="kt-nav__link-text">PDF</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4]
                            }
                        },
                    ]
                }).container().appendTo($('#buttons'));

                return DTtable;
            };

            let positionValidate = function (DTtable) {
                form.validate({
                    // define validation rules
                    rules: {
                        'type_of_gas_station_id[]': {
                            required: true,
                        },
                        type_of_checklist_id: {
                            required: true,
                        },
                        'region_id[]': {
                            required: true,
                        },
                        it_works: {
                            required: true,
                        },
                    },

                    //display error alert on form submit
                    invalidHandler: function(event, validator) {
                        KTUtil.scrollTop();
                    },

                    submitHandler: function (form) {
                        $(form).ajaxSubmit({
                            url: form.action,
                            type: 'POST',
                            beforeSend: function() {
                                KTApp.block(modal);
                            },
                            success: function(response) {
                                let values = Object.keys(response.data).map(function (key) { return response.data[key] + '<br>'; });
                                DTtable.ajax.reload(null, false);
                                modal.modal('hide');
                                KTApp.unblock(modal);
                                toastr.success(values, "Отлично!");
                            },
                            error: function(xhr, status, errorThrown) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) { return errors[key] + '<br>'; });
                                toastr.error(values, 'Ошибка');
                                KTApp.unblock(modal);
                            }
                        });
                        return false;
                    }
                });
            };

            let submitForm = function() {
                buttonSubmit.on('click', function(e){
                    form.submit();
                });
            };

            let newPosition = function(typeOfGasStation, typeOfChecklist, regions) {
                newButton.on('click', function (el) {
                    form.attr('action', '{{ route('templates.store') }}');
                    modal.find('input[name=_method]').val('POST');
                    typeOfGasStation.val(null).trigger('change');
                    typeOfChecklist.val(null).trigger('change');
                    regions.val(null).trigger('change');
                    modal.find('select[name=it_works]').val('');
                    modal.modal('show');
                });
            };

            let deletePosition = function(DTtable) {
                table.on('click', '.positionsDelete', function(e){
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    if (confirm("Удалить элемент")) {
                        $.ajax({
                            url: '/api/templates/'+record_id,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                toastr.success(response.data.title, "Удалён элемент");
                                DTtable.ajax.reload(null, false);
                            },
                            error: function(xhr, status, errorThrown) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) { return errors[key] + '<br>'; });
                                toastr.error(values, 'Ошибка');
                            }
                        })
                    }
                });
            };

            let editPosition = function(typeOfGasStation, typeOfChecklist, regions) {
                table.on('click', '.positionsEdit', function(e){
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    $.get("{{ route('templates.index') }}" +'/' + record_id, function (response) {
                        form.attr('action', '{{ route('templates.index') }}' + '/' + response.data.id);
                        let el = '<input type="hidden" name="template_id" value="'+response.data.id+'" />';
                        form.append(el);
                        modal.find('input[name=_method]').val('PUT');
                        typeOfGasStation.val(null).trigger('change');
                        if(response.data.gas_station_types) {
                            response.data.gas_station_types.forEach(function(d) {
                                let option = new Option(d.abbreviation, d.id, true, true);
                                typeOfGasStation.append(option).trigger('change');
                            });
                            typeOfGasStation.trigger({
                                type: 'select2:select',
                                params: {
                                    data: response.data.gas_station_types
                                }
                            });
                        }
                        typeOfChecklist.val(null).trigger('change');
                        if(response.data.template_types) {
                            let currentTemplateType = new Option(response.data.template_types.title, response.data.template_types.id, true, true);
                            typeOfChecklist.append(currentTemplateType).trigger('change');
                        }
                        regions.val(null).trigger('change');
                        if(response.data.regions) {
                            response.data.regions.forEach(function(d) {
                                let option = new Option(d.title, d.id, true, true);
                                regions.append(option).trigger('change');
                            });
                            regions.trigger({
                                type: 'select2:select',
                                params: {
                                    data: response.data.regions
                                }
                            });
                        }
                        modal.find('select[name=it_works]').val(response.data.status);
                        modal.modal('show');
                    })
                });
            };

            let showPosition = function(DTtable) {
                table.on('click', '.model-show', function (e) {
                    e.preventDefault();
                    let modelId = e.target.dataset.id;
                    let templateQuestionsDT= initTemplateQuestions(modelId);
                    modalShowContent.block({
                        onBlock: function(){
                            modalShow.modal('show');
                            $.ajax({
                                url: "{{ route('templates.index') }}" +'/' + modelId,
                                type: 'GET',
                                success: function(response) {
                                    modalShow.find('.modal-title').text('');
                                    modalShow.find('#created_at').text('');
                                    modalShow.find('#author').text('');
                                    modalShow.find('#updated_at').text('');
                                    modalShow.find('#editor').text('');

                                    modalShow.find('.modal-title').text('Шаблон №' + response.data.title);
                                    modalShow.find('#created_at').text(response.data.created_at);
                                    modalShow.find('#author').text(response.data.author.profile.full_name);
                                    if(response.data.editor) {
                                        modalShow.find('#updated_at').text(response.data.updated_at);
                                        modalShow.find('#editor').text(response.data.editor.profile.full_name);
                                    }
                                    if(response.data.type_of_gas_station !== null){
                                        let temp_table = '';
                                        $.each(response.data.type_of_gas_station, function(k, v){
                                            temp_table += v.abbreviation + '; ';
                                        });
                                        modalShow.find('#gasStationTypes').text(temp_table);
                                    }
                                    modalShow.find('#templateTypes').text(response.data.type_of_checklist.title);
                                    if(response.data.regions) {
                                        let temp_table = '';
                                        $.each(response.data.regions, function (k, v) {
                                            temp_table += '<span class="kt-badge kt-shape-bg-color-1 kt-badge--inline mt-1 mb-1">'+v.title+'</span> ';
                                        });
                                        modalShow.find('#regions').html(temp_table);
                                    }
                                    let status = {
                                        1: {'title': 'Активен', 'class': 'kt-badge--success'},
                                        0: {'title': 'Выключен', 'class': 'kt-badge--danger'},
                                    };
                                    if (typeof status[response.data.status] !== 'undefined') {
                                        modalShow.find('#status').html('<span class="kt-badge ' + status[response.data.status].class + ' kt-badge--inline kt-badge--pill">' + status[response.data.status].title + '</span>');
                                    }
                                    modalShow.find('#questionsButton').attr('data-id', response.data.id);
                                },
                                error: function(xhr, status, errorThrown) {
                                    let values = 'Ошибка получения данных с сервера';
                                    toastr.error(values, 'Ошибка');
                                }
                            }).done(function() {
                                modalShowContent.unblock();
                            });
                        }
                    });

                    modalShow.on('hide.bs.modal', function (event) {
                        templateQuestionsList.DataTable().clear();
                        templateQuestionsList.DataTable().destroy();
                        DTtable.ajax.reload(null, false);
                    });

                });

            };

            let getRegions = function() {
                return $("#regions").select2({
                    language: "ru",
                    placeholder: "Выберите...",
                    minimumResultsForSearch: 5,
                    ajax: {
                        url: "{{ route('regions.index') }}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                title: params.term
                            };
                        },
                        processResults: function (response) {
                            let res = response.data.map(function (item) {
                                return {id: item.id, text: item.title};
                            });
                            return {
                                results: res
                            };
                        },
                        cache: false
                    }
                });
            };

            let getGasStationTypes = function() {
                return $("#gas-station-types").select2({
                    language: "ru",
                    placeholder: "Выберите...",
                    minimumResultsForSearch: 5,
                    ajax: {
                        url: "{{ route('typeofgasstations.index') }}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                title: params.term
                            };
                        },
                        processResults: function (response) {
                            let res = response.data.map(function (item) {
                                return {id: item.id, text: item.abbreviation};
                            });
                            return {
                                results: res
                            };
                        },
                        cache: true
                    }
                });
            };

            let getTypeOfChecklists = function() {
                return $("#type-of-checklist").select2({
                    language: "ru",
                    placeholder: "Выберите...",
                    ajax: {
                        url: "{{ route('typeofchecklists.index') }}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                title: params.term
                            };
                        },
                        processResults: function (response) {
                            let res = response.data.map(function (item) {
                                return {id: item.id, text: item.title};
                            });
                            return {
                                results: res
                            };
                        },
                        cache: true
                    }
                });
            };

            let initTemplateQuestions = function(modelId) {
                templateQuestionsList.DataTable({
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '/api/templates/'+modelId+'/questions',
                    orderFixed: [0, 'asc'],
                    order: [[0, 'asc']],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json",
                    },
                    rowGroup: {
                        dataSrc: 'section.resource.title',
                        startRender: function(rows, group) {
                            // Assign class name to all child rows
                            let groupName = 'group-' + group.replace(/[^A-Za-z0-9]/g, '');
                            let rowNodes = rows.nodes();
                            rowNodes.to$().addClass(groupName);

                            return '<div class="row"><div class="col-8">' + group + '</div><div class="col-4 text-right">asdas</div></div>';
                        }
                    },
                    columns: [
                        {data: 'id'},
                        {
                            data: 'title',
                            render: function(data, type, row, meta){
                                if(row.edited)
                                    return data+'<span class="kt-badge kt-badge--warning kt-badge--inline">изменено</span>';

                                return data;
                            }
                        },
                        {
                            data: 'positions.resource',
                            render: function(data, type, row, meta){
                                if(data !== null){
                                    let temp_table = '';
                                    $.each(data, function(k, v){
                                        temp_table += v.code + '; ';
                                    });
                                    return '<a href="#" class="edit-positions underline" data-toggle="modal" data-id="'+row.id+'">'+temp_table+'</a>';
                                }else{
                                    return '';
                                }
                            }
                        },
                        {data: 'section.resource.title'},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '5%',
                        },
                        {
                            targets: -1,
                            visible: false,
                        },
                    ],
                    preDrawCallback: function( settings ) {
                        let api = this.api();
                        $(api.table().body()).off('click', '.edit-positions');
                    },
                    drawCallback: function(settings){
                        let api = this.api();
                        editPositions(api, modelId)
                    },
                });
            };

            let editPositions = function(api, modelId){
                $(api.table().body()).on('click', '.edit-positions', function (event) {
                    let question_id = event.target.dataset.id;
                    let positions = $('#positions', templateQuestionsEditPositionsForm);
                    positions.val(null).trigger('change');
                    $.get('{{ route('templates.index') }}' + '/' + modelId + '/questions/' + question_id + '/positions/index', function (response) {
                        templateQuestionsEditPositionsForm.attr('action', '{{ route('templates.index') }}' + '/' + modelId + '/questions/' + question_id + '/positions/update');
                        templateQuestionsEditPositions.find('input[name=template_id]').val(modelId);
                        templateQuestionsEditPositions.find('input[name=question_id]').val(question_id);
                        positions.val(null).trigger('change');
                        if(response.data) {
                            response.data.forEach(function(d) {
                                let option = new Option(d.title, d.id, true, true);
                                positions.append(option).trigger('change');
                            });
                            positions.trigger({
                                type: 'select2:select',
                                params: {
                                    data: response.data
                                }
                            });
                        }
                    }).done(function(){
                        templateQuestionsEditPositions.modal('show');
                    });
                });
            };

            let getPositions = function() {
                return $("#positions").select2({
                    language: "ru",
                    placeholder: "Выберите...",
                    minimumResultsForSearch: 5,
                    ajax: {
                        url: "{{ route('positions.index') }}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                title: params.term
                            };
                        },
                        processResults: function (response) {
                            let res = response.data.map(function (item) {
                                return {id: item.id, text: item.title};
                            });
                            return {
                                results: res
                            };
                        },
                        cache: false
                    }
                });
            };

            let templateQuestionsEditPositionsShowEvent = function(){
                $(document).on('show.bs.modal', '.modal', function (event) {
                    let zIndex = 1040 + (10 * $('.modal:visible').length);
                    $(this).css('z-index', zIndex);
                    $(this).css('z-index', zIndex);
                    setTimeout(function() {
                        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                    }, 0);
                });

                templateQuestionsEditPositions.on('show.bs.modal', function (event) {
                    getPositions();
                });
                templateQuestionsEditPositions.on('hide.bs.modal', function (event) {
                    let positions = $('#positions', templateQuestionsEditPositionsForm);
                    positions.empty().trigger("change");
                    positions.select2('destroy');
                });

            };

            let templateQuestionsEditPositionsFormSubmit = function() {
                positionsQuestionTemplateFormSubmitButton.on('click', function(e){
                    templateQuestionsEditPositionsForm.submit();
                });
            };

            let templateQuestionsEditPositionsFormValidate = function() {
                templateQuestionsEditPositionsForm.validate({
                    rules: {
                        'position_id[]': {
                            required: true,
                        },
                    },
                    invalidHandler: function(event, validator) {
                        KTUtil.scrollTop();
                    },
                    submitHandler: function () {
                        $(templateQuestionsEditPositionsForm).ajaxSubmit({
                            url: templateQuestionsEditPositionsForm.action,
                            type: 'POST',
                            success: function(response) {
                                let values = response.message;
                                templateQuestionsList.DataTable().ajax.reload(null, false);
                                templateQuestionsEditPositions.modal('hide');
                                toastr.success(values, "Отлично!");
                            },
                            error: function(xhr, status, errorThrown) {
                                let values = '';
                                if (xhr.responseJSON.hasOwnProperty('message')) {
                                    values = xhr.responseJSON.message;
                                }
                                toastr.error(values, 'Ошибка');
                            }
                        });
                        return false;
                    }
                });
            };

            return {
                init: function() {
                    let DTtable = initTable();
                    let regions = getRegions();
                    let typeOfGasStation = getGasStationTypes();
                    let typeOfChecklist = getTypeOfChecklists();
                    positionValidate(DTtable);
                    submitForm();
                    deletePosition(DTtable);
                    newPosition(typeOfGasStation, typeOfChecklist, regions);
                    editPosition(typeOfGasStation, typeOfChecklist, regions);
                    showPosition(DTtable);
                    templateQuestionsEditPositionsShowEvent();
                    templateQuestionsEditPositionsFormSubmit();
                    templateQuestionsEditPositionsFormValidate();
                },

            };

        }();

        jQuery(document).ready(function() {
            KTDatatablesDataSourceAjaxServer.init();
        });
    </script>
@endpush

@push('global-config')
    <script>
        $.blockUI.defaults.overlayCSS.backgroundColor = '#fff';
        $.blockUI.defaults.overlayCSS.opacity = 1;
        $.blockUI.defaults.fadeIn = 0;
        $.blockUI.defaults.fadeOut = 0;
        $.blockUI.defaults.css.border = 'none';
        $.blockUI.defaults.message = '<div class="blockui "><span>Обработка данных...</span><span><div class="kt-spinner kt-spinner--v2 kt-spinner--primary "></div></span></div>';

        $.fn.select2.amd.define('select2/i18n/ru',[],function () {
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

                    if (args.maximum  >= 2 && args.maximum <= 4) {
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
