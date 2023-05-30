@extends('layouts.default')

@section('title')
    Third Party Service Details
@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style type="text/css">
        .bg-success{
            padding:6px 15px;
            border-radius: 5px;
            box-shadow: 6px 7px 10px rgba(0,0,0,0.5);
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title font-weight-bold text-uppercase">
                      Third Party Service Details
                    </span>
                    <div class="row">

                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i>
                                    Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_THIRD_PARTY_SERVICE_DETAILS?xdo=/~weblogic/CCMS/RPT_THIRD_PARTY_SERVICE_DETAILS.xdo&P_THIRD_PARTY_SERVICE_ID='.\Request::get('id').'&type=pdf&filename=RPT_THIRD_PARTY_SERVICE_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_THIRD_PARTY_SERVICE_DETAILS?xdo=/~weblogic/CCMS/RPT_THIRD_PARTY_SERVICE_DETAILS.xdo&P_THIRD_PARTY_SERVICE_ID='.\Request::get('id').'&type=xlsx&filename=RPT_THIRD_PARTY_SERVICE_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-navigation"></i>
                                    Action</a>
                                <div class="dropdown-menu" style="">
                                    @if ((auth()->user()->hasRole('CCMS_SERVICE_ENGINEER') && $thirdPartyMstData->approved_yn != 'Y') || auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{ route('admin.third_party.index', 'id='.\Request::get('id')) }}" class="">
                                        <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Third Party
                                    </a>
                                    @endif
                                    @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') && $thirdPartyMstData->approved_yn != 'Y')
{{--                                        <a class="dropdown-item hvr-underline-reveal"   href="{{ route('admin.third_party.approve',\Request::get('id')) }}" class="">--}}
                                        <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{ route('admin.third_party.index', 'id='.\Request::get('id').'&approve=Y') }}" class="">
                                            <i class="bx bx-calendar-check cursor-pointer"></i> &nbsp;Approve Third Party
                                        </a>
                                    @endif
{{--                                    @if (auth()->user()->hasRole('CCMS_ADMIN') && $thirdPartyMstData->forward_yn != 'Y')--}}
{{--                                        <a class="dropdown-item hvr-underline-reveal"   href="{{ route('admin.third_party.forward',\Request::get('id')) }}" class="">--}}
{{--                                            <i class="bx bx-calendar-check cursor-pointer"></i> &nbsp;Forward to System Analyst--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
                                </div>
                            </li>
                        </ul> {{-- javascript:history.go(-1) --}}
                        <a  class="btn btn btn-outline-dark" style="height: 38px" href="{{ route('admin.third_party.index') }}">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div><hr>
                <div class="card-body">
                    <div class="row mb-1">
                            <table class="table table-bordered table-striped">

                                        <tr>
                                            <td class="pl-5 text-nowrap" width="200"><strong>Status<span>:</span></strong></td>
                                            @if($thirdPartyMstData->approved_yn == 'Y')
                                               <td><span class="badge badge-success">Approved</span></td>
                                            @else
                                               <td><span class="badge badge-warning">Pending</span></td>
                                            @endif
                                        </tr>
                                    <tr>
                                        <td class="pl-5 text-nowrap" width="200"><strong>Equipment Name<span>:</span></strong></td>
                                        <td><a href="{{route('admin.equipment-list.detail',['id' => $thirdPartyMstData->equipment_no])}}" target="_blank"><span>{{$thirdPartyMstData->equipment_name}}</span></a></td>
                                    </tr>
                                    <tr >
                                        <td class="pl-5 text-nowrap"><strong>Ticket No <span>:</span></strong></td>
                                        <td><a href="{{route('service_ticket.ticket_dtl',['id' => $thirdPartyMstData->ticket_no])}}" target="_blank"><span>{{$thirdPartyMstData->ticket_no}}</span></a></td>
                                    </tr>
                                    <tr>
                                        <td class="pl-5 text-nowrap"><strong>Vendor Name <span>:</span></strong></td>
                                        <td>{{$thirdPartyMstData->vendor_name}}</td>
                                    </tr>
                                    <tr >
                                        <td class="pl-5 text-nowrap"><strong>Problem Description <span>:</span></strong></td>
                                        <td>{{$thirdPartyMstData->problem_description}}</td>
                                    </tr>
                                @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                    <tr>
                                        <td class="pl-5 text-nowrap"><strong>Service Charge <span>:</span></strong></td>
                                        <td>{{$thirdPartyMstData->service_charge}}</td>
                                    </tr>
                                @endif
                                    <tr>
                                        <td class="pl-5 text-nowrap"><strong>Sending Date <span>:</span></strong></td>
                                        <td>{{date('d-m-Y', strtotime($thirdPartyMstData->sending_date))}}</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-5 text-nowrap"><strong>Received Date <span>:</span></strong></td>
                                        <td>{{date('d-m-Y', strtotime($thirdPartyMstData->received_date))}}</td>
                                    </tr>
                                    {{--<tr >
                                        <td class="pl-5 text-nowrap"><strong>Problem Solve Status <span>:</span></strong></td>
                                        <td>
                                            @if($thirdPartyMstData->problem_solved_yn=='Y')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill:rgba(62, 169, 85, 1);">
                                                    <path d="M19,3H5C3.897,3,3,3.897,3,5v14c0,1.103,0.897,2,2,2h14c1.103,0,2-0.897,2-2V5C21,3.897,20.103,3,19,3z M11.067,16.481 l-3.774-3.774l1.414-1.414l2.226,2.226l4.299-5.159l1.537,1.28L11.067,16.481z"></path>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill:rgba(255, 45, 24, 1);">
                                                    <path d="M21,5c0-1.104-0.896-2-2-2H5C3.896,3,3,3.896,3,5v14c0,1.104,0.896,2,2,2h14c1.104,0,2-0.896,2-2V5z M16.207,14.793 l-1.414,1.414L12,13.414l-2.793,2.793l-1.414-1.414L10.586,12L7.793,9.207l1.414-1.414L12,10.586l2.793-2.793l1.414,1.414 L13.414,12L16.207,14.793z"></path>
                                                </svg>
                                            @endif
                                        </td>
                                    </tr>--}}
                            </table>
{{--                        @if(auth()->user()->hasRole('CCMS_ADMIN') && $thirdPartyMstData->forward_yn != 'Y')--}}
{{--                            <a href="{{ route('admin.third_party.forward',\Request::get('id')) }}" class="btn btn-primary">--}}
{{--                                <i class="bx bx-calendar-check cursor-pointer"></i> &nbsp;Forward to System Analyst--}}
{{--                            </a>--}}
{{--                        @endif--}}
                        @if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') &&  $thirdPartyMstData->approved_yn != 'Y')
                            <a  href="{{ route('admin.third_party.index', 'id='.\Request::get('id').'&approve=Y') }}" class="btn btn-primary">
                                <i class="bx bx-calendar-check cursor-pointer"></i> &nbsp;Approve Third Party
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer-script')
    <!--Load custom script-->
@endsection
