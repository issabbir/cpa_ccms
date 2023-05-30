@extends('layouts.default')

@section('title')
    Dashboard
@endsection

@section('header-style')
    <style type="text/css">
        .swiper-container {
            padding: 0px 130px;
        }
        .swiper-slide {
            width: 60%;
            min-height: 200px;
        }
        .swiper-slide:nth-child(2n) {
            width: 40%;
        }
        .swiper-slide:nth-child(3n) {
            width: 20%;
        }
        .card.cardSlide {
            min-height: 180px;
        }
        .first_row{
            min-height: 530px;
        }
        .second_row{
            min-height: 275px;
        }
        .third_row{
            min-height: 500px;
        }
        .forth_row{
            min-height: 410px;
        }

        @media only screen and (max-width: 1400px) {
            .swiper-container {
                padding: 0px !important;
            }
            .swiper-slide {
                width: 50%;
                min-height: 200px;
            }
            .swiper-slide:nth-child(2n) {
                width: 50%;
            }
            .swiper-slide:nth-child(3n) {
                width: 50%;
            }
            .swiper-slide h5{
                font-size: 15px !important;
            }
            #dashboard-analytics h2{
                font-size: 22px !important;
            }
            /*#dashboard-analytics h4, #dashboard-analytics h6{*/
            /*	font-size: 15px !important;*/
            /*}*/
            #dashboard-analytics span{
                font-size:12px;
            }
            #dashboard-analytics table tr th{
                font-size:13px;
            }
        }
        @media only screen and (max-width: 640px) {
            .swiper-container {
                padding: 0px !important;
            }
            .swiper-slide {
                width: 100% !important;
                min-height: 200px;
            }
            .swiper-slide:nth-child(2n) {
                width: 100% !important;
            }
            .swiper-slide:nth-child(3n) {
                width: 100% !important;
            }

            .shadow-lg.p-2 {
                padding: 0!important;
            }
        }
        .card{
            background: rgb(15, 73, 110);
            color: white;
        }
        th,
        td {
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        table, label{
            color: white;
        }
        .card .card-header .card-title{
            text-shadow: 10px 10px 10px rgba(3, 9, 9, 0.81);
            font-weight: 900;
            color: white;
            font-size: 24px;
            font-family: "Lucida Grande", "Lucida Sans Unicode", geneva, verdana, arial, helvetica, sans-serif;
        }
        table{
            border-radius: 5px;
            border: none;
        }
        table.dataTable.table-sm>thead>tr>th {
            color: #77ffd3;
            background-color: #0d3349;
        }
        .table.table-bordered thead th {
            color: #77ffd3;
            background-color: #0d3349;
        }
        a {
            color: #5aeeb7;
        }
        table.table tbody tr td,
        table.table thead tr th,
        table.table {
            border: 1px solid rgb(120, 162, 204);
        }
        .table-bordered, .table-bordered td, .table-bordered th {
            border: 1px solid rgb(120, 162, 204);
        }
        .badge{
            color: #0A246A;
            font-weight: bolder;
            text-shadow: 10px 10px 10px rgba(0, 0, 0, 0.5);
            font-family: "Lucida Grande", "Lucida Sans Unicode", geneva, verdana, arial, helvetica, sans-serif;
        }
    </style>
@endsection

@section('content')
    <section id="dashboard-analytics">
        <div class="row">
            <div class="col-md-12">
                {{--<div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="text-center">
                                <h3>Welcome to computer equipment and peripherals maintenance system</h3>
                            </div>
                        </div>
                    </div>
                </div>--}}
                {{--Ticket Issue Status--}}
                @if(auth()->user()->hasRole('CCMS_ADMIN'))
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="card-title text-uppercase" style="text-align: center">Ticket Issue Status </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    {{--<table class="table table-sm table-bordered text-uppercase" id="service-ticket">
                                        <thead class="text-center">
                                        <tr class="text-nowrap">
                                            <th>SL</th>
                                            <th>TICKET TYPE NAME</th>
                                            <th>TOTAL ASSIGNED ISSUES</th>
                                            <th>TOTAL RESOLVED ISSUES</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @if(!empty($ticketStatus))
                                            @foreach($ticketStatus as $key=>$value)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{$value->ticket_type_name}}</td>
                                                    <td>{{$value->total_assigned_issues}}</td>
                                                    <td>{{$value->total_resolved_issues}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <div style="width: 100%;text-align: center"><span>No Data Found</span></div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>--}}

                                    <table class="table table-sm table-bordered datatable text-uppercase" id="assigned-ticket"
                                           data-url="{{ route('ticketissuestatus.dashboard')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                                        <thead >
                                        <tr class="text-nowrap">
                                            <th data-col="DT_RowIndex">SL</th>
                                            <th data-col="ticket_type_name">TICKET TYPE NAME</th>
                                            <th data-col="total_assigned_issues" title="TOTAL ASSIGNED ISSUES">TOTAL ASSIGNED ISSUES</th>
                                            <th data-col="total_resolved_issues" title="TOTAL RESOLVED ISSUES">TOTAL RESOLVED ISSUES</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{--Service Ticket List--}}
                @if(auth()->user()->hasRole('CCMS_SERVICE_ENGINEER'))
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="card-title text-uppercase" style="text-align: center">Assigned Issues </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered datatable text-uppercase" id="service-ticket"
                                           data-url="{{ route('service_ticket.dashboard')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                                        <thead >
                                        <tr class="text-nowrap">
                                            <th data-col="DT_RowIndex">SL</th>
                                            <th data-col="ticket_id">TICKET ID</th>
                                            <th data-col="ticket_type_no" title="TICKET TYPE NO">TICKET TYPE</th>
                                            <th data-col="description" title="TICKET DESCRIPTION">DESCRIPTION</th>
                                            <th data-col="emp_id" title="EMPLOYEE ID">Employee/Department</th>
                                            <th data-col="assigned_to" title="ASSIGNED TO">Assigned To</th>
                                            <th data-col="ticket_priority" title="ASSIGNMENT DATE">TICKET PRIORITY</th>
                                            <th data-col="ticket_internal_external_yn" title="Ticket Internal External YN">
                                                Is Internal
                                            </th>
                                            <th data-col="ticket_status" title="Ticket Status">
                                                Ticket Status
                                            </th>
                                            <th data-col="action">action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{--Requsition List--}}
                @if(auth()->user()->hasRole('CCMS_SERVICE_ENGINEER')||auth()->user()->hasRole('CCMS_SYSTEM_ANALYST')||auth()->user()->hasRole('CCMS_MEMBER_FINANCE')||auth()->user()->hasRole('CCMS_ADMIN'))
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="card-title text-uppercase" style="text-align: center">Available Requisition </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-sm datatable" id="req_datatable"
                                           data-url="{{ route('reqList.dashboard')}}"
                                           data-csrf="{{csrf_token() }}" data-page="10" style="width: 100%">
                                        <thead class="text-nowrap">
                                        <tr>
                                            {{--<th data-col="DT_RowIndex">SL</th>--}}
                                            <th data-col="requisition_id">REQUISITION ID</th>
                                            <th data-col="equipment_name">EQUIPMENT NAME</th>
                                            <th data-col="requisition_note">REQUISITION NOTE</th>
                                            <th data-col="user_name">REQUISITION BY</th>
                                            <th data-col="status_name">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{--3rd party Service--}}
                @if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="card-title text-uppercase" style="text-align: center">3rd party Service </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-sm datatable" id="req_datatable"
                                           data-url="{{ route('serviceList.dashboard')}}"
                                           data-csrf="{{csrf_token() }}" data-page="10" style="width: 100%">
                                        <thead>
                                        <tr class="text-nowrap">
                                            <th data-col="DT_RowIndex">SL</th>
                                            <th data-col="equipment_no" title="EQUIPMENT NO">EQUIPMENT</th>
                                            <th data-col="ticket_no" title="TICKET NO">TICKET</th>
                                            <th data-col="vendor_no" title="VENDOR NO">VENDOR</th>
                                            <th data-col="service_charge" title="SERVICE CHARGE">SERVice CHARGE</th>
                                            <th data-col="problem_description" title="PROBLEM DESCRIPTION">problem description</th>
                                            <th data-col="sending_date" title="SENDING DATE">SEND DATE</th>
                                            <th data-col="received_date" title="RECEIVED DATE">receive DATE</th>
                                            {{--<th data-col="problem_solved_yn" title="PROBLEM SOLVED YN">Problem Status</th>--}}
                                            <th data-col="action">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{--Engineer Ticket Status--}}
                @if(auth()->user()->hasRole('CCMS_ADMIN'))
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="card-title text-uppercase" style="text-align: center">Engineer Ticket Status </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered text-uppercase" id="service-ticket">
                                        <thead >
                                        <tr class="text-nowrap text-center">
                                            <th>SL</th>
                                            <th>SERVICE ENGINEER NAME</th>
                                            <th>TOTAL ASSIGNED ISSUES</th>
                                            <th>TOTAL RESOLVED ISSUES</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        @if(!empty($enginTicketStatus))
                                            @foreach($enginTicketStatus as $key=>$value)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{$value->service_engineer_name}}</td>
                                                    <td>{{$value->total_assigned_issues}}</td>
                                                    <td>{{$value->total_resolved_issues}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">
                                                    <div style="width: 100%;text-align: center"><span>No Data Found</span></div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

@endsection

@section('footer-script')
    <script type="text/javascript">
        var options = {
            series: [{
                name: "STOCK ABC",
                data: [100,200,300,400]
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },

            title: {
                text: 'Fundamental Analysis of Stocks',
                align: 'left'
            },
            subtitle: {
                text: 'Price Movements',
                align: 'left'
            },
            labels: ['01/01/2019','02/02/2019','03/03/2019','04/04/2019'],
            xaxis: {
                type: 'datetime',
            },
            yaxis: {
                opposite: true
            },
            legend: {
                horizontalAlign: 'left'
            }
        };

        /*var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();*/
    </script>
@endsection
