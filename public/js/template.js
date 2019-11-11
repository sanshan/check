class Template {
    constructor() {

    }
}


class TemplateManagement {
    constructor() {
        this.bindZIndexModal();
        this.newTemplateButtonElement = KTUtil.get('newTemplateButton');
        this.createEditTemplateModal = KTUtil.get('createEditTemplateModal');
        this.showTemplateModal = $(KTUtil.get('showTemplateModal'));
        this.templates = {};
        this.templates.baseElement = KTUtil.get('templates');
        this.templates.tableElement = KTUtil.get('templatesTable');
        this.templates.table = this.drawDT();
        this.sections = {};
        this.sections.tableElement = $(KTUtil.get('templateSectionsList'));
        this.sections.management = {};
        this.sections.management.modal = $(KTUtil.get('templateSections'));
        this.sections.management.weightEditModal = $(KTUtil.get('templateSectionWeightEdit'));
        this.sections.management.unAppliedSectionsForm = $(KTUtil.get('unAppliedSectionsForm'));
        this.sections.management.sectionsAddedForm = $(KTUtil.get('sectionsAddedForm'));
        this.questions = {};
        this.questions.modal = $(KTUtil.get('showQuestionsModal'));
        this.questions.tableElement = $(KTUtil.get('templateSectionsQuestionsList'));
        this.questions.unAppliedQuestionsForm = $(KTUtil.get('unAppliedQuestionsForm'));
        this.questions.questionsAddedForm = $(KTUtil.get('questionsAddedForm'));
        this.positions = {};
        this.positions.positionsModal = $(KTUtil.get('templatePositionsModal'));
        this.positions.select2 = this.initSelect2(KTUtil.get('positions'), '/api/positions');
        this.gasStationTypes = this.initSelect2(KTUtil.get('gas-station-types'), '/api/typeofgasstations');
        this.checklistTypes = this.initSelect2(KTUtil.get('type-of-checklist'), '/api/typeofchecklists');
        this.regions = this.initSelect2(KTUtil.get('regions'), '/api/regions');

        this.bindCreateTemplateEvent();
        this.bindStoreTemplateEvent();
        this.bindValidateTemplateEvent();
        this.bindTemplateSectionCloseEvent();
        this.bindOpenSectionManagementModalEvent();
        this.bindShowSectionManagementModalEvent();
        this.bindAddSectionToTemplateEvent();
        this.bindRemoveSectionFromTemplateEvent();
        this.bindSectionsManagementCloseEvent();
        this.addSectionsToTemplateFormSubmit();
        this.removeSectionsToTemplateFormSubmit();
        this.bindWeightFormSubmitEvent();
        this.bindWeightEditFormButtonSubmitEvent();
        this.bindShowQuestionsModalEvent();
        this.bindTemplateSectionQuestionsCloseEvent();
        this.bindPositionsSaveButtonEvent();
        this.bindPositionsSubmitFormEvent();
        this.bindOpenQuestionManagementModalEvent();
        this.bindShowQuestionManagementModalEvent();
        this.bindTemplateQuestionCloseEvent();
        this.bindAddQuestionToTemplateEvent();
        this.bindRemoveQuestionFromTemplateEvent();
        this.removeQuestionsFromTemplateFormSubmit();
        this.addQuestionsToTemplateFormSubmit();
    }

