@extends('layouts.default')

@section('title')
    Service Ticket Details
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
                <div class="card-header pb-0 d-flex justify-content-between">
                    <span class="card-title font-weight-bold text-uppercase">
                      Service Engineer Info Details
                    </span>
{{--                    <a href="" class="btn btn-info btn-sm">Assign</a>--}}
                    <div class="row">
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i>
                                    Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_TICKET_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_ENGINEER_INFO_LIST.xdo&p_service_engineer_info_id='.\Request::get('id').'&type=pdf&filename=RPT_SERVICE_ENGINEER_INFO_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_TICKET_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_ENGINEER_INFO_LIST.xdo&p_service_engineer_info_id='.\Request::get('id').'&type=xlsx&filename=RPT_SERVICE_ENGINEER_INFO_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-navigation"></i> Action</a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{ route('service-engineer-info.index', ['id' => $data['service_engineer_info_id']]) }}" class="">
                                        <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Engineer Info
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <a  class="btn btn btn-outline-dark hvr-underline-reveal mb-1" href="{{ route('service-engineer-info.index') }}">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div><hr>
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap" width="200"><strong>Service Engineer Name <span>:</span></strong></td>
                                <td>{{ ($data)?$data->service_engineer_name:''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Present Address<span>:</span></strong></td>
                                <td>{{ ($data)?$data->present_address:''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Premanent Address<span>:</span></strong></td>
                                <td>{{ ($data)?$data->premanent_address:'' }}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Mobile No<span>:</span></strong></td>
                                <td>{{ ($data)?$data->mobile_no:'' }}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>NID<span>:</span></strong></td>
                                <td>{{ ($data)?$data->nid_number:'' }}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Contract Start Date<span>:</span></strong></td>
                                <td>{{($data)?date('d-m-Y', strtotime($data->contract_start_date)):''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Contract End Date<span>:</span></strong></td>
                                <td>{{($data)?date('d-m-Y', strtotime($data->contract_end_date)):''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Preferred Work<span>:</span></strong></td>
                                <td>{{ ($data)?$data->preferred_work:'' }}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Activation Status<span>:</span></strong></td>
                                <td>@if($data)
                                        @if($data->active_yn=='Y')
                                            Yes
                                        @else
                                        No
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Skills List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">SKILLS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty(!empty($skills)))
                                    @foreach($skills as $key=>$value)
                                        <tr class="text-center">
                                            <td>{{$value->service_skill_name}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
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
        </div>
    </div>

@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>
        $('body').on('mouseenter mouseleave','.dropdown',function(e){
            var _d=$(e.target).closest('.dropdown');
            if (e.type === 'mouseenter')_d.addClass('show');
            setTimeout(function(){
                _d.toggleClass('show', _d.is(':hover'));
                $('[data-toggle="dropdown"]', _d).attr('aria-expanded',_d.is(':hover'));
            },300);
        });
        $('[data-dismiss=modal]').on('click', function (e) {
            var $t = $(this),
                target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
          $(target)
            .find("#assignment_date,#assignment_note,#assign_by,#service_engineer_id,select")
               .val('').end();
        })
        $(document).on('click', '.show-modal', function(id){
          $('#show').modal('show');
          $('.modal-title').text('Service Ticket Assign');
        });

        $(document).on('click', '.show-action-modal', function(id){
            $('#show-action').modal('show');
        });

    </script>
@endsection

{{-- onClick="window.location.href='{{ route('ticket_assign.index', ['id' => $data['ticket_no']]) }}'" --}}
