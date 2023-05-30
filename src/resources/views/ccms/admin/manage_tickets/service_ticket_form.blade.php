<div class="row mb-1">
    <div class="col-md-3 mb-1">
        <div class="row">
            <div class="col-md-12">
                <label>Ticket ID</label>
                <input type="text"
                       readonly
                       id="ticket_id"
                       name="ticket_id"
                       value="{{ old('ticket_id', ($data)?$data->ticket_id:$gen_uniq_id) }}"
                       placeholder="Ticket ID"
                       class="form-control text-uppercase"
                />
                @if($errors->has("ticket_id"))
                    <span class="help-block">{{$errors->first("ticket_id")}}</span>
                @endif
            </div>
        </div>
    </div>
{{--    {{(auth()->user()->hasRole('CCMS_ADMIN')==true)?'disabled':''}}--}}
    <div class="col-md-3 mb-1">
        <div class="row">
            <div class="col-md-12">
                <label class="input-required required"> TICKET FOR</label>
                <select id="ticket_for_id" name="ticket_for" class="form-control select2" {{(auth()->user()->hasRole('CCMS_ADMIN') && $data )?'disabled':''}} >
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
    {{--@if($myTicket=='N')
        <div class="col-md-3" style="display: block" id="employee_div">
            <div class="form-group">
                <label>Employee</label>
                <select class="custom-select select2 emp_id" name="emp_id" id="emp_id"
                        style="width: 100%">

                </select>
            </div>
        </div>
    @endif--}}
    @include('ccms/common/employee_select_box',
            [
                'select_name' => 'emp_id',
                'label_name' => 'Employee',
                'required' => true
            ]
        )
    <div class="col-md-3 mb-1" style="@if(!empty($data->department_id)) display: block @else display: none @endif"
         id="dept_div">
        <div class="row">
            <div class="col-md-12">
                <label>Department </label>
                <select id="department_id" name="department_id"
                        style="width: 100%!important;"
                        class="form-control select2 department_id" {{(auth()->user()->hasRole('CCMS_ADMIN') && $data )?'disabled':''}} >
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
    <div class="col-md-3" style="@if(!empty($data->section_id)) display: block @else display: none @endif"
         id="section_div">
        <div class="row">
            <div class="col-md-12">
                <label>SECTION</label>
                <select id="dpt_section_id" name="section_id"
                        class="form-control select2" {{(auth()->user()->hasRole('CCMS_ADMIN') && $data )?'disabled':''}} >
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
                <label class="input-required required"> TICKET TYPE</label>
                <select id="ticket_type_no" name="ticket_type_no" class="form-control select2"
{{--                    {{(auth()->user()->hasRole('CCMS_ADMIN') && $data )?'disabled':''}} --}}
                >
                    <option value="">Select one</option>
                    @foreach($getTicketTypeNo as $ticketTypeNo)
                        <option
                            {{ ( old("ticket_type_no", ($data)?$data->ticket_type_no:'') == $ticketTypeNo->ticket_type_no) ? "selected" : ""  }}
                            value="{{$ticketTypeNo->ticket_type_no}}">{{$ticketTypeNo->ticket_type_name}}
                        </option>
                    @endforeach
                </select>
                @if($errors->has("ticket_type_no"))
                    <span class="help-block">{{$errors->first("ticket_type_no")}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3" id="equip_no_div"
         style="@if(!empty($data->equipment_no)) display: block @else display: none @endif">
        <div class="row">
            <div class="col-md-12">
                <label class="input-required required">Equipment</label>
                <select id="equipment_id" name="equipment_id" class="form-control select2" {{(auth()->user()->hasRole('CCMS_ADMIN') && $data )?'disabled':''}} >
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
    @php
        $getKey = json_encode(Auth::user()->roles->pluck('role_key'));
    @endphp
    @if(strpos($getKey, "CCMS_GENERAL_USER") == FALSE)
    <div class="col-md-3 mb-1">
        <div class="row">
            <div class="col-md-12">
                <label class="input-required required">TICKET PRIORITY NO</label>
                <select id="ticket_priority_no" name="ticket_priority_no" class="form-control select2">
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
    @endif
    <div class="col-md-3 mb-1" id="conf_show_one"
         style="@if(!empty($data->ticket_type_no) && $data->ticket_type_no=='1004') display: block @else display: none @endif">
        <div class="row ">
            <div class="col-md-12">
                <label class="input-required">OCCURANCE DATE<span class="required"></span></label>
                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="occurance_date"
                     data-target-input="nearest">
                    <input type="text" name="occurance_date"
                           value="{{ old('occurance_date', ($data)?$data->occurance_date:'') }}"
                           class="form-control berthing_at" id="occurance_date_input"
                           data-target="#occurance_date" autocomplete="off"
                           data-toggle="datetimepicker"
                           placeholder="OCCURANCE DATE">
                    <div class="input-group-append" data-target="#occurance_date" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                </div>
                @if($errors->has("occurance_date"))
                    <span class="help-block">{{$errors->first("occurance_date")}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-1" id="conf_show_two"
         style="@if(!empty($data->ticket_type_no) && $data->ticket_type_no=='1004') display: block @else display: none @endif">
        <div class="row ">
            <div class="col-md-12">
                <label>Schedule start<span class="required"></span></label>
                <div class="input-group date" id="meeting_start_time" data-target-input="nearest">
                    <input type="text"
                           name="meeting_start_time"
                           value="{{ old('meeting_start_time', isset($data->meeting_start_time)?$data->meeting_start_time->format("h:i A"):'') }}"
                           class="form-control datetimepicker-input customError"
                           data-target="#meeting_start_time" autocomplete="off"
                           data-toggle="datetimepicker" id="meeting_start_time_input"
                           placeholder="Schedule start at">
                    <div class="input-group-append" data-target="#meeting_start_time" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="bx bx-time"></i>
                        </div>
                    </div>
                </div>

                @if($errors->has("meeting_start_time"))
                    <span class="help-block">{{$errors->first("meeting_start_time")}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-1" id="conf_show_three"
         style="@if(!empty($data->ticket_type_no) && $data->ticket_type_no=='1004') display: block @else display: none @endif">
        <div class="row ">
            <div class="col-md-12">
                <label class="input-required">MEETING END TIME<span class="required"></span></label>
                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="meeting_end_time"
                     data-target-input="nearest">
                    <input type="text" name="meeting_end_time"
                           value="{{ old('meeting_end_time', isset($data->meeting_end_time)?$data->meeting_end_time->format("h:i A"):'') }}"
                           class="form-control berthing_at" autocomplete="off"
                           data-target="#meeting_end_time" id="meeting_end_time_input"
                           data-toggle="datetimepicker"
                           placeholder="MEETING START TIME">
                    <div class="input-group-append" data-target="#meeting_end_time" data-toggle="datetimepicker">
                        <div class="input-group-text">
                            <i class="bx bx-time"></i>
                        </div>
                    </div>
                </div>
                @if($errors->has("meeting_end_time"))
                    <span class="help-block">{{$errors->first("meeting_end_time")}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-1" id="conf_show_four"
         style="@if(!empty($data->ticket_type_no) && $data->ticket_type_no=='1004') display: block @else display: none @endif">
        <div class="row ">
            <div class="col-md-12">
                <label class="input-required">MEETING ROOM NO<span class="required"></span></label>
                <input type="number"
                       id="meeting_room_no"
                       name="meeting_room_no"
                       value="{{ old('meeting_room_no', ($data)?$data->meeting_room_no:'') }}"
                       placeholder="MEETING ROOM NO"
                       class="form-control"
                />
                @if($errors->has("meeting_room_no"))
                    <span class="help-block">{{$errors->first("meeting_room_no")}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <label>IS INTERNAL</label>
                <div class="d-flex d-inline-block" style="margin-top: 10px">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input"
                               {{(auth()->user()->hasRole('CCMS_ADMIN'))?'disabled':''}}
                               value="{{ old('ticket_internal_external_yn','Y') }}"
                               {{isset($data->ticket_internal_external_yn) && $data->ticket_internal_external_yn == 'Y' ? 'checked' : ''}}
                               name="ticket_internal_external_yn" id="customRadio1"
                               checked="">
                        <label class="custom-control-label cursor-pointer" for="customRadio1">YES</label>
                    </div>&nbsp;&nbsp;
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input"
                               value="{{ old('ticket_internal_external_yn','N') }}"
                               {{(auth()->user()->hasRole('CCMS_ADMIN'))?'disabled':''}}
                               {{isset($data->ticket_internal_external_yn) && $data->ticket_internal_external_yn == 'N' ? 'checked' : ''}}
                               name="ticket_internal_external_yn" id="customRadio2"
                        />
                        <label class="custom-control-label cursor-pointer" for="customRadio2">NO</label>
                    </div>
                </div>
                @if($errors->has("ticket_internal_external_yn"))
                    <span class="help-block">{{$errors->first("ticket_internal_external_yn")}}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-1">
        <div class="row">
            <div class="col-md-12">
                <label class="input-required">TICKET DESCRIPTION <span class="required"></span></label>
                <textarea style="height: 37px" name="ticket_description"
                          placeholder="TICKET DESCRIPTION" cols="30" class="form-control" {{(auth()->user()->hasRole('CCMS_ADMIN'))?'disabled':''}}
                          oninput="this.value = this.value.toUpperCase()">{{ old('ticket_description', ($data)?$data->ticket_description:'') }}</textarea>
                <input type="hidden" value="{{auth()->user()->emp_id}}" id="get_emp_id">
                @if($errors->has("ticket_description"))
                    <span class="help-block">{{$errors->first("ticket_description")}}</span>
                @endif
            </div>
        </div>
    </div>
</div>
@if($myTicket=='N')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        @if (\Request::get('id'))
                            <button type="submit" name="save" class="btn btn-sm btn-dark shadow mr-1 mb-1">
                                <i class="bx bx-edit-alt"></i> Update
                            </button>
                            <a href="{{ route('service_ticket.index') }}" class="btn btn-sm btn-outline-secondary mb-1"
                               style="font-weight: 900;"><i class="bx bx-arrow-back"></i> Back</a>
                        @else
                            <button type="submit" name="save" class="btn btn btn-sm btn-dark mr-1 mb-1 shadow shadow-lg rounded">
                                <i class="bx bx-save"></i> SAVE
                            </button>
                            <button type="button" onclick="$('#ticket_form').hide('slow')"
                                    class="btn btn-sm btn-outline-dark mb-1 shadow shadow-lg rounded"><i class="bx bx-window-close"></i> Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12" style="margin: 10px 0px">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        @if (\Request::get('id'))
                            <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                <i class="bx bx-sync"></i> Update
                            </button>
                            <a href="{{ route('my_ticket.index') }}" class="btn btn-sm btn-outline-secondary mb-1"
                               style="font-weight: 900;"><i class="bx bx-arrow-back"></i> Back</a>
                        @else
                            <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                <i class="bx bx-save"></i> SAVE
                            </button>
                            <button type="button" onclick="$('#ticket_form').hide('slow')"
                                    class="btn btn btn-outline-dark  mb-1"><i class="bx bx-window-close"></i> Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@section('footer-script')
    @parent
    <script>
        $("#ticket_type_no").change(function () {
            let ticket_type_no = this.value;
            if (ticket_type_no) {
                $.ajax({
                    type: "GET",
                    url: 'ticket-type-detail',
                    data: {ticket_type_no: ticket_type_no},
                    success: function (data) {
                        if (data.toUpperCase() == 'HARDWARE' || data.toUpperCase() == 'SOFTWARE') {
                            $('#equip_no_div').css("display", "block");
                        } else {
                            $('#equip_no_div').css("display", "none");
                        }

                        if (data.toUpperCase() == 'CONFERENCE') {
                            $('#conf_show_one').css("display", "block");
                            $('#conf_show_two').css("display", "block");
                            $('#conf_show_three').css("display", "block");
                            $('#conf_show_four').css("display", "block");
                        } else {
                            $('#conf_show_one').css("display", "none");
                            $('#conf_show_two').css("display", "none");
                            $('#conf_show_three').css("display", "none");
                            $('#conf_show_four').css("display", "none");
                        }
                    },
                    error: function (err) {
                        alert('error');
                    }
                });
            } else {

            }
        });
        $("#ticket_for_id").change(function () {
            let ticket_for_id = this.value;
            if (ticket_for_id == '2') {
                $('#employee_div').css("display", "block");
                $('#dept_div').css("display", "none");
                $('#section_div').css("display", "none");
                $('#department_id').val("").trigger('change');
                $('#dpt_section_id').val("").trigger('change');
            } else if (ticket_for_id == '3') {
                $('#employee_div').css("display", "none");
                $('#dept_div').css("display", "block");
                $('#section_div').css("display", "block");
                $('#st_emp_id').empty();
            } else {
                $('#employee_div').css("display", "none");
                $('#dept_div').css("display", "none");
                $('#section_div').css("display", "none");
                $('#department_id').val("").trigger('change');
                $('#dpt_section_id').val("").trigger('change');
                $('#st_emp_id').empty();

                let emp_id = $('#get_emp_id').val();
                let dept_id = '';
                $.ajax({
                    type: 'get',
                    url: '/admin/get-equipment-list/',
                    data: {emp_id: emp_id, dept_id: dept_id},
                    success: function (msg) {
                        $("#equipment_id").html(msg);
                    }
                });
            }
        });
        $('#department_id').change(function () {
            let emp_id = '';
            let dept_id = $(this).val();
            $.ajax({
                type: 'get',
                url: '/admin/get-equipment-list/',
                data: {emp_id: emp_id, dept_id: dept_id},
                success: function (msg) {
                    $("#equipment_id").html(msg);
                }
            });
        });


        $('#st_emp_id').change(function () {
            let emp_id = $(this).val();
            let dept_id = '';
            $.ajax({
                type: 'get',
                url: '/admin/get-equipment-list/',
                data: {emp_id: emp_id, dept_id: dept_id},
                success: function (msg) {
                    $("#equipment_id").html(msg);
                }
            });
        });
        $(document).ready(function () {

            $(document).on("click", '.confirm-delete', function (e) {
                let ticket_no = $(this).attr('href');
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
                            url: 'service-ticket-remove',
                            data: {ticket_no: ticket_no},
                            success: function (results) {
                                if (results == "1") {
                                    Swal.fire({
                                        title: 'SERVICE TICKET DELETED SUCCESSFULLY.',
                                        confirmButtonText: 'OK',
                                        type: 'success'
                                    }).then(function () {
                                        $('#service-ticket').DataTable().ajax.reload();
                                    });
                                } else {
                                    swal("Error!", results.message, "error");
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

            //Date time picker
            function dateTimePicker(selector) {
                var elem = $(selector);
                elem.datetimepicker({
                    format: 'hh:mm A',
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
                    let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm A");
                    elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                }
            }

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

            function datePicker(selector) {
                var elem = $(selector);
                elem.datetimepicker({
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
                let preDefinedDate = elem.attr('data-predefined-date');

                if (preDefinedDate) {
                    let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD").format("YYYY-MM-DD");
                    elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                }
            }

            datePicker("#occurance_date");
            //datePicker("#occurance_date_start");
            //datePicker("#occurance_date_end");
            dateRangePicker('#occurance_date_start', '#occurance_date_end');
            dateTimePicker("#meeting_end_time");
            dateTimePicker("#meeting_start_time");
            //$('#occurance_date_input').val(getSysDate());
            //$('#occurance_date_start_input').val(getSysDate());
            // $('#occurance_date_end_input').val(getSysDate());
            //$('#meeting_start_time_input').val(getSysTime());
            //$('#meeting_end_time_input').val(getSysTime());
        });


    </script>
@endsection
