@extends('layouts.default')

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
                      Equipment Add Details
                    </span>
                    <div class="row">
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i> Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_EQUIPMENT_ADD_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_ADD_DETAILS.xdo&P_EQUIPMENT_ADD_NO='.\Request::get('id').'&type=pdf&filename=RPT_SERVICE_EQUIPMENT_ADD_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"  href="{{url('/report/render/RPT_SERVICE_EQUIPMENT_ADD_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_ADD_DETAILS.xdo&P_EQUIPMENT_ADD_NO='.\Request::get('id').'&type=xlsx&filename=RPT_SERVICE_EQUIPMENT_ADD_DETAILS')}}"  >
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
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{ route('admin.equipment-add.index', 'id='.\Request::get('id')) }}" class="">
                                        <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Equipment
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <a  class="btn btn btn-outline-dark hvr-underline-reveal mb-1" href="{{ route('admin.equipment-add.index') }}">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
{{--                    <div class="row">--}}
{{--                        <button type="button" class="btn btn-primary btn-sm show-modal">Assign</button>--}}
{{--                    </div>--}}

                </div>
                <hr>
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap" width="200">
                                    <strong>Equipment Add Id <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->equipment_add_id:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap" width="200">
                                    <strong>Equipment Id <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->equipment_id:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Equipment Name <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->equipment_name:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Equipment Name Bangla <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->equipment_name_bn:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Equipment Description <span>:</span></strong>
                                </td>
                                <td>
                                    <span><p>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->equipment_description:''}}</p></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Quantity <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->quantity:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Vendor Name <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl->vendor)?$getEquipmentAddDtl->vendor->vendor_name:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Manufacturer <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->manufacturer:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Model No <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->model_no:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Serial No <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->serial_no:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Price <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->price:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Purchase Date <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->purchase_date:''}}</span></td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td class="pl-5 text-nowrap">--}}
{{--                                    <strong>Requisition Master No <span>:</span></strong>--}}
{{--                                </td>--}}
{{--                                <td><span>{{($getEquipmentAddDtl)?$getEquipmentAddDtl->requisition_mst_no:''}}</span></td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td class="pl-5 text-nowrap">
                                    <strong>Warranty Expiry Date <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentAddDtl)?date('d-m-Y', strtotime($getEquipmentAddDtl->warranty_expiry_date)):''}}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    </script>
@endsection

{{-- onClick="window.location.href='{{ route('ticket_assign.index', ['id' => $data['ticket_no']]) }}'" --}}
