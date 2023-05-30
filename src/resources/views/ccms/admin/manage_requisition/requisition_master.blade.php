@extends('layouts.default')

@section('title')
    Requisition Master
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
        @include('ccms/admin/manage_requisition/requisition_master_form')

            <!--List-->
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Equipment Requisition List</h4>
                    <div class="row">
                        <form name="report_form" id="report_form" target="_blank" action="{{route('report', ['title' => 'Requisitions'])}}">
                            {{csrf_field()}}
                            <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_REQUISITION_LIST.xdo" />
                            <input type="hidden" name="type" id="type" value="pdf" />
                            <input type="hidden" name="p_requisition_for" id="p_requisition_for" />
                            <input type="hidden" name="p_start_date" id="p_start_date" />
                            <input type="hidden" name="p_end_date" id="p_end_date" />
                            <input type="hidden" name="p_requisition_status_id" id="p_requisition_status_id" />
                            <input type="hidden" name="p_equipment_no" id="p_equipment_no" />
                            @section('footer-script')
                                @parent
                                <script>
                                    $(document).ready(function() {

                                        $("#report_pdf_action").on('click',function() {

                                            var report_form = $("#report_form");
                                            var filter_form = $("#datatable_filter_form");
                                            report_form.find('#type').val("pdf");
                                            report_form.find('#p_emp_id').val(filter_form.find('select.emp_id').val());
                                            report_form.find('#p_start_date').val(filter_form.find('input.requisition_start_date').val());
                                            report_form.find('#p_end_date').val(filter_form.find('input.requisition_end_date').val());
                                            report_form.find('#p_requisition_status_id').val(filter_form.find('select.requisition_status_id').val());
                                            report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());


                                            report_form.submit();
                                        });

                                        $("#report_xlsx_action").on('click',function() {
                                            var report_form = $("#report_form");
                                            var filter_form = $("#datatable_filter_form");
                                            report_form.find('#type').val("xlsx");
                                            report_form.find('#p_emp_id',).val(filter_form.find('select.emp_id').val());
                                            report_form.find('#p_start_date',).val(filter_form.find('input.requisition_start_date').val());
                                            report_form.find('#p_end_date',).val(filter_form.find('input.requisition_end_date').val());
                                            report_form.find('#p_requisition_status_id').val(filter_form.find('select.requisition_status_id').val());
                                            report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());

                                            report_form.submit();
                                        });
                                    });
                                </script>
                            @endsection
                        </form>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i> Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" id="report_pdf_action" href="javascript:void(0)" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" id="report_xlsx_action"  href="javascript:void(0)" >
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <button onclick="$('#datatable_filter_form').toggle('slow')" class="btn btn-secondary mb-1 hvr-underline-reveal">
                        <i class="bx bx-filter-alt"></i> Filter</button>
                        {{--<button id="show_form" onclick="$('#equip_req_form').toggle('slow')" class="btn btn-secondary mb-1 ml-1 hvr-underline-reveal">
                        <i class="bx bx-plus"></i> Add New</button>--}}
                    </div>
                </div>
                <div class="bg-rgba-secondary mr-2 ml-2" style="border-radius: 5px">
                    <form style="display: none;padding: 1rem 0" id="datatable_filter_form" method="POST">
                        <div class="row ml-1" style="margin-right: 10px">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Equipment No</label>
                                        <select id="equipment_id_filter" name="equipment_no" class="form-control select2 equipment_no">
                                            <option value="">Select one</option>
                                            @foreach($getEquipmentID as $equipmentID)
                                                <option value="{{$equipmentID->equipment_no}}">{{$equipmentID->equipment_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("equipment_id"))
                                            <span class="help-block">{{$errors->first("equipment_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        {{--@include('ccms/common/requisition_select_box',
                                            [
                                                'select_name' => 'requisition_for',
                                                'label_name' => 'Requisition For',
                                                'required' => false
                                                ]
                                         )--}}
                                        <label>Requisition For</label>
                                        <select name="requisition_for_filter" class="form-control emp_id" style="width: 100%">
                                            <option value="" >Select one </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Requisition Start Date</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="requisition_start_date" data-target-input="nearest">
                                            <input type="text" name="requisition_date"
                                                   value=""
                                                   class="form-control requisition_start_date"
                                                   data-target="#requisition_start_date" id="requisition_start_date_input"
                                                   data-toggle="datetimepicker" autocomplete="off"
                                                   placeholder="Requisition Start Date">
                                            <div class="input-group-append" data-target="#requisition_start_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("requisition_start_date"))
                                            <span class="help-block">{{$errors->first("requisition_start_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Requisition End Date</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="requisition_end_date" data-target-input="nearest">
                                            <input type="text" name="requisition_end_date"
                                                   value=""
                                                   class="form-control requisition_end_date"
                                                   data-target="#requisition_end_date" id="requisition_end_date_input"
                                                   data-toggle="datetimepicker" autocomplete="off"
                                                   placeholder="Requisition End Date">
                                            <div class="input-group-append" data-target="#requisition_end_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("requisition_end_date"))
                                            <span class="help-block">{{$errors->first("requisition_end_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Approve</label>
                                        <div class="d-flex d-inline-block" style="margin-top: 10px">
                                            <div class="custom-control custom-radio mr-1">
                                                <input type="radio" class="custom-control-input " value="Y" name="app_yn" id="customRadio3"/>
                                                <label class="custom-control-label cursor-pointer" for="customRadio3">YES</label>
                                            </div>&nbsp;&nbsp;
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" value="N" name="app_yn" id="customRadio4"/>
                                                <label class="custom-control-label cursor-pointer" for="customRadio4">NO</label>
                                            </div>
                                        </div>
                                        @if($errors->has("app_yn"))
                                            <span class="help-block">{{$errors->first("app_yn")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Requisition Status</label>
                                        <select id="req_status" name="req_status" class="form-control select2 requisition_status_id">
                                            <option value="">Select one</option>
                                            @foreach($requisitionStatus as $status)
                                                <option value="{{$status->requisition_status_id}}"
                                                        @if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                                            @if($status->requisition_status_id=='2')
                                                                selected
                                                            @endif
                                                        @elseif(auth()->user()->hasRole('CCMS_MEMBER_FINANCE'))
                                                            @if($status->requisition_status_id=='3')
                                                                selected
                                                            @endif
                                                        @endif
                                                >{{$status->status_name}}</option>

                                                {{--<option value="{{$status->requisition_status_id}}">{{$status->status_name}}</option>--}}
                                            @endforeach
                                        </select>
                                        @if($errors->has("req_status"))
                                            <span class="help-block">{{$errors->first("req_status")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Status</label>
                                        <select name="status" class="form-control select2" style="width: 100%">
                                            <option value="all">All</option>
                                            <option value="pending" selected>Pending</option>
                                            <option value="4" >Approved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bx-search"></i> SEARCH
                                            </button>
                                            <button type="button" class="btn btn text-uppercase  reset-btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bx-reset"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-1">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <button type="submit" name="search" class="btn btn btn-dark shadow mr-0 mb-1">
                                            <i class="bx bx-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>--}}

                        </div>
                    </form>
                </div>

                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable" id="req_datatable"
                                   data-url="{{ route('admin.requisition-master-datatable.data')}}"
                                   data-csrf="{{csrf_token() }}" data-page="10">
                                <thead class="text-nowrap">
                                <tr>
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="requisition_id">REQUISITION ID</th>
                                    {{--<th data-col="ticket_no">TICKET NO</th>--}}
                                    <th data-col="equipment_no">EQUIPMENT</th>
                                    <th data-col="requisition_for">REQUISITION FOR</th>
                                    {{--<th data-col="requisition_note">REQUISITION NOTE</th>--}}
                                    <th data-col="requisition_date">REQUISITION DATE</th>
                                    <th data-col="requistion_by">REQUISITION BY</th>
                                    <th data-col="approved_yn" title="APPROVED YN">APPROVED?</th>
                                    <th data-col="requisition_status_id" title="REQUISITION STATUS ID">Requisition Status</th>
                                    {{--<th data-col="approved_by">APPROVED BY</th>
                                    <th data-col="approved_date">APPROVED DATE</th>
                                    <th data-col="ticket_yn" >TICKET Status</th>--}}
                                    <th data-col="action">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





