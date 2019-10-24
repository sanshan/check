@extends('lists.layouts.base')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="alert alert-light alert-elevate" role="alert">
            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
            <div class="alert-text">
                Управление вопросами. <br>
                <u>Функционал:</u>
                <ul>
                    <li>Добавление / удаление / редактирование</li>
                    <li>Просмотр вопросов по разделам</li>
                    <li>Просмотр вопросов в разделе</li>
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
                        Вопросы {{ $section ? 'раздела "'.$section->title.'"' : '' }}
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
                        <th>Название</th>
                        <th>Код категории должности</th>
                        <th>Обязательный</th>
                        <th>Частично</th>
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
    <div class="modal fade" id="recordsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle">Вопрос</h5>
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
                                        <label class="col-lg-3 col-form-label">Текст вопроса:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="title" placeholder="">
                                            <span class="form-text text-muted">До 500 символов</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Должности:</label>
                                        <div class="col-lg-9">
                                            <select style="width:100%" class="form-control m-select2" id="positions"
                                                    name="position_id[]" multiple="multiple">
                                            </select>
                                            <span class="form-text text-muted">Выберите должности для проверки</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Обязательный?</label>
                                        <div class="col-lg-9">
                                            <div class="kt-radio-inline">
                                                <label class="kt-radio">
                                                    <input type="radio" name="required" value="1"> Да
                                                    <span></span>
                                                </label>
                                                <label class="kt-radio">
                                                    <input type="radio" name="required" value="0"> Нет
                                                    <span></span>
                                                </label>
                                            </div>
                                            <span class="form-text text-muted">Является ли вопрос обязательным для ответа</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Частично?</label>
                                        <div class="col-lg-9">
                                            <div class="kt-radio-inline">
                                                <label class="kt-radio">
                                                    <input type="radio" name="partly" value="1"> Да
                                                    <span></span>
                                                </label>
                                                <label class="kt-radio">
                                                    <input type="radio" name="partly" value="0"> Нет
                                                    <span></span>
                                                </label>
                                            </div>
                                            <span class="form-text text-muted">Возможно ли выполнить требование частично?</span>
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
@endsection

