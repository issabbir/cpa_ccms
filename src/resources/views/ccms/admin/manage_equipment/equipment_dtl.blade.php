@extends('layouts.default')
@section('title')
    Equipment List Details
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

        .select2-container--default .select2-results > .select2-results__options {
            max-width: 200px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <span class="card-title font-weight-bold text-uppercase">
                              Equipment Information
                            </span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="row float-right">
                                <ul class="nav nav-pills">
                                    <li class="nav-item dropdown nav-fill">
                                        <a class="nav-link btn-sm dropdown-toggle bg-secondary text-white"
                                           data-toggle="dropdown"
                                           href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-down-arrow-circle font-small-4"></i>
                                            <span style="font-size: medium;font-weight: bold">Print</span>
                                        </a>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                               href="{{url('/report/render/RPT_EQUIPMENT_DETAILS?xdo=/~weblogic/CCMS/RPT_EQUIPMENT_DETAILS.xdo&p_equipment_no='.\Request::get('id').'&type=pdf&filename=RPT_EQUIPMENT_DETAILS')}}">
                                                <i class="bx bxs-file-pdf"></i> PDF
                                            </a>
                                            <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                               href="{{url('/report/render/RPT_EQUIPMENT_DETAILS?xdo=/~weblogic/CCMS/RPT_EQUIPMENT_DETAILS.xdo&p_equipment_no='.\Request::get('id').'&type=xlsx&filename=RPT_EQUIPMENT_DETAILS')}}">
                                                <i class="bx bxs-file-pdf"></i> Excel
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="nav nav-pills">
                                    <li class="nav-item dropdown nav-fill">
                                        <a class="nav-link btn-sm dropdown-toggle bg-secondary text-white"
                                           data-toggle="dropdown"
                                           href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-navigation font-small-4"></i> <span
                                                style="font-size: medium;font-weight: bold">Action</span>
                                        </a>
                                        <div class="dropdown-menu" style="">
                                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') || auth()->user()->hasRole('CCMS_ADMIN'))
                                                @if($getDatas->equipment_status_id=='1' || $getDatas->equipment_status_id==null)
                                                    @if(empty($equipAssignData))
                                                        <a class="dropdown-item show-modal hvr-underline-reveal"
                                                           href="javascript:void(0)">
                                                            <i class="bx bx-task"></i> &nbsp;Assign
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item show-modal hvr-underline-reveal"
                                                           href="javascript:void(0)">
                                                            <i class="bx bx-task"></i> &nbsp;Reassign
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif
                                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') || auth()->user()->hasRole('CCMS_ADMIN'))
                                                <a class="dropdown-item show-status-modal hvr-underline-reveal"
                                                   href="javascript:void(0)">
                                                    <i class="bx bx-edit-alt"></i> &nbsp;Change Status
                                                </a>
                                            @endif
                                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') || auth()->user()->hasRole('CCMS_ADMIN'))
                                                <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                                   href="{{ route('admin.equipment-list.index', 'id='.\Request::get('id')) }}"
                                                   class="">
                                                    <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Equipment
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                                <a class="btn btn-sm btn-outline-dark  mb-1"
                                   href="{{ route('admin.equipment-list.index') }}">
                                    <i class="bx bx-arrow-back font-small-4"></i> <span
                                        style="font-size: medium;font-weight: bold">Back</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @if(!empty($equipAssignData))
                    <div class="bs-component pl-1 pr-1 alert alert-dismissible alert-static-success"
                         style="margin: 0 1rem">
                        <div class="d-flex justify-content-between">
                            @if($equipAssignData[0]->emp_id==null)
                                <div class="" style="text-shadow: 10px 10px 10px rgba(0,0,0,0.3);">
                                    <span class="alert-heading" style="font-size: 1.25rem">
                                        Current Assigned : {{ ($equipAssignData)?$equipAssignData[0]->department_name:'' }}
                                    </span>
                                </div>
                                <div class="" style="text-shadow: 10px 10px 10px rgba(0,0,0,0.3);">
                                    <span
                                        style="font-size: 1rem; margin-left: auto"><strong>Equipment Status : &nbsp</strong></span>
                                    @if($equipAssignData[0]->equipment_status_id=='1')
                                        <span class="badge badge-success"
                                              style="font-size: 1rem"><strong> {{ ($equipAssignData)?$equipAssignData[0]->status_name:'' }}</strong></span>
                                    @elseif($equipAssignData[0]->equipment_status_id=='2')
                                        <span class="badge badge-danger"
                                              style="font-size: 1rem"><strong> {{ ($equipAssignData)?$equipAssignData[0]->status_name:'' }}</strong></span>
                                    @elseif($equipAssignData[0]->equipment_status_id=='3')
                                        <span class="badge badge-primary"
                                              style="font-size: 1rem"><strong> {{ ($equipAssignData)?$equipAssignData[0]->status_name:'' }}</strong></span>
                                    @else
                                        <span class="badge badge-success"
                                              style="font-size: 1rem"><strong></strong></span>
                                    @endif
                                </div>
                            @else
                                <div class="" style="text-shadow: 10px 10px 10px rgba(0,0,0,0.3);">
                                    <span class="alert-heading" style="font-size: 1.25rem">
                                            Current Assigned : {{ ($equipAssignData)?$equipAssignData[0]->emp_name:'' }} ({{($equipAssignData)?$equipAssignData[0]->emp_code:'' }})
                                    </span><br>
                                    <span class="alert-heading" style="font-size: 1.25rem">
                                            Department : {{ ($equipAssignData)?$equipAssignData[0]->department_name:'' }}
                                    </span><br>
                                    <span class="alert-heading" style="font-size: 1.25rem">
                                            Designation : {{ ($equipAssignData)?$equipAssignData[0]->designation:'' }}
                                    </span>
                                </div>
                                <div class="align-middle"
                                     style="margin-top: 4%;text-shadow: 0px 8px 10px rgba(0,0,0,0.3);">
                                    <span
                                        style="font-size: 1rem; margin-left: auto"><strong>Equipment Status : &nbsp</strong></span>
                                    <span class="badge badge-primary"
                                          style="font-size: 1rem"><strong> {{ ($equipAssignData)?$equipAssignData[0]->status_name:'' }}</strong></span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap text-right" width="200">
                                    <strong>Equipment Id <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->equipment_id:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Equipment Name <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->equipment_name:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Equipment Name Bangla <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->equipment_name_bn:''}}</span></td>
                            </tr>

                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Catagory Name <span>:</span></strong>
                                </td>
                                <td><span>{{($getDatas)?$getDatas->catagory_name:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Vendor Name <span>:</span></strong>
                                </td>
                                <td><span>{{(isset($getDatas->vendor))?$getDatas->vendor->vendor_name:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Manufacturer <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->manufacturer:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Model No <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->model_no:''}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Serial No <span>:</span></strong>
                                </td>
                                <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->serial_no:''}}</span></td>
                            </tr>
                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                <tr>
                                    <td class="pl-5 text-nowrap text-right">
                                        <strong>Price <span>:</span></strong>
                                    </td>
                                    <td><span>{{($getEquipmentDtl)?$getEquipmentDtl->price:''}}</span></td>
                                </tr>
                            @endif
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Purchase Date <span>:</span></strong>
                                </td>
                                <td>
                                    <span>{{($getEquipmentDtl)?date('d-m-Y', strtotime($getEquipmentDtl->purchase_date)):''}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Warranty Expiry Date <span>:</span></strong>
                                </td>
                                <td>
                                    <span>{{($getEquipmentDtl)?date('d-m-Y', strtotime($getEquipmentDtl->warranty_expiry_date)):''}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Last Maintenance Date <span>:</span></strong>
                                </td>
                                <td>
                                    <span>{{--{{($getEquipmentDtl)?date('d-m-Y', strtotime($getEquipmentDtl->last_maintenance_date)):''}}--}}
                                        @if($getEquipmentDtl)
                                            @if($getEquipmentDtl->last_maintenance_date!=null)
                                                {{date('d-m-Y', strtotime($getEquipmentDtl->last_maintenance_date))}}
                                            @else
                                                --
                                            @endif
                                        @else
                                            --
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') || auth()->user()->hasRole('CCMS_ADMIN'))
                                <tr>
                                    <td class="pl-5 text-nowrap text-right">
                                        <strong>Total Maintenance Cost <span>:</span></strong>
                                    </td>
                                    <td>
                                        <span>{{number_format($total_equipment_item + $total_third_party + $getEquipmentDtl->total_maintenance_cost)}}</span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>No Of Maintenance <span>:</span></strong>
                                </td>
                                <td><span>{{count($equipmentItemData) + count($thirdPartyData)}}</span></td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap text-right">
                                    <strong>Equipment Description <span>:</span></strong>
                                </td>
                                <td>
                                    <span>{!! strip_tags(($getEquipmentDtl)?$getEquipmentDtl->equipment_description:'') !!}</span>
                                </td>
                            </tr>
                            @if($getEquipmentDtl->invoice!=null)
                                <tr>
                                    <td class="pl-5 text-nowrap text-right">
                                        <strong>Download Invoice <span>:</span></strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('download-equipment-invoice', $getEquipmentDtl->equipment_no) }}"
                                           target="_blank"><i class="bx bx-download cursor-pointer"></i></a></td>
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
<span class="card-title">
<div class="row" style="margin-left: 0px">
<h4>Equipment Items</h4>
<span class="badge bg-dark h-25 ml-1" style="margin-top: 3px">
<strong>{{count($equipmentItemData)}}</strong>
</span>
</div>
</span>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="eq_items">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">EQUIPMENT NAME</th>
                                    <th class="text-center" style="padding: 10px">EQUIPMENT DESCRIPTION</th>
                                    <th class="text-center" style="padding: 10px">VENDOR NAME</th>
                                    <th class="text-center" style="padding: 10px">MANUFACTURER</th>
                                    <th class="text-center" style="padding: 10px">MODEL NO</th>
                                    <th class="text-center" style="padding: 10px">SERIAL NO</th>
                                    <th class="text-center" style="padding: 10px">QUANTITY</th>
                                    <th class="text-center" style="padding: 10px">PRICE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($equipmentItemData))
                                    @foreach($equipmentItemData as $key=>$value)
                                        <tr>
                                            <td>{{$value->equipment_name}}</td>
                                            <td>{{$value->equipment_description}}</td>
                                            <td>{{(isset($value->vendor))?$value->vendor->vendor_name:''}}</td>
                                            <td>{{$value->manufacturer}}</td>
                                            <td>{{$value->model_no}}</td>
                                            <td>{{$value->serial_no}}</td>
                                            <td>{{$value->quantity}}</td>
                                            <td>{{$value->price}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">
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

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
<span class="card-title">
<div class="row" style="margin-left: 0px">
<h4>Equipment Assign History</h4>
<span class="badge bg-dark h-25 ml-1" style="margin-top: 3px">
<strong>{{count($equipAssignData)}}</strong>
</span>
</div>
</span>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">Person Wise Use</th>
                                    <th class="text-center" style="padding: 10px">Name</th>
                                    <th class="text-center" style="padding: 10px">Department</th>
                                    <th class="text-center" style="padding: 10px">Building No</th>
                                    <th class="text-center" style="padding: 10px">Room No</th>
                                    <th class="text-center" style="padding: 10px">ASSIGN DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($equipAssignData))
                                    @foreach($equipAssignData as $key=>$value)
                                        <tr>
                                            <td>@if($value->person_wise_use_yn=='Y') Yes @else No @endif</td>
                                            <td>{{$value->emp_name}}</td>
                                            <td>{{$value->department_name}}</td>
                                            <td>{{$value->working_location}} ({{$value->building_no}})</td>
                                            <td>{{$value->room_no}}</td>
                                            <td>{{($value->assign_date)?date('d-m-Y h:i A', strtotime($value->assign_date)):''}}</td>
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
<span class="card-title">
<div class="row" style="margin-left: 0px">
<h4>Requisition</h4>
<span class="badge bg-dark h-25 ml-1" style="margin-top: 3px">
<strong>{{count($requisitionData)}}</strong>
</span>
</div>
</span>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">REQUISITION ID</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION FOR</th>
                                    <th class="text-center" style="padding: 10px">EQUIPMENT NAME</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION NOTE</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION STATUS</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION DATE</th>
                                    {{--<th class="text-center" style="padding: 10px">APPROVED DATE</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($requisitionData))
                                    @foreach($requisitionData as $key=>$value)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.requisition-master.detail-view',['id' => $value->requisition_mst_no])}}"
                                                   target="_blank"><span>{{$value->requisition_id}}</span></a></td>
                                            <td>{{$value->requisition_for}}</td>
                                            <td>{{$value->equipment_name}}</td>
                                            <td>{{strip_tags($value->requisition_note)}}</td>
                                            <td>{!! $value->status_name == 'DELIVER TO STORE OFFICER' ? "<span class='badge badge-success'>APPROVED</span>" : $value->status_name !!}</td>
                                            <td>{{($value->requisition_date)?date('d-m-Y', strtotime($value->requisition_date)):''}}</td>
                                            {{--<td>{{($value->approved_date)?date('d-m-Y', strtotime($value->approved_date)):''}}</td>--}}
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
<span class="card-title">
<div class="row" style="margin-left: 0px">
<h4>Third Party Services</h4>
<span class="badge bg-dark h-25 ml-1" style="margin-top: 3px">
<strong>{{count($thirdPartyData)}}</strong>
</span>
</div>
</span>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">TICKET NO</th>
                                    <th class="text-center" style="padding: 10px">VENDOR NAME</th>
                                    <th class="text-center" style="padding: 10px">EQUIPMENT NAME</th>
                                    <th class="text-center" style="padding: 10px">PROBLEM DESCRIPTION</th>
                                    @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                        <th class="text-center" style="padding: 10px">SERVICE CHARGE</th>
                                    @endif
                                    <th class="text-center" style="padding: 10px">SENDING DATE</th>
                                    <th class="text-center" style="padding: 10px">RECEIVED DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(filled($thirdPartyData))
                                    @foreach($thirdPartyData as $key=>$value)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.third_party.detail-view',['id' => $value->third_party_service_id])}}"
                                                   target="_blank"><span>{{$value->ticket_no}}</span></a></td>
                                            <td>{{$value->vendor_name}}</td>
                                            <td>{{$value->equipment_name}}</td>
                                            <td>{{$value->problem_description}}</td>
                                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                                <td>{{$value->service_charge}}</td>
                                            @endif
                                            <td>{{date('d-m-Y', strtotime($value->sending_date))}}</td>
                                            <td>{{date('d-m-Y', strtotime($value->received_date))}}</td>
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

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
<span class="card-title">
<div class="row" style="margin-left: 0px">
<h4>Service Ticket History</h4>
<span class="badge bg-dark h-25 ml-1" style="margin-top: 3px">
<strong>{{count($serviceTicketData)}}</strong>
</span>
</div>
</span>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">Ticket</th>
                                    <th class="text-center" style="padding: 10px">Ticket Type</th>
                                    <th class="text-center" style="padding: 10px">Priority</th>
                                    <th class="text-center" style="padding: 10px">Employee/Department</th>
                                    <th class="text-center" style="padding: 10px">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($serviceTicketData))
                                    @foreach($serviceTicketData as $key=>$value)
                                        <tr>
                                            <td>
                                                <a href="{{route('service_ticket.ticket_dtl',['id' => $value->ticket_no])}}"
                                                   target="_blank"><span>{{$value->ticket_no}}</span></a></td>
                                            <td>{{$value->ticket_type_name}}</td>
                                            <td>{{$value->remarks}}</td>
                                            <td>@if($value->department_id!=null) {{$value->department_name}} @else {{$value->emp_name.' ('.$value->emp_code.')'}} @endif</td>
                                            <td>{{$value->status_name}}</td>
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
        </div>
    </div>

    {{-- Start Modal Form For Equipment Assign --}}
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">
                    <i class="fas fa-check"></i> Assign</a> --}}
                    <h4 class="modal-title text-uppercase text-left">
                        Equipment Assign
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('admin.equipment-assign.store')}}">
                        {!! csrf_field() !!}
                        @if ($data && $data->equipment_assign_id)
                            <input type="hidden" name="equipment_assign_id" value="{{$data->equipment_assign_id}}">
                        @endif

                        <input type="hidden" id="inventory_details_id" name="inventory_details_id"
                               value="{{($getDatas)?$getDatas->inventory_details_id:''}}">
                        <input type="hidden" name="flag" value="Y">
                        <hr>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>SL NO</label>
                                        <input type="text"
                                               id="inventory_sl_no"
                                               autocomplete="off" disabled
                                               value="{{($getDatas)?$getDatas->inventory_sl_no:''}}"
                                               class="form-control text-uppercase">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>SERIAL NO/PART NO</label>
                                        <input type="text"
                                               id="sl_no"
                                               autocomplete="off" disabled
                                               value="{{($getDatas)?$getDatas->serial_no:''}}"
                                               class="form-control text-uppercase">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>PERSON WISE USE</label>
                                <div class="d-flex d-inline-block" style="margin-top: 10px">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                               onclick="javascript:enableDisableOne();"
                                               value="{{ old('person_wise_use_yn','Y') }}"
                                               {{isset($data->person_wise_use_yn) && $data->person_wise_use_yn == 'Y' ? 'checked' : ''}} name="person_wise_use_yn"
                                               id="customRadio1" checked>
                                        <label class="custom-control-label cursor-pointer"
                                               for="customRadio1">Person</label>
                                    </div>&nbsp;&nbsp;
                                    <div class="custom-control custom-radio ml-1">
                                        <input type="radio" class="custom-control-input"
                                               onclick="javascript:enableDisableTwo();"
                                               value="{{ old('person_wise_use_yn','N') }}"
                                               {{isset($data->person_wise_use_yn) && $data->person_wise_use_yn == 'N' ? 'checked' : ''}} name="person_wise_use_yn"
                                               id="customRadio2">
                                        <label class="custom-control-label cursor-pointer"
                                               for="customRadio2">Dept</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-1">
                                        <input type="radio" class="custom-control-input"
                                               onclick="javascript:enableDisableTwo3();"
                                               value="{{ old('person_wise_use_yn','O') }}" name="person_wise_use_yn"
                                               {{isset($data->person_wise_use_yn) && $data->person_wise_use_yn == 'O' ? 'checked' : ''}}
                                               id="customRadio55">
                                        <label class="custom-control-label cursor-pointer"
                                               for="customRadio55">Other</label>
                                    </div>
                                </div>
                                <input type="hidden" id="equipment_no" name="equipment_no"
                                       value="{{\Request::get('id')}}">
                                @if($errors->has("person_wise_use_yn"))
                                    <span class="help-block">{{$errors->first("person_wise_use_yn")}}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Emp Code</label>
                                    <select class="custom-select select2" name="emp_id" id="emp_id"
                                            style="width: 100%">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="show_info" style="display: none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" id="emp_desig"
                                                   class="form-control"
                                                   disabled
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input type="text" id="emp_department" name="emp_department"
                                                   class="form-control"
                                                   disabled
                                                   autocomplete="off">
                                            <input type="hidden" id="emp_department_id" name="emp_department_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <input type="text" id="emp_section" name="emp_section"
                                                   class="form-control"
                                                   disabled
                                                   autocomplete="off">
                                            <input type="hidden" id="emp_section_id" name="emp_section_id">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="col-md-6">
                            <div class="row">
                            <div class="col-md-12">
                            @include('ccms/common/equipment_emp_select_box',
                            [
                            'select_name' => 'emp_id',
                            'label_name' => 'Employee ID',
                            'required' => true,
                            ]
                            )
                            </div>
                            </div>
                            </div>--}}
                            <div class="col-md-12" id="show_info_dept" style="display: block;">
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Department ID </label>
                                                <select id="department_id" name="department_id"
                                                        style="width: 100%!important;"
                                                        class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($departments as $department)
                                                        <option
                                                            value="{{$department->department_id}}">{{$department->department_name}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has("department_id"))
                                                    <span class="help-block">{{$errors->first("department_id")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>SECTION</label>
                                                <select id="dpt_section_id" name="dpt_section_id"
                                                        class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($sections as $section)
                                                        <option
                                                            value="{{$section->dpt_section_id}}">{{$section->dpt_section}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has("dpt_section_id"))
                                                    <span class="help-block">{{$errors->first("dpt_section_id")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="show_info_outsider" style="display: none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Name</label>
                                            <input type="text" id="emp_name_outside"
                                                   class="form-control" name="emp_name_outside"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Department</label>
                                            <input type="text" id="emp_dept_outside" name="emp_dept_outside"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Designation</label>
                                            <input type="text" id="emp_desig_outside" name="emp_desig_outside"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <input type="text" id="emp_section_outside" name="emp_section_outside"
                                                   class="form-control"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>BUILDING NO</label>
                                        <select id="building_no" name="building_no"
                                                class="form-control select2">
                                            <option value="">Select one</option>
                                            @foreach($locationList as $location)
                                                <option style="width: 100px!important;"
                                                        value="{{$location->location_id}}">{{$location->working_location}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("building_no"))
                                            <span class="help-block">{{$errors->first("building_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>ROOM NO</label>
                                        <input type="text"
                                               id="room_no"
                                               name="room_no"
                                               autocomplete="off"
                                               value="{{ old('room_no', ($data)?$data->room_no:'') }}"
                                               placeholder="ROOM NO"
                                               class="form-control text-uppercase">
                                        @if($errors->has("room_no"))
                                            <span class="help-block">{{$errors->first("room_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-1">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Assignment Date<span></span></label>
                                        <div class="input-group date" id="eqip_assign_date" data-target-input="nearest">
                                            <input type="date" name="eqip_assign_date"
                                                   autocomplete="off"
                                                   value="{{ old('eqip_assign_date')}}"
                                                   class="form-control"
                                                   id="eqip_assign_date"
                                                   placeholder="Assignment Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                            <div class="row ">
                            <div class="col-md-12">
                            <label class="input-required">ASSIGN DATE<span class="required"></span></label>
                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                            id="assign_date" data-target-input="nearest">
                            <input type="text" name="assign_date"
                               required
                               value="{{ old('assign_date', ($data)?$data->assign_date:'') }}"
                               class="form-control berthing_at"
                               data-target="#assign_date"
                               id="assign_date_input"
                               data-toggle="datetimepicker"
                               placeholder="PURCHASE DATE">
                            <div class="input-group-append" data-target="#assign_date"
                             data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="bx bx-calendar"></i>
                            </div>
                            </div>
                            </div>
                            @if($errors->has("assign_date"))
                            <span class="help-block">{{$errors->first("assign_date")}}</span>
                            @endif
                            </div>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <label class="input-required required">ACTIVE YN</label>
                            <div class="d-flex d-inline-block" style="margin-top: 10px">
                            <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input"
                            value="{{ old('active_yn','Y') }}"
                            {{isset($data->active_yn) && $data->active_yn == 'Y' ? 'checked' : ''}} name="active_yn"
                            id="customRadio3" checked>
                            <label class="custom-control-label" for="customRadio3">YES</label>
                            </div>&nbsp;&nbsp;
                            <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input"
                            value="{{ old('active_yn','N') }}"
                            {{isset($data->active_yn) && $data->active_yn == 'N' ? 'checked' : ''}} name="active_yn"
                            id="customRadio4">
                            <label class="custom-control-label" for="customRadio4">NO</label>
                            </div>
                            </div>
                            @if($errors->has("active_yn"))
                            <span class="help-block">{{$errors->first("active_yn")}}</span>
                            @endif
                            </div>--}}
                            <div class="col-md-12">
                                <hr>
                                <div class="row my-1">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bx-task"></i> Assign
                                            </button>
                                            <button type="reset" class="btn btn btn-outline-dark  mb-1"
                                                    data-dismiss="modal"><i class="bx bx-window-close"></i> Cancel
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

    {{-- Start Modal Form For Equipment Assign --}}
    <div id="status-show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase text-left">
                        Equipment Status
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('admin.stauts-update')}}">
                        {!! csrf_field() !!}
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Equipment Status</label>
                                    <select class="custom-select select2" name="equipment_status" id="equipment_status"
                                            style="width: 100%">
                                        <option value="">Select One</option>
                                        @foreach($getEquipmentStatus as $equipmentStatus)
                                            <option value="{{$equipmentStatus->equipment_status_id}}"
                                                {{isset($equipAssignData[0]->equipment_status_id) && $equipAssignData[0]->equipment_status_id == $equipmentStatus->equipment_status_id ? 'selected' : ''}}
                                            >{{$equipmentStatus->status_name}}</option>
                                            {{--<option
                                            value="{{ $equipmentStatus->equipment_status_id }}">
                                            {{ $equipmentStatus->status_name }}
                                            </option>--}}
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="equipment_no" name="equipment_no"
                                           value="{{\Request::get('id')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end" style="margin-top: 10%">
                                            <button type="submit" name="save"
                                                    class="btn btn btn-dark btn-sm shadow mr-1 mb-1">
                                                {{--                                                <div class="row" style="padding: 5px;margin-bottom: 2px">--}}
                                                {{--                                                </div>--}}
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

        $(document).on('click', '.show-modal', function (id) {
            $('#show').modal('show');
// $('.modal-title').text('Equipment List Detail');
        });
        $(document).on('click', '.show-status-modal', function (id) {
            $('#status-show').modal('show');
// $('.modal-title').text('Equipment List Detail');
        });

        function enableDisableOne() {
            if (document.getElementById('customRadio1').checked) {
                $("#emp_id").prop("disabled", false);
                $("#department_id").prop("disabled", true);
                $('#department_id').val("").trigger("change");
                $('#dpt_section_id').val("").trigger("change");
                $('#emp_desig').val('');
                $('#emp_name_outside').val('');
                $('#emp_desig_outside').val('');
                $('#emp_dept_outside').val('');
                $('#emp_section_outside').val('');
                $('#show_info').css("display", "block");
                $('#show_info_dept').css("display", "none");
                $('#show_info_outsider').css("display", "none");

            }
        }

        function enableDisableTwo() {
            if (document.getElementById('customRadio2').checked) {
                $("#emp_id").prop("disabled", true);
                $("#department_id").prop("disabled", false);
                $('#emp_id').empty();
                $('#emp_department').val('');
                $('#emp_section').val('');
                $('#emp_name_outside').val('');
                $('#emp_desig_outside').val('');
                $('#emp_dept_outside').val('');
                $('#emp_section_outside').val('');
//$('#emp_department_id').val('');
//$('#emp_section_id').val('');
                $('#show_info').css("display", "none");
                $('#show_info_dept').css("display", "block");
                $('#show_info_outsider').css("display", "none");
            }
        }

        function enableDisableTwo3() {
            if (document.getElementById('customRadio55').checked) {
                $('#department_id').val("").trigger("change");
                $('#dpt_section_id').val("").trigger("change");
                $('#emp_id').empty();
                $('#emp_department').val('');
                $('#emp_desig').val('');
                $('#emp_section').val('');
                $("#emp_id").prop("disabled", true);
                $('#show_info_outsider').css("display", "block");
                $('#show_info').css("display", "none");
                $('#show_info_dept').css("display", "none");
            }
        }

        function populateRelatedFields(that, data) {
            $(that).parent().parent().parent().find('#emp_department').val(data.department);
            $(that).parent().parent().parent().find('#emp_section').val(data.section);
            $(that).parent().parent().parent().find('#emp_desig').val(data.designation);
            $(that).parent().parent().parent().find('#emp_department_id').val(data.department_id);
            $(that).parent().parent().parent().find('#emp_section_id').val(data.dpt_section_id);
        }

        $(document).ready(function () {
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
            selectCpaEmployees('#emp_id', APP_URL + '/admin/employees', APP_URL + '/admin/employee/', populateRelatedFields);
            $('#assign_date_input').val(getSysDate());
//$("#department_id").prop("disabled", true);
            $('#show_info').css("display", "block");
            $('#show_info_dept').css("display", "none");
        });
    </script>
@endsection

{{-- onClick="window.location.href='{{ route('ticket_assign.index', ['id' => $data['ticket_no']]) }}'" --}}
