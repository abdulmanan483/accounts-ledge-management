<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>@yield('title')</title>

<!-- Global stylesheets -->
<link href="{{ asset('assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/demo/dropify/css/dropify.css') }}" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->
{{-- CUSTOM CSSS --}}
<link href="{{ asset('assets/css/app.css') }}" id="stylesheet" rel="stylesheet" type="text/css">

<!-- Core JS files -->
<script src="{{ asset('assets/demo/demo_configurator.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/forms/validation/validate.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/forms/selects/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/forms/selects/bootstrap_multiselect.js') }}"></script>
<script src="{{ asset('assets/js/vendor/uploaders/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/demo/dropify/js/dropify.js') }}"></script>

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/demo/pages/datatables_basic.js') }}"></script>
<script src="{{ asset('assets/demo/pages/dashboard.js') }}"></script>
<script>
    var NotyDemo = function() {
        const _componentNoty = function() {
            if (typeof Noty == 'undefined') {
                console.warn('Warning - noty.min.js is not loaded.');
                return;
            }
            Noty.overrideDefaults({
                theme: 'limitless',
                layout: 'topRight',
                type: 'alert',
                timeout: 2500
            });
            @if(Session::has('success'))
                new Noty({
                    layout: 'bottomCenter',
                    text: "{{Session::get('success')}}",
                    type: 'success'
                }).show();
            @endif
            @if(Session::has('warning'))
                new Noty({
                    layout: 'bottomCenter',
                    text: "{{Session::get('warning')}}",
                    type: 'warning'
                }).show();
            @endif
            @if(Session::has('info'))
                new Noty({
                    layout: 'bottomCenter',
                    text: "{{Session::get('info')}}",
                    type: 'info'
                }).show();
            @endif
            @if(Session::has('error'))
                new Noty({
                    layout: 'bottomCenter',
                    text: "{{Session::get('error')}}",
                    type: 'error'
                }).show();
            @endif
        }
        return {
            init: function() {
                _componentNoty();
            }
        }
    }();
    document.addEventListener('DOMContentLoaded', function() {
        NotyDemo.init();
    });
</script>
@yield('script')
@stack('scripts')
