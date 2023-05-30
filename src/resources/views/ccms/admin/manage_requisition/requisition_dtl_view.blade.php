@extends('layouts.default')

@section('title')
    Requisition Details
@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style type="text/css">
        .bg-success {
            padding: 6px 15px;
            border-radius: 5px;
            box-shadow: 6px 7px 10px rgba(0, 0, 0, 0.5);
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
                      Requsition Details
                    </span>
                    <div class="row">
                        <input type="hidden" id="req_mst_no"
                               value="{{($requisitionMstData)?$requisitionMstData->requisition_mst_no:''}}">
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white" data-toggle="dropdown"
                                   href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i>
                                    Print</a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                       href="{{url('/report/render/RPT_REQUISITION_DETAILS?xdo=/~weblogic/CCMS/RPT_REQUISITION_DETAILS.xdo&p_requisition_mst_no='.\Request::get('id').'&type=pdf&filename=RPT_REQUISITION_DETAILS')}}">
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                       href="{{url('/report/render/RPT_REQUISITION_DETAILS?xdo=/~weblogic/CCMS/RPT_REQUISITION_DETAILS.xdo&p_requisition_mst_no='.\Request::get('id').'&type=xlsx&filename=RPT_REQUISITION_DETAILS')}}">
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white" data-toggle="dropdown"
                                   href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-navigation"></i> Action</a>
                                <div class="dropdown-menu" style="">
                                    @if ($requisitionMstData->requisition_status_id == '1' || (auth()->user()->hasRole('CCMS_ADMIN') && $requisitionMstData->requisition_status_id == '2'))
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                       href="{{ route('admin.requisition-master.index', 'id='.\Request::get('id')) }}"
                                       class="">
                                        <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Requisition
                                    </a>
                                    @endif
{{--                                    @if($requisitionMstData->approved_yn=='Y')--}}
{{--                                        <a class="dropdown-item show-modal hvr-underline-reveal" style="cursor: pointer"--}}
{{--                                           onclick="approveReq('Y')">--}}
{{--                                            <i class="bx bx-task"></i> &nbsp Dis Approve--}}
{{--                                        </a>--}}
{{--                                    @else--}}
{{--                                        <a class="dropdown-item show-modal hvr-underline-reveal" style="cursor: pointer"--}}
{{--                                           onclick="approveReq('N')">--}}
{{--                                            <i class="bx bx-task"></i> &nbsp Approve--}}
{{--                                        </a>--}}
{{--                                    @endif--}}
                                </div>
                            </li>
                        </ul>
                        <a class="btn btn btn-outline-dark" style="height: 38px"
                           href="{{ route('admin.requisition-master.index') }}">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap" width="200"><strong>Requisition Id <span>:</span></strong>
                                </td>
                                <td>{{$requisitionMstData->requisition_id}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Requisition For <span>:</span></strong></td>
                                <td>{{$requisitionMstData->req_for_name}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Requisition Note <span>:</span></strong></td>
                                <td>
                                    <span><p>{!! strip_tags(($requisitionMstData)?$requisitionMstData->requisition_note:'') !!}</p></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Requisition Date <span>:</span></strong></td>
                                <td>{{date('d-m-Y', strtotime($requisitionMstData->requisition_date))}}</td>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket No <span>:</span></strong></td>
                                <td>
                                    <a href="{{route('service_ticket.ticket_dtl',['id' => $requisitionMstData->ticket_no])}}"
                                       target="_blank"><span>{{$requisitionMstData->ticket_no}}</span></a></td>
                            </tr>
                            @if ($requisitionMstData->equipment)
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Equipment Name <span>:</span></strong></td>
                                    <td>
                                        <a href="{{route('admin.equipment-list.detail',['id' => $requisitionMstData->equipment_no])}}"
                                           target="_blank"><span>{{$requisitionMstData->equipment->equipment_name}}</span></a>
                                    </td>
                                </tr>
                            @endif
                            @if(!auth()->user()->hasRole('SUPER_ADMIN'))
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Requisition Status <span>:</span></strong></td>
                                    <td style="text-shadow: 10px 10px 10px rgba(0,0,0,0.3);">
                                        @if(auth()->user()->hasRole('CCMS_SERVICE_ENGINEER'))
                                            @if($requisitionMstData->requisition_status_id=='1')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>OPEN.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='2')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>FORWARDED TO SYSTEM ANALYST.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='3')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>FORWARDED TO STORE ADMINISTRATOR</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='4')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>APPROVE TO PURCHASE.</strong></span>
                                            @endif
                                        @elseif(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                            @if($requisitionMstData->requisition_status_id=='1')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>OPEN.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='2')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>FORWARDED TO SYSTEM ANALYST.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='3')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>FORWARDED TO STORE ADMINISTRATOR.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='4')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>APPROVE TO PURCHASE.</strong></span>
                                            @endif
                                        @elseif(auth()->user()->hasRole('CCMS_MEMBER_FINANCE'))
                                            @if($requisitionMstData->requisition_status_id=='1')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>OPEN.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='2')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>FORWARDED TO SYSTEM ANALYST.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='3')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>FORWARDED TO STORE ADMINISTRATOR.</strong></span>
                                            @elseif($requisitionMstData->requisition_status_id=='4')
                                                <span style="background-image: linear-gradient(#FF8E8F, #ff6618)" class="badge font-size-base" ><strong>APPROVE TO PURCHASE.</strong></span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
                    <h4 class="card-title">Requisition Detail List</h4>
                </div>
                <form method="POST" action="{{ route('admin.requisition-submit')}}">
                    {!! csrf_field() !!}
                    <div class="card-content">
                        <div class="card-body card-dashboard">
                            <div class="table-responsive">
                                <table class="table table-sm datatable" id="req_datatable"
                                       data-url="{{ route('admin.requisition-detail-datatable.data', 'req_mst_id='.$requisitionMstData->requisition_mst_no)}}"
                                       data-csrf="{{csrf_token() }}" data-page="10">
                                    <thead class="text-nowrap">
                                    @php
                                        $approve_mf_qty = DB::selectOne('select count(*) count_val from EQUIPMENT_REQUISITION_DTL where REQUISITION_MST_NO = :REQUISITION_MST_NO and APPROVE_MF_QTY IS NOT NULL', ['REQUISITION_MST_NO' => \Request::get('id')]);
                                        $approve_sa_qty = DB::selectOne('select count(*) count_val from EQUIPMENT_REQUISITION_DTL where REQUISITION_MST_NO = :REQUISITION_MST_NO and APPROVE_SA_QTY IS NOT NULL', ['REQUISITION_MST_NO' => \Request::get('id')]);
                                        $status = [];
                                            $status = DB::selectOne('select REQUISITION_STATUS_ID from EQUIPMENT_REQUISITION_MST where REQUISITION_MST_NO = :REQUISITION_MST_NO', ['REQUISITION_MST_NO' => \Request::get('id')]);
                                            if(!empty($status)){
                                                $requisition_status_id = $status->requisition_status_id;
                                            }else{
                                                $requisition_status_id = 1;
                                            }
                                    @endphp
                                    <tr>
                                        @if(!auth()->user()->hasRole('CCMS_SERVICE_ENGINEER'))
                                            @if($requisition_status_id == 2 && auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                                <th data-col="selected">Actions</th>
                                            @elseif($requisition_status_id == 3 && auth()->user()->hasRole('CCMS_MEMBER_FINANCE'))
                                                <th data-col="selected">Actions</th>
                                            @endif
                                        @endif
                                        <th data-col="item">ITEM</th>
                                        <th data-col="description">DESCRIPTION</th>
{{--                                        <th data-col="appx_price">APPX PRICE</th>--}}
                                        <th data-col="brand_name">Brand</th>
                                        <th data-col="variants">Variant</th>
                                        @if(!auth()->user()->hasRole('CCMS_MEMBER_FINANCE'))
                                            <th data-col="quantity">QUANTITY</th>
                                        @endif
                                        @if(auth()->user()->hasRole('CCMS_MEMBER_FINANCE')&& $approve_sa_qty->count_val>0)
                                            <th data-col="approve_sa_qty">APPROVED QUANTITY BY SYSTEM ANALYST</th>
                                        @endif
                                        @if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') /*&& $approve_sa_qty->count_val<=0*/)
                                            <th data-col="approve_qty">APPROVED QUANTITY</th>
                                        @elseif(auth()->user()->hasRole('CCMS_MEMBER_FINANCE') /*&& $approve_mf_qty->count_val<=0*/)
                                            <th data-col="approve_qty">APPROVED QUANTITY</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 mb-1 ml-1">
                                    <div class="d-flex justify-content-start">
                                        @php
                                            $status = [];
                                            $status = DB::selectOne('select REQUISITION_STATUS_ID from EQUIPMENT_REQUISITION_MST where REQUISITION_MST_NO = :REQUISITION_MST_NO', ['REQUISITION_MST_NO' => \Request::get('id')]);
                                            if(!empty($status)){
                                                $status_id = $status->requisition_status_id;
                                            }else{
                                                $status_id = 1;
                                            }
                                        @endphp
{{--                                        @if($status_id == 1 && (auth()->user()->hasRole('CCMS_SERVICE_ENGINEER') || auth()->user()->hasRole('CCMS_ADMIN')))--}}
                                        @if($status_id == 1 && auth()->user()->hasRole('CCMS_ADMIN'))
                                            <input type="hidden" name="status_key" value="FWD_SA">
                                            <input type="hidden" name="req_mst_no"
                                                   value="{{($requisitionMstData)?$requisitionMstData->requisition_mst_no:''}}">
                                            <button type="submit" name="search"
                                                    class="btn btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bx-archive"></i> Forwarding to System Analyst
                                            </button>
                                        @elseif ($status_id == 2 && auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                            <input type="hidden" name="status_key" value="FWD_MF">
                                            <input type="hidden" name="req_mst_no"
                                                   value="{{($requisitionMstData)?$requisitionMstData->requisition_mst_no:''}}">
                                            <button type="submit" name="search"
                                                    class="btn btn btn-dark shadow mr-1 mb-1" id="chkForm">
                                                <i class="bx bx-archive"></i> Forwarding to Store Administrator
                                            </button>
                                            <button type="button" name="reject"
                                                    class="btn btn btn-dark shadow mr-1 mb-1" id="rejectReq">
                                                <i class="bx bx-window-close"></i> Reject
                                            </button>
                                            <a href="{{externalLoginUrl(env('INVENTORY_URL'),'inventory-index')}}"  target="_blank"
                                               class="btn btn btn-primary shadow mr-1 mb-1" id="chkForm">
                                                <i class="bx bx-archive"></i> Inventory
                                            </a>
                                        @elseif ($status_id == 3 && auth()->user()->hasRole('CCMS_MEMBER_FINANCE'))
                                            <input type="hidden" name="status_key" value="PURCHASE">
                                            <input type="hidden" name="req_mst_no"
                                                   value="{{($requisitionMstData)?$requisitionMstData->requisition_mst_no:''}}">
                                            <button type="submit" name="search"
                                                    class="btn btn btn-dark shadow mr-1 mb-1" id="chkForm">
                                                <i class="bx bx-archive"></i> Delivering To Service Engineer
                                            </button>
                                            <button type="button" name="reject"
                                                    class="btn btn btn-dark shadow mr-1 mb-1" id="rejectReq">
                                                <i class="bx bx-window-close"></i> Reject
                                            </button>
                                            <a href="{{externalLoginUrl(env('INVENTORY_URL'),'inventory-index')}}"  target="_blank"
                                                    class="btn btn btn-primary shadow mr-1 mb-1" id="chkForm">
                                                <i class="bx bx-archive"></i> Inventory
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Start Modal Form For Rejet Requsition --}}
    <div id="modal-show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase text-left">
                        Reject Requisition
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('admin.requisition-reject')}}">
                        {!! csrf_field() !!}
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Reject Note</label>
                                    <textarea name="reject_note" class="form-control" id="reject_note" cols="30" rows="5"></textarea>
                                    @if (\Request::get('id'))
                                        <input type="hidden" name="req_mst_no" value="{{\Request::get('id')}}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end" style="margin-top: 10%">
                                            <button type="submit" name="save"
                                                    class="btn btn btn-dark btn-sm shadow mr-1 mb-1">
                                                <i class="bx bx-check-circle"></i>&nbsp; <span style="font-size: 15px;">OK</span>
                                            </button>
                                            <button type="reset" class="btn btn btn-outline-dark btn-sm mb-1"
                                                    data-dismiss="modal"><i class="bx bx-window-close"></i> <span
                                                    style="font-size: 15px;">Cancel</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!--Modal End -->
