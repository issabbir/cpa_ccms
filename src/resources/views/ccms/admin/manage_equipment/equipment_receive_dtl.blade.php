@extends('layouts.default')

@section('title')
    Service Equipment Receive Details
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
        input[type="file"]{

        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title font-weight-bold text-uppercase">
                      Equipment Receive Details
                    </span>
                    <div class="row">
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i> Delivery Slip Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_EQUIPMENT_DELIVERY_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_DELIVERY_DETAILS.xdo&P_RECEIPT_NO='.\Request::get('id').'&type=pdf&filename=RPT_SERVICE_EQUIPMENT_DELIVERY_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_EQUIPMENT_DELIVERY_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_DELIVERY_DETAILS.xdo&P_RECEIPT_NO='.\Request::get('id').'&type=xlsx&filename=RPT_SERVICE_EQUIPMENT_DELIVERY_DETAILS')}}">
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i> Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_EQUIPMENT_RECEIVE_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_RECEIVE_DETAILS.xdo&P_RECEIPT_NO='.\Request::get('id').'&type=pdf&filename=RPT_SERVICE_EQUIPMENT_RECEIVE_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_EQUIPMENT_RECEIVE_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_RECEIVE_DETAILS.xdo&P_RECEIPT_NO='.\Request::get('id').'&type=xlsx&filename=RPT_SERVICE_EQUIPMENT_RECEIVE_DETAILS')}}">
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-navigation"></i> <span style="margin-bottom: 5px">Action</span>
                                </a>
                                <div class="dropdown-menu" style="">
{{--                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{ route('admin.equipment-receive.index', 'id='.\Request::get('id')) }}" class="">--}}
{{--                                        <i class="bx bx-edit cursor-pointer"></i>&nbsp;&nbsp;&nbsp;Edit Receive--}}
{{--                                    </a>--}}
                                    @if((auth()->user()->hasRole('CCMS_SERVICE_ENGINEER') || auth()->user()->hasRole('CCMS_TICKET_MANAGER')) && $getEquipmentReceiveDtl->delivered_yn=='N')
                                        <a type="button" class="dropdown-item hvr-underline-reveal show-modal">
                                            <i class="bx bx-check-circle"></i>&nbsp;&nbsp; Equipment Delivery
                                        </a>
                                    @endif
                                </div>
                            </li>
                        </ul>
{{--                        javascript:history.go(-1)--}}
                        <a  class="btn btn btn-outline-dark hvr-underline-reveal mb-1" href="{{ route('admin.equipment-receive.index') }}">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>

                </div>
                <hr>
{{--                {{dd($getEquipmentReceiveDtl)}}--}}
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap" width="200">
                                    <strong>Receipt Id <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentReceiveDtl)?$getEquipmentReceiveDtl->receipt_id:''}}</span></td>
                            </tr>
                            @if($getEquipmentReceiveDtl->equipment_no!=null)
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Ticket No <span>:</span></strong></td>
                                    <td>
                                        <a href="{{route('service_ticket.ticket_dtl',['id' => $getEquipmentReceiveDtl->ticket_no])}}" target="_blank"><span>{{$getEquipmentReceiveDtl->ticket_no}}</span></a>
                                    </td>
                                </tr>
                            @endif
                            @if($getEquipmentReceiveDtl->equipment_no!=null)
                                <tr>
                                    <td class="pl-5 text-nowrap">
                                        <strong>Equipment Name <span>:</span></strong>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.equipment-list.detail',['id' => $getEquipmentReceiveDtl->equipment_no])}}" target="_blank"><span>{{$getEquipmentReceiveDtl->equipment_name}}</span></a>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Received Date <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentReceiveDtl)?date('d-m-Y', strtotime($getEquipmentReceiveDtl->received_date)):''}}</span></td>
                            </tr>

                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Equipment Description <span>:</span></strong>
                                </td>
                                <td>
                                    <span>{{($getEquipmentReceiveDtl)?$getEquipmentReceiveDtl->received_note:''}}</span>
                                </td>
                            </tr>
                            @if($getEquipmentReceiveDtl->received_doc)
                                <tr>
                                    <td class="pl-5 text-nowrap">
                                        <strong>Download Received Doc <span>:</span></strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('download-receive-doc', $getEquipmentReceiveDtl->receipt_no) }}"
                                           target="_blank"><i class="bx bx-download cursor-pointer"></i></a>
                                    </td>
                                </tr>
                            @endif
                            @if($getEquipmentReceiveDtl->delivery_doc)
                                <tr>
                                    <td class="pl-5 text-nowrap">
                                        <strong>Download Delivery Doc <span>:</span></strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('download-delivery-doc', $getEquipmentReceiveDtl->receipt_no) }}"
                                           target="_blank"><i class="bx bx-download cursor-pointer"></i></a>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Start Modal Form For Equipment Assign --}}
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">
                      <i class="fas fa-check"></i> Assign</a> --}}
                    <h4 class="modal-title text-uppercase text-left">Equipment Delivery</h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
{{--                {{route('admin.equipment-assign.store')}}--}}
                <form method="POST" action="{{route('admin.equipment-delivery-status')}}">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="col-md-12">
                                    <label class="">DELIVERY DOC </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file1" >
                                        <input type="hidden" name="delivery_doc" id="delivery_doc"/>
                                        @if (\Request::get('id'))
                                            <input type="hidden" name="receipt_no" value="{{\Request::get('id')}}">
                                        @endif
                                        <label class="custom-file-label" for="delivery_doc">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="comment">Comment </label>
                                        <textarea name="comment" id="comment"
                                                  placeholder="Wright Your Comment" cols="30"
                                                  class="form-control"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="save"
                                                class="float-right btn btn btn-dark shadow mt-2 mb-1">
                                            <i class="bx bx-save"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div> <!--Modal End -->

