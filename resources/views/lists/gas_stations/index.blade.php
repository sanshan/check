@extends('lists.layouts.base')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="alert alert-light alert-elevate" role="alert">
            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
            <div class="alert-text">
                Управление справочником "АЗС". <br>
                <u>Функционал:</u>
                <ul>
                    <li>Добавление / удаление / редактирование</li>
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
                        АЗС
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
                <table id="recordsTable" class="table table-striped table-sm table-bordered table-hover table-checkable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Номер</th>
                        <th>Регион</th>
                        <th>Тип</th>
                        <th>Адрес</th>
                        <th>Статус</th>
                        <th>Магазин</th>
                        <th>Начальник АЗС</th>
                        <th>Телефон АЗС</th>
                        <th>E-mail</th>
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLongTitle">АЗС</h5>
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
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Фамилия директора:</label>
                                                <input type="text" class="form-control" name="dir_surname" placeholder="">
                                                <span class="form-text text-muted">До 20 символов</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Имя директора:</label>
                                                <input type="text" class="form-control" name="dir_name" placeholder="">
                                                <span class="form-text text-muted">До 20 символов</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Отчество директора:</label>
                                                <input type="text" class="form-control" name="dir_patronymic" placeholder="">
                                                <span class="form-text text-muted">До 20 символов</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label>Адрес:</label>
                                                <input type="text" class="form-control" name="address" placeholder="">
                                                <span class="form-text text-muted">До 500 символов</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleSelect1">Тип АЗС:</label>
                                                <select style="width:100%" class="form-control m-select2" id="type-of-gas-station" name="type_of_gas_station_id">
                                                </select>
                                                <span class="form-text text-muted">Выберите тип АЗС</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Номер АЗС:</label>
                                                <input type="text" class="form-control" name="number" placeholder="">
                                                <span class="form-text text-muted">До 10 символов</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Email АЗС:</label>
                                                <input type="email" class="form-control" name="email" placeholder="">
                                                <span class="form-text text-muted">До 50 символов</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Телефон АЗС:</label>
                                                <input type="text" class="form-control" name="phone" placeholder="">
                                                <span class="form-text text-muted">До 50 символов</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleSelect1">Регион:</label>
                                                <select style="width:100%" class="form-control m-select2" id="regions" name="region_id">
                                                </select>
                                                <span class="form-text text-muted">Выберите регион АЗС</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleSelect1">Статус:</label>
                                                <select class="form-control" name="it_works">
                                                    <option>Выберите...</option>
                                                    <option value="1">Да</option>
                                                    <option value="0">Нет</option>
                                                </select>
                                                <span class="form-text text-muted">Азс работает?</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="exampleSelect1">Магазин:</label>
                                                <select class="form-control" name="is_shop">
                                                    <option>Выберите...</option>
                                                    <option value="1">Да</option>
                                                    <option value="0">Нет</option>
                                                </select>
                                                <span class="form-text text-muted">Есть магазин?</span>
                                            </div>
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
        let KTDatatablesDataSourceAjaxServer = function() {

            let table = $('#recordsTable');
            let form = $('#recordsForm');
            let buttonSubmit = $('#recordsFormSubmit');
            let modal = $('#recordsModal');
            let newButton = $('#newRecordsButton');

            let initTable = function() {

                let DTtable = table.DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('gasstations.index.datatable') }}',
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
                        {data: 'number'},
                        {
                            data: 'region',
                            searchable: false,
                            orderable: false,
                            render: function(d){
                                if(d !== null){
                                    return '<span class="kt-badge kt-shape-bg-color-1 kt-badge--inline">'+d+'</span>';
                                }else{
                                    return '';
                                }
                            }
                        },
                        {
                            data: 'type',
                            searchable: false,
                            orderable: false,
                            render: function(d){
                                if(d !== null){
                                    return '<abbr title="">' + d + '</abbr> ';
                                }else{
                                    return '';
                                }
                            }
                        },
                        {data: 'address'},
                        {data: 'it_works'},
                        {data: 'is_shop'},
                        {
                            data: 'dir_full_name',
                        },
                        {data: 'phone'},
                        {data: 'email'},
                        {
                            data: '',
                            responsivePriority: -1,
                            searchable:false
                        },
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '5%',
                        },
                        {
                            targets: 5,
                            width: '5%',
                            render: function(data, type, full, meta) {
                                let status = {
                                    1: {'title': 'Да', 'class': 'kt-badge--success'},
                                    0: {'title': 'Нет', 'class': ' kt-badge--warning'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                            },
                        },
                        {
                            targets: 6,
                            width: '5%',
                            render: function(data, type, full, meta) {
                                let status = {
                                    1: {'title': 'Да', 'class': 'kt-badge--success'},
                                    0: {'title': 'Нет', 'class': ' kt-badge--warning'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                            },
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
                                columns: [ 0, 1, 2, 3, 4, 7, 8, 9]
                            }
                        },
                        {
                            extend: 'copyHtml5',
                            text: '<i class="kt-nav__link-icon la la-copy"></i> <span class="kt-nav__link-text">Копировать</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 7, 8, 9]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-excel-o"></i> <span class="kt-nav__link-text">Excel</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 7, 8, 9]
                            }
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-text-o"></i> <span class="kt-nav__link-text">CSV</span>',
                            exportOptions: {
                                columns: [ 0, 1]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-pdf-o"></i> <span class="kt-nav__link-text">PDF</span>',
                            exportOptions: {
                                columns: [ 0, 1, 2, 3, 4, 7, 8, 9]
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
                        dir_surname: {
                            required: true,
                            minlength: 3,
                            maxlength: 20,
                        },
                        dir_patronymic: {
                            required: true,
                            minlength: 3,
                            maxlength: 20,
                        },
                        dir_name: {
                            required: true,
                            minlength: 3,
                            maxlength: 20,
                        },
                        address: {
                            required: true,
                            minlength: 3,
                            maxlength: 500,
                        },
                        type_of_gas_station_id: {
                            required: true,
                            digits: true,
                        },
                        number: {
                            required: true,
                            digits: true,
                            minlength: 3,
                            maxlength: 10,
                        },
                        email: {
                            required: true,
                            email: true,
                            minlength: 5,
                            maxlength: 50,
                        },
                        phone: {
                            required: true,
                            minlength: 5,
                            maxlength: 50,
                        },
                        region_id: {
                            required: true,
                            digits: true,
                        },
                        it_works: {
                            required: true,
                            digits: true,
                        },
                        is_shop: {
                            required: true,
                            digits: true,
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
                                toastr.success(values, response.message);
                            },
                            error: function(xhr, status, errorThrown) {
                                let errors = xhr.responseJSON.errors;
                                let values = Object.keys(errors).map(function (key) { return errors[key] + '<br>'; });
                                toastr.error(values, 'Ошибка!');
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

            let newPosition = function(type, region) {
                newButton.on('click', function (el) {
                    form.attr('action', '{{ route('gasstations.store') }}');
                    modal.find('input[name=_method]').val('POST');
                    modal.find('input[name=dir_name]').val('');
                    modal.find('input[name=dir_surname]').val('');
                    modal.find('input[name=dir_patronymic]').val('');
                    modal.find('input[name=address]').val('');
                    modal.find('input[name=number]').val('');
                    modal.find('input[name=email]').val('');
                    modal.find('input[name=phone]').val('');
                    modal.find('select[name=it_works]').val('');
                    modal.find('select[name=is_shop]').val('');
                    type.val(null).trigger('change');
                    region.val(null).trigger('change');
                    modal.modal('show');
                });
            };

            let deletePosition = function(DTtable) {
                table.on('click', '.positionsDelete', function(e){
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    if (confirm("Удалить элемент")) {
                        $.ajax({
                            url: '/api/gasstations/'+record_id,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                let values = Object.keys(response.data).map(function (key) { return response.data[key] + '<br>'; });
                                toastr.success(values, response.message);
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

            let editPosition = function(type, region) {
                table.on('click', '.positionsEdit', function(e){
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    $.get("{{ route('gasstations.index') }}" +'/' + record_id, function (response) {
                        form.attr('action', '{{ route('gasstations.index') }}' + '/' + response.data.id);
                        let el = '<input type="hidden" name="gas_station_id" value="'+response.data.id+'" />';
                        form.append(el);
                        modal.find('input[name=_method]').val('PUT');
                        modal.find('input[name=dir_name]').val(response.data.dir_name);
                        modal.find('input[name=dir_surname]').val(response.data.dir_surname);
                        modal.find('input[name=dir_patronymic]').val(response.data.dir_patronymic);
                        modal.find('input[name=address]').val(response.data.address);
                        modal.find('input[name=number]').val(response.data.number);
                        modal.find('input[name=email]').val(response.data.email);
                        modal.find('input[name=phone]').val(response.data.phone);
                        modal.find('select[name=it_works]').val(response.data.it_works);
                        modal.find('select[name=is_shop]').val(response.data.is_shop);
                        type.val(null).trigger('change');
                        region.val(null).trigger('change');
                        if(response.data.type) {
                            let currentType = new Option(response.data.type.abbreviation, response.data.type.id, true, true);
                            type.append(currentType).trigger('change');
                        }
                        if(response.data.region) {
                            let currentRegion = new Option(response.data.region.title, response.data.region.id, true, true);
                            region.append(currentRegion).trigger('change');
                        }
                        modal.modal('show');
                    })
                });
            };

            let getType = function() {
                return $("#type-of-gas-station").select2({
                    minimumResultsForSearch: Infinity,
                    language: "ru",
                    placeholder: "Выберите...",
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

            let getRegion = function() {
                return $("#regions").select2({
                    language: "ru",
                    placeholder: "Выберите...",
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
                        cache: true
                    }
                });
            };

            return {
                //main function to initiate the module
                init: function() {
                    let DTtable = initTable();
                    positionValidate(DTtable);
                    submitForm();
                    deletePosition(DTtable);
                    let selectType = getType();
                    let selectRegion = getRegion();
                    editPosition(selectType, selectRegion);
                    newPosition(selectType, selectRegion);
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