@push('scripts')
    <script>
        "use strict";
        let KTDatatablesDataSourceAjaxServer = function () {

            let table = $('#recordsTable');
            let form = $('#recordsForm');
            let buttonSubmit = $('#recordsFormSubmit');
            let modal = $('#recordsModal');
            let newButton = $('#newRecordsButton');

            let initTable = function () {

                let DTtable = table.DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: '{{ route('sections.questions.index.datatable', ['section' => $section->id]) }}',
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
                        {data: 'title'},
                        {
                            data: 'positions.resource',
                            searchable: false,
                            orderable: false,
                            render: function (d) {
                                if (d !== null) {
                                    let temp_table = '';
                                    $.each(d, function (k, v) {
                                        temp_table += v.code + '; ';
                                    });
                                    return temp_table;
                                } else {
                                    return '';
                                }
                            }
                        },
                        {data: 'required'},
                        {data: 'partly'},
                        {
                            data: '',
                            searchable: false,
                            orderable: false,
                            responsivePriority: -1
                        },
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
                            render: function (data, type, full, meta) {
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
                            render: function (data, type, full, meta) {
                                let status = {
                                    1: {'title': 'Да', 'class': 'kt-badge--success'},
                                    0: {'title': 'Нет', 'class': ' kt-badge--danger'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                            },
                        },
                        {
                            targets: -3,
                            width: '10%',
                            render: function (data, type, full, meta) {
                                let status = {
                                    1: {'title': 'Да', 'class': 'kt-badge--success'},
                                    0: {'title': 'Нет', 'class': ' kt-badge--danger'},
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
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'copyHtml5',
                            text: '<i class="kt-nav__link-icon la la-copy"></i> <span class="kt-nav__link-text">Копировать</span>',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-excel-o"></i> <span class="kt-nav__link-text">Excel</span>',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-text-o"></i> <span class="kt-nav__link-text">CSV</span>',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-pdf-o"></i> <span class="kt-nav__link-text">PDF</span>',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4]
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
                        title: {
                            required: true,
                            minlength: 3,
                            maxlength: 500,
                        },
                        'position_id[]': {
                            required: true,
                        },
                        required: {
                            required: true,
                        },
                        partly: {
                            required: true,
                        },
                    },

                    //display error alert on form submit
                    invalidHandler: function (event, validator) {
                        KTUtil.scrollTop();
                    },

                    submitHandler: function (form) {
                        $(form).ajaxSubmit({
                            url: form.action,
                            type: 'POST',
                            beforeSend: function () {
                                KTApp.block(modal);
                            },
                            success: function (response) {
                                let values = Object.keys(response.data).map(function (key) {
                                    return response.data[key] + '<br>';
                                });
                                DTtable.ajax.reload(null, false);
                                modal.modal('hide');
                                KTApp.unblock(modal);
                                toastr.success(values, response.message);
                            },
                            error: function (xhr, status, errorThrown) {
                                let toastrTitle = 'Неопознанная ошибка!';
                                let toastrMessage = '';
                                if (xhr.hasOwnProperty('responseJSON')) {
                                    toastrTitle = errorThrown;
                                    if (xhr.responseJSON.hasOwnProperty('errors')) {
                                        toastrMessage = Object.keys(xhr.responseJSON.errors).map(function (key) {
                                            return xhr.responseJSON.errors[key] + '<br>';
                                        });
                                    } else {
                                        toastrMessage = (xhr.responseJSON.hasOwnProperty('message')) ? xhr.responseJSON.message : '';
                                    }
                                }
                                toastr.error(toastrMessage, toastrTitle);
                                KTApp.unblock(modal);
                            }
                        });
                        return false;
                    }
                });
            };

            let submitForm = function () {
                buttonSubmit.on('click', function (e) {
                    form.submit();
                });
            };

            let newPosition = function (positions) {
                newButton.on('click', function (el) {
                    form.attr('action', '{{ route('questions.store', ['section' => $section->id]) }}');
                    modal.find('input[name=_method]').val('POST');
                    modal.find('input[name=title]').val('');
                    positions.val(null).trigger('change');
                    modal.find('input[name="required"]').each(function (i) {
                        this.checked = false;
                    });
                    modal.find('input[name="partly"]').each(function (i) {
                        this.checked = false;
                    });
                    modal.modal('show');
                });
            };

            let deletePosition = function (DTtable) {
                table.on('click', '.positionsDelete', function (e) {
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    if (confirm("Удалить элемент")) {
                        $.ajax({
                            url: '/api/sections/{{ request()->route('section')->id }}/questions/' + record_id,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                            },
                            success: function (response) {
                                let values = Object.keys(response.data).map(function (key) {
                                    return response.data[key] + '<br>';
                                });
                                toastr.success(values, response.message);
                                DTtable.ajax.reload(null, false);
                            },
                            error: function (xhr, status, errorThrown) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) {
                                    return errors[key] + '<br>';
                                });
                                toastr.error(values, 'Ошибка');
                            }
                        })
                    }
                });
            };

            let editPosition = function (positions) {
                table.on('click', '.positionsEdit', function (e) {
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    $.get('/api/sections/{{ request()->route('section')->id }}/questions/' + record_id, function (response) {
                        form.attr('action', '/api/sections/{{ request()->route('section')->id }}/questions/' + response.data.id);
                        let el = '<input type="hidden" name="question_id" value="' + response.data.id + '" />';
                        form.append(el);
                        modal.find('input[name=_method]').val('PUT');
                        modal.find('input[name=title]').val(response.data.title);
                        positions.val(null).trigger('change');
                        if (response.data.positions) {
                            response.data.positions.forEach(function (d) {
                                let option = new Option(d.title, d.id, true, true);
                                positions.append(option).trigger('change');
                            });
                            positions.trigger({
                                type: 'select2:select',
                                params: {
                                    data: response.data.positions
                                }
                            });
                        }
                        modal.find('input[name=required][value="' + Number(response.data.required) + '"]').prop('checked', true);
                        modal.find('input[name=partly][value="' + Number(response.data.partly) + '"]').prop('checked', true);
                        modal.modal('show');
                    })
                });
            };

            let getPositions = function () {
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

            return {
                //main function to initiate the module
                init: function () {
                    let DTtable = initTable();
                    let positions = getPositions();
                    positionValidate(DTtable);
                    submitForm();
                    deletePosition(DTtable);
                    editPosition(positions);
                    newPosition(positions);
                    getPositions();
                },

            };

        }();

        jQuery(document).ready(function () {
            KTDatatablesDataSourceAjaxServer.init();
        });
    </script>
@endpush


@push('global-config')
    <script>
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
