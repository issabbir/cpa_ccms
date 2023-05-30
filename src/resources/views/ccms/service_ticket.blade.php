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
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title text-uppercase">
                          {{ $data && isset($data->ticket_no)?'Edit':'Add' }} Service Ticket
                        </h4>
                        <form method="POST" action="@if ($data && $data->ticket_no) {{route('service_ticket.update',['id' => $data->ticket_no])}} @else {{route('service_ticket.store')}} @endif">
                            {{ ($data && isset($data->ticket_no))?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            @if ($data && $data->ticket_no)
                                <input type="hidden" name="ticket_no" value="{{$data->ticket_no}}">
                            @endif
                            <hr>
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Ticket ID<span class="required"></span></label>
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
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required"> TICKET TYPE NO</label>
                                            <select  id="ticket_type_no" name="ticket_type_no" class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($getTicketTypeNo as $ticketTypeNo)
                                                  <option {{ ( old("ticket_type_no", ($data)?$data->ticket_type_no:'') == $ticketTypeNo->ticket_type_no) ? "selected" : ""  }}
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
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">TICKET PRIORITY NO</label>
                                            <select id="ticket_priority_no" name="ticket_priority_no" class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($getTicketPriorityNo as $ticketPriorityNo)
                                                  <option {{ ( old("ticket_priority_no", ($data)?$data->ticket_priority_no:'') == $ticketPriorityNo->ticket_priority_no) ? "selected" : ""  }}
                                                    value="{{$ticketPriorityNo->ticket_priority_no}}">{{$ticketPriorityNo->ticket_priority_no}}
                                                  </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has("ticket_priority_no"))
                                                <span class="help-block">{{$errors->first("ticket_priority_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('ccms/common/emp_select_box',
                                                [
                                                'select_name' => 'emp_id',
                                                'label_name' => 'Employee ID',
                                                'required' => true,
                                                ]
                                             )
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">OCCURANCE DATE<span class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="occurance_date" data-target-input="nearest">
                                                <input type="text" name="occurance_date"
                                                       value="{{ old('occurance_date', ($data)?$data->occurance_date:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#occurance_date"
                                                       data-toggle="datetimepicker"
                                                       placeholder="OCCURANCE DATE"
                                                />
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
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label>Schedule start<span class="required"></span></label>
                                            <div class="input-group date" id="meeting_start_time" data-target-input="nearest">
                                                <input type="text"
                                                       name="meeting_start_time"
                                                       value="{{ old('meeting_start_time', ($data)?$data->meeting_start_time:'') }}"
                                                       class="form-control datetimepicker-input customError"
                                                       data-target="#meeting_start_time"
                                                       data-toggle="datetimepicker"
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
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">MEETING END TIME<span class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="meeting_end_time" data-target-input="nearest">
                                                <input type="text" name="meeting_end_time"
                                                       value="{{ old('meeting_end_time', ($data)?$data->meeting_end_time:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#meeting_end_time"
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
                                <div class="col-md-3">
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
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <label class="input-required">TICKET DESCRIPTION <span class="required"></span></label>
                                        <textarea style="height: 37px" name="ticket_description" id="ticket_description" placeholder="TICKET DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('ticket_description', ($data)?$data->ticket_description:'') }}</textarea>
                                        @if($errors->has("ticket_description"))
                                            <span class="help-block">{{$errors->first("ticket_description")}}</span>
                                        @endif
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">TICKET INTERNAL EXTERNAL YN<span class="required"></span></label>
                                            <div class="d-flex d-inline-block" style="margin-top: 10px">
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input"
                                                        value="{{ old('ticket_internal_external_yn','Y') }}" {{isset($data->ticket_internal_external_yn) && $data->ticket_internal_external_yn == 'Y' ? 'checked' : ''}}
                                                         name="ticket_internal_external_yn" id="customRadio1"
                                                         checked=""
                                                  />
                                                  <label class="custom-control-label" for="customRadio1">YES</label>
                                              </div>&nbsp;&nbsp;
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input"
                                                          value="{{ old('ticket_internal_external_yn','N') }}" {{isset($data->ticket_internal_external_yn) && $data->ticket_internal_external_yn == 'N' ? 'checked' : ''}}
                                                         name="ticket_internal_external_yn" id="customRadio2"
                                                  />
                                                  <label class="custom-control-label" for="customRadio2">NO</label>
                                              </div>
                                            </div>
                                            @if($errors->has("ticket_internal_external_yn"))
                                                <span class="help-block">{{$errors->first("ticket_internal_external_yn")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                @if (\Request::get('id'))
                                                  <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">Update</button>
                                                  <a href="{{ route('service_ticket.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="padding-top: 10px; font-weight: 900;">Back</a>
                                                @else
                                                  <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">SAVE  </button>
                                                  <button type="reset" class="btn btn btn-outline-dark  mb-1">Cancel  </button>
                                                @endif
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
        <!-- Modal -->

        {{-- Modal Form Show POST --}}
{{--         <div id="show" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title text-left"></h4>
                <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}"> 
                  <i class="fas fa-check"></i> Assign</a>
                <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                  &times;
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-active table-bordered table-hover">
                  <tr>
                    <td>Ticket No</td>
                    <td><b id="tn"/></td>
                  </tr>
                  <tr>
                    <td>Ticket ID</td>
                    <td><b id="tid"/></td>
                  </tr>
                  <tr>
                    <td>TICKET TYPE NO</td>
                    <td><b id="ttn"/></td>
                  </tr>
                  <tr>
                    <td>EMPLOYEE ID</td>
                    <td><b id="ei"/></td>
                  </tr>
                  <tr>
                    <td>TICKET DESCRIPTION</td>
                    <td><b id="td"/></td>
                  </tr>
                  <tr>
                    <td>TICKET PRIORITY NO</td>
                    <td><b id="tpn"/></td>
                  </tr>
                  <tr>
                    <td>OCCURANCE DATE</td>
                    <td><b id="ocd"/></td>
                  </tr>
                  <tr>
                    <td>MEETING START TIME</td>
                    <td><b id="mst"/></td>
                  </tr>
                  <tr>
                    <td>MEETING END TIME</td>
                    <td><b id="met"/></td>
                  </tr>
                  <tr>
                    <td>MEETING ROOM NO</td>
                    <td><b id="mrn"/></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
        
          <!--List-->
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title text-uppercase">Service ticket List</h4>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('service_ticket.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="ticket_id">TICKET ID</th>
                                    <th data-col="ticket_internal_external_yn" title="Ticket Internal External YN">
                                      Ticket YN
                                    </th>
                                    <th data-col="ticket_type_no" title="TICKET TYPE NO">TYPE NO</th>
                                    <th data-col="ticket_description" title="TICKET DESCRIPTION">DESCRIPTION</th>
                                    <th data-col="ticket_priority_no" title="TICKET PRIORITY NO">PRIOR. NO</th>
                                    <th data-col="emp_id" title="EMPLOYEE ID">Emp. Id</th>
                                    <th data-col="occurance_date" title="OCCURANCE DATE">OCCUR. DATE</th>
                                    <th data-col="meeting_start_time" title="MEETING START TIME">START TIME</th>
                                    <th data-col="meeting_end_time" title="MEETING END TIME">END TIME</th>
                                    <th data-col="meeting_room_no" title="MEETING ROOM NO">ROOM NO</th>
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
    </div>
    <a href="" data-></a>
@endsection


@section('footer-script')
    <!--Load custom script route('service_ticket.ticket_dtl', ['id' => $data['ticket_no']])-->
    <script>
        // $(document).on('click', '.show-modal', function(id){
        //   $('#show').modal('show');
        //   $('#tn').text($(this).data('ticket_no'));
        //   $('#tid').text($(this).data('ticket_id'));
        //   $('#ttn').text($(this).data('ticket_type_no'));
        //   $('#td').text($(this).data('ticket_description'));
        //   $('#tpn').text($(this).data('ticket_priority_no'));
        //   $('#ei').text($(this).data('emp_id'));
        //   $('#ocd').text($(this).data('occurance_date'));
        //   $('#mst').text($(this).data('meeting_start_time'));
        //   $('#met').text($(this).data('meeting_end_time'));
        //   $('#mrn').text($(this).data('meeting_room_no'));
        //   $('.modal-title').text('Show Ticket Detail');
        // });
          // $('#exampleModal').modal('show');

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
            //dateTimePicker("#occurance_date");
            dateTimePicker("#meeting_end_time");
            dateTimePicker("#meeting_start_time");

        });
    </script>
@endsection