{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <!--List-->--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">Requisition List</h4>--}}
{{--                </div>--}}
{{--                <div class="card-content">--}}
{{--                    <div class="card-body card-dashboard">--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table table-sm table-striped">--}}
{{--                                <thead class="text-nowrap">--}}
{{--                                <tr>--}}
{{--                                    <th class="text-center" style="padding: 10px">REQUISITION ID</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">REQUISITION FOR</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">EQUIPMENT NAME</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">REQUISITION NOTE</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">REQUISITION DATE</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">APPROVED DATE</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @if(!empty($requisitionData))--}}
{{--                                    @foreach($requisitionData as $key=>$value)--}}
{{--                                        <tr>--}}
{{--                                            <td>--}}
{{--                                                <a href="{{route('admin.requisition-master.detail-view',['id' => $value->requisition_mst_no])}}"--}}
{{--                                                   target="_blank"><span>{{$value->requisition_id}}</span></a></td>--}}
{{--                                            <td>{{$value->requisition_for}}</td>--}}
{{--                                            <td>{{$value->equipment_name}}</td>--}}
{{--                                            <td>{{$value->requisition_note}}</td>--}}
{{--                                            <td>{{($value->requisition_date)?date('d-m-Y', strtotime($value->requisition_date)):''}}</td>--}}
{{--                                            <td>{{($value->approved_date)?date('d-m-Y', strtotime($value->approved_date)):''}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                @else--}}
{{--                                    <tr>--}}
{{--                                        <td colspan="6">--}}
{{--                                            <div style="width: 100%;text-align: center"><span>No Data Found</span></div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <!--List-->--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 class="card-title">Third Party List</h4>--}}
{{--                </div>--}}
{{--                <div class="card-content">--}}
{{--                    <div class="card-body card-dashboard">--}}
{{--                        <div class="table-responsive">--}}
{{--                            <table class="table table-sm table-striped">--}}
{{--                                <thead class="text-nowrap">--}}
{{--                                <tr>--}}
{{--                                    <th class="text-center" style="padding: 10px">TICKET NO</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">VENDOR NAME</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">EQUIPMENT NAME</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">PROBLEM DESCRIPTION</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">SERVICE_CHARGE</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">SENDING DATE</th>--}}
{{--                                    <th class="text-center" style="padding: 10px">RECEIVED DATE</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @if(!empty(!empty($thirdPartyData)))--}}
{{--                                    @foreach($thirdPartyData as $key=>$value)--}}
{{--                                        <tr>--}}
{{--                                            <td>--}}
{{--                                                <a href="{{route('admin.third_party.detail-view',['id' => $value->third_party_service_id])}}"--}}
{{--                                                   target="_blank"><span>{{$value->ticket_no}}</span></a></td>--}}
{{--                                            <td>{{$value->vendor_name}}</td>--}}
{{--                                            <td>{{$value->equipment_name}}</td>--}}
{{--                                            <td>{{$value->problem_description}}</td>--}}
{{--                                            <td>{{$value->service_charge}}</td>--}}
{{--                                            <td>{{date('d-m-Y', strtotime($value->sending_date))}}</td>--}}
{{--                                            <td>{{date('d-m-Y', strtotime($value->received_date))}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                @else--}}
{{--                                    <tr>--}}
{{--                                        <td colspan="6">--}}
{{--                                            <div style="width: 100%;text-align: center"><span>No Data Found</span></div>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>
        $(document).on('click', '.show-modal', function (id) {
            $('#show').modal('show');
            // $('.modal-title').text('Equipment List Detail');
        });
        $(document).ready(function () {
            //Date time picker
            function dateTimePicker(selector) {
                var elem = $(selector);
                elem.datetimepicker({
                    format: 'DD-MM-YYYY',
                    icons: {
                        date: 'bx bxs-calendar',
                        up: 'bx bx-up-arrow-alt',
                        down: 'bx bx-down-arrow-alt',
                        previous: 'bx bx-chevron-left',
                        next: 'bx bx-chevron-right',
                        today: 'bx bxs-calendar-check',
                        clear: 'bx bx-trash',
                        close: 'bx bx-window-close'

                    }
                });
            }

            dateTimePicker("#assign_date");
            // dateTimePicker("#warranty_expiry_date");
            $('#assign_date_input').val(getSysDate());

        });
        function getBase64(file) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                $(document).find('#delivery_doc').val(reader.result);
                console.log(reader.result);
            };
            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        }

        $("#file1").on('change', function(){
            var file = document.querySelector('#file1').files[0];
            getBase64(file); // prints the base64 string
        });
    </script>
@endsection

{{-- onClick="window.location.href='{{ route('ticket_assign.index', ['id' => $data['ticket_no']]) }}'" --}}
