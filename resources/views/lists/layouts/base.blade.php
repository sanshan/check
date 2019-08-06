@extends('shared.layout.base')

@push('vendors-css')
    <link href="/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

@push('vendors-scripts')
    <script src="/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
@endpush

@push('global-config')
    <script>
        "use strict";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.extend( $.validator.messages, {
            required: "Это поле необходимо заполнить.",
            remote: "Пожалуйста, введите правильное значение.",
            email: "Пожалуйста, введите корректный адрес электронной почты.",
            url: "Пожалуйста, введите корректный URL.",
            date: "Пожалуйста, введите корректную дату.",
            dateISO: "Пожалуйста, введите корректную дату в формате ISO.",
            number: "Пожалуйста, введите число.",
            digits: "Пожалуйста, вводите только цифры.",
            creditcard: "Пожалуйста, введите правильный номер кредитной карты.",
            equalTo: "Пожалуйста, введите такое же значение ещё раз.",
            extension: "Пожалуйста, выберите файл с правильным расширением.",
            maxlength: $.validator.format( "Пожалуйста, введите не больше {0} символов." ),
            minlength: $.validator.format( "Пожалуйста, введите не меньше {0} символов." ),
            rangelength: $.validator.format( "Пожалуйста, введите значение длиной от {0} до {1} символов." ),
            range: $.validator.format( "Пожалуйста, введите число от {0} до {1}." ),
            max: $.validator.format( "Пожалуйста, введите число, меньшее или равное {0}." ),
            min: $.validator.format( "Пожалуйста, введите число, большее или равное {0}." )
        } );

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>
@endpush
