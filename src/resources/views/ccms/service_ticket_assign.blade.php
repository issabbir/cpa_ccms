@extends('layouts.default')

@section('title')
Service Ticket Assign
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
          <h4 class="card-title">
            {{ $data && isset($data->assignment_no)?'Edit':'Add' }} Service Ticket Assign
          </h4>
          <form method="POST" action="
          @if ($data && $data->assignment_no) {{route('ticket_assign.update',['id' => $data->assignment_no])}}
          @else {{route('ticket_assign.store')}} @endif">
          {{ ($data && isset($data->assignment_no))?method_field('PUT'):'' }}
          {!! csrf_field() !!}
          @if ($data && $data->assignment_no)
            <input type="hidden" name="assignment_no" value="{{$data->assignment_no}}">
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
                  value="{{ old('assignment_id', ($data)?$data->assignment_id:$gen_uniq_id) }}"
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
                         value="{{ old('ticket_no', ($data)?$data->ticket_no:\Request::get('id')) }}"
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
                      <option {{ ( old("service_engineer_id", ($data)?$data->service_engineer_id:'') == $ServiceEngineerId->service_engineer_id) ? "selected" : ""  }}
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
                    value="{{ old('assign_by', ($data)?$data->assign_by:'') }}"
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
                        <textarea style="height: 37px" name="assignment_note" id="assignment_note" placeholder="ASSIGNMENT NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('assignment_note', ($data)?$data->assignment_note:'') }}</textarea>
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
                                     ($data)?$data->assignment_date:'') }}"
                                     class="form-control berthing_at"
                                     data-target="#assignment_date"
                                     data-toggle="datetimepicker"
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
                      <button type="reset" class="btn btn-outline-dark  mb-1">Cancel  </button>
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
<!--List-->
<div class="card">
  <div class="card-header">
    <h4 class="card-title text-uppercase">Service Ticket Assign </h4>
  </div>
  <div class="card-content">
    <div class="card-body card-dashboard">
      <div class="table-responsive">
        <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
        data-url="{{ route('ticket_assign.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
        <thead >
          <tr class="text-nowrap">
            <th data-col="DT_RowIndex">SL</th>
            <th data-col="assignment_id" title="ASSIGNMENT ID">ASSIGNMENT ID</th>
            <th data-col="ticket_no" title="TICKET NO">TICKET NO</th>
            <th data-col="service_engineer_id" title="SERVICE ENGINEER ID">SERVICE ENGINEER ID</th>
            <th data-col="assign_by" title="ASSIGN BY">ASSIGN BY</th>
            <th data-col="assignment_note" title="ASSIGNMENT NOTE">ASSIGNMENT NOTE</th>
            <th data-col="assignment_date" title="ASSIGNMENT DATE">ASSIGNMENT DATE</th>
            <th data-col="action">ACTION</th>
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
@endsection


@section('footer-script')
<!--Load custom script-->
<script>
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
          datePicker("#assignment_date");
          //dateTimePicker("#occurance_date");
          // dateTimePicker("#meeting_end_time");
          // dateTimePicker("#meeting_start_time");
  });
</script>
@endsection
