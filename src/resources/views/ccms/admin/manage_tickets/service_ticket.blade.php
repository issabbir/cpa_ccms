@extends('layouts.default')

@section('title')
    Service Ticket
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body" id="ticket_form" style="@if(\Request::get('id')) display: block @else display: none @endif">
                        <h4 class="card-title text-uppercase">
                            {{ $data && isset($data->ticket_no)?'Edit':'Add' }} Service Ticket
                        </h4>
                        <div>
                            <form method="POST" class="mt-1" action="@if ($data && $data->ticket_no) {{route('service_ticket.update',['id' => $data->ticket_no])}} @else {{route('service_ticket.store')}} @endif">
                                {{ ($data && isset($data->ticket_no))?method_field('PUT'):'' }}
                                {!! csrf_field() !!}
                                @if ($data && $data->ticket_no)
                                    <input type="hidden" name="ticket_no" value="{{$data->ticket_no}}">
                                @endif
                                @include('ccms/admin/manage_tickets/service_ticket_form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--List-->
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title text-uppercase">Service Ticket List </h4>
                </div>
                <div class="col-md-6">
                    <div class="row float-right">
                        <form name="report_form" id="report_form" target="_blank" action="{{route('report', ['title' => 'Service-ticket'])}}">
                            {{csrf_field()}}
                            <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_SERVICE_TICKET_LIST.xdo"/>
                            <input type="hidden" name="type" id="type" value="pdf" />
                            <input type="hidden" name="filename" id="filename" value="service_ticket" />
                            <input type="hidden" name="p_emp_id" id="p_emp_id" />
                            <input type="hidden" name="p_ticket_for" id="p_ticket_for" />
                            <input type="hidden" name="p_department_id" id="p_department_id" />
                            <input type="hidden" name="p_section_id" id="p_section_id" />
                            <input type="hidden" name="p_meeting_room_no" id="p_meeting_room_no" />
                            <input type="hidden" name="p_ticket_type_no" id="p_ticket_type_no" />
                            <input type="hidden" name="p_ticket_priority_no" id="p_ticket_priority_no" />
                            <input type="hidden" name="p_equipment_no" id="p_equipment_no" />
                            <input type="hidden" name="p_ticket_internal_external_yn" id="p_ticket_internal_external_yn" />
                            <input type="hidden" name="p_occurance_from_date" id="p_occurance_from_date" />
                            <input type="hidden" name="p_occurance_to_date" id="p_occurance_to_date" />
                            <input type="hidden" name="p_assign_engineer_id" id="p_assign_engineer_id" />
                            <input type="hidden" name="p_service_status_no" id="p_service_status_no" />


                            @section('footer-script')
                                @parent
                                <script>
                                    $(document).ready(function() {

                                        $("#report_pdf_action").on('click',function() {

                                            var report_form = $("#report_form");
                                            var filter_form = $("#datatable_filter_form");
                                            report_form.find('#type').val("pdf");
                                            report_form.find('#p_emp_id').val(filter_form.find('select.emp_id').val());
                                            report_form.find('#p_ticket_for').val(filter_form.find('select.ticket_for').val());
                                            report_form.find('#p_department_id').val(filter_form.find('select.department_id').val());
                                            report_form.find('#p_section_id').val(filter_form.find('select.section_id').val());
                                            report_form.find('#p_meeting_room_no').val(filter_form.find('input.meeting_room_no').val());
                                            report_form.find('#p_ticket_type_no').val(filter_form.find('select.ticket_type_no').val());
                                            report_form.find('#p_ticket_priority_no').val(filter_form.find('select.ticket_priority_no').val());
                                            report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                            report_form.find('#p_occurance_from_date').val(filter_form.find('input.occurance_from_date').val());
                                            report_form.find('#p_occurance_to_date').val(filter_form.find('input.occurance_to_date').val());
                                            report_form.find('#p_assign_engineer_id').val(filter_form.find('select.assigned_to').val());
                                            report_form.find('#p_service_status_no').val(filter_form.find('select.status_no').val());

                                            var selected = $("input[type='radio'][name='ticket_internal_external']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_ticket_internal_external_yn').val(selected.val());
                                            }
                                            report_form.submit();
                                        });


                                        $("#report_xlsx_action").on('click',function() {
                                            var report_form = $("#report_form");
                                            var filter_form = $("#datatable_filter_form");
                                            report_form.find('#type').val("xlsx");
                                            report_form.find('#filename').val("service_ticket");
                                            report_form.find('#p_emp_id').val(filter_form.find('select.emp_id').val());
                                            report_form.find('#p_ticket_for').val(filter_form.find('select.ticket_for').val());
                                            report_form.find('#p_department_id').val(filter_form.find('select.department_id').val());
                                            report_form.find('#p_section_id').val(filter_form.find('select.section_id').val());
                                            report_form.find('#p_meeting_room_no').val(filter_form.find('input.meeting_room_no').val());
                                            report_form.find('#p_ticket_type_no').val(filter_form.find('select.ticket_type_no').val());
                                            report_form.find('#p_ticket_priority_no').val(filter_form.find('select.ticket_priority_no').val());
                                            report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                            report_form.find('#p_occurance_from_date').val(filter_form.find('input.occurance_from_date').val());
                                            report_form.find('#p_occurance_to_date').val(filter_form.find('input.occurance_to_date').val());
                                            report_form.find('#p_assign_engineer_id').val(filter_form.find('select.assigned_to').val());
                                            report_form.find('#p_service_status_no').val(filter_form.find('select.status_no').val());

                                            var selected = $("input[type='radio'][name='ticket_internal_external_yn']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_ticket_internal_external_yn').val(selected.val());
                                            }
                                            report_form.submit();
                                        });
                                    });
                                </script>
                            @endsection
                        </form>

                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i>
                                    Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" id="report_pdf_action" href="javascript:void(0)" >
                                        <i class="bx bxs-file-pdf"></i> Pdf
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal"  id="report_xlsx_action" href="javascript:void(0)" >
                                        <i class="bx bxs-file-doc"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <button onclick="$('#datatable_filter_form').toggle('slow')" class="btn btn-secondary mb-1 mr-1 hvr-underline-reveal" id="filter">
                        <i class="bx bx-filter-alt"></i> Filter</button>
                        <button onclick="$('#ticket_form').toggle('slow')" class="btn btn-secondary mb-1 hvr-underline-reveal">
                        <i class="bx bx-plus"></i> Add New</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-rgba-secondary mr-2 ml-2" style="border-radius: 5px">
            <form style="display: none;padding: 1rem 0" id="datatable_filter_form" method="POST">
                <div class="row ml-1 mr-1">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label>{{trans("Assigned To")}}</label>
                                <select id="assigned_to" name="assigned_to"
                                        class="form-control select2 assigned_to">
                                    <option value="">{{trans("Select one")}}</option>
                                    <option value="Assigned">{{trans('Assigned')}}</option>
                                    <option value="Unassigned">{{trans('Unassigned')}}</option>
                                    <option disabled style="font-style:italic">Other Service Engineer</option>
                                    @foreach($getServiceEngineerId as $ServiceEngineerId)
                                        <option
                                            value="{{$ServiceEngineerId->service_engineer_id}}">{{$ServiceEngineerId->service_engineer_name}}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has("service_engineer_id"))
                                    <span class="help-block">{{$errors->first("service_engineer_id")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="row">
                            <div class="col-md-12">
                                <label> TICKET FOR</label>
                                <select id="ticket_for_id_filter" name="ticket_for" class="form-control select2 ticket_for">
                                    <option value="">Select one</option>
                                    @foreach($ticketFor as $value)
                                        <option
                                            {{ ( old("ticket_for_id", ($data)?$data->ticket_for:'') == $value->ticket_for_id) ? "selected" : ""  }}
                                            value="{{$value->ticket_for_id}}">{{$value->ticket_for}}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has("ticket_for_id"))
                                    <span class="help-block">{{$errors->first("ticket_for_id")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1" style="display: none" id="employee_div_filter">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Ticket For Employee</label>
                                @php
                                    $employee = [];
                                    if (old('emp_id')){
                                        $employee = DB::selectOne('select emp_id, emp_name from pmis.employee where emp_id = :emp_id', ['emp_id' => old('emp_id')]);
                                    }
                                @endphp
                                <select name="emp_id" class="form-control emp_id" id="st_emp_id_filter" style="width: 100%">

                                    @if ($employee)
                                        <option selected="selected"
                                                value="{{$employee->emp_id}}">
                                            {{ $employee->emp_name}}
                                        </option>
                                    @else
                                        <option value="">Select one</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1" style="display: none" id="dept_div_filter">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Department </label>
                                <select id="department_id_filter" name="department_id"
                                        style="width: 100%!important;"
                                        class="form-control select2 department_id">
                                    <option value="">Select one</option>
                                    @foreach($departments as $department)
                                        <option
                                            {{ ( old("department_id", ($data)?$data->department_id:'') == $department->department_id) ? "selected" : ""  }}
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
                    <div class="col-md-3" style="display: none" id="section_div_filter">
                        <div class="row">
                            <div class="col-md-12">
                                <label>SECTION</label>
                                <select id="dpt_section_id_filter" name="section_id"
                                        class="form-control select2 section_id">
                                    <option value="">Select one</option>
                                    @foreach($sections as $section)
                                        <option
                                            {{ ( old("dpt_section_id", ($data)?$data->section_id:'') == $section->dpt_section_id) ? "selected" : ""  }}
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
                    <div class="col-md-3 mb-1">
                        <div class="row">
                            <div class="col-md-12">
                                <label> TICKET TYPE NO</label>
                                <select id="ticket_type_no_filter" name="ticket_type_no" class="form-control select2 ticket_type_no">
                                    <option value="">Select one</option>
                                    @foreach($getTicketTypeNo as $ticketTypeNo)
                                        @if (request()->get('ticket_type_no'))
                                            <option
                                                {{ ( old("ticket_type_no", request()->get('ticket_type_no') == $ticketTypeNo->ticket_type_no)) ? "selected" : ""  }}
                                                value="{{$ticketTypeNo->ticket_type_no}}">{{$ticketTypeNo->ticket_type_name}}
                                            </option>
                                        @else
                                            <option
                                                {{ ( old("ticket_type_no", ($data)?$data->ticket_type_no:'') == $ticketTypeNo->ticket_type_no) ? "selected" : ""  }}
                                                value="{{$ticketTypeNo->ticket_type_no}}">{{$ticketTypeNo->ticket_type_name}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has("ticket_type_no"))
                                    <span class="help-block">{{$errors->first("ticket_type_no")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" id="equip_no_div_filter" style="display: none">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Equipment No</label>
                                <select id="equipment_id_filter" name="equipment_id" class="form-control select2 equipment_no">
                                    <option value="">Select one</option>
                                    @foreach($getEquipmentID as $equipmentID)
                                        <option
                                            {{ ( old("equipment_id", ($data)?$data->equipment_no:'') == $equipmentID->equipment_no) ? "selected" : ""  }}
                                            value="{{$equipmentID->equipment_no}}">
                                            {{$equipmentID->equipment_name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has("equipment_id"))
                                    <span class="help-block">{{$errors->first("equipment_id")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1" id="conf_show_one_filter" style="display: none">
                        <div class="row ">
                            <div class="col-md-12">
                                <label>OCCURANCE FROM DATE</label>
                                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                     id="purchase_date" data-target-input="nearest">
                                    <input type="text" name="occurance_from_date"
                                           autocomplete="off"
                                           value=""
                                           class="form-control berthing_at"
                                           data-target="#purchase_date" id="purchase_date_input"
                                           data-toggle="datetimepicker"
                                           placeholder="Purchase Date">
                                    <div class="input-group-append" data-target="#purchase_date"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="bx bx-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has("purchase_date"))
                                    <span class="help-block">{{$errors->first("purchase_date")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1" id="conf_show_two_filter" style="display: none">
                        <div class="row ">
                            <div class="col-md-12">
                                <label>OCCURANCE TO DATE</label>
                                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                     id="warranty_expiry_date" data-target-input="nearest">
                                    <input type="text" name="occurance_to_date"
                                           autocomplete="off"
                                           value=""
                                           class="form-control berthing_at"
                                           data-target="#warranty_expiry_date"
                                           id="warranty_expiry_date_input"
                                           data-toggle="datetimepicker"
                                           placeholder="Warranty Expiry Date">
                                    <div class="input-group-append" data-target="#warranty_expiry_date"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="bx bx-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has("warranty_expiry_date"))
                                    <span
                                        class="help-block">{{$errors->first("warranty_expiry_date")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1" id="conf_show_four_filter" style="display: none">
                        <div class="row ">
                            <div class="col-md-12">
                                <label>MEETING ROOM NO</label>
                                <input type="number"
                                       id="meeting_room_no_filter"
                                       name="meeting_room_no"
                                       value=""
                                       placeholder="MEETING ROOM NO"
                                       class="form-control"
                                />
                                @if($errors->has("meeting_room_no_filter"))
                                    <span class="help-block">{{$errors->first("meeting_room_no_filter")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
{{--                    CCMS_ADMIN--}}
                        <div class="col-md-3 mb-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>TICKET PRIORITY NO</label>
                                    <select id="ticket_priority_no_filter" name="ticket_priority_no" class="form-control select2 ticket_priority_no">
                                        <option value="">Select one</option>
                                        @foreach($getTicketPriorityNo as $ticketPriorityNo)
                                            <option
                                                {{ ( old("ticket_priority_no", ($data)?$data->ticket_priority_no:'') == $ticketPriorityNo->ticket_priority_no) ? "selected" : ""  }}
                                                value="{{$ticketPriorityNo->ticket_priority_no}}">{{$ticketPriorityNo->remarks}}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has("ticket_priority_no"))
                                        <span class="help-block">{{$errors->first("ticket_priority_no")}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    <div class="col-md-3 mb-1">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Ticket Status</label>
                                <select id="ticket_status_filter" name="status_no" class="form-control select2 status_no">
                                    <option value="">Select one</option>
                                    @foreach($getServiceStatus as $status)
                                        @if (request()->get('service_status_no'))
                                            <option {{ ( old("status_no", request()->get('service_status_no') == $status->status_no)) ? "selected" : ""  }}
                                            value="{{$status->status_no}}">{{$status->status_name}}</option>
                                        @else
                                            <option value="{{$status->status_no}}">{{$status->status_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has("status_no"))
                                    <span class="help-block">{{$errors->first("status_no")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label>IS INTERNAL</label>
                                <div class="d-flex d-inline-block" style="margin-top: 10px">
                                    <div class="custom-control custom-radio mr-1">
                                        <input type="radio" class="custom-control-input " value="Y" name="ticket_internal_external" id="customRadio3"/>
                                        <label class="custom-control-label cursor-pointer" for="customRadio3">YES</label>
                                    </div>&nbsp;&nbsp;
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" value="N" name="ticket_internal_external" id="customRadio4"/>
                                        <label class="custom-control-label cursor-pointer" for="customRadio4">NO</label>
                                    </div>
                                </div>
                                @if($errors->has("ticket_internal_external_yn"))
                                    <span class="help-block">{{$errors->first("ticket_internal_external_yn")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 20px">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" name="search" class="btn btn-sm btn-dark shadow shadow-lg rounded mr-1 mb-1">
                                        <i class="bx bx-search"></i> SEARCH
                                    </button>
                                    <button type="button" class="btn shadow-lg rounded btn-sm text-uppercase reset-btn btn-dark shadow mr-1 mb-1">
                                        <i class="bx bx-reset"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-content">
            @php
                $getKey = json_encode(Auth::user()->roles->pluck('role_key'));
            @endphp
            <div class="card-body card-dashboard">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase" id="service-ticket"
                           data-url="{{ route('service_ticket.list').'?ticket_type_no='.app('request')->input('ticket_type_no').'&'.'service_status_no='.app('request')->input('service_status_no')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                        <thead >
                        <tr class="text-nowrap">
                            <th data-col="DT_RowIndex">SL</th>
                            <th data-col="ticket_id">TICKET ID</th>
                            <th data-col="ticket_type_no" title="TICKET TYPE NO">TICKET TYPE</th>
                            <th data-col="description" title="TICKET DESCRIPTION">DESCRIPTION</th>
                            <th data-col="emp_id" title="EMPLOYEE ID">Employee/Department</th>
                            <th data-col="assigned_to" title="assigned to">Assigned To</th>
                            @if (strpos($getKey, "CCMS_GENERAL_USER") !== FALSE)
                                <th data-col="insert_date" title="Assigned date & Time">Assigned date & Time</th>
                            @else
                                <th data-col="ticket_priority" title="TICKET PRIORITY NO">priority</th>
                            @endif
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

    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-left"></h4>

                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">
                      <i class="fas fa-check"></i> Assign</a> --}}
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action=" @if ($assigndata && $assigndata->assignment_no)
                    {{route('service-ticket-assign.store','id='.\Request::get('id'))}} @else
                    {{route('service-ticket-assign.store','id='.\Request::get('id'))}} @endif">
                        {{ ($assigndata && isset($assigndata->assignment_no))?method_field('PUT'):'' }}
                        {!! csrf_field() !!}
                        @if ($assigndata && $assigndata->assignment_no)
                            <input type="hidden" name="assignment_no" value="{{$assigndata->assignment_no}}">
                        @endif
                        <div class="row pl-1 pr-1">
                            <div
                                class="text-wrap pl-1 pt-1 pb-1 w-100"
                                style="background-color: #CACACA">
                                <p class="modal-desc text-left mb-0"></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required">ASSIGNMENT ID<span
                                                class="required"></span></label>
                                        <input type="text"
                                               readonly
                                               id="assignment_id"
                                               name="assignment_id"
                                               value="{{ old('assignment_id', ($assigndata)?$assigndata->assignment_id:$gen_uniq_id) }}"
                                               placeholder="ASSIGNMENT ID"
                                               class="form-control text-uppercase">
                                        @if($errors->has("assignment_id"))
                                            <span class="help-block">{{$errors->first("assignment_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">Ticket No</label>
                                        <input type="text"
                                               readonly
                                               id="ticket_no"
                                               name="ticket_no"
                                               {{--value="{{ old('ticket_no', ($assigndata)?$assigndata->ticket_no:\Request::get('id')) }}"--}}
                                               class="form-control text-uppercase">
                                        @if($errors->has("ticket_no"))
                                            <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">SERVICE ENGINEER ID</label>
                                        <select id="service_engineer_id" name="service_engineer_id"
                                                class="form-control select2">
                                            <option value="">Select one</option>
                                            @foreach($getServiceEngineerId as $ServiceEngineerId)
                                                <option
                                                    {{ ( old("service_engineer_id", ($assigndata)?$assigndata->service_engineer_id:'') == $ServiceEngineerId->service_engineer_id) ? "selected" : ""  }}
                                                    value="{{$ServiceEngineerId->service_engineer_id}}" data-issue-status="{{isset($ServiceEngineerId->ticket_status)?$ServiceEngineerId->ticket_status:''}}">{{$ServiceEngineerId->service_engineer_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="assignment_date" id="assignment_date">
                                        @if($errors->has("service_engineer_id"))
                                            <span class="help-block">{{$errors->first("service_engineer_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Assigned Issues</label>
                                        <input type="hidden" name="user_name" id="user_name" value=""/>
                                        <input type="text" id="assigned_issue" class="form-control" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Resolved Issues</label>
                                        <input type="text" id="resolved_issue" class="form-control" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-6">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label class="input-required required">ASSIGNMENT DATE</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="assignment_date" data-target-input="nearest">
                                            <input type="text" name="assignment_date"
                                                   value="{{ old('assignment_date',
                                             ($assigndata)?$assigndata->assignment_date:'') }}"
                                                   class="form-control berthing_at"
                                                   data-target="#assignment_date"
                                                   data-toggle="datetimepicker"
                                                   id="assignment_date_input"
                                                   autocomplete="off"
                                                   placeholder="ASSIGNMENT DATE">
                                            <div class="input-group-append"
                                                 data-target="#assignment_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("assignment_date"))
                                            <span class="help-block">{{$errors->first("assignment_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">ASSIGNMENT NOTE </label>
                                        <textarea name="assignment_note" id="assignment_note"
                                                  placeholder="ASSIGNMENT NOTE" cols="30" class="form-control"
                                                  oninput="this.value = this.value.toUpperCase()">{{ old('assignment_note', ($assigndata)?$assigndata->assignment_note:'') }}</textarea>
                                        @if($errors->has("assignment_note"))
                                            <span class="help-block">{{$errors->first("assignment_note")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 10px">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" name="save"
                                                            class="btn btn-dark shadow mr-1 mb-1">SAVE
                                                    </button>
                                                    <button type="reset" class="btn btn-outline-dark mb-1"
                                                            data-dismiss="modal">Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function() {
            //datePicker("#assignment_date");
            @if(request()->get('ticket_type_no'))
                $("#filter").trigger('click');
            @endif
            $('#assignment_date').val(getSysDate());
        });

        $(document).on('click', '.show-modal', function () {
            let data = $(this).data('id');
            let ticket_id = data.split("+")[0];
            let desc = data.split("+")[1];
            $('#ticket_no').val(ticket_id);
            $('#show').modal('show');
            $('.modal-title').text('Service Ticket Assign');
            $('.modal-desc').html(desc);
        });
        $( "table" ).has( "td.dataTables_empty" ).css( "text-align", "center" );
        $("#ticket_type_no_filter").change(function () {
            let ticket_type_no = this.value;
            if (ticket_type_no) {
                $.ajax({
                    type: "GET",
                    url: 'ticket-type-detail',
                    data: {ticket_type_no: ticket_type_no},
                    success: function (data) {
                        if (data.toUpperCase() == 'HARDWARE' || data.toUpperCase() == 'SOFTWARE') {
                            $('#equip_no_div_filter').css("display", "block");
                        } else {
                            $('#equip_no_div_filter').css("display", "none");
                        }

                        if (data.toUpperCase() == 'CONFERENCE') {
                            $('#conf_show_one_filter').css("display", "block");
                            $('#conf_show_two_filter').css("display", "block");
                            $('#conf_show_four_filter').css("display", "block");
                        } else {
                            $('#conf_show_one_filter').css("display", "none");
                            $('#conf_show_two_filter').css("display", "none");
                            $('#conf_show_four_filter').css("display", "none");
                        }
                    },
                    error: function (err) {
                        alert('error');
                    }
                });
            } else {

            }
        });
        $("#ticket_for_id_filter").change(function () {
            let ticket_for_id = this.value;
            if (ticket_for_id == '2') {
                $('#employee_div_filter').css("display", "block");
                $('#dept_div_filter').css("display", "none");
                $('#section_div_filter').css("display", "none");
                $('#department_id_filter').val("").trigger('change');
                $('#dpt_section_id_filter').val("").trigger('change');
            } else if (ticket_for_id == '3') {
                $('#employee_div_filter').css("display", "none");
                $('#dept_div_filter').css("display", "block");
                $('#section_div_filter').css("display", "block");
                $('#st_emp_id_filter').empty();
            } else {
                $('#employee_div_filter').css("display", "none");
                $('#dept_div_filter').css("display", "none");
                $('#section_div_filter').css("display", "none");
                $('#department_id_filter').val("").trigger('change');
                $('#dpt_section_id_filter').val("").trigger('change');
                $('#st_emp_id_filter').empty();
            }
        });


        $("#service_engineer_id").bind().on("change", function () {
            let issue_status = $(this).find(":selected").attr('data-issue-status');
            if(issue_status){
                let parseObj = JSON.parse(issue_status);
                setIssueStatus(parseObj);
            }else{
                $("#assigned_issue").val(0);
                $("#resolved_issue").val(0);
            }
        });


        function setIssueStatus(parseObj) {
            if(parseObj){
                $("#assigned_issue").val(parseObj.total_assigned_issues);
                $("#resolved_issue").val(parseObj.total_resolved_issues);
                $("#user_name").val(parseObj.user_name);
            }
        }

        $(".reset-btn").click(function () {
            $("#datatable_filter_form").trigger("reset");
            $(document).find('#datatable_filter_form select').val('').trigger('change');
            $("#datatable_filter_form").submit();
            $('#equip_no_div_filter').css("display", "none");
            $('#conf_show_one_filter').css("display", "none");
            $('#conf_show_two_filter').css("display", "none");
            $('#conf_show_four_filter').css("display", "none");
        });

        dateRangePicker('#purchase_date', '#warranty_expiry_date');
        //datePicker("#occurance_date_filter");
        function dateRangePicker(Elem1, Elem2) {
            let minElem = $(Elem1);
            let maxElem = $(Elem2);

            minElem.datetimepicker({
                format: 'DD-MM-YYYY',
                ignoreReadonly: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                },
                icons: {
                    time: 'bx bx-time',
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
            maxElem.datetimepicker({
                useCurrent: false,
                format: 'DD-MM-YYYY',
                ignoreReadonly: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                },
                icons: {
                    time: 'bx bx-time',
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
            minElem.on("change.datetimepicker", function (e) {
                maxElem.datetimepicker('minDate', e.date);
            });
            maxElem.on("change.datetimepicker", function (e) {
                minElem.datetimepicker('maxDate', e.date);
            });

            let preDefinedDateMin = minElem.attr('data-predefined-date');
            let preDefinedDateMax = maxElem.attr('data-predefined-date');

            if (preDefinedDateMin) {
                let preDefinedDateMomentFormat = moment(preDefinedDateMin, "YYYY-MM-DD").format("YYYY-MM-DD");
                minElem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
            }

            if (preDefinedDateMax) {
                let preDefinedDateMomentFormat = moment(preDefinedDateMax, "YYYY-MM-DD").format("YYYY-MM-DD");
                maxElem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
            }

        }
    </script>
@endsection
