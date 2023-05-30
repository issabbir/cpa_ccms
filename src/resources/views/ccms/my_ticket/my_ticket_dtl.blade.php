@extends('layouts.default')

@section('title')
    My Ticket Details
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <span class="card-title font-weight-bold text-uppercase">
                      My Ticket Details
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
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_TICKET_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_TICKET_DETAILS.xdo&p_ticket_no='.\Request::get('id').'&type=pdf&filename=RPT_SERVICE_TICKET_DETAILS')}}" >
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{url('/report/render/RPT_SERVICE_TICKET_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_TICKET_DETAILS.xdo&p_ticket_no='.\Request::get('id').'&type=xlsx&filename=RPT_SERVICE_TICKET_DETAILS')}}" >
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
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank" href="{{ route('my_ticket.index', ['id' => $data['ticket_no']]) }}" class="">
                                        <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Ticket
                                    </a>
                                </div>
                            </li>
                        </ul> {{-- javascript:history.go(-1) --}}
                        <a  class="btn btn btn-outline-dark hvr-underline-reveal mb-1" href="{{ route('my_ticket.index') }}">
                            <i class="bx bx-arrow-back"></i> Back
                        </a>
                    </div>
                </div><hr>
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap" width="200"><strong>Ticket Id <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_id:''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket Type No <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_type_no:''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket Priority No <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_priority_no:'' }}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Occurance Date <span>:</span></strong></td>
                                <td>{{($getTicketDetls)?date('d-m-Y', strtotime($getTicketDetls->occurance_date)):''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Meeting Start Time <span>:</span></strong></td>
                                <td>{{($getTicketDetls)?date('h:i A', strtotime($getTicketDetls->meeting_start_time)):''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Meeting End Time <span>:</span></strong></td>
                                <td>{{($getTicketDetls)?date('h:i A', strtotime($getTicketDetls->meeting_end_time)):''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket Description <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_description:'' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Ticket Action list</h4>
                </div>
                <div class="col-md-12">
                    <div class="card-body comment-widgets">
                        <!-- Comment Row -->
                        @if(!empty($commentsData))
                            @foreach($commentsData as $key=>$data)
                                <div class="d-flex flex-row comment-row m-t-0"
                                     style="border: 2px solid #475F7B; border-radius: 5px">
                                    <!-- Comment Row -->
                                    <div class="comment-text w-100">
                                        <div class="row d-flex justify-content-between">
                                          <span class="ml-1 font-medium">
                                            <h5>{{$data->action_taken}}</h5>
                                          </span>
                                            <span><strong>Status : </strong>{{$data->status}}</span>
                                            <span class="text-muted pr-1">
                                                <span><strong>Posted By : </strong>{{$data->created_by}}</span><br>
                                                 {{date('d M, Y h:i A', strtotime($data->insert_date))}}
                                            </span>
                                        </div>
                                        <hr style="margin-top: 0">
                                        <span class="m-b-15 d-block">{{$data->action_note}}</span>
                                    </div>
                                </div> <!-- Card -->
                            @endforeach
                        @else
                            <div class="text-center"><h3 class="text-danger">No Comments Available !!</h3></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Form Show POST --}}
{{--    <div id="show" class="modal fade" role="dialog">--}}
{{--      <div class="modal-dialog modal-xl">--}}
{{--        <div class="modal-content">--}}
{{--          <div class="modal-header">--}}
{{--            <h4 class="modal-title text-left"></h4>--}}
{{--            --}}{{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">--}}
{{--              <i class="fas fa-check"></i> Assign</a> --}}
{{--            <button class="close" type="button" data-dismiss="modal" area-hidden="true">--}}
{{--              &times;--}}
{{--            </button>--}}
{{--          </div>--}}
{{--          <div class="modal-body">--}}
{{--            <h4 class="card-title">Service Ticket Assign</h4>--}}
{{--              <form method="POST" action=" @if ($assigndata && $assigndata->assignment_no) {{route('ticket_assign.update',['id' => $assigndata->assignment_no])}} @else {{route('ticket_assign.store')}} @endif">--}}
{{--              {{ ($assigndata && isset($assigndata->assignment_no))?method_field('PUT'):'' }}--}}
{{--              {!! csrf_field() !!}--}}
{{--              @if ($assigndata && $assigndata->assignment_no)--}}
{{--                <input type="hidden" name="assignment_no" value="{{$assigndata->assignment_no}}">--}}
{{--              @endif--}}
{{--              <hr>--}}
{{--              <div class="row">--}}
{{--                <div class="col-md-3">--}}
{{--                  <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                      <label class="input-required">ASSIGNMENT ID<span class="required"></span></label>--}}
{{--                      <input type="text"--}}
{{--                      readonly--}}
{{--                      id="assignment_id"--}}
{{--                      name="assignment_id"--}}
{{--                      value="{{ old('assignment_id', ($assigndata)?$assigndata->assignment_id:$gen_uniq_id) }}"--}}
{{--                      placeholder="ASSIGNMENT ID"--}}
{{--                      class="form-control text-uppercase">--}}
{{--                      @if($errors->has("assignment_id"))--}}
{{--                      <span class="help-block">{{$errors->first("assignment_id")}}</span>--}}
{{--                      @endif--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                  <div class="row">--}}
{{--                    <div class="col-md-12">--}}
{{--                      <label class="input-required required">Ticket No</label>--}}
{{--                      <input type="text"--}}
{{--                             readonly--}}
{{--                             id="ticket_no"--}}
{{--                             name="ticket_no"--}}
{{--                             value="{{ old('ticket_no', ($assigndata)?$assigndata->ticket_no:\Request::get('id')) }}"--}}
{{--                             class="form-control text-uppercase">--}}
{{--                        @if($errors->has("ticket_no"))--}}
{{--                        <span class="help-block">{{$errors->first("ticket_no")}}</span>--}}
{{--                        @endif--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                  <div class="col-md-3">--}}
{{--                    <div class="row">--}}
{{--                      <div class="col-md-12">--}}
{{--                        <label class="input-required required">SERVICE ENGINEER ID</label>--}}
{{--                        <select id="service_engineer_id" name="service_engineer_id" class="form-control select2">--}}
{{--                          <option value="">Select one</option>--}}
{{--                          @foreach($getServiceEngineerId as $ServiceEngineerId)--}}
{{--                          <option {{ ( old("service_engineer_id", ($assigndata)?$assigndata->service_engineer_id:'') == $ServiceEngineerId->service_engineer_id) ? "selected" : ""  }}--}}
{{--                            value="{{$ServiceEngineerId->service_engineer_id}}">{{$ServiceEngineerId->service_engineer_name}}--}}
{{--                          </option>--}}
{{--                          @endforeach--}}
{{--                        </select>--}}
{{--                        @if($errors->has("service_engineer_id"))--}}
{{--                        <span class="help-block">{{$errors->first("service_engineer_id")}}</span>--}}
{{--                        @endif--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                  <div class="col-md-3">--}}
{{--                    <div class="row ">--}}
{{--                      <div class="col-md-12">--}}
{{--                        <label class="input-required">ASSIGN BY<span class="required"></span></label>--}}
{{--                        <input type="text"--}}
{{--                        id="assign_by"--}}
{{--                        name="assign_by"--}}
{{--                        value="{{ old('assign_by', ($assigndata)?$assigndata->assign_by:'') }}"--}}
{{--                        placeholder="ASSIGN BY"--}}
{{--                        class="form-control"--}}
{{--                        />--}}
{{--                        @if($errors->has("assign_by"))--}}
{{--                        <span class="help-block">{{$errors->first("assign_by")}}</span>--}}
{{--                        @endif--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                  <div class="col-md-6">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <label class="input-required required">ASSIGNMENT NOTE </label>--}}
{{--                            <textarea style="height: 37px" name="assignment_note" id="assignment_note" placeholder="ASSIGNMENT NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('assignment_note', ($assigndata)?$assigndata->assignment_note:'') }}</textarea>--}}
{{--                            @if($errors->has("assignment_note"))--}}
{{--                                <span class="help-block">{{$errors->first("assignment_note")}}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                  <div class="col-md-3">--}}
{{--                      <div class="row ">--}}
{{--                          <div class="col-md-12">--}}
{{--                              <label class="input-required required">ASSIGNMENT DATE</label>--}}
{{--                              <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="assignment_date" data-target-input="nearest">--}}
{{--                                  <input type="text" name="assignment_date"--}}
{{--                                         value="{{ old('assignment_date',--}}
{{--                                         ($assigndata)?$assigndata->assignment_date:'') }}"--}}
{{--                                         class="form-control berthing_at"--}}
{{--                                         data-target="#assignment_date"--}}
{{--                                         data-toggle="datetimepicker"--}}
{{--                                         id="assignment_date"--}}
{{--                                         placeholder="ASSIGNMENT DATE">--}}
{{--                                  <div   class="input-group-append"--}}
{{--                                         data-target="#assignment_date"--}}
{{--                                         data-toggle="datetimepicker">--}}
{{--                                      <div class="input-group-text">--}}
{{--                                          <i class="bx bx-calendar"></i>--}}
{{--                                      </div>--}}
{{--                                  </div>--}}
{{--                              </div>--}}
{{--                              @if($errors->has("assignment_date"))--}}
{{--                                  <span class="help-block">{{$errors->first("assignment_date")}}</span>--}}
{{--                              @endif--}}
{{--                          </div>--}}
{{--                      </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--                <div class="row">--}}
{{--                  <div class="col-md-12" style="margin-top: 10px">--}}
{{--                    <div class="row my-1">--}}
{{--                      <div class="col-md-12">--}}
{{--                        <div class="d-flex justify-content-end">--}}
{{--                          <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">SAVE  </button>--}}
{{--                          <button type="reset" class="btn btn-outline-dark mb-1" data-dismiss="modal">Cancel  </button>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--          </div>--}}

{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}
@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>
        $('[data-dismiss=modal]').on('click', function (e) {
            var $t = $(this),
                target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
          $(target)
            .find("#assignment_date,#assignment_note,#assign_by,#service_engineer_id,select")
               .val('').end();
        })
        $(document).on('click', '.show-modal', function(id){
          $('#show').modal('show');
          $('.modal-title').text('Show Ticket Detail');
        });
        $(document).ready(function () {
             //Date time picker
            function dateTimePicker(selector) {
                var elem = $(selector);
                elem.datetimepicker({
                    format: 'DD-MM-YYYY HH:mm A',
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
            // timePicker("#meeting_start_time");
            // timePicker("#meeting_end_time");

             datePicker("#occurance_date");
             datePicker("#assignment_date");
            //dateTimePicker("#occurance_date");
            dateTimePicker("#meeting_end_time");
            dateTimePicker("#meeting_start_time");

        });
    </script>
@endsection

{{-- onClick="window.location.href='{{ route('ticket_assign.index', ['id' => $data['ticket_no']]) }}'" --}}