    bindZIndexModal = () => {
        $(document).on('show.bs.modal', '.modal', function (event) {
            let zIndex = 1040 + (1 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });

    };

    displayError = (xhr, status, errorThrown) => {
        let message = 'Сообщение!';

        if (xhr.responseJSON.hasOwnProperty('errors')) {
            let errors = xhr.responseJSON.errors;
            let message = Object.keys(errors).map((key) => {
                return errors[key] + '<br>';
            });
        }
        if (xhr.responseJSON.hasOwnProperty('message')) {
            message = xhr.responseJSON.message;
        }
        toastr.error(message, errorThrown);
    };

    displaySuccess = (response) => {
        let data = '';

        if (response.hasOwnProperty('data')) {
            data = Object.keys(response.data).map((key) => {
                return response.data[key] + '<br>';
            });
        }
        toastr.success(data, response.message);
    };

    present = (el, target) => {
        let ret = $(el).find(target);
        return !!ret.length ? ret : false;
    };

    initDT = () => {
        if (this.templates.tableElement instanceof $.fn.dataTable.Api) {
            return this.templates.tableElement;
        }

        let parent = this;

        let ret = $(this.templates.tableElement).DataTable({
            deferRender: true,
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: '/api/templates/datatable',
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
                    data: 'title',
                    render: (data, type, full, meta) => {
                        if (data !== null) {
                            return '<a class="templateShow font-weight-bold" title="Шаблон №' + full.id + '" href="#" data-id="' + full.id + '">' + full.title + '</a>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'type_of_gas_station.resource',
                    render: (d) => {
                        if (d !== null) {
                            let temp_table = '';
                            $.each(d, (k, v) => {
                                temp_table += '<abbr title="' + v.title + '">' + v.abbreviation + '</abbr> ';
                            });
                            return temp_table;
                        } else {
                            return '';
                        }
                    }
                },
                {data: 'type_of_checklist.resource.title'},
                {
                    data: 'regions.resource',
                    render: (d) => {
                        if (d !== null) {
                            let temp_table = '';
                            $.each(d, (k, v) => {
                                temp_table += '<span class="kt-badge kt-shape-bg-color-1 kt-badge--inline">' + v.title + '</span> ';
                            });
                            return temp_table;
                        } else {
                            return '';
                        }
                    }
                },
                {data: 'sections_count'},
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
                    render: (data, type, full, meta) => {
                        return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item templateDelete" href="#"><i class="la la-trash"></i> Удалить</a>
                                <a class="dropdown-item templateEdit" href="#" title="View"><i class="la la-edit"></i>  Редактировать</a>
                            </div>
                        </span>`;
                    },
                },
                {
                    targets: -2,
                    width: '10%',
                    render: (data, type, full, meta) => {
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
            preDrawCallback: (settings) => {
                console.log('preDrawCallback');
            },
            drawCallback: (settings) => {
                console.log('drawCallback');
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                let api = this.api();
                console.log('fnRowCallback');
                nRow.querySelector('.templateEdit').onclick = (event) => {
                    event.preventDefault();
                    parent.getTemplate(aData.id);
                };

                nRow.querySelector('.templateShow').onclick = (event) => {
                    event.preventDefault();
                    parent.showTemplate(aData.id);
                };

                nRow.querySelector('.templateDelete').onclick = (event) => {
                    event.preventDefault();
                    if (confirm("Удалить элемент")) {
                        $.ajax({
                            url: '/api/templates/' + aData.id,
                            method: 'POST',
                            data: {
                                _method: 'DELETE',
                            }
                        })
                            .done((response) => {
                                api.row(response.data.id).remove().draw(false);
                                parent.displaySuccess(response);
                            })
                            .fail(parent.displayError);
                    }
                };

            },
            fnInitComplete: (oSettings, json) => {
                console.log('fnInitComplete');
            },
            rowCallback: (ePos, data, index) => {
                console.log('rowCallback');
            }
        });
        let buttons = new $.fn.dataTable.Buttons(ret, {
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
        return ret;
    };

    drawDT = () => {
        this.templates.jqTable = this.present(this.templates.baseElement, this.templates.tableElement);
        if (this.templates.jqTable) {
            return this.initDT();
        }
        return false;
    };

    showTemplate = (id) => {
        this.showTemplateModal.modal('show');
        let parent = this;
        parent.templates.openTemplateId = id;
        $.ajax({
            url: '/api/templates/' + id,
            type: 'GET',
            beforeSend: () => {
                KTApp.block(parent.showTemplateModal.find('.modal-content'),
                    {
                        opacity: 0.8,
                        overlayColor: '#fff',
                    }
                );
            }
        })
            .then((success) => parent.renderTemplateModal(success, id)
                .then(response => KTApp.unblock(parent.showTemplateModal.find('.modal-content')))
            )
            .fail(parent.displayError);
    };

    renderTemplateModal = (response, template_id) => {
        return new Promise((resolve, reject) => {
            this.initTemplateSections(template_id);
            this.showTemplateModal.find('.modal-title').text('');
            this.showTemplateModal.find('#created_at').text('');
            this.showTemplateModal.find('#author').text('');
            this.showTemplateModal.find('#updated_at').text('');
            this.showTemplateModal.find('#editor').text('');
            this.showTemplateModal.find('.modal-title').text('Шаблон №' + response.data.title);
            this.showTemplateModal.find('#created_at').text(response.data.created_at);
            this.showTemplateModal.find('#author').text(response.data.user.profile.full_name);
            if (response.data.editor) {
                this.showTemplateModal.find('#updated_at').text(response.data.updated_at);
                this.showTemplateModal.find('#editor').text(response.data.editor.profile.full_name);
            }
            if (response.data.type_of_gas_station !== null) {
                let temp_table = '';
                $.each(response.data.type_of_gas_station, function (k, v) {
                    temp_table += v.abbreviation + '; ';
                });
                this.showTemplateModal.find('#gasStationTypes').text(temp_table);
            }
            this.showTemplateModal.find('#templateTypes').text(response.data.type_of_checklist.title);
            if (response.data.regions) {
                let temp_table = '';
                $.each(response.data.regions, function (k, v) {
                    temp_table += '<span class="kt-badge kt-shape-bg-color-1 kt-badge--inline mt-1 mb-1">' + v.title + '</span> ';
                });
                this.showTemplateModal.find('#regions').html(temp_table);
            }
            let status = {
                1: {'title': 'Активен', 'class': 'kt-badge--success'},
                0: {'title': 'Выключен', 'class': 'kt-badge--danger'},
            };
            if (typeof status[response.data.status] !== 'undefined') {
                this.showTemplateModal.find('#status').html('<span class="kt-badge ' + status[response.data.status].class + ' kt-badge--inline kt-badge--pill">' + status[response.data.status].title + '</span>');
            }
            this.showTemplateModal.find('#showSectionsManagementModalButton').attr('data-id', response.data.id);

            resolve(response);
        });
    };

    initTemplateSections = (id) => {
        let parent = this;
        this.sections.table = this.sections.tableElement.DataTable({
            async: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/templates/' + id + '/sections',
            },
            order: [[0, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json",
            },
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'weight'},
            ],
            columnDefs: [
                {
                    targets: 0,
                    width: '5%',
                },
                {
                    targets: 1,
                    render: function (data, type, full, meta) {
                        return '<a class="d-block show-questions" title="' + data + '" data-ts="' + full.ts + '" data-id="' + full.id + '" data-section-id="' + full.id + '" data-template-id="' + id + '" href="">' + data + '</a>';
                    }
                },
                {
                    targets: -1,
                    width: '5%',
                    render: function (data, type, full, meta) {
                        return '<a class="btn btn-outline-primary edit-weight" title="Вес раздела" data-id="' + full.id + '" href="#">' + data + '</a>'
                    }
                },
            ],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                nRow.querySelector('.edit-weight').onclick = parent.showWeightEditModal;
                nRow.querySelector('.show-questions').onclick = (event) => {
                    event.preventDefault();
                    parent.showQuestionsModal(event);
                };
            },
        });
    };

    showWeightEditModal = (event) => {
        event.preventDefault();
        let section_id = event.target.dataset.id;
        this.sections.management.weightEditModal.find('form').attr('action', '/api/templates/' + this.templates.openTemplateId + '/sections/' + section_id);
        let currentWeight = event.target.text;
        let weightInput = $('#sectionWeight', this.sections.management.weightEditModal.find('form'));
        weightInput.val(currentWeight);
        this.sections.management.weightEditModal.modal('show');
    };

    showQuestionsModal = (event) => {
        this.questions.modal.modal('show', event.target);
    };

    bindShowQuestionsModalEvent = () => {
        this.questions.modal.on('show.bs.modal', this.renderSectionQuestions);
    };

    bindTemplateSectionQuestionsCloseEvent = () => {
        let parent = this;
        this.questions.modal.on('hide.bs.modal', function (event) {
            parent.questions.questionsTable.clear();
            parent.questions.questionsTable.destroy();
        })
    };

    renderSectionQuestions = (event) => {
        let section_id = event.relatedTarget.dataset.id;
        let ts = event.relatedTarget.dataset.ts;
        let template_id = this.templates.openTemplateId;
        this.sections.openSectionId = section_id;

        $('#showQuestionsModal').find('#showQuestionsManagementModalButton').attr('data-id', section_id);
        $('#showQuestionsModal').find('#showQuestionsManagementModalButton').attr('data-ts', ts);
        this.initTemplateSectionQuestions(section_id, template_id, ts);
    };

    initTemplateSectionQuestions = (section_id, template_id, ts) => {
        let parent = this;
        let link = '/api/templates/' + template_id + '/sections/' + section_id + '/questions';
        this.questions.questionsTable = this.questions.tableElement.DataTable({
            async: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: link,
            },
            order: [[0, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json",
            },
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'positions'},
            ],
            columnDefs: [
                {
                    targets: 0,
                    width: '5%',
                },
                {
                    targets: -1,
                    width: '10%',
                    render: (data, type, full, meta) => {
                        if (data !== null) {
                            let temp_table = '<a title="Категории должности" class="edit-positions" data-rel = "' + full.rel + '" data-id="' + full.id + '" href="#">';
                            $.each(data, (k, v) => {
                                temp_table += v.code + ' ';
                            });
                            return temp_table + '</a>';
                        } else {
                            return '';
                        }
                    }
                },
            ],
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                nRow.querySelector('.edit-positions').onclick = (event) => {
                    event.preventDefault();
                    parent.showPositionsEditModal(event, ts);
                };
            },
        });
    };

    showPositionsEditModal = (event, ts) => {
        event.preventDefault();
        KTApp.block(this.positions.positionsModal.find('.modal-body'), {
            opacity: 0.8,
            overlayColor: '#fff'
        });
        this.positions.positionsModal.modal('show');
        let question_id = event.target.dataset.id;
        let tsq = event.target.dataset.rel;
        let positions = this.positions.select2;
        positions.val(null).trigger('change');
        this.positions.positionsModal.find('form').attr('action', '/api/templates/' + this.templates.openTemplateId + '/sections/' + ts + '/questions/' + tsq + '/positions');
        $.get('/api/templates/' + this.templates.openTemplateId + '/sections/' + ts + '/questions/' + tsq + '/positions', function (response) {
            if (response.data) {
                response.data.forEach(function (d) {
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

        })
            .done(() => {
                KTApp.unblock(this.positions.positionsModal.find('.modal-body'));
            });
    };

    bindPositionsSaveButtonEvent = () => {
        this.positions.positionsModal.find('#positionsQuestionTemplateFormSubmitButton').on('click', event => {
            event.preventDefault();
            this.positions.positionsModal.find('form').submit();
        })
    };

    bindPositionsSubmitFormEvent = () => {
        this.positions.positionsModal.find('form').on('submit', this.positionsFormSubmit);
    };

    positionsFormSubmit = event => {
        event.preventDefault();
        KTApp.block(this.positions.positionsModal.find('.modal-content'), {
            opacity: 0.8,
            overlayColor: '#fff'
        });
        let positionsForm = this.positions.positionsModal.find('#templatePositionsForm');
        let parent = this;
        positionsForm.ajaxSubmit({
            url: positionsForm.action,
            type: 'POST',
            success: (response) => {
                parent.questions.questionsTable.ajax.reload(null, false);
                parent.positions.positionsModal.modal('hide');
                parent.displaySuccess(response);
                KTApp.unblock(parent.positions.positionsModal.find('.modal-content'));
            },
            error: (xhr, status, errorThrown) => {
                parent.displayError(xhr, status, errorThrown);
                KTApp.unblock(parent.positions.positionsModal.find('.modal-content'));
            }
        });

    };

    bindWeightEditFormButtonSubmitEvent = () => {
        this.sections.management.weightEditModal.find('#weightEditFormSubmitButton').on('click', (event) => {
            event.preventDefault();
            this.sections.management.weightEditModal.find('form').submit();
        })
    };

    bindWeightFormSubmitEvent = () => {
        this.sections.management.weightEditModal.find('form').on('submit', this.weightEditFormSubmit);
    };

    weightEditFormSubmit = (event) => {
        event.preventDefault();
        KTApp.block(this.sections.management.weightEditModal.find('.modal-content'));
        let weightEditFrom = this.sections.management.weightEditModal.find('#weightEditForm');
        let parent = this;
        weightEditFrom.ajaxSubmit({
            url: weightEditFrom.action,
            type: 'POST',
            success: (response) => {
                parent.sections.table.ajax.reload(null, false);
                parent.sections.management.weightEditModal.modal('hide');
                parent.displaySuccess(response);
                KTApp.unblock(parent.sections.management.weightEditModal.find('.modal-content'));
            },
            error: (xhr, status, errorThrown) => {
                parent.displayError(xhr, status, errorThrown);
                KTApp.unblock(parent.sections.management.weightEditModal.find('.modal-content'));
            }
        });
    };

    bindOpenQuestionManagementModalEvent = () => {
        $('#showQuestionsManagementModalButton').on('click', (event) => {
            event.preventDefault();
            $('#templateQuestionsManagement').modal('show', event.target);
        });
    };

    bindShowQuestionManagementModalEvent = () => {
        $('#templateQuestionsManagement').on('show.bs.modal', this.renderQuestionManagement);
    };

    renderQuestionManagement = (event) => {
        let t = this.templates.openTemplateId;
        let s = event.relatedTarget.dataset.id;
        let ts = event.relatedTarget.dataset.ts;
        console.log('t: ' + t);
        console.log('s: ' + s);
        console.log('ts: ' + ts);

        this.initQuestionsAddedTable(t, s);
        this.initQuestionsUnAppliedTable(s, ts);
    };

    initQuestionsAddedTable = (t, s) => {
        this.questions.addedQuestionsTable = $(KTUtil.get('questionsAdded')).DataTable({
            sPaginationType: 'listbox',
            async: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/templates/'+ t +'/sections/'+ s +'/questions',
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
            drawCallback: (settings) => {
                KTApp.unblock(KTUtil.get('questionsAdded'));
            },
        });
    };

    initQuestionsUnAppliedTable = (s, ts) => {
        this.questions.unAppliedQuestionsTable = $(KTUtil.get('unAppliedQuestions')).DataTable({
            sPaginationType: 'listbox',
            async: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/sections/'+ s +'/questions/datatable',
                data: {
                    'missing_in_section_template': ts
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
            drawCallback: (settings) => {
                KTApp.unblock(KTUtil.get('unAppliedQuestions'));
            },
        });
    };

    bindTemplateQuestionCloseEvent = () => {
        let parent = this;
        $('#templateQuestionsManagement').on('hide.bs.modal', function (event) {
            parent.questions.addedQuestionsTable.clear();
            parent.questions.addedQuestionsTable.destroy();
            parent.questions.unAppliedQuestionsTable.clear();
            parent.questions.unAppliedQuestionsTable.destroy();
            parent.questions.questionsTable.ajax.reload();
        })
    };

    bindAddQuestionToTemplateEvent = () => {
        $('#addQuestionButton').on('click', this.addQuestionsToTemplate)
    };

    bindRemoveQuestionFromTemplateEvent = () => {
        $('#removeQuestionButton').on('click', this.removeQuestionsFromTemplate)
    };

    addQuestionsToTemplate = () => {
        this.questions.unAppliedQuestionsForm.submit();
    };

    removeQuestionsFromTemplate = () => {
        this.questions.questionsAddedForm.submit();
    };

    removeQuestionsFromTemplateFormSubmit = (event) => {
        this.questions.questionsAddedForm.off('submit').on('submit', event => {
            event.preventDefault();
            KTApp.block(KTUtil.get('questionsAdded'));

            this.questions.addedQuestionsTable
                .column(0)
                .checkboxes
                .selected()
                .each((index, rowId) => {
                    this.questions.questionsAddedForm.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'questions[]')
                            .val(index.replace('row_', ''))
                    );
                });

            let parent = this;

            this.questions.questionsAddedForm.ajaxSubmit({
                url: '/api/templates/' + parent.templates.openTemplateId + '/sections/'+ parent.sections.openSectionId +'/questions',
                success: function (response) {
                    parent.questions.questionsAddedForm.find("input[name='questions[]']").remove();
                    parent.questions.unAppliedQuestionsTable.ajax.reload(function (data) {
                        parent.questions.unAppliedQuestionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.questions.addedQuestionsTable.ajax.reload(function (data) {
                        parent.questions.addedQuestionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.displaySuccess(response);
                },
                error: function (xhr, status, errorThrown) {
                    parent.questions.questionsAddedForm.find("input[name='questions[]']").remove();
                    parent.displayError(xhr, status, errorThrown);
                }
            })

        });
    };

    addQuestionsToTemplateFormSubmit = (event) => {
        this.questions.unAppliedQuestionsForm.off('submit').on('submit', event => {
            event.preventDefault();
            KTApp.block(KTUtil.get('unAppliedQuestions'));

            this.questions.unAppliedQuestionsTable
                .column(0)
                .checkboxes
                .selected()
                .each((index, rowId) => {
                    this.questions.unAppliedQuestionsForm.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'questions[]')
                            .val(index.replace('row_', ''))
                    );
                });

            let parent = this;

            this.questions.unAppliedQuestionsForm.ajaxSubmit({
                url: '/api/templates/' + parent.templates.openTemplateId + '/sections/'+ parent.sections.openSectionId +'/questions',
                success: function (response) {
                    parent.questions.unAppliedQuestionsForm.find("input[name='questions[]']").remove();

                    parent.questions.unAppliedQuestionsTable.ajax.reload(function (data) {
                        parent.questions.unAppliedQuestionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.questions.addedQuestionsTable.ajax.reload(function (data) {
                        parent.questions.addedQuestionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.displaySuccess(response);
                },
                error: function (xhr, status, errorThrown) {
                    parent.questions.unAppliedQuestionsForm.find("input[name='questions[]']").remove();
                    parent.displayError(xhr, status, errorThrown);
                }
            })

        });
    };

    bindOpenSectionManagementModalEvent = () => {
        this.showTemplateModal.find('#showSectionsManagementModalButton').on('click', (event) => {
            event.preventDefault();
            this.sections.management.modal.modal('show', event.target);
        });
    };

    bindShowSectionManagementModalEvent = () => {
        this.sections.management.modal.on('show.bs.modal', this.renderSectionManagement);
    };

    renderSectionManagement = (event) => {
        let id = event.relatedTarget.dataset.id;
        this.initSectionsAddedTable(id);
        this.initSectionsUnAppliedTable(id);
    };

    initSectionsAddedTable = (id) => {
        this.sections.management.addedSectionsTable = $(KTUtil.get('sectionsAdded')).DataTable({
            sPaginationType: 'listbox',
            async: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/templates/' + id + '/sections/',
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
            drawCallback: (settings) => {
                KTApp.unblock(KTUtil.get('sectionsAdded'));
            },
        });
    };

    initSectionsUnAppliedTable = (id) => {
        this.sections.management.unAppliedSectionsTable = $(KTUtil.get('unAppliedSections')).DataTable({
            sPaginationType: 'listbox',
            async: false,
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/sections/datatable',
                data: {
                    'missing_in_template': id
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
            drawCallback: (settings) => {
                KTApp.unblock(KTUtil.get('unAppliedSections'));
            },
        });
    };

    bindTemplateSectionCloseEvent = () => {
        let parent = this;
        this.showTemplateModal.on('hide.bs.modal', function (event) {
            parent.sections.table.clear();
            parent.sections.table.destroy();
            parent.templates.table.ajax.reload();
        })
    };

    bindAddSectionToTemplateEvent = () => {
        this.sections.management.modal.find('#addSectionButton').on('click', this.addSectionsToTemplate)
    };

    addSectionsToTemplate = () => {
        this.sections.management.unAppliedSectionsForm.submit();
    };

    addSectionsToTemplateFormSubmit = (event) => {
        this.sections.management.unAppliedSectionsForm.off('submit').on('submit', event => {
            event.preventDefault();
            KTApp.block(KTUtil.get('unAppliedSections'));

            this.sections.management.unAppliedSectionsTable
                .column(0)
                .checkboxes
                .selected()
                .each((index, rowId) => {
                    this.sections.management.unAppliedSectionsForm.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'sections[]')
                            .val(index.replace('row_', ''))
                    );
                });

            let parent = this;

            this.sections.management.unAppliedSectionsForm.ajaxSubmit({
                url: '/api/templates/' + parent.templates.openTemplateId + '/sections',
                success: function (response) {
                    parent.sections.management.unAppliedSectionsForm.find("input[name='sections[]']").remove();

                    parent.sections.management.unAppliedSectionsTable.ajax.reload(function (data) {
                        parent.sections.management.unAppliedSectionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.sections.management.addedSectionsTable.ajax.reload(function (data) {
                        parent.sections.management.addedSectionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.displaySuccess(response);
                },
                error: function (xhr, status, errorThrown) {
                    parent.sections.management.unAppliedSectionsForm.find("input[name='sections[]']").remove();
                    parent.displayError(xhr, status, errorThrown);
                }
            })

        });
    };

    bindRemoveSectionFromTemplateEvent = () => {
        this.sections.management.modal.find('#removeSectionButton').on('click', this.removeSectionsFromTemplate)
    };

    removeSectionsFromTemplate = () => {
        this.sections.management.sectionsAddedForm.submit();
    };

    removeSectionsToTemplateFormSubmit = (event) => {
        this.sections.management.sectionsAddedForm.off('submit').on('submit', event => {
            event.preventDefault();
            KTApp.block(KTUtil.get('sectionsAdded'));

            this.sections.management.addedSectionsTable
                .column(0)
                .checkboxes
                .selected()
                .each((index, rowId) => {
                    this.sections.management.sectionsAddedForm.append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'sections[]')
                            .val(index.replace('row_', ''))
                    );
                });

            let parent = this;

            this.sections.management.sectionsAddedForm.ajaxSubmit({
                url: '/api/templates/' + parent.templates.openTemplateId + '/sections',
                success: function (response) {
                    parent.sections.management.sectionsAddedForm.find("input[name='sections[]']").remove();

                    parent.sections.management.unAppliedSectionsTable.ajax.reload(function (data) {
                        parent.sections.management.unAppliedSectionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.sections.management.addedSectionsTable.ajax.reload(function (data) {
                        parent.sections.management.addedSectionsTable.column(0).checkboxes.deselectAll();
                    }, false);
                    parent.displaySuccess(response);
                },
                error: function (xhr, status, errorThrown) {
                    parent.sections.management.sectionsAddedForm.find("input[name='sections[]']").remove();
                    parent.displayError(xhr, status, errorThrown);
                }
            })

        });
    };

    bindSectionsManagementCloseEvent = () => {
        let parent = this;
        this.sections.management.modal.on('hide.bs.modal', function (event) {
            parent.sections.management.addedSectionsTable.clear();
            parent.sections.management.addedSectionsTable.destroy();
            parent.sections.management.unAppliedSectionsTable.clear();
            parent.sections.management.unAppliedSectionsTable.destroy();
            parent.sections.table.ajax.reload();
        })
    };

    getTemplate = (id) => {
        $.get('/api/templates/' + id, this.showEditForm)
    };

    bindCreateTemplateEvent = () => {
        $(this.newTemplateButtonElement).on('click', this.showCreateForm);
    };

    bindStoreTemplateEvent = () => {
        $(this.createEditTemplateModal).find('.form-submit').on('click', (event) => {
            $('#createEditTemplateModalForm').submit();
        });
    };

    bindValidateTemplateEvent = () => {
        let parent = this;
        $('#createEditTemplateModalForm').validate({
            rules: {
                'types_of_gas_station[]': {
                    required: true,
                },
                type_of_checklist: {
                    required: true,
                },
                'regions[]': {
                    required: true,
                },
                status: {
                    required: true,
                },
            },
            submitHandler: (form) => {
                $(form).ajaxSubmit({
                    url: form.action,
                    type: 'POST',
                    beforeSend: () => {
                        KTApp.block($(parent.createEditTemplateModal));
                    },
                    success: (response) => {
                        parent.templates.table.ajax.reload(null, false);
                        parent.displaySuccess(response);
                        KTApp.unblock($(parent.createEditTemplateModal));
                        $(parent.createEditTemplateModal).modal('hide');
                    },
                    error: (xhr, status, errorThrown) => {
                        parent.displayError(xhr, status, errorThrown);
                        KTApp.unblock($(parent.createEditTemplateModal));
                    }
                });
            }
        });
    };

    showCreateForm = (event) => {
        $('#createEditTemplateModalForm', this.createEditTemplateModal).attr('action', '/api/templates');
        $('input[name=_method]', this.createEditTemplateModal).val('POST');
        this.gasStationTypes.val(null).trigger('change');
        this.checklistTypes.val(null).trigger('change');
        this.regions.val(null).trigger('change');
        $('select[name=status]', this.createEditTemplateModal).val('');
        $(this.createEditTemplateModal).modal('show');
    };

    showEditForm = (response) => {
        $('#createEditTemplateModalForm', this.createEditTemplateModal).attr('action', '/api/templates/' + response.data.id);
        $(this.createEditTemplateModal).find('input[name=_method]').val('PATCH');
        this.gasStationTypes.val(null).trigger('change');
        this.checklistTypes.val(null).trigger('change');
        this.regions.val(null).trigger('change');
        let parent = this;
        response.data.type_of_gas_station.forEach(function (d) {
            let option = new Option(d.title, d.id, true, true);
            parent.gasStationTypes.append(option).trigger('change');
        });
        parent.gasStationTypes.trigger({
            type: 'select2:select',
            params: {
                data: response.data.type_of_gas_station
            }
        });
        let currentTemplateType = new Option(response.data.type_of_checklist.title, response.data.type_of_checklist.id, true, true);
        parent.checklistTypes.append(currentTemplateType).trigger('change');
        response.data.regions.forEach(function (d) {
            let option = new Option(d.title, d.id, true, true);
            parent.regions.append(option).trigger('change');
        });
        parent.regions.trigger({
            type: 'select2:select',
            params: {
                data: response.data.regions
            }
        });
        $(this.createEditTemplateModal).find('select[name=status]').val(response.data.status);
        $(this.createEditTemplateModal).modal('show');
    };

    initSelect2 = (el, route) => {
        return $(el).select2({
            language: "ru",
            placeholder: "Выберите...",
            minimumResultsForSearch: 5,
            ajax: {
                url: route,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: (params) => {
                    return {
                        title: params.term
                    };
                },
                processResults: (response) => {
                    let res = response.data.map((item) => {
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

}

jQuery(document).ready(() => {
    let templates = new TemplateManagement();
});



