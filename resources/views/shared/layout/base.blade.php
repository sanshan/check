@include('shared.layout._head')
<!-- begin::Body -->
<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading" >
@include('shared.layout._page-loader')
@include('shared.page.page-base')
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors":{
            "state":{
                "brand":"#5d78ff",
                "dark":"#282a3c",
                "light":"#ffffff",
                "primary":"#5867dd",
                "success":"#34bfa3",
                "info":"#36a3f7",
                "warning":"#ffb822",
                "danger":"#fd3995"
            },
            "base":{
                "label":[
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape":[
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>
@stack('global-config')
<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ URL::asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
@stack('vendors-scripts')
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
@stack('scripts')
<!--end::Page Scripts -->

</body>
<!-- end::Body -->
</html>
