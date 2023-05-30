@extends('layouts.default')

@section('title')
    Third Party Service
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body" style="@if(\Request::get('id')) display: block @else display: none @endif" id="third_party_service_form">
                        <h4 class="card-title">
                          {{ $data && isset($data->third_party_service_id)?'Edit':'Add' }} Third Party Service
                        </h4>
                        <form method="POST" action="
                        @if ($data && $data->third_party_service_id)
                        {{route('admin.third_party.update',['id' => $data->third_party_service_id])}}
                        @else {{route('admin.third_party.store')}} @endif">
                            {{ ($data && isset($data->third_party_service_id))?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            @if ($data && $data->third_party_service_id)
                                <input type="hidden"
                                       name="third_party_service_id"
                                       value="{{$data->third_party_service_id}}">
                            @endif
                            <hr>
                            <div class="row mb-1">

                              <div class="col-md-3">
                                  <div class="row">
                                      <div class="col-md-12">
                                          @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') && isset($data->approved_yn) && $data->approved_yn != 'Y')
                                              <input type="hidden" name="approve_yn" value="{{\Request::get('approve')}}">
                                          @endif
                                          <label class="input-required required">Equipment ID</label>
                                          <select  id="equipment_no" name="equipment_no" class="form-control select2">
                                              <option value="">Select one</option>
                                              @foreach($getEquipmentID as $equipmentID)
                                                <option {{ ( old("equipment_no", ($data)?$data->equipment_no:'') == $equipmentID->equipment_no) ? "selected" : ""  }}
                                                  value="{{$equipmentID->equipment_no}}">
                                                  {{$equipmentID->equipment_name}}</option>
                                              @endforeach
                                          </select>
                                          @if($errors->has("equipment_no"))
                                              <span class="help-block">{{$errors->first("equipment_no")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                                @if(!empty(\Request::get('id')) && empty($data))
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">Ticket No</label>
                                            <select class="form-control select2" id="select_ticket" disabled>
                                                <option value="">Select one</option>
                                                @foreach($getTicketNo as $ticketNo)
                                                    <option {{ ( old("ticket_no", (\Request::get('id'))?\Request::get('id'):'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                            value="{{$ticketNo->ticket_no}}">
                                                        {{$ticketNo->ticket_no}}</option>
                                                @endforeach
                                                <input type="hidden" id="ticket_no" name="ticket_no">
                                            </select>
                                            @if($errors->has("ticket_no"))
                                                <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @elseif(!empty($data->ticket_no))
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">Ticket No</label>
                                                <select  id="ticket_no" name="ticket_no" class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($getTicketNo as $ticketNo)
                                                        <option {{ ( old("ticket_no", ($data)?$data->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                                value="{{$ticketNo->ticket_no}}">
                                                            {{$ticketNo->ticket_no}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has("ticket_no"))
                                                    <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">Ticket No</label>
                                                <select  id="ticket_no" name="ticket_no" class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($getTicketNo as $ticketNo)
                                                        <option {{ ( old("ticket_no", ($data)?$data->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                                value="{{$ticketNo->ticket_no}}">
                                                            {{$ticketNo->ticket_no}}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has("ticket_no"))
                                                    <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif


                              <div class="col-md-3">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <label class="input-required required">Vendor No</label>
                                          <select  id="vendor_no" name="vendor_no" class="form-control select2">
                                              <option value="">Select one</option>
                                              @foreach($getVendorNo as $vendorNo)
                                                <option {{ ( old("vendor_no", ($data)?$data->vendor_no:'') == $vendorNo->vendor_no) ? "selected" : ""  }}
                                                  value="{{$vendorNo->vendor_no}}">
                                                  {{$vendorNo->vendor_name}}</option>
                                              @endforeach
                                          </select>
                                          @if($errors->has("vendor_no"))
                                              <span class="help-block">{{$errors->first("vendor_no")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">Service Charge</label>
                                            <input type="number"
                                                   required
                                                   id="service_charge"
                                                   name="service_charge"
                                                   value="{{ old('service_charge', ($data)?$data->service_charge:'') }}"
                                                   placeholder="Service Charge"
                                                   class="form-control text-uppercase">
                                            @if($errors->has("service_charge"))
                                              <span class="help-block">{{$errors->first("service_charge")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required required">SENDING DATE</label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="sending_date" data-target-input="nearest">
                                                <input type="text" name="sending_date"
                                                       value="{{ old('sending_date',
                                                       ($data)?$data->sending_date:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#sending_date"
                                                       id="sending_date_input"
                                                       data-toggle="datetimepicker"
                                                       placeholder="SENDING DATE">
                                                <div   class="input-group-append"
                                                       data-target="#sending_date"
                                                       data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("sending_date"))
                                                <span class="help-block">{{$errors->first("sending_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required required">RECEIVED DATE</label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="received_date" data-target-input="nearest">
                                                <input type="text" name="received_date"
                                                       value="{{ old('received_date',
                                                       ($data)?$data->received_date:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#received_date"
                                                       id="received_date_input"
                                                       data-toggle="datetimepicker"
                                                       placeholder="RECEIVED DATE">
                                                <div   class="input-group-append"
                                                       data-target="#received_date"
                                                       data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("received_date"))
                                                <span class="help-block">{{$errors->first("received_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-md-3">
                                    <label class="input-required required">PROBLEM STATUS</label>
                                    <div class="d-flex d-inline-block">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                   value="{{ old('problem_solved_yn','Y') }}" {{isset($data->problem_solved_yn) && $data->problem_solved_yn == 'Y' ? 'checked' : ''}} name="problem_solved_yn" id="customRadio1" checked>
                                            <label class="custom-control-label" for="customRadio1">RESOLVED</label>
                                        </div>&nbsp;&nbsp;
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input"
                                                   value="{{ old('problem_solved_yn','N') }}" {{isset($data->problem_solved_yn) && $data->problem_solved_yn == 'N' ? 'checked' : ''}} name="problem_solved_yn" id="customRadio2">
                                            <label class="custom-control-label" for="customRadio2">NOT RESOLVED</label>
                                        </div>
                                    </div>
                                    @if($errors->has("problem_solved_yn"))
                                        <span class="help-block">{{$errors->first("problem_solved_yn")}}</span>
                                    @endif
                                </div>--}}
                                <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <label class="input-required required">PROBLEM DESCRIPTION </label>
                                          <textarea style="height: 37px" name="problem_description" id="editor" placeholder="PROBLEM DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('problem_description', ($data)?$data->problem_description:'') }}</textarea>
                                          @if($errors->has("problem_description"))
                                              <span class="help-block">{{$errors->first("problem_description")}}</span>
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
                                                @if (\Request::get('id') && !empty($data))
                                                    @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST') && $data->approved_yn != 'Y')
                                                  <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">
                                                      <i class="bx bx-edit-alt"></i> Approve</button>
                                                    @else
                                                   <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">
                                                            <i class="bx bx-edit-alt"></i> Update</button>
                                                    @endif
                                                  <a href="{{ route('admin.third_party.index') }}" class="btn btn-outline-secondary mb-1" style="font-weight: 900;">
                                                  <i class="bx bx-arrow-back"></i> Back</a>
                                                @else
                                                  <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">
                                                  <i class="bx bx-save"></i> SAVE  </button>
                                                  <button type="button" onclick="$('#third_party_service_form').hide('slow')" class="btn btn-outline-dark  mb-1">
                                                  <i class="bx bx-window-close"></i> Cancel  </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                        </form>
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
                          <h4 class="card-title text-uppercase">Third Party Service List</h4>
                      </div>

                      <div class="col-md-6">
                          <div class="row float-right">
                              <form name="report_form" id="report_form" target="_blank" action="{{route('report', ['title' => 'Third-Party-Service'])}}">
                                  {{csrf_field()}}
                                  <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_THIRD_PARTY_SERVICE_LIST.xdo"/>
                                  <input type="hidden" name="type" id="type" value="pdf" />
                                  <input type="hidden" name="p_equipment_no" id="p_equipment_no" />
                                  <input type="hidden" name="p_vendor_no" id="p_vendor_no" />
                                  <input type="hidden" name="p_sending_date" id="p_sending_date" />
                                  <input type="hidden" name="p_received_date" id="p_received_date" />
                                  <input type="hidden" name="p_problem_solved_yn" id="p_problem_solved_yn" />

                                  @section('footer-script')
                                      @parent
                                      <script>
                                          $(document).ready(function() {

                                              $("#report_pdf_action").on('click',function() {
                                                  var report_form = $("#report_form");
                                                  var filter_form = $("#datatable_filter_form");
                                                  report_form.find('#type').val("pdf");
                                                  report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                                  report_form.find('#p_vendor_no').val(filter_form.find('input.vendor_no').val());
                                                  report_form.find('#p_sending_date').val(filter_form.find('input.send_date').val());
                                                  report_form.find('#p_received_date').val(filter_form.find('input.receive_date').val());
                                                  var selected = $("input[type='radio'][name='problem_solved_yn_filter']:checked");
                                                  if (selected.length > 0) {
                                                      report_form.find('#p_problem_solved_yn').val(selected.val());
                                                  }
                                                  report_form.submit();
                                              });

                                              $("#report_xlsx_action").on('click',function() {
                                                  var report_form = $("#report_form");
                                                  var filter_form = $("#datatable_filter_form");
                                                  report_form.find('#type').val("xlsx");
                                                  report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                                  report_form.find('#p_vendor_no').val(filter_form.find('input.vendor_no').val());
                                                  report_form.find('#p_sending_date').val(filter_form.find('input.send_date').val());
                                                  report_form.find('#p_received_date').val(filter_form.find('input.receive_date').val());
                                                  var selected = $("input[type='radio'][name='problem_solved_yn_filter']:checked");
                                                  if (selected.length > 0) {
                                                      report_form.find('#p_problem_solved_yn').val(selected.val());
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

                              <button onclick="$('#datatable_filter_form').toggle('slow')" class="btn btn-secondary mb-1 mr-1 hvr-underline-reveal">
                                  <i class="bx bx-filter-alt"></i> Filter</button>
                              {{--<button id="show_form" class="btn btn-secondary mb-1" onclick="$('#third_party_service_form').toggle('slow')">
                              <i class="bx bx-plus"></i> Add New</button>--}}
                          </div>
                      </div>
                  </div>
              </div>
              <div class="bg-rgba-secondary mr-2 ml-2" style="border-radius: 5px">
                  <form style="display: none;padding: 1rem 0" id="datatable_filter_form" method="POST">
                      <div class="row ml-1 mr-1">
                          <div class="col-md-3 mb-1">
                              <div class="row">
                                  <div class="col-md-12">
                                      <label>Equipment ID</label>
                                      <select name="equipment_no_filter" class="form-control select2 equipment_no">
                                          <option value="">Select one</option>
                                          @foreach($getEquipmentID as $equipmentID)
                                              <option {{ ( old("equipment_no", ($data)?$data->equipment_no:'') == $equipmentID->equipment_no) ? "selected" : ""  }}
                                                      value="{{$equipmentID->equipment_no}}">
                                                  {{$equipmentID->equipment_name}}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has("equipment_no"))
                                          <span class="help-block">{{$errors->first("equipment_no")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row">
                                  <div class="col-md-12">
                                      <label>Vendor No</label>
                                      <select name="vendor_no_filter" class="form-control select2 vendor_no">
                                          <option value="">Select one</option>
                                          @foreach($getVendorNo as $vendorNo)
                                              <option {{ ( old("vendor_no", ($data)?$data->vendor_no:'') == $vendorNo->vendor_no) ? "selected" : ""  }}
                                                      value="{{$vendorNo->vendor_no}}">
                                                  {{$vendorNo->vendor_name}}</option>
                                          @endforeach
                                      </select>
                                      @if($errors->has("vendor_no"))
                                          <span class="help-block">{{$errors->first("vendor_no")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>SENDING DATE</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="send_date" data-target-input="nearest">
                                          <input type="text" value="" name="send_date"
                                                 class="form-control berthing_at send_date" id="send_date_input"
                                                 data-target="#send_date" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="SENDING DATE">
                                          <div class="input-group-append" data-target="#send_date" data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("send_date"))
                                          <span class="help-block">{{$errors->first("send_date")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>RECEIVED DATE</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="receive_date" data-target-input="nearest">
                                          <input type="text" value="" name="receive_date"
                                                 class="form-control berthing_at receive_date " id="receive_date_input"
                                                 data-target="#receive_date" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="RECEIVED DATE">
                                          <div class="input-group-append" data-target="#receive_date" data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("receive_date"))
                                          <span class="help-block">{{$errors->first("receive_date")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <label>PROBLEM STATUS</label>
                              <div class="d-flex d-inline-block">
                                  <div class="custom-control custom-radio">
                                      <input type="radio" class="custom-control-input problem_solved_yn"
                                             value="Y"  name="problem_solved_yn_filter" id="customRadio3">
                                      <label class="custom-control-label cursor-pointer" for="customRadio3">RESOLVED</label>
                                  </div>&nbsp;&nbsp;
                                  <div class="custom-control custom-radio">
                                      <input type="radio" class="custom-control-input problem_solved_yn"
                                             value="N" name="problem_solved_yn_filter" id="customRadio4">
                                      <label class="custom-control-label cursor-pointer" for="customRadio4">NOT RESOLVED</label>
                                  </div>
                              </div>
                              @if($errors->has("problem_solved_yn"))
                                  <span class="help-block">{{$errors->first("problem_solved_yn")}}</span>
                              @endif
                          </div>
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="col-md-12" style="margin-top: 20px">
                                      <div class="d-flex justify-content-end">
                                          <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                              <i class="bx bx-search"></i> SEARCH
                                          </button>
                                          <button type="button" class="btn btn text-uppercase btn-dark shadow mr-1 mb-1">
                                              <i class="bx bx-reset"></i> Reset
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      {{--<div class="row">
                          <div class="col-md-12 mr-1">
                              <div class="row" style="margin-right: 2px">
                                  <div class="col-md-12 d-flex justify-content-end" style="margin-top: 20px">
                                      <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                          <i class="bx bx-search"></i> SEARCH
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>--}}
                  </form>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase" id="third_party_table"
                            data-url="{{ route('admin.third_party.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="equipment_no" title="EQUIPMENT NO">EQUIPMENT</th>
                                    <th data-col="ticket_no" title="TICKET NO">TICKET</th>
                                    <th data-col="vendor_no" title="VENDOR NO">VENDOR</th>
                                    @if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                        <th data-col="service_charge" title="SERVICE CHARGE">SERVice CHARGE</th>
                                    @endif
                                    <th data-col="problem_description" title="PROBLEM DESCRIPTION">problem description</th>
                                    <th data-col="sending_date" title="SENDING DATE">SEND DATE</th>
                                    <th data-col="received_date" title="RECEIVED DATE">receive DATE</th>
                                    {{--<th data-col="problem_solved_yn" title="PROBLEM SOLVED YN">Problem Status</th>--}}
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

        $(document).ready(function () {

            $(document).on("click", '.confirm-delete', function (e) {
                let third_party_service_id = $(this).attr('href');
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
                            url: 'third-party-service-remove',
                            data: {third_party_service_id: third_party_service_id},
                            success: function (results) {
                                if (results == "1") {
                                    Swal.fire({
                                        title: 'THIRD PARTY SERVICE DELETED SUCCESSFULLY.',
                                        confirmButtonText: 'OK',
                                        type: 'success'
                                    }).then(function () {
                                        $('#third_party_table').DataTable().ajax.reload();
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

            @if((!empty(\Request::get('id')) && empty($data)))
                let ticket_no = $('#select_ticket :selected').val();
                $('#ticket_no').val(ticket_no);
            @endif

            $(function () {
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


                dateTimePicker("#sending_date");
                dateTimePicker("#received_date");
                dateTimePicker("#receive_date");
                dateTimePicker("#send_date");
                //
                $('#sending_date_input').val(getSysDate());
                $('#received_date_input').val(getSysDate());
                // $('#send_date_input').val(getSysDate());
                // $('#receive_date_input').val(getSysDate());

            });
        });
    </script>
@endsection