@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>
        $(document).on('click', '#rejectReq', function (id) {
            $('#modal-show').modal('show');
            // $('.modal-title').text('Equipment List Detail');
        });
        $('#chkForm').click(function () {
            let checked = $("input[type=checkbox]:checked").length;

            if (!checked) {
                Swal.fire({
                    title: 'Please select at least one item.',
                    type: 'error',
                    confirmButtonText: 'OK'
                }).then(function () {
                });
                return false;
            }

        });

        function approveReq(status) {
            var requisition_mst_no = $('#req_mst_no').val();
            if (status == 'Y') {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, disapprove it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'GET',
                            url: 'requisition-master-data-approved',
                            data: {requisition_mst_no: requisition_mst_no, APPROVED_YN: 'N'},
                            success: function (msg) {
                                if (msg == "1") {
                                    Swal.fire({
                                        title: 'Requisition Disapproved!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(function () {
                                        location.reload();
                                    });
                                } else {
                                    swal("Error!", results.message, "error");
                                }
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'GET',
                            url: 'requisition-master-data-approved',
                            data: {requisition_mst_no: requisition_mst_no, APPROVED_YN: 'Y'},
                            success: function (msg) {
                                if (msg == "1") {
                                    Swal.fire({
                                        title: 'Requisition Approved!',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(function () {
                                        location.reload();
                                    });
                                } else {
                                    swal("Error!", results.message, "error");
                                }
                            }
                        });
                    }
                });
            }
        }

    </script>
@endsection
