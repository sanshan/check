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
@push('scripts')
    <script>
        "use strict";
        let TemplateSectionsManagement = function () {
            let showSectionsManagementModalButton = $('#showSectionsManagementModalButton');
            let modalTemplateSections = $('#templateSections');
            let modalTemplateSectionsContent = modalTemplateSections.find('.modal-content');
            let sectionsAddedElement = $('#sectionsAdded');
            let unAppliedSectionsElement = $('#unAppliedSections');
            let unAppliedSectionsForm = $('#unAppliedSectionsForm');
            let sectionsAddedForm = $('#sectionsAddedForm');

            let initSectionsAddedTable = function (modelId) {
                let sectionsAddedDataTable = sectionsAddedElement.DataTable({
                    sPaginationType: 'listbox',
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/api/templates/' + modelId + '/sections/',
                        data: {
                            'present_in_template': modelId
                        },
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

                sectionsAddedElement.on('click', 'thead .dt-checkboxes-select-all', function (e) {
                    let $selectAll = $('input[type="checkbox"]', this);
                    setTimeout(function () {
                        sectionsAddedElement.find('.group-checkbox').prop('checked', $selectAll.prop('checked'));
                    }, 0);
                });

                return sectionsAddedDataTable;
            };

            let initUnAppliedSectionsTable = function (modelId) {
                let unAppliedSectionsDataTable = unAppliedSectionsElement.DataTable({
                    sPaginationType: 'listbox',
                    async: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/api/sections/datatable',
                        data: {
                            'missing_in_template': modelId
                        },
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

                unAppliedSectionsElement.on('click', 'thead .dt-checkboxes-select-all', function (e) {
                    let $selectAll = $('input[type="checkbox"]', this);
                    setTimeout(function () {
                        unAppliedSectionsElement.find('.group-checkbox').prop('checked', $selectAll.prop('checked'));
                    }, 0);
                });

                return unAppliedSectionsDataTable;
            };

            let addSectionButton = function () {
                modalTemplateSections.on('click', '#addSectionButton', function (e) {
                    e.preventDefault();
                    unAppliedSectionsForm.submit();
                })
            };

            let addSectionFormSubmit = function (unAppliedTable, sectionsAddedTable, modelId) {
                unAppliedSectionsForm.off('submit').on('submit', function (e) {
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
                        url: '/api/templates/' + modelId + '/sections',
                        success: function (response) {
                            unAppliedSectionsForm.find("input[name='sections[]']").remove();
                            let values = 'Разделы добавлены';
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
                            sectionsAddedTable.ajax.reload(function (data) {
                                sectionsAddedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            toastr.success(values, "Отлично!");
                        },
                        error: function (xhr, status, errorThrown) {
                            unAppliedSectionsForm.find("input[name='sections[]']").remove();
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

            let removeSectionButton = function () {
                modalTemplateSections.on('click', '#removeSectionButton', function (e) {
                    e.preventDefault();
                    sectionsAddedForm.submit();
                })
            };

            let removeSectionFormSubmit = function (unAppliedTable, sectionsAddedTable, modelId) {
                sectionsAddedForm.off('submit').on('submit', function (e) {
                    e.preventDefault();
                    let form = this;
                    let rowsSelected = sectionsAddedTable.column(0).checkboxes.selected();
                    $.each(rowsSelected, function (index, rowId) {
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', 'sections[]')
                                .val(rowId.replace('row_', ''))
                        );
                    });

                    $(form).ajaxSubmit({
                        url: '/api/templates/' + modelId + '/sections',
                        success: function (response) {
                            sectionsAddedForm.find("input[name='sections[]']").remove();
                            let values = 'Разделы удалены из шаблона';
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
                            sectionsAddedTable.ajax.reload(function () {
                                sectionsAddedTable.column(0).checkboxes.deselectAll();
                            }, false);
                            toastr.success(values, "Отлично!");
                        },
                        error: function (xhr, status, errorThrown) {
                            sectionsAddedForm.find("input[name='sections[]']").remove();
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
                    modalTemplateSections.on('show.bs.modal', function (event) {
                        let modelId = event.relatedTarget.dataset.id;
                        let sectionsAddedDataTable = initSectionsAddedTable(modelId);
                        let unAppliedSectionsDataTable = initUnAppliedSectionsTable(modelId);
                        addSectionButton();
                        removeSectionButton();
                        addSectionFormSubmit(unAppliedSectionsDataTable, sectionsAddedDataTable, modelId);
                        removeSectionFormSubmit(unAppliedSectionsDataTable, sectionsAddedDataTable, modelId);
                    });

                    showSectionsManagementModalButton.on('click', function (e) {
                        e.preventDefault();
                        modalTemplateSections.modal('show', this);
                    });

                    modalTemplateSections.on('hide.bs.modal', function (event) {
                        sectionsAddedElement.DataTable().clear();
                        sectionsAddedElement.DataTable().destroy();
                        unAppliedSectionsElement.DataTable().clear();
                        unAppliedSectionsElement.DataTable().destroy();
                        let templateSectionsDataTable = $('#' + $.fn.dataTable.tables()[1].id).DataTable();
                        templateSectionsDataTable.ajax.reload(null, false);
                        modalTemplateSections.off('click', '#removeSectionButton');
                        modalTemplateSections.off('click', '#addSectionButton');
                    })
                },
            };
        }();
        jQuery(document).ready(function () {
            TemplateSectionsManagement.init();
        });
    </script>
@endpush
