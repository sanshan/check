@extends('lists.layouts.base')

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="alert alert-light alert-elevate" role="alert">
            <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
            <div class="alert-text">
                Управление справочником "Категории должности". <br>
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
                        Категории должности
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
                <table  class="table table-striped table-sm table-bordered table-hover table-checkable" id="recordsTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Код</th>
                        <th>Оценка</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Должность</h5>
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
                                        <label class="col-lg-3 col-form-label">Название должности:</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name ="title" placeholder="Введите название">
                                            <span class="form-text text-muted">До 100 символов</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Код должности</label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" name="code" placeholder="Введите код">
                                            <span class="form-text text-muted">До 10 символов</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Оценка:</label>
                                        <div class="col-lg-9">
                                            <div class="kt-radio-inline">
                                                <label class="kt-radio">
                                                    <input type="radio" name="to_rate" value="1"> Да
                                                    <span></span>
                                                </label>
                                                <label class="kt-radio">
                                                    <input type="radio" name="to_rate" value="0"> Нет
                                                    <span></span>
                                                </label>
                                            </div>
                                            <span class="form-text text-muted">Будет ли производиться оценка?</span>
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
                ajax: {
                    url: '{{ route('positions.index.datatable') }}',
                    headers: {
                        'Authorization': sessionStorage.getItem('token_type') + ' ' + sessionStorage.getItem('access_token')
                    }
                },
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
                        data: 'code',
                        render: function(d){
                            if(d !== null){
                                return '<abbr title="Код категории должности">' + d + '</abbr> ';
                            }else{
                                return '';
                            }
                        }
                    },
                    {data: 'to_rate'},
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
                                1: {'title': 'Да', 'class': 'kt-badge--success'},
                                false: {'title': 'Нет', 'class': ' kt-badge--danger'},
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
                    }
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
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'copyHtml5',
                        text: '<i class="kt-nav__link-icon la la-copy"></i> <span class="kt-nav__link-text">Копировать</span>',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="kt-nav__link-icon la la-file-excel-o"></i> <span class="kt-nav__link-text">Excel</span>',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: '<i class="kt-nav__link-icon la la-file-text-o"></i> <span class="kt-nav__link-text">CSV</span>',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="kt-nav__link-icon la la-file-pdf-o"></i> <span class="kt-nav__link-text">PDF</span>',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
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
                        maxlength: 100,
                    },
                    code: {
                        required: true,
                        minlength: 1,
                        maxlength: 10,
                    },
                    to_rate: {
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
                            toastr.success(values, response.message);
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

        let newPosition = function() {
            newButton.on('click', function (el) {
                form.attr('action', '{{ route('positions.store') }}');
                modal.find('input[name=_method]').val('POST');
                modal.find('input[name=title]').val('');
                modal.find('input[name=code]').val('');
                modal.find('input[name="to_rate"]').each(function(i) {
                    this.checked = false;
                });
                modal.modal('show');
            });
        };

        let deletePosition = function(DTtable) {
            table.on('click', '.positionsDelete', function(e){
                let position_id = this.closest('tr').getAttribute('id').slice(4);
                if (confirm("Удалить элемент")) {
                    $.ajax({
                        url: '/api/positions/'+position_id,
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

        let editPosition = function(DT_table) {
            table.on('click', '.positionsEdit', function(e){
                let position_id = this.closest('tr').getAttribute('id').slice(4);
                $.get("{{ route('positions.index') }}" +'/' + position_id, function (response) {
                    form.attr('action', '{{ route('positions.index') }}' + '/' + response.data.id);
                    let el = '<input type="hidden" name="position_id" value="'+response.data.id+'" />';
                    form.append(el);
                    modal.find('input[name=_method]').val('PUT');
                    modal.find('input[name=title]').val(response.data.title);
                    modal.find('input[name=code]').val(response.data.code);
                    modal.find('input[name=to_rate][value="'+Number(response.data.to_rate)+'"]').prop('checked', true);

                    modal.modal('show');
                })
            });

        };

        return {

            //main function to initiate the module
            init: function() {
                let DTtable = initTable();
                positionValidate(DTtable);
                submitForm();
                deletePosition(DTtable);
                editPosition();
                newPosition();
            },

        };

    }();

    jQuery(document).ready(function() {
        KTDatatablesDataSourceAjaxServer.init();
    });
</script>
@endpush
