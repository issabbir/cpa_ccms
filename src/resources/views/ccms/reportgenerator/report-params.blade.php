<div class="col-12">
    <div class="row">
        @if($report)
            @if($report->params)
                @foreach($report->params as $reportParam)
                    @if($reportParam->component == 'emp_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                            </select>
                        </div>
                    @elseif($reportParam->component == 'dept_name')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control custom-select select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                            </select>
                        </div>
                    @elseif($reportParam->component == 'received_date')
                        <div class="col-md-3">
                            <label for="p_start_date"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">From
                                Date</label>
                            <div class="input-group date datePiker" id="p_received_date"
                                 data-target-input="nearest">
                                <input type="text" autocomplete="off"
                                       class="form-control datetimepicker-input"
                                       value="" name="p_received_date"
                                       data-toggle="datetimepicker"
                                       data-target="#p_received_date"
                                       @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required
                                       @endif onautocomplete="off"/>
                                <div class="input-group-append" data-target="#p_received_date"
                                     data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="bx bxs-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                    @elseif($reportParam->component == 'sending_date')
                        <div class="col-md-3">
                            <label for="p_sending_date"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">To
                                Date</label>
                            <div class="input-group date datePiker" id="p_sending_date"
                                 data-target-input="nearest">
                                <input type="text" autocomplete="off"
                                       class="form-control datetimepicker-input"
                                       value="" name="p_sending_date"
                                       data-toggle="datetimepicker"
                                       data-target="#p_sending_date"
                                       @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required
                                       @endif onautocomplete="off"/>
                                <div class="input-group-append" data-target="#p_sending_date"
                                     data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="bx bxs-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    {{--@elseif($reportParam->component == 'trainee_name')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($traineeList)
                                    @foreach($traineeList as $trainee)
                                        <option value="{{$trainee->trainee_id}}">{{$trainee->trainee_name.'- ('.$trainee->trainee_code.')'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>--}}

                        @elseif($reportParam->component == 'equipment_status')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($getEquipmentStatus)
                                    @foreach($getEquipmentStatus as $equipmentStatus)
                                        <option value="{{$equipmentStatus->equipment_status_id}}">{{$equipmentStatus->status_name.'- ('.$equipmentStatus->equipment_status_id.')'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        @elseif($reportParam->component == 'equipment_name')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($getEquipmentList)

                                    @foreach($getEquipmentList as $Eq_data)
                                        <option value="{{$Eq_data->equipment_add_no}}">{{$Eq_data->equipment_name.'- ('.$Eq_data->equipment_add_no.')'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @elseif($reportParam->component == 'equipment_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($getEquipmentID)
                                    @foreach($getEquipmentID as $equipment)
                                        <option value="{{$equipment->equipment_no}}">{{$equipment->equipment_name.'- ('.$equipment->equipment_no.')'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'requisition_status')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($requisitionStatus)
                                    @foreach($requisitionStatus as $reqsiStataus)
                                        <option value="{{$reqsiStataus->requisition_status_id}}">{{$reqsiStataus->status_name.'- ('.$reqsiStataus->requisition_status_id.')'}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'requisition_mst_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($requisitionMasterList)
                                    @foreach($requisitionMasterList as $reqsiMasterList)
                                        <option value="{{$reqsiMasterList->requisition_mst_no}}">{{$reqsiMasterList->requisition_mst_no}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'ticket_type_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($ticketTypeList)
                                    @foreach($ticketTypeList as $ticketList)
                                        <option value="{{$ticketList->ticket_type_no}}">{{$ticketList->ticket_type_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'ticket_priority_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($ticketPriorityList)
                                    @foreach($ticketPriorityList as $ticketPriority)
                                        <option value="{{$ticketPriority->ticket_priority_no}}">{{$ticketPriority->remarks}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'ticket_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($serviceTicketlist)
                                    @foreach($serviceTicketlist as $serviceTicket)
                                        <option value="{{$serviceTicket->ticket_no}}">{{$serviceTicket->ticket_no}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'vendor_no')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                @if($vendorList)
                                    @foreach($vendorList as $vendorLists)
                                        <option value="{{$vendorLists->vendor_no}}">{{$vendorLists->vendor_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @elseif($reportParam->component == 'ticket_internal_yn')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                <option value="Y">YES</option>
                                <option value="N">NO</option>
                            </select>

                        </div>
                    @elseif($reportParam->component == 'problem_solved_yn')
                        <div class="col-md-3">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <select name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                    class="form-control select2"
                                    @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif>
                                <option value="">Select One</option>
                                <option value="Y">Resolved</option>
                                <option value="N">Not Resolved</option>
                            </select>

                        </div>
                    @else
                        <div class="col">
                            <label for="{{$reportParam->param_name}}"
                                   class="@if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif">{{$reportParam->param_label}}</label>
                            <input type="text" name="{{$reportParam->param_name}}" id="{{$reportParam->param_name}}"
                                   class="form-control"
                                   @if($reportParam->requied_yn==\App\Enums\YesNoFlag::YES) required @endif />
                        </div>
                    @endif
                @endforeach
            @endif
            <div class="col-md-3">
                <label for="type">Report Type</label>
                <select name="type" id="type" class="form-control">
                    <option value="pdf">PDF</option>
                    <option value="xlsx">Excel</option>
                </select>
                <input type="hidden" value="{{$report->report_xdo_path}}" name="xdo"/>
                <input type="hidden" value="{{$report->report_id}}" name="rid"/>
                <input type="hidden" value="{{$report->report_name}}" name="filename"/>
            </div>
            <div class="col-md-3 mt-2">
                <button type="submit" class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary">Generate Report</button>
            </div>
        @endif
    </div>
</div>

{{--<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/select/select2.min.css')}}">--}}
{{--<script src="{{asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>--}}

<script src="{{asset('assets/js/scripts/forms/select/form-select2.min.js')}}"></script>
<script type="text/javascript">

    $('.datePiker').datetimepicker({
        format: 'DD-MM-YYYY',
        widgetPositioning: {
            horizontal: 'left',
            vertical: 'bottom'
        },
        icons: {
            date: 'bx bxs-calendar',
            previous: 'bx bx-chevron-left',
            next: 'bx bx-chevron-right'
        }
    });

    function deptName(){
       $('#p_department_id').select2({
           placeholder: "Select",
           allowClear: true,
           ajax: {
               url: APP_URL+'/ajax/dept-name',
               data: function (params) {
                   if(params.term) {
                       if (params.term.trim().length  < 1) {
                           return false;
                       }
                   } else {
                       return false;
                   }

                   return params;
               },
               dataType: 'json',
               processResults: function(data) {
                   var formattedResults = $.map(data, function(obj, idx) {
                       obj.id = obj.department_id;
                       obj.text = obj.department_name;
                       return obj;
                   });
                   return {
                       results: formattedResults,
                   };
               }
           }
       });
   }

    $(document).ready(function() {
        deptName();
        selectCpaEmployees('#p_emp_id', APP_URL+'/ajax/employees', APP_URL+'/ajax/employee/');
    });

</script>
