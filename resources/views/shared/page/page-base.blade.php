<!-- begin:: Page -->
@include('shared.page._header-base-mobile')
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        @include('shared.page.aside.aside-base')
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            @include('shared.page.header.header-base')
            <div class="kt-content kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                @include('shared.page.header._subheader-v1')
                @include('shared.page.content._content-base')
            </div>
            @include('shared.page.footer._footer-base')
        </div>
    </div>
</div>
<!-- end:: Page -->
@include('shared.layout._scrolltop')
