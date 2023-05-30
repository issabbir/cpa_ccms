<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>CPA  @yield('title', 'Computer Equipment system')</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.html')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/logo/cns_favicon.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/vendors.min.css')}}">
    <style>
        @font-face {
            font-family: boxicons;
            font-weight: 400;
            font-style: normal;
            src: url({{asset('assets/fonts/boxicons/fonts/boxicons.eot')}});
            src: url({{asset('assets/fonts/boxicons/fonts/boxicons.eot')}}) format('embedded-opentype'), url({{asset('assets/fonts/boxicons/fonts/boxicons.woff2')}}) format('woff2'), url({{asset('assets/fonts/boxicons/fonts/boxicons.woff')}}) format('woff'), url({{asset('assets/fonts/boxicons/fonts/boxicons.ttf')}}) format('truetype'), url({{asset('assets/fonts/boxicons/fonts/boxicons.svg?#boxicons')}}) format('svg');
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/dragula.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/pickers/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/editors/quill/katex.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/editors/quill/monokai-sublime.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/editors/quill/quill.snow.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/editors/quill/quill.bubble.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/datetime/tempusdominus-bootstrap-4.min.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-extended.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/colors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/components.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/dark-layout.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themes/semi-dark-layout.min.css')}}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Application global common -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/watchman-common.css')}}">
    <!-- END: Application global common -->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/pages/dashboard-analytics.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/pages/app-file-manager.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/validation/form-validation.css')}}">
    {{--<link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/wizard.min.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/secdbms/jquery-steps/jquery.steps.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/menu/menu-types/vertical-menu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/forms/wizard.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/ccms.css')}}">
    <!-- END: Page CSS-->
    <script>
        var APP_URL = "{{ url('/') }}";
    </script>
    @yield('header-style')
</head>
<!-- END: Head-->


<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern content-left-sidebar file-manager-application semi-dark-layout 2-columns navbar-sticky footer-static  "
      data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar" data-col="2-columns"
      data-layout="semi-dark-layout">

<div class="se-pre-con"></div>
<!-- BEGIN Header-->
@include('layouts.partial.watchman.header')
@include('layouts.partial.sidebar')

<!-- BEGIN: Content-->
<div class="app-content content mt-5">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <br>
        <div class="content-body">
            <br>
            @include('layouts.partial.flash-message')
            @yield('content')
        </div>
    </div>
</div>

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('layouts.partial.footer')
<div id="approveService" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-left">3rd party Service Approve</h4>
                <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div id="showApprove"></div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/vendors/js/vendors.min.js')}}"></script>
{{--<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>--}}

<script type="text/javascript" src="{{asset('assets/datetime/2.24.0-moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/datetime/tempusdominus-bootstrap-4.min.js')}}"></script>

<script src="{{asset('assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js')}}"></script>
<script src="{{asset('assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js')}}"></script>
<script src="{{asset('assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>

<script src="{{asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
{{--<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>--}}
<script src="{{asset('assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/daterange/moment.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<!-- END Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('assets/vendors/js/charts/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/extensions/dragula.min.js')}}"></script>

<script src="{{asset('assets/vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
{{--<script src="{{asset('assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>--}}
<script src="{{asset('assets/vendors/js/editors/quill/katex.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/editors/quill/highlight.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/editors/quill/quill.min.js')}}"></script>

{{--<script src="{{asset('assets/vendors/js/charts/chart.min.js')}}"></script>--}}


<!-- BEGIN: Theme JS-->
<script src="{{asset('assets/js/scripts/configs/vertical-menu-light.min.js')}}"></script>
<script src="{{asset('assets/js/core/app-menu.min.js')}}"></script>
<script src="{{asset('assets/js/core/app.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/components.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/footer.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/customizer.min.js')}}"></script>

<script src="{{asset('assets/vendors/js/extensions/jquery.steps.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/secdbms/plugins/jquery-validation-additional-methods/additional-methods.min.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Application global common -->
{{--<script src="{{asset('assets/js/scripts/watchman-common.js')}}"></script>--}}
<script src="{{asset('assets/js/scripts/common.js')}}"></script>
<!-- END: Application global common -->

<!-- BEGIN: Page JS-->
<script src="{{asset('assets/js/scripts/pages/dashboard-analytics.min.js')}}"></script>
{{--<script src="{{asset('assets/js/scripts/pages/dashboard-ecommerce.min.js')}}"></script>--}}

<script src="{{asset('assets/js/scripts/forms/select/form-select2.min.js')}}"></script>
{{--<script src="{{asset('assets/js/scripts/pickers/dateTime/pick-a-datetime.min.js')}}"></script>--}}
<script src="{{asset('assets/js/scripts/datatables/datatable.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/validation/form-validation.js')}}"></script>
<script src="{{asset('assets/js/scripts/forms/wizard-steps.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/editors/editor-quill.min.js')}}"></script>

<script src="{{asset('assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/extensions/sweet-alerts.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/notify.min.js')}}"></script>

<script src="{{asset('assets/js/scripts/pages/app-file-manager.min.js')}}"></script>
{{--<script src="{{assets('assets/js/scripts/forms/wizard-steps.min.js')}}"></script>--}}
<script src="{{asset('assets/js/script.js')}}"></script>
<script>
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    function seen_notification() {
        $.ajax({
            type:'POST',
            url:'{{route('seen-notification')}}',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                $(".unseen_notification").html(0);
            }
        });
    }
    function read_notification($id) {
        $.ajax({
            type:'GET',
            url:'{{route('read-notification')}}?id='+$id,
            success:function(data){
                $(".unseen_notification").html(data.count);
            }
        });
    }
    $(document).on('click', '.show-third-party-modal', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: url,
            success:function(data){
                $("#showApprove").html(data.html);
                $('#approveService').modal('show');
            }
        });
    });
</script>
@yield('footer-script')
</body>


{{--<script>--}}

{{--    ClassicEditor--}}
{{--        .create( document.querySelector( '#editor' ) )--}}

{{--        .catch( error => {--}}
{{--            console.error( error );--}}
{{--        } );--}}
{{--</script>--}}

{{--<script>
    var ctx = document.getElementById('CargoContainerChart');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sep-19', 'Oct-19'],
            datasets: [{
                label: 'Container Handle +5%',
                data: [13250, 15540],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            },
                {
                    label: 'Cargo Handle +3%',
                    data: [48500, 50000],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById('VesselHandlingChart');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['July-19', 'Aug-19', 'Sep-19', 'Oct-19'],
            datasets: [{
                label: 'Vessel Handle',
                data: [365, 360, 330, 350],
                backgroundColor: [
                    'rgba(0, 0, 0, 0.0)'
                ],
                borderColor: [
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 320
                    }
                }]
            }
        }
    });
</script>--}}
<!-- END: Body-->
</html>
