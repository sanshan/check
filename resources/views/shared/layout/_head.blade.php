<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <title>Metronic | Dashboard</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families":[
                    "Poppins:300,400,500,600,700",
                    "Roboto:300,400,500,600,700"
                ]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->

    <!--begin::Page Vendors Styles(used by this page) -->
    @stack('vendors-css')
    <!--end::Page Vendors Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ URL::asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ URL::asset('assets/demo/default/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/demo/default/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/demo/default/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/demo/default/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.ico') }}" />
</head>
<!-- end::Head -->
