@extends('lists.layouts.base')

@push('page-css')
    <link href="/assets/app/custom/wizard/wizard-v4.default.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div id="#kt_page_portlet" class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-line-chart"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Заявки на проверку
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
                        <th>Начало</th>
                        <th>Окончание</th>
                        <th>ОП</th>
                        <th>АЗС</th>
                        <th>Вид проверки</th>
                        <th>Проверяющий</th>
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
                    <h5 class="modal-title" id="modalLongTitle">Новая заявка на проверку</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Form-->
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                                    <div class="kt-wizard-v4" id="kt_wizard_v4" data-ktwizard-state="step-first">
                                        <!--begin: Form Wizard Nav -->
                                        <div class="kt-wizard-v4__nav">
                                            <div class="kt-wizard-v4__nav-items">
                                                <a class="kt-wizard-v4__nav-item" href="#" data-ktwizard-type="step" data-ktwizard-state="current">
                                                    <div class="kt-wizard-v4__nav-body">
                                                        <div class="kt-wizard-v4__nav-number">
                                                            1
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label">
                                                            <div class="kt-wizard-v4__nav-label-title">
                                                                АЗС
                                                            </div>
                                                            <div class="kt-wizard-v4__nav-label-desc">
                                                                Проверяемая АЗС
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="kt-wizard-v4__nav-item" href="#" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v4__nav-body">
                                                        <div class="kt-wizard-v4__nav-number">
                                                            2
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label">
                                                            <div class="kt-wizard-v4__nav-label-title">
                                                                Дата
                                                            </div>
                                                            <div class="kt-wizard-v4__nav-label-desc">
                                                                Дата или период проверки
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="kt-wizard-v4__nav-item" href="#" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v4__nav-body">
                                                        <div class="kt-wizard-v4__nav-number">
                                                            3
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label">
                                                            <div class="kt-wizard-v4__nav-label-title">
                                                                Тип
                                                            </div>
                                                            <div class="kt-wizard-v4__nav-label-desc">
                                                                Установка типа проверки
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="kt-wizard-v4__nav-item" href="#" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v4__nav-body">
                                                        <div class="kt-wizard-v4__nav-number">
                                                            4
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label">
                                                            <div class="kt-wizard-v4__nav-label-title">
                                                                Ответственный
                                                            </div>
                                                            <div class="kt-wizard-v4__nav-label-desc">
                                                                Выбор ответственного
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a class="kt-wizard-v4__nav-item" href="#" data-ktwizard-type="step">
                                                    <div class="kt-wizard-v4__nav-body">
                                                        <div class="kt-wizard-v4__nav-number">
                                                            5
                                                        </div>
                                                        <div class="kt-wizard-v4__nav-label">
                                                            <div class="kt-wizard-v4__nav-label-title">
                                                                Создание заявки
                                                            </div>
                                                            <div class="kt-wizard-v4__nav-label-desc">
                                                                Обзор параметров
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!--end: Form Wizard Nav -->
                                        <div class="kt-portlet">
                                            <div class="kt-portlet__body kt-portlet__body--fit">
                                                <div class="kt-grid">
                                                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">
                                                        <!--begin: Form Wizard Form-->
                                                        <form action="{{ route('tasks.store') }}" method="POST" class="kt-form" id="kt_form">
                                                            @method('PUT')
                                                            <!--begin: Form Wizard Step 1-->
                                                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                                                <div class="kt-heading kt-heading--md"></div>
                                                                <div class="kt-form__section kt-form__section--first">
                                                                    <div class="kt-wizard-v4__form">
                                                                        <div class="form-group">
                                                                            <label>Номер АЗС</label>
                                                                            <select style="width:100%" class="form-control m-select2" id="gasStation" name="gas_station_id">
                                                                            </select>
                                                                            <span class="form-text text-muted">Выберите номер из списка.</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end: Form Wizard Step 1-->
                                                            <!--begin: Form Wizard Step 2-->
                                                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                                <div class="kt-heading kt-heading--md"></div>
                                                                <div class="kt-form__section kt-form__section--first">
                                                                    <div class="kt-wizard-v4__form">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Дата или период проверки</label>
                                                                            <div class="input-daterange input-group" id="kt_datepicker_5">
                                                                                <input type="text" class="form-control" name="start_date" />
                                                                                <div class="input-group-append">
                                                                                    <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" name="end_date" />
                                                                            </div>
                                                                            <span class="form-text text-muted">Укажите дату или период в который должна выполнится проверка</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end: Form Wizard Step 2-->
                                                            <!--begin: Form Wizard Step 3-->
                                                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                                <div class="kt-heading kt-heading--md"></div>
                                                                <div class="kt-form__section kt-form__section--first">
                                                                    <div class="kt-wizard-v4__form">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label" for="type-of-checklist">Тип шаблона:</label>
                                                                            <select style="width:100%" class="form-control m-select2" id="typeOfChecklist" name="type_of_checklists_id">
                                                                            </select>
                                                                            <span class="form-text text-muted">Выберите тип проверки</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end: Form Wizard Step 3-->
                                                            <!--begin: Form Wizard Step 4-->
                                                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                                <div class="kt-heading kt-heading--md"></div>
                                                                <div class="kt-form__section kt-form__section--first">
                                                                    <div class="kt-wizard-v4__form">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label" for="type-of-checklist">Ответственный</label>
                                                                            <select style="width:100%" class="form-control m-select2" id="user" name="user_id">
                                                                            </select>
                                                                            <span class="form-text text-muted">Выберите ответственного сотрудника</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end: Form Wizard Step 4-->
                                                            <!--begin: Form Wizard Step 5-->
                                                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content">
                                                                <div class="kt-heading kt-heading--md"></div>
                                                                <div class="kt-form__section kt-form__section--first">
                                                                    <div class="kt-wizard-v4__review">
                                                                        <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="kt-wizard-v4__review-item">
                                                                            <div class="kt-wizard-v4__review-title">
                                                                                АЗС
                                                                            </div>
                                                                            <div class="kt-wizard-v4__review-content">
                                                                                <span data-name="gas_station_id"></span>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="kt-wizard-v4__review-item">
                                                                            <div class="kt-wizard-v4__review-title">
                                                                                Тип проверки
                                                                            </div>
                                                                            <div class="kt-wizard-v4__review-content">
                                                                                <span data-name="type_of_checklists_id"></span>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        </div>
                                                                        <div class="kt-divider pt-4 pb-4">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="kt-wizard-v4__review-item">
                                                                            <div class="kt-wizard-v4__review-title">
                                                                                Ответственный
                                                                            </div>
                                                                            <div class="kt-wizard-v4__review-content">
                                                                                <span data-name="user_id"></span>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="kt-wizard-v4__review-item">
                                                                            <div class="kt-wizard-v4__review-title">
                                                                                Даты
                                                                            </div>
                                                                            <div class="kt-wizard-v4__review-content">
                                                                                с <abbr title="Первый день проверки"><span data-name="start_date"></span></abbr><br>
                                                                                до <abbr title="Последний день проверки"><span data-name="end_date"></span></abbr>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end: Form Wizard Step 5-->
                                                            <!--begin: Form Actions -->
                                                            <div class="kt-form__actions">
                                                                <div class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-prev">
                                                                    Назад
                                                                </div>
                                                                <div class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-submit">
                                                                    submit
                                                                </div>
                                                                <div class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" data-ktwizard-type="action-next">
                                                                    Вперёд
                                                                </div>
                                                            </div>
                                                            <!--end: Form Actions -->
                                                        </form>
                                                        <!--end: Form Wizard Form-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
