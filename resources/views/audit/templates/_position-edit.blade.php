<div id="templateQuestionsEditPositions" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateQuestionsTitle">Должности</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form id="recordsForm" class="kt-form" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="template_id" value="">
                    <input type="hidden" name="question_id" value="">
                    <div class="form-group">
                        <label class="kt-form__label">Должности для этого вопроса:</label>
                        <select style="width:100%" class="form-control m-select2" id="positions" name="position_id[]" multiple="multiple">
                        </select>
                        <span class="form-text text-muted">Эта настройка будет сохранена только для этого шаблона.</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="positionsQuestionTemplateFormSubmitButton" type="button" class="btn btn-primary">Сохранить</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
