@extends('layouts.default')

@section('title')
    Equipment List
@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style type="text/css">
        input {
            margin-bottom: 4%;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body" id="equipment_list_form"
                         style="@if(\Request::get('id')) display: block @else display: none @endif">
                        <h4 class="card-title"> {{ isset($data->equipment_no)?'Edit':'Add' }} Equipment Register
                            List </h4>
                        <form method="POST"
                              action="@if ($data && $data->equipment_no) {{route('admin.equipment-list.update',['id' => $data->equipment_no])}} @else {{route('admin.equipment-list.create')}} @endif">
                            {!! csrf_field() !!}
                            @if ($data && $data->equipment_no)
                                {{method_field('PUT')}}
                                <input type="hidden" name="equipment_no" value="{{$data->equipment_no}}">
                            @endif
                            @if(!isset($data->equipment_name))
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="required">Equipment Item</label>
                                        {{--                                    <input type="hidden" name="item_id" value="{{$data->item_id}}">--}}
                                        <select class="form-control select2" name="item_id"
                                                id="item_id" {{isset($data->equipment_name) ? 'disabled' : ''}}>
                                            <option value="">Select One</option>
                                            @if(filled($items))
                                                @foreach($items as $item)
                                                    <option
                                                        {{old('item_id') == $item->item_id ? 'selected' : ''}} value="{{$item->item_id}}">{{$item->item_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div id="inventoryData">
                                @if(old('item_id'))
                                    @include('ccms.admin.manage_equipment.inventory_list',['item_id' => old('item_id')])
                                @endif
                            </div>
                            @if(isset($data->equipment_no))
                                <div id="inventoryDataView">
                                    @include('ccms.admin.manage_equipment.view_data')
                                </div>


                                <div class="row">
                                    <div class="col-md-4 offset-8">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-top: 16%;">
                                                <div class="d-flex justify-content-end col">
                                                    @if (\Request::get('id'))
                                                        <button type="submit" name="save"
                                                                class="btn btn btn-dark shadow mr-1 mb-1"><i
                                                                class="bx bx-edit-alt"></i> Update
                                                        </button>
                                                        <a href="{{ route('admin.equipment-list.index') }}"
                                                           class="btn btn-sm btn-outline-secondary mb-1"
                                                           style="font-weight: 900;">
                                                            <i class="bx bx-arrow-back"></i> Back</a>
                                                    @else
                                                        <button type="submit" name="save"
                                                                class="btn btn btn-dark shadow mr-1 mb-1"><i
                                                                class="bx bx-save"></i> SAVE
                                                        </button>
                                                        <button type="button"
                                                                onclick="$('#equipment_list_form').hide('slow')"
                                                                class="btn btn btn-outline-dark  mb-1">
                                                            <i class="bx bx-window-close"></i> Cancel
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <!--List-->
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Equipment List</h4>
                    <div class="row">
                        <form name="report_form" id="report_form" target="_blank"
                              action="{{route('report', ['title' => 'Equipment'])}}">
                            {{csrf_field()}}
                            {{--<input type="hidden" id = "xdo" name="xdo" value="/~weblogic/CCMS/RPT_EQUIPMENT_LIST.xdo"/>
                            <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_EQUIPMENT_WISE_ASSIGNED_UNASSIGNED_COUNT.xdo"/>--}}
                            <input type="hidden" id="xdo" name="xdo"/>
                            <input type="hidden" name="type" id="type" value="pdf"/>
                            <input type="hidden" name="p_equipment_name" id="p_equipment_name"/>
                            <input type="hidden" name="p_equipment_no" id="p_equipment_no"/>
                            <input type="hidden" name="p_emp_id" id="p_emp_id"/>
                            <input type="hidden" name="p_item_id" id="p_item_id"/>
                            <input type="hidden" name="p_department_id" id="p_department_id"/>
                            <input type="hidden" name="p_vendor_no" id="p_vendor_no"/>
                            <input type="hidden" name="p_equipment_status_id" id="p_equipment_status_id"/>
                            <input type="hidden" name="p_outsider_name" id="p_outsider_name"/>
                            {{--<input type="hidden" name="p_start_date" id="p_start_date"/>
                            <input type="hidden" name="p_end_date" id="p_end_date"/>--}}
                            <input type="hidden" name="p_assign_start_date" id="p_assign_start_date"/>
                            <input type="hidden" name="p_assign_end_date" id="p_assign_end_date"/>
                            <input type="hidden" name="p_person_use_yn" id="p_person_use_yn"/>
                            <input type="hidden" name="p_warranty_expire" id="p_warranty_expire"/>
                            <input type="hidden" name="p_assign_yn" id="p_assign_yn"/>
                            <input type="hidden" name="p_serial_no" id="p_serial_no"/>
                            @section('footer-script')
                                @parent
                                <script>
                                    $(document).ready(function () {

                                        $("#report_pdf_action").on('click', function (e) {
                                            e.preventDefault();
                                            var report_form = $("#report_form");
                                            var filter_form = $("#datatable_filter_form");
                                            report_form.find('#type').val("pdf");
                                            if(filter_form.find('select.equipment_name').val() != '' || filter_form.find('#vendor_no').val() != ''){
                                                report_form.find('#xdo').val('/~weblogic/CCMS/RPT_EQUIPMENT_WISE_ASSIGNED_UNASSIGNED_COUNT.xdo');
                                            }else if(filter_form.find('select.item_id').val() != ''){
                                                report_form.find('#xdo').val('/~weblogic/CCMS/RPT_COMBINE_EQUIPMENT_LIST.xdo');
                                            }else{
                                                report_form.find('#xdo').val('/~weblogic/CCMS/RPT_EQUIPMENT_LIST.xdo');
                                            }
                                            report_form.find('#p_equipment_name').val(filter_form.find('select.equipment_name').val());
                                            report_form.find('#p_emp_id').val(filter_form.find('#emp_id').val());
                                            report_form.find('#p_item_id').val(filter_form.find('#item_id').val());
                                            report_form.find('#p_equipment_status_id').val(filter_form.find('#equipment_status_id').val());
                                            report_form.find('#p_department_id').val(filter_form.find('#department_id_show').val());
                                            report_form.find('#p_vendor_no').val(filter_form.find('#vendor_no').val());
                                            report_form.find('#p_outsider_name').val(filter_form.find('#outsider_name').val());
                                            /*report_form.find('#p_start_date').val(filter_form.find('input.purchase_start_date').val());
                                            report_form.find('#p_end_date').val(filter_form.find('input.purchase_end_date').val());*/
                                            report_form.find('#p_assign_start_date').val(filter_form.find('#assign_start_date_input').val());
                                            report_form.find('#p_assign_end_date').val(filter_form.find('#assign_end_date_input').val());
                                            report_form.find('#p_serial_no').val(filter_form.find('#serial_no').val());

                                            var selected = $("input[type='radio'][name='person_use_yn_filter']:checked");
                                            let filter_data_equipment_id = filter_form.find('select.equipment_id');
                                            let filter_data_vendor_no = filter_form.find('#vendor_no');

                                            if (selected.length > 0) {
                                                report_form.find('#p_person_use_yn').val(selected.val());
                                            }
                                            var selected = $("input[type='radio'][name='warranty_expired_yn']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_warranty_expire').val(selected.val());
                                            }
                                            var selected = $("input[type='radio'][name='equipment_assign']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_assign_yn').val(selected.val());
                                            };
                                            report_form.submit();
                                        });

                                        $("#report_xlsx_action").on('click', function (e) {
                                            e.preventDefault();
                                            var report_form = $("#report_form");
                                            var filter_form = $("#datatable_filter_form");
                                            report_form.find('#type').val("xlsx");
                                            report_form.find('#p_emp_id').val(filter_form.find('select.emp_id').val());
                                            report_form.find('#p_equipment_status_id').val(filter_form.find('select.equipment_status_id').val());
                                            report_form.find('#p_department_id').val(filter_form.find('select.department_id_show').val());
                                            report_form.find('#p_equipment_name').val(filter_form.find('select.equipment_name').val());
                                            report_form.find('#p_vendor_no').val(filter_form.find('select.vendor_no').val());
                                            /*report_form.find('#p_start_date').val(filter_form.find('input.purchase_start_date').val());
                                            report_form.find('#p_end_date').val(filter_form.find('input.purchase_end_date').val());*/
                                            report_form.find('#p_assign_start_date').val(filter_form.find('input.assign_start_date_input').val());
                                            report_form.find('#p_assign_end_date').val(filter_form.find('input.assign_end_date_input').val());
                                            report_form.find('#p_serial_no').val(filter_form.find('#serial_no').val());

                                            var selected = $("input[type='radio'][name='person_use_yn_filter']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_person_use_yn').val(selected.val());
                                            }

                                            var selected = $("input[type='radio'][name='warranty_expired_yn']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_warranty_expire').val(selected.val());
                                            }
                                            var selected = $("input[type='radio'][name='equipment_assign']:checked");
                                            if (selected.length > 0) {
                                                report_form.find('#p_assign_yn').val(selected.val());
                                            }
                                            report_form.submit();
                                        });
                                    });
                                </script>
                            @endsection
                        </form>
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal"
                                   data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i> Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" id="report_pdf_action"
                                       href="javascript:void(0)">
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                       id="report_xlsx_action" href="javascript:void(0)">
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <button onclick="$('#datatable_filter_form').toggle('slow')" class="btn btn-secondary mb-1">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        <button id="show_form" onclick="$('#equipment_list_form').toggle('slow')"
                                class="btn btn-secondary mb-1 ml-1"><i class="bx bx-plus"></i> Add New
                        </button>
                    </div>
                </div>
                <div class="bg-rgba-secondary ml-1 mr-1" style="border-radius: 5px">
                    <form style="display: none;padding-top: 2rem" id="datatable_filter_form" method="POST">
                        <div class="row ml-1 mr-1">
                            <div class="col-md-3">
                                <label>Equipment</label>
                                <div class="d-flex d-inline-block" style="margin-top: 10px">
                                    <div class="custom-control custom-radio equipment">
                                        <input type="radio" class="custom-control-input"
                                               name="equipment" value="{{ old('equipment','Y') }}"
                                               id="radio_equipment1" checked>
                                        <label class="custom-control-label cursor-pointer"
                                               for="radio_equipment1">Combine</label>
                                    </div>&nbsp;&nbsp;
                                    <div class="custom-control custom-radio ml-1 equipment">
                                        <input type="radio" class="custom-control-input equipment"
                                               name="equipment" value="{{ old('equipment','N') }}"
                                               id="radio_equipment2">
                                        <label class="custom-control-label cursor-pointer" for="radio_equipment2">Individual</label>
                                    </div>
                                </div>
                                @if($errors->has("equipment"))
                                    <span class="help-block">{{$errors->first("equipment")}}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label>Assigned</label>
                                <div class="d-flex d-inline-block" style="margin-top: 10px">
                                    <div class="custom-control custom-radio equipment_assign">
                                        <input type="radio" class="custom-control-input"
                                               value="{{ old('equipment_assign','Y') }}"
                                               name="equipment_assign"
                                               id="customRadio3">
                                        <label class="custom-control-label cursor-pointer"
                                               for="customRadio3">YES</label>
                                    </div>&nbsp;&nbsp;
                                    <div class="custom-control custom-radio ml-1 equipment_assign">
                                        <input type="radio" class="custom-control-input equipment_assign"
                                               value="{{ old('equipment_assign','N') }}"
                                               name="equipment_assign"
                                               id="customRadio4">
                                        <label class="custom-control-label cursor-pointer" for="customRadio4">NO</label>
                                    </div>
                                </div>
                                @if($errors->has("equipment_assign"))
                                    <span class="help-block">{{$errors->first("equipment_assign")}}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label>PERSON WISE USE</label>
                                <div class="d-flex d-inline-block" style="margin-top: 10px">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input person_use_yn"
                                               onclick="javascript:enableDisableOne();"
                                               value="{{ old('person_use_yn','Y') }}"
                                               name="person_use_yn_filter"
                                               id="customRadio1">
                                        <label class="custom-control-label cursor-pointer"
                                               for="customRadio1">YES</label>
                                    </div>&nbsp;&nbsp;
                                    <div class="custom-control custom-radio ml-1">
                                        <input type="radio" class="custom-control-input"
                                               onclick="javascript:enableDisableTwo();"
                                               value="{{ old('person_wise_use_yn','N') }}"
                                               name="person_use_yn_filter"
                                               id="customRadio2">
                                        <label class="custom-control-label cursor-pointer" for="customRadio2">NO</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-1">
                                        <input type="radio" class="custom-control-input"
                                               onclick="javascript:enableDisableThree();"
                                               value="{{ old('person_wise_use_yn','O') }}"
                                               name="person_use_yn_filter"
                                               id="customRadio99">
                                        <label class="custom-control-label cursor-pointer" for="customRadio99">Outsider</label>
                                    </div>
                                </div>
                                <input type="hidden" id="equipment_no" name="equipment_no"
                                       value="{{\Request::get('id')}}">
                                @if($errors->has("person_wise_use_yn"))
                                    <span class="help-block">{{$errors->first("person_wise_use_yn")}}</span>
                                @endif
                            </div>
                            <div class="col-md-3" style="display: block" id="employee_div">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select class="custom-select select2 emp_id" name="assign_emp_id" id="emp_id"
                                            style="width: 100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="display: none" id="outsider_div">
                                <div class="form-group">
                                    <label>Outsider</label>
                                    <input type="text" class="form-control" name="outsider_name" autocomplete="off" id="outsider_name" placeholder="Outsider Name"/>
                                </div>
                            </div>
                            <div class="col-md-3 mb-1" style="display: none" id="dept_div">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Department </label>
                                        <select id="department_id_show" name="department_id_show"
                                                style="width: 100%!important;"
                                                class="form-control select2 department_id">
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
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>VENDOR</label>
                                        <select name="vendor_no" id="vendor_no" class="form-control select2 vendor_no">
                                            <option value="">Select one</option>
                                            @foreach($vendorTypes as $vendorList)
                                                <option
                                                    value="{{$vendorList->vendor_id}}">{{$vendorList->vendor_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("vendor_no"))
                                            <span class="help-block">{{$errors->first("vendor_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Warranty Expired</label>
                                <div class="d-flex d-inline-block" style="margin-top: 10px">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input"
                                               value="{{ old('warranty_expired_yn','Y') }}"
                                               name="warranty_expired_yn"
                                               id="customRadio5">
                                        <label class="custom-control-label cursor-pointer"
                                               for="customRadio5">YES</label>
                                    </div>&nbsp;&nbsp;
                                    <div class="custom-control custom-radio ml-1">
                                        <input type="radio" class="custom-control-input warranty_expired_yn"
                                               value="{{ old('warranty_expired_yn','N') }}"
                                               name="warranty_expired_yn"
                                               id="customRadio6">
                                        <label class="custom-control-label cursor-pointer" for="customRadio6">NO</label>
                                    </div>
                                </div>
                                @if($errors->has("warranty_expired_yn"))
                                    <span class="help-block">{{$errors->first("warranty_expired_yn")}}</span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Equipment Status</label>
                                        <select name="equipment_status_id" id="equipment_status_id"
                                                class="form-control select2 equipment_status_id">
                                            <option value="">Select one</option>
                                            @foreach($getEquipmentStatus as $value)
                                                <option
                                                    value="{{$value->equipment_status_id}}">{{$value->status_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("equipment_status_id"))
                                            <span class="help-block">{{$errors->first("equipment_status_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Assign From Date</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="assign_start_date" data-target-input="nearest">
                                            <input type="text" name="assign_start_date"
                                                   value=""
                                                   class="form-control assign_start_date"
                                                   data-target="#assign_start_date" id="assign_start_date_input"
                                                   data-toggle="datetimepicker" autocomplete="off"
                                                   placeholder="Assign From Date"
                                            />
                                            <div class="input-group-append" data-target="#assign_start_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("assign_start_date"))
                                            <span class="help-block">{{$errors->first("assign_start_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row ml-1 mr-1">
                            {{--<div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Purchase From Date</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="purchase_start_date" data-target-input="nearest">
                                            <input type="text" name="purchase_start_date"
                                                   value=""
                                                   class="form-control purchase_start_date"
                                                   data-target="#purchase_start_date" id="purchase_start_date_input"
                                                   data-toggle="datetimepicker" autocomplete="off"
                                                   placeholder="Purchase Start Date"
                                            />
                                            <div class="input-group-append" data-target="#purchase_start_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("purchase_start_date"))
                                            <span class="help-block">{{$errors->first("purchase_start_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>Purchase To Date</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="purchase_end_date" data-target-input="nearest">
                                            <input type="text" name="purchase_end_date"
                                                   value=""
                                                   class="form-control purchase_end_date"
                                                   data-target="#purchase_end_date" id="purchase_end_date_input"
                                                   data-toggle="datetimepicker" autocomplete="off"
                                                   placeholder="Purchase End Date"
                                            />
                                            <div class="input-group-append" data-target="#purchase_end_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("purchase_end_date"))
                                            <span class="help-block">{{$errors->first("purchase_end_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>--}}
                            <div class="col-md-3">
                                <div class="row ">
                                    <div class="col-md-12" style="margin-top: 10px">
                                        <label>Assign To Date</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="assign_end_date" data-target-input="nearest">
                                            <input type="text" name="assign_end_date"
                                                   value=""
                                                   class="form-control assign_end_date"
                                                   data-target="#assign_end_date" id="assign_end_date_input"
                                                   data-toggle="datetimepicker" autocomplete="off"
                                                   placeholder="Assign To Date"
                                            />
                                            <div class="input-group-append" data-target="#assign_end_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("assign_end_date"))
                                            <span class="help-block">{{$errors->first("assign_end_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Equipment Serial No</label>
                                        <select name="serial_no" id="serial_no"
                                                class="form-control select2 serial_no">
                                            <option value="">Select one</option>
                                            @foreach($allEquipmentList as $value)
                                                <option value="{{$value->serial_no}}">{{$value->serial_no}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("serial_no"))
                                            <span class="help-block">{{$errors->first("serial_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1" id="equipment_combine">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Equipment Name</label>
                                        <select name="item_id" id="item_id"
                                                class="form-control select2 item_id">
                                            <option value="">Select one</option>
                                            @foreach($equipmentListWithoutVariants as $value)
                                                <option value="{{$value->item_id}}">{{$value->item_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("item_id"))
                                            <span class="help-block">{{$errors->first("item_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1" style="display: none" id="equipment_individual">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Equipment Name</label>
                                        <select name="equipment_name" id="equipment_name"
                                                class="form-control select2 equipment_name">
                                            <option value="">Select one</option>
                                            @foreach($equipmentList as $value)
                                                <option value="{{$value->equipment_name}}">{{$value->equipment_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("equipment_name"))
                                            <span class="help-block">{{$errors->first("equipment_name")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mt-1 mb-2">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px; padding-right: 0px">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="search"
                                                    class="btn btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bx-search"></i> SEARCH
                                            </button>
                                            <button type="button" class="btn btn btn-dark shadow reset-btn mr-1 mb-1">
                                                <i class="bx bx-reset"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="row ml-1 mr-1">--}}
{{--                            --}}
{{--                        </div>--}}

                        {{--<div class="row" style="margin-right: 0px">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bx-search"></i> SEARCH
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </form>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable" id="equipment_table"
                                   data-url="{{ route('admin.equipment-list-datatable.data', isset($data->id)?$data->id:0 )}}"
                                   data-csrf="{{ csrf_token() }}" data-page="10">
                                <thead class="text-nowrap">
                                <tr>
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="equipment_name">Equipment Name</th>
                                    <th data-col="equipment_id">equipment id</th>
{{--                                    <th data-col="item_id">Item id</th>--}}
                                    <th data-col="assign_to">assign To</th>
                                    {{--<th data-col="manufacturer">manufacturer</th>--}}
                                    <th data-col="vendor_name">vendor</th>
                                    {{--<th data-col="model_no">Model No</th>--}}
                                    <th data-col="equipment_status">equipment status</th>
                                    <th data-col="purchase_date">Purchase Date</th>
                                    <th data-col="warranty_expiry_date">Warranty Expiry Date</th>
                                    <th data-col="eqip_assign_date">Assign Date</th>
                                    <th data-col="inventory_sl_no">SL NO</th>
                                    <th data-col="serial_no">SERIAL NO/PART NO</th>
                                    <th data-col="action">Actions</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <input type="hidden" id="equipment_no" name="equipment_no">
                            <input type="hidden" id="inventory_details_id" name="inventory_details_id">
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
                                                   class="form-control text-uppercase">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>PERSON WISE USE</label>
                                    <div class="d-flex d-inline-block" style="margin-top: 10px">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                   onclick="javascript:enableDisableOne1();"
                                                   value="Y" name="person_wise_use_yn"
                                                   id="customRadio33" checked>
                                            <label class="custom-control-label cursor-pointer"
                                                   for="customRadio33">Person</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="custom-control custom-radio ml-1">
                                            <input type="radio" class="custom-control-input"
                                                   onclick="javascript:enableDisableTwo2();"
                                                   value="N" name="person_wise_use_yn"
                                                   id="customRadio44">
                                            <label class="custom-control-label cursor-pointer"
                                                   for="customRadio44">Dept</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-1">
                                            <input type="radio" class="custom-control-input"
                                                   onclick="javascript:enableDisableTwo3();"
                                                   value="O" name="person_wise_use_yn"
                                                   id="customRadio55">
                                            <label class="custom-control-label cursor-pointer"
                                                   for="customRadio55">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Emp Code</label>
                                        <select class="custom-select select2" name="emp_id" id="pop_emp_id"
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
                                                        @if(isset($departments))
                                                            @foreach($departments as $department)
                                                                <option
                                                                    value="{{$department->department_id}}">{{$department->department_name}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if($errors->has("department_id"))
                                                        <span
                                                            class="help-block">{{$errors->first("department_id")}}</span>
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
                                                        @if(isset($sections))
                                                            @foreach($sections as $section)
                                                                <option
                                                                    value="{{$section->dpt_section_id}}">{{$section->dpt_section}}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @if($errors->has("dpt_section_id"))
                                                        <span
                                                            class="help-block">{{$errors->first("dpt_section_id")}}</span>
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
                                                @if(isset($locationList))
                                                    @foreach($locationList as $location)
                                                        <option style="width: 100px!important;"
                                                                value="{{$location->location_id}}">{{$location->working_location}}</option>
                                                    @endforeach
                                                @endif
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
                                <div class="col-md-12">
                                    <hr>
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" name="save"
                                                        class="btn btn btn-dark shadow mr-1 mb-1">
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

    @endsection


    @section('footer-script')
        <!--Load custom script-->
            <script>
                selectCpaEmployees('#pop_emp_id', APP_URL + '/admin/employees', APP_URL + '/admin/employee/', populateRelatedFields);
                $('#equipment_table tbody').on('click', '.editButton', function () {
                    let data_row = $('#equipment_table').DataTable().row( $(this).parents('tr') ).data();
                    console.log(data_row);
                    let myModal = $('#show');

                    /*$('#item_name', myModal).val(data_row.item);
                    $('#model_no', myModal).val(data_row.item);
                    $('#manufacturer', myModal).val(data_row.brand_name);
                    $('#brand_id', myModal).val(data_row.brand_id);
                    $('#variants', myModal).val(data_row.variants);
                    $('#item_id', myModal).val(data_row.item_id);
                    $('#equipment_name', myModal).val($(data_row.equipment_name).text());
                    $('#equipment_id', myModal).val(data_row.equipment_id);
                    $('#quantity', myModal).val(data_row.approve_mf_qty);
                    $('#equipment_description', myModal).val(data_row.description);
                    $('#req_mst_id', myModal).val(data_row.requisition_mst_no);
                    $('#req_dtl_id', myModal).val(data_row.requisition_dtl_no);*/
                     $('#equipment_no', myModal).val(data_row.equipment_no);
                     $('#inventory_sl_no', myModal).val(data_row.inventory_sl_no);
                     $('#inventory_details_id', myModal).val(data_row.inventory_details_id);
                     $('#sl_no', myModal).val(data_row.serial_no);

                    $('#department_id').val("").trigger("change");
                    $('#dpt_section_id').val("").trigger("change");
                    $('#pop_emp_id').empty();
                    $('#emp_department').val('');
                    $('#emp_desig').val('');
                    $('#emp_section').val('');
                    $('#emp_name_outside').val('');
                    $('#emp_desig_outside').val('');
                    $('#emp_dept_outside').val('');
                    $('#emp_section_outside').val('');

                    myModal.modal({show: true});
                    return false;
                });

                function enableDisableOne() {
                    if (document.getElementById('customRadio1').checked) {
                        $('#employee_div').css("display", "block");
                        $('#dept_div').css("display", "none");
                        $('#department_id_show').val("").trigger('change');
                        $('#outsider_div').css("display", "none");
                        $('#outsider_name').val("");
                    }
                }

                function enableDisableTwo() {
                    if (document.getElementById('customRadio2').checked) {
                        $('#emp_id').empty();
                        $('#outsider_name').val("");
                        $('#dept_div').css("display", "block");
                        $('#employee_div').css("display", "none");
                        $('#outsider_div').css("display", "none");
                    }
                }

                function enableDisableThree() {
                    if (document.getElementById('customRadio99').checked) {
                        $('#emp_id').empty();
                        $('#outsider_name').val("");
                        $('#department_id_show').val("").trigger('change');
                        $('#dept_div').css("display", "none");
                        $('#employee_div').css("display", "none");
                        $('#outsider_div').css("display", "block");
                    }
                }

                function enableDisableOne1() {
                    if (document.getElementById('customRadio33').checked) {
                        $("#pop_emp_id").prop("disabled", false);
                        $("#department_id").prop("disabled", true);
                        $('#department_id').val("").trigger("change");
                        $('#dpt_section_id').val("").trigger("change");
                        $('#emp_name_outside').val('');
                        $('#emp_desig_outside').val('');
                        $('#emp_dept_outside').val('');
                        $('#emp_section_outside').val('');
                        $('#show_info').css("display", "block");
                        $('#show_info_dept').css("display", "none");
                        $('#show_info_outsider').css("display", "none");

                    }
                }

                function enableDisableTwo2() {
                    if (document.getElementById('customRadio44').checked) {
                        $("#pop_emp_id").prop("disabled", true);
                        $("#department_id").prop("disabled", false);
                        $('#pop_emp_id').empty();
                        $('#emp_department').val('');
                        $('#emp_desig').val('');
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
                        $('#pop_emp_id').empty();
                        $('#emp_department').val('');
                        $('#emp_desig').val('');
                        $('#emp_section').val('');
                        $("#pop_emp_id").prop("disabled", true);
                        $('#show_info_outsider').css("display", "block");
                        $('#show_info').css("display", "none");
                        $('#show_info_dept').css("display", "none");
                    }
                }


                $(document).ready(function () {
                    $('#show_info').css("display", "block");
                    $('#show_info_dept').css("display", "none");
                    $(document).on("click", '.confirm-delete', function (e) {
                        let equipment_no = $(this).attr('href');
                        e.preventDefault();
                        swal({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            type: "warning",
                            showCancelButton: !0,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#dd3333",
                            confirmButtonText: "Yes, delete it!",
                            confirmButtonClass: "btn btn-primary",
                            cancelButtonClass: "btn btn-danger ml-1",
                            buttonsStyling: !1
                        }).then(function (e) {
                            if (e.value === true) {
                                $.ajax({
                                    type: 'GET',
                                    url: 'equipment-remove',
                                    data: {equipment_no: equipment_no},
                                    success: function (results) {
                                        let fields = results.split('+');
                                        let status_code = fields[0];
                                        let status_msg = fields[1];

                                        if (status_code == "1") {
                                            Swal.fire({
                                                title: status_msg,
                                                confirmButtonText: 'OK',
                                                type: 'success'
                                            }).then(function () {
                                                $('#equipment_table').DataTable().ajax.reload();
                                            });
                                        } else {
                                            swal("Error!", status_msg, "error");
                                        }
                                    }
                                });

                            } else {
                                e.dismiss;
                            }

                        }, function (dismiss) {
                            return false;
                        })
                    });
                    $(".reset-btn").click(function () {
                        $("#datatable_filter_form").trigger("reset");
                        $("#p_emp_id").val('');
                        $("#p_department_id").val('');
                        $("#p_vendor_no").val('');
                        $("#p_equipment_status_id").val('');
                        $("#p_assign_start_date").val('');
                        $("#p_assign_end_date").val('');
                        $("#p_person_use_yn").val('');
                        $("#p_warranty_expire").val('');
                        $("#p_assign_yn").val('');
                        $(document).find('#datatable_filter_form select').val('').trigger('change');
                        $("#datatable_filter_form").submit();
                    });


                    //Date time picker
                    function dateTimePicker(selector) {
                        var elem = $(selector);
                        elem.datetimepicker({
                            format: 'DD-MM-YYYY',
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

                        let preDefinedDate = elem.attr('data-predefined-date');

                        if (preDefinedDate) {
                            let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD");
                            elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                        }
                    }

                    //dateTimePicker("#occurance_date");
                    maxDateOff("#purchase_date");
                    dateTimePicker("#warranty_expiry_date");
                    dateTimePicker("#last_maintenance_date");
                    dateTimePicker("#purchase_end_date");
                    dateTimePicker("#purchase_start_date");
                    dateTimePicker("#assign_start_date");
                    dateTimePicker("#assign_end_date");

                    dateRangePicker('#purchase_date', '#warranty_expiry_date');

                    //$('#purchase_date_input').val(getSysDate());
                    //$('#warranty_expiry_date_input').val(getSysDate());
                    //$('#last_maintenance_date_input').val(getSysDate());
                    //$('#purchase_start_date_input').val(getSysDate());
                    //$('#purchase_end_date_input').val(getSysDate());
                    selectCpaEmployees('#emp_id', APP_URL + '/admin/employees', APP_URL + '/admin/employee/', populateRelatedFields);

                });

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

                function populateRelatedFields(that, data) {
                    $(that).parent().parent().parent().find('#emp_department').val(data.department);
                    $(that).parent().parent().parent().find('#emp_desig').val(data.designation);
                    $(that).parent().parent().parent().find('#emp_section').val(data.section);
                    $(that).parent().parent().parent().find('#emp_department_id').val(data.department_id);
                    $(that).parent().parent().parent().find('#emp_section_id').val(data.dpt_section_id);
                }

                // Initialize Select2
                // Set option selected onchange
                $('#catagory_no').change(function () {
                    var catId = $(this).val();
                    var select = $('#sub_catagory_no');
                    select.find('option').remove();

                    select.removeAttr('disabled');

                    $.get('/setup/ajax/sub-categories-data/' + catId, function (data) {
                        data.forEach(function (item, i) {
                            let op = '<option value=' + item.sub_catagory_no + '>' + item.sub_catagory_name + '</option>';
                            select.append(op);
                        });
                    });
                    //$('#sub_catagory_no').select2();
                });

                function getBase64(file) {
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        $(document).find('#invoice').val(reader.result);
                        console.log(reader.result);
                    };
                    reader.onerror = function (error) {
                        console.log('Error: ', error);
                    };
                }

                $("#file").on('change', function () {
                    var file = document.querySelector('#file').files[0];
                    getBase64(file); // prints the base64 string
                });

                // function resetForm() {
                //     document.getElementById("datatable_filter_form").reset();
                // }
                $(document).on('change', '#item_id', function (e) {
                    let item_id = $(this).val();
                    $('#warranty_yn').attr('checked', false)
                    inventoryData(item_id);
                })
                $(document).on('click', '.view-inventory', function (e) {
                    e.preventDefault();
                    let url = $(this).attr('href');
                    $(document).find('.view-inventory i').addClass("bx-plus-circle").removeClass('bx-check');
                    $(this).find('i').removeClass("bx-plus-circle").addClass('bx-check');
                    inventoryViewData(url);
                })

                $('input:radio[name="equipment"]').change(function(){
                    if($(this).val() == 'Y'){
                        $("#serial_no").val('').trigger('change')
                        $('#equipment_combine').show('slow');
                        $('#equipment_individual').hide('slow');
                    }else {
                        $("#serial_no").val('').trigger('change')
                        $('#equipment_combine').hide('slow');
                        $('#equipment_individual').show('slow');
                    }
                });

                function inventoryData(item_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{route('equipment-inventory')}}?item_id=" + item_id,
                        cache: false,
                        success: function (data) {
                            if (data.status) {
                                $('#inventoryData').html(data.html);
                            } else {
                                $.notify(data.message, 'error');
                            }

                        }
                    });
                }

                function inventoryViewData(url) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        cache: false,
                        success: function (data) {
                            if (data.status) {
                                // $('#inventoryDataView').html(data.html);
                                $.notify(data.message, 'success');
                                // window.location.reload();
                                /*setTimeout(function () {
                                    location.reload();
                                }, 5000);*/

                                $('.datatable').DataTable().ajax.reload();
                                inventoryData($('#item_id').val());

                            } else {
                                $.notify(data.message, 'error');
                            }
                        }
                    });
                }
            </script>
@endsection