@endsection

@push('scripts')
    <script>
        "use strict";
        !function(a){a.fn.datepicker.dates.ru={days:["Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота"],daysShort:["Вск","Пнд","Втр","Срд","Чтв","Птн","Суб"],daysMin:["Вс","Пн","Вт","Ср","Чт","Пт","Сб"],months:["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"],monthsShort:["Янв","Фев","Мар","Апр","Май","Июн","Июл","Авг","Сен","Окт","Ноя","Дек"],today:"Сегодня",clear:"Очистить",format:"dd.mm.yyyy",weekStart:1,monthsTitle:"Месяцы"}}(jQuery);

        let KTDatatablesDataSourceAjaxServer = function() {
            var wizardEl;
            var formEl;
            var validator;
            var wizard;

            let table = $('#recordsTable');
            let form = $('#recordsForm');
            //let buttonSubmit = $('#recordsFormSubmit');
            let modal = $('#recordsModal');
            let newButton = $('#newRecordsButton');

            let initTable = function() {

                let DTtable = table.DataTable({
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('tasks.index') }}',
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
                        {
                            data: 'start_date',
                            type: 'num',
                            render: {
                                _: 'display',
                                sort: 'timestamp'
                            }
                        },
                        {
                            data: 'end_date',
                            type: 'num',
                            render: {
                                _: 'display',
                                sort: 'timestamp'
                            }
                        },
                        {data: 'region.title'},
                        {data: 'station.number'},
                        {data: 'type.title'},
                        {data: 'user.profile.full_name'},
                        {
                            data: '',
                            searchable: false,
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
                                columns: [ 0, 1]
                            }
                        },
                        {
                            extend: 'copyHtml5',
                            text: '<i class="kt-nav__link-icon la la-copy"></i> <span class="kt-nav__link-text">Копировать</span>',
                            exportOptions: {
                                columns: [ 0, 1]
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="kt-nav__link-icon la la-file-excel-o"></i> <span class="kt-nav__link-text">Excel</span>',
                            exportOptions: {
                                columns: [ 0, 1]
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
                                columns: [ 0, 1]
                            }
                        },
                    ]
                }).container().appendTo($('#buttons'));

                return DTtable;
            };
            let newPosition = function(gasStationList, typeOfChecklistList, usersList, dateRange) {
                newButton.on('click', function (el) {
                    formEl.attr('action', '{{ route('tasks.store') }}');
                    modal.find('input[name=_method]').val('POST');
                    wizard.goFirst();
                    gasStationList.val(null).trigger('change');
                    typeOfChecklistList.val(null).trigger('change');
                    usersList.val(null).trigger('change');
                    $('input[name=start_date]', dateRange).datepicker("clearDates");
                    $('input[name=end_date]', dateRange).datepicker("clearDates");
                    modal.modal('show');
                });
            };
            let deletePosition = function(DTtable) {
                table.on('click', '.positionsDelete', function(e){
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    if (confirm("Удалить элемент")) {
                        $.ajax({
                            url: '/api/tasks/'+record_id,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                DTtable.ajax.reload(null, false);
                                toastr.success(response.data.id, "Заявка удалена");
                            },
                            error: function(xhr, status, errorThrown) {
                                let toastrTitle = 'Неопознанная ошибка!';
                                let toastrMessage = '';
                                if (xhr.hasOwnProperty('responseJSON')) {
                                    toastrTitle = errorThrown;
                                    if(xhr.responseJSON.hasOwnProperty('errors')) {
                                        toastrMessage = Object.keys(xhr.responseJSON.errors).map(function (key) { return xhr.responseJSON.errors[key] + '<br>'; });
                                    }
                                    else{
                                        toastrMessage = (xhr.responseJSON.hasOwnProperty('message')) ? xhr.responseJSON.message : '';
                                    }
                                }
                                toastr.error(toastrMessage, toastrTitle);
                            }
                        })
                    }
                });
            };
            let editPosition = function(DTtable, gasStationList, typeOfChecklistList, usersList, dateRange) {
                table.on('click', '.positionsEdit', function(e){
                    let record_id = this.closest('tr').getAttribute('id').slice(4);
                    $.get("{{ route('tasks.index') }}" +'/' + record_id, function (response) {
                        console.log(formEl);
                        formEl.attr('action', '{{ route('tasks.index') }}' + '/' + response.data.id);
                        let el = '<input type="hidden" name="task_id" value="'+response.data.id+'" />';
                        formEl.append(el);
                        modal.find('input[name=_method]').val('PUT');
                        wizard.goFirst();
                        gasStationList.val(null).trigger('change');
                        if(response.data.hasOwnProperty('station')) {
                            let currentStation = new Option(response.data.station.number, response.data.station.id, true, true);
                            gasStationList.append(currentStation).trigger('change');
                        }
                        typeOfChecklistList.val(null).trigger('change');
                        if(response.data.hasOwnProperty('type')) {
                            let currentType = new Option(response.data.type.title, response.data.type.id, true, true);
                            typeOfChecklistList.append(currentType).trigger('change');
                        }
                        usersList.val(null).trigger('change');
                        if(response.data.hasOwnProperty('user')) {
                            let currentUser = new Option(response.data.user.profile.full_name, response.data.user.id, true, true);
                            usersList.append(currentUser).trigger('change');
                        }
                        $('input[name=start_date]', dateRange).datepicker("setDate", response.data.start_date);
                        $('input[name=end_date]', dateRange).datepicker("setDate", response.data.end_date);
                        modal.modal('show');
                    })
                });
            };
            let setDate = function() {
                let datepicker = $('#kt_datepicker_5').datepicker({
                    language: 'ru',
                    todayHighlight: true,
                    autoclose: true,
                });
                datepicker.on('changeDate', function(event) {
                    let formEl = $('#kt_form');
                    $('*[data-name="'+event.target.getAttribute('name')+'"]', formEl).text(event.format('dd-mm-yyyy'));
                });
                return datepicker;
            };
            let getGasStationList = function() {
                return $("#gasStation").select2({
                    language: "ru",
                    placeholder: "Выберите...",
                    ajax: {
                        url: "{{ route('gasstations.index') }}",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                number: params.term
                            };
                        },
                        processResults: function (response) {
                            let res = response.data.map(function (item) {
                                return {id: item.id, text: item.number};
                            });
                            return {
                                results: res
                            };
                        },
                        cache: false
                    }
                });
            };
            let getGasStation = function(GSList, usersList) {
                GSList.on('select2:select', function (e) {
                    usersList.val(null).trigger('change');
                });
            };
            let getTypeOfChecklistList = function() {
                return $("#typeOfChecklist").select2({
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
            let getUsersList = function(GSList) {
                return $("#user").select2({
                    language: "ru",
                    placeholder: "Выберите...",
                    ajax: {
                        url: "/api/regions/users",
                        type: "get",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                title: params.term,
                                gas_station_id: $('option:selected', GSList).val(),
                            };
                        },
                        processResults: function (response) {
                            let res = response.data.map(function (item) {
                                return {id: item.id, text: item.full_name};
                            });
                            return {
                                results: res
                            };
                        },
                        cache: false
                    }
                });
            };
            let initValidation = function() {
                validator = formEl.validate({
                    // Validate only visible fields
                    ignore: ":hidden",

                    // Validation rules
                    rules: {
                        //= Step 1
                        gas_station_id: {
                            required: true
                        },

                        //= Step 2
                        start_date: {
                            required: true
                        },
                        end_date: {
                            required: true
                        },

                        //= Step 3
                        type_of_checklists_id: {
                            required: true
                        },

                        //= Step 4
                        user_id: {
                            required: true
                        },

                    },

                    // Display error
                    invalidHandler: function(event, validator) {
                        KTUtil.scrollTop();
                        toastr.error('Заполните все необходимые поля', "Ошибка!");
                    },

                    // Submit valid form
                    submitHandler: function (form) {

                    }
                });
            };
            let initWizard = function () {
                wizard = new KTWizard('kt_wizard_v4', {
                    startStep: 1,
                });
                wizard.on('beforeNext', function(wizardObj) {
                    if (validator.form() !== true) {
                        wizardObj.stop();  // don't go to the next step
                    }
                });
                wizard.on('change', function(wizard) {
                    KTUtil.scrollTop();
                });
                $('#kt_wizard_v4 .m-select2').on('change.select2', function(event){
                    if(this.selectedIndex >= 0) {
                        $('*[data-name="' + event.target.getAttribute('name') + '"]', formEl).text(this.options[this.selectedIndex].text);
                        validator.element($(this));
                    }
                });
            };
            let initSubmit = function(DTtable) {
                let btn = formEl.find('[data-ktwizard-type="action-submit"]');

                btn.on('click', function(e) {
                    e.preventDefault();

                    if (validator.form()) {
                        // See: src\js\framework\base\app.js
                        KTApp.progress(btn);
                        KTApp.block(formEl);

                        // See: http://malsup.com/jquery/form/#ajaxSubmit
                        formEl.ajaxSubmit({
                            success: function(response) {
                                DTtable.ajax.reload(null, false);
                                KTApp.unprogress(btn);
                                KTApp.unblock(formEl);
                                modal.modal('hide');
                                toastr.success(response, "Отлично!");
                            },
                            error: function(xhr, status, errorThrown) {
                                let toastrTitle = 'Неопознанная ошибка!';
                                let toastrMessage = '';
                                if (xhr.hasOwnProperty('responseJSON')) {
                                    toastrTitle = errorThrown;
                                    if(xhr.responseJSON.hasOwnProperty('errors')) {
                                        toastrMessage = Object.keys(xhr.responseJSON.errors).map(function (key) { return xhr.responseJSON.errors[key] + '<br>'; });
                                    }
                                    else{
                                        toastrMessage = (xhr.responseJSON.hasOwnProperty('message')) ? xhr.responseJSON.message : '';
                                    }
                                }
                                toastr.error(toastrMessage, toastrTitle);
                                KTApp.unprogress(btn);
                                KTApp.unblock(formEl);
                            },
                        });
                    }
                });
            };

            return {
                init: function() {
                    let DTtable = initTable();
                    wizardEl = KTUtil.get('kt_wizard_v4');
                    formEl = $('#kt_form');
                    initValidation();
                    let gasStationList = getGasStationList();
                    let typeOfChecklistList = getTypeOfChecklistList();
                    let usersList = getUsersList(gasStationList);
                    let dateRange = setDate();
                    initSubmit(DTtable);
                    initWizard();
                    deletePosition(DTtable);
                    editPosition(DTtable, gasStationList, typeOfChecklistList, usersList, dateRange);
                    newPosition(gasStationList, typeOfChecklistList, usersList, dateRange);
                    getGasStation(gasStationList, usersList);
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
