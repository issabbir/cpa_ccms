@extends('layouts.default')

@section('title')
    Manage vendors
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title font-weight-bold text-uppercase">
                      Service Engineer Ticket Details
                    </span>
                </div><hr>
                <div class="card-body">
                    <div class="row mb-1">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">Ticket ID</label>
                                    <input type="text" readonly value="{{ ($getTicketDetls)?$getTicketDetls->ticket_id:''}}"
                                           class="form-control text-uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">TICKET TYPE NO </label>
                                    <input type="text" readonly value="{{ ($getTicketDetls)?$getTicketDetls->ticket_type_no:''}}"
                                           class="form-control text-uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">TICKET PRIORITY NO </label>
                                    <input type="text" readonly value="{{ ($getTicketDetls)?$getTicketDetls->ticket_priority_no:'' }}"
                                           class="form-control text-uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">OCCURANCE DATE </label>
                                    <input type="text" readonly value="{{ ($getTicketDetls)?$getTicketDetls->occurance_date:'' }}"
                                           class="form-control text-uppercase">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">MEETING START TIME </label>
                                    <input type="text" readonly value="{{ ($getTicketDetls)?$getTicketDetls->meeting_start_time:'' }}"
                                           class="form-control text-uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">MEETING END TIME </label>
                                    <input type="text" readonly value="{{ ($getTicketDetls)?$getTicketDetls->meeting_end_time:'' }}"
                                           class="form-control text-uppercase">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">TICKET DESCRIPTION </label>
                                    <textarea name="" id="" readonly class="form-control text-uppercase"
                                      title="{{ ($getTicketDetls)?$getTicketDetls->ticket_description:'' }}" style="height: 37px" >{{ ($getTicketDetls)?$getTicketDetls->ticket_description:'' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px">
                                    <div class="d-flex justify-content-end col">
                                        <a  class="btn btn btn-outline-dark  mb-1" href="javascript:history.go(-1)"> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <h4 class="card-title">Service Ticket Action</h4>
              <form method="POST" action=" @if ($data && $data->ticket_no) {{route('service-engineer-tickets.store',['id' => $data->ticket_no])}} @else {{route('service-engineer-tickets.store')}} @endif"> {{ ($data && isset($data->ticket_no))?method_field('PUT'):'' }}
                  {{ ($data && isset($data->ticket_no))?method_field('PUT'):'' }}
                  {!! csrf_field() !!}
              @if ($data && $data->ticket_no)
                <input type="hidden" name="ticket_no" value="{{$data->ticket_no}}">
              @endif
              <hr>
              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="input-required required">SERVICE TICKET ACTION</label>
                      <select id="action_no" name="action_no" class="form-control select2">
                        <option value="">Select one</option>
                        @foreach($getTicketAction as $ticketAction)
                        <option {{ ( old("action_no", ($data)?$data->action_no:'') == $ticketAction->action_no) ? "selected" : ""  }} value="{{$ticketAction->action_no}}">{{$ticketAction->action_description}}
                        </option>
                        @endforeach
                      </select>
                      @if($errors->has("action_no"))
                      <span class="help-block">{{$errors->first("action_no")}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="input-required required">STATUS NO</label>
                      <select id="status_no" name="status_no" class="form-control select2">
                        <option value="">Select one</option>
                        @foreach($getServiceStatus as $serviceStatus)
                        <option {{ ( old("status_no", ($data)?$data->status_no:'') == $serviceStatus->status_no) ? "selected" : ""  }} value="{{$serviceStatus->status_no}}">{{$serviceStatus->status_name}}
                        </option>
                        @endforeach
                      </select>
                      @if($errors->has("status_no"))
                      <span class="help-block">{{$errors->first("status_no")}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                      <div class="row">
                          <div class="col-md-12">
                              <label class="input-required required">ACTION NOTE </label>
                              <textarea style="height: 37px" name="action_note" id="action_note" placeholder="ACTION NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('action_note', ($data)?$data->action_note:'') }}</textarea>
                              @if($errors->has("action_note"))
                                  <span class="help-block">{{$errors->first("action_note")}}</span>
                              @endif
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4" style="margin-top: 10px">
                      <div class="row my-1">
                        <div class="col-md-12">
                          <div class="d-flex justify-content-end">
                            <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">SAVE  </button>
                            <button type="reset" class="btn btn-outline-dark  mb-1">Cancel  </button>
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
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Latest Comments</h4>
                </div>
                <div class="col-md-12">
                    <div class="card-body comment-widgets">
                        <!-- Comment Row -->
                        @if(!empty($commentsData))
                        @foreach($commentsData as $key=>$data)
                            <div class="d-flex flex-row comment-row m-t-0" style="border: 2px solid #475F7B; border-radius: 5px">
                                <!-- Comment Row -->
                                    <div class="comment-text w-100">
                                        <div class="row d-flex justify-content-between">
                                      <span class="ml-1 font-medium">
                                        <h6>{{$data->emp_name}}</h6>
                                      </span>
                                            <span class="text-muted pr-1">{{date('d M, Y', strtotime($data->insert_date))}}</span>
                                        </div><hr style="margin-top: 0">
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
    <div id="show" class="modal fade" role="dialog">
      <div class="modal-dialog modal-xl">
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
            <h4 class="card-title">Service Ticket Assign</h4>
              <form method="POST" action=" @if ($assigndata && $assigndata->assignment_no) {{route('ticket_assign.update',['id' => $assigndata->assignment_no])}} @else {{route('ticket_assign.store')}} @endif">
              {{ ($assigndata && isset($assigndata->assignment_no))?method_field('PUT'):'' }}
              {!! csrf_field() !!}
              @if ($assigndata && $assigndata->assignment_no)
                <input type="hidden" name="assignment_no" value="{{$assigndata->assignment_no}}">
              @endif
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="input-required">ASSIGNMENT ID<span class="required"></span></label>
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
                <div class="col-md-3">
                  <div class="row">
                    <div class="col-md-12">
                      <label class="input-required required">Ticket No</label>
                      <input type="text"
                             readonly
                             id="ticket_no"
                             name="ticket_no"
                             value="{{ old('ticket_no', ($assigndata)?$assigndata->ticket_no:\Request::get('id')) }}"
                             class="form-control text-uppercase">
                        @if($errors->has("ticket_no"))
                        <span class="help-block">{{$errors->first("ticket_no")}}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
                        <label class="input-required required">SERVICE ENGINEER ID</label>
                        <select id="service_engineer_id" name="service_engineer_id" class="form-control select2">
                          <option value="">Select one</option>
                          @foreach($getServiceEngineerId as $ServiceEngineerId)
                          <option {{ ( old("service_engineer_id", ($assigndata)?$assigndata->service_engineer_id:'') == $ServiceEngineerId->service_engineer_id) ? "selected" : ""  }}
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
                  <div class="col-md-3">
                    <div class="row ">
                      <div class="col-md-12">
                        <label class="input-required">ASSIGN BY<span class="required"></span></label>
                        <input type="text"
                        id="assign_by"
                        name="assign_by"
                        value="{{ old('assign_by', ($assigndata)?$assigndata->assign_by:'') }}"
                        placeholder="ASSIGN BY"
                        class="form-control"
                        />
                        @if($errors->has("assign_by"))
                        <span class="help-block">{{$errors->first("assign_by")}}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="input-required required">ASSIGNMENT NOTE </label>
                            <textarea style="height: 37px" name="assignment_note" id="assignment_note" placeholder="ASSIGNMENT NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('assignment_note', ($assigndata)?$assigndata->assignment_note:'') }}</textarea>
                            @if($errors->has("assignment_note"))
                                <span class="help-block">{{$errors->first("assignment_note")}}</span>
                            @endif
                        </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                      <div class="row ">
                          <div class="col-md-12">
                              <label class="input-required required">ASSIGNMENT DATE</label>
                              <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="assignment_date" data-target-input="nearest">
                                  <input type="text" name="assignment_date"
                                         value="{{ old('assignment_date',
                                         ($assigndata)?$assigndata->assignment_date:'') }}"
                                         class="form-control berthing_at"
                                         data-target="#assignment_date"
                                         data-toggle="datetimepicker"
                                         id="assignment_date"
                                         autocomplete="off"
                                         placeholder="ASSIGNMENT DATE">
                                  <div   class="input-group-append"
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
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" style="margin-top: 10px">
                    <div class="row my-1">
                      <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                          <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">SAVE  </button>
                          <button type="reset" class="btn btn-outline-dark mb-1" data-dismiss="modal">Cancel  </button>
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
