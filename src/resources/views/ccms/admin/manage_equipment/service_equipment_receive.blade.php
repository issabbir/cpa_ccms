@extends('layouts.default')

@section('title')
    Service Equipment Receive
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body" style="@if(\Request::get('id')) display: block @else display: none @endif" id="equipment_receive_form">
                        <h4 class="card-title text-uppercase">
                          {{ $data && isset($data->receipt_no)?'Edit':'Add' }} Service Equipment Receive
                        </h4>
                        <div class="bg-rgba-secondary p-1" style="border-radius: 5px">
                            <form method="POST" action="@if ($data && $data->receipt_no) {{route('admin.equipment-receive.update',['id' => $data->receipt_no])}} @else {{route('admin.equipment-receive.store')}} @endif">
                                {{ ($data && isset($data->receipt_no))?method_field('PUT'):'' }}
                                {!! csrf_field() !!}
                                @if ($data && $data->receipt_no)
                                    <input type="hidden" name="receipt_no" value="{{$data->receipt_no}}">
                                @endif
                                <hr>
                                <div class="row mb-1">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">Receipt ID</label>
                                                <input type="text"
                                                       readonly
                                                       required
                                                       id="receipt_id"
                                                       name="receipt_id"
                                                       value="{{ old('receipt_id', ($data)?$data->receipt_id:$gen_uniq_id) }}"
                                                       placeholder="Receipt ID"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("receipt_id"))
                                                    <span class="help-block">{{$errors->first("receipt_id")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required"> TICKET NO</label>
                                                <select  name="ticket_no"  id="ticket_no"  required class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($getTicketNo as $ticketNo)
                                                        <option {{ ( old("ticket_no", ($data)?$data->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                                value="{{$ticketNo->ticket_no}}">{{$ticketNo->ticket_no}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has("ticket_no"))
                                                    <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">Equipment NO</label>
                                                <select  name="equipment_no" id="equipment_no" required class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($getEquipmentNo as $equipmentNo)
                                                        <option {{ ( old("equipment_no", ($data)?$data->equipment_no:'') == $equipmentNo->equipment_no) ? "selected" : ""  }}
                                                                value="{{$equipmentNo->equipment_no}}">{{$equipmentNo->equipment_name}}
                                                        </option>
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
                                                <label class="input-required required">SERVICE ENGINEER ID</label>
                                                <select id="service_engineer_id" required name="service_engineer_id" class="form-control select2">
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
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-3">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <label class="input-required">RECEIVED DATE<span class="required"></span></label>
                                                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="received_date" data-target-input="nearest">
                                                    <input type="text" name="received_date"
                                                           value="{{ old('received_date', ($data)?$data->received_date:'') }}"
                                                           required
                                                           class="form-control berthing_at"
                                                           id="received_date_input"
                                                           data-target="#received_date"
                                                           data-toggle="datetimepicker"
                                                           placeholder="RECEIVED DATE">
                                                    <div class="input-group-append" data-target="#received_date" data-toggle="datetimepicker">
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
                                    <div class="col-md-3">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <label>RECEIVED DOC </label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file" >
                                                    <input type="hidden" name="received_doc" id="received_doc" />
                                                    <label class="custom-file-label" for="received_doc">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-4">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <label>DELIVERY DOC </label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file1" >
                                                    <input type="hidden" name="delivery_doc" id="delivery_doc" />
                                                    <label class="custom-file-label" for="delivery_doc">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>--}}
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required ">RECEIVED NOTE</label>
                                                <textarea name="received_note" id="editor" placeholder="RECEIVED NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('received_note', ($data)?$data->received_note:'') }}</textarea>
                                                @if($errors->has("received_note"))
                                                    <span class="help-block">{{$errors->first("received_note")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-end" style="margin-top: 45px">
                                                    @if (\Request::get('id'))
                                                        <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                            <i class="bx bx-edit-alt"></i> Update</button>
                                                        <a href="{{ route('admin.equipment-receive.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="font-weight: 900;">
                                                            <i class="bx bx-arrow-back"></i> Back</a>
                                                    @else
                                                        <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                            <i class="bx bx-save"></i> SAVE  </button>
                                                        <button type="button" onclick="$('#equipment_receive_form').hide('slow')" class="btn btn btn-outline-dark  mb-1">
                                                            <i class="bx bx-window-close"></i> Cancel  </button>
                                                    @endif
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

        </div>
          <!--List-->
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          <h4 class="card-title text-uppercase">Service Equipment Receive List</h4>
                      </div>
                      <div class="col-md-6">
                          <div class="row float-right">
                              <form name="report_form" id="report_form" target="_blank" action="{{route('report', ['title' => 'Equipment-Receive'])}}">
                                  {{csrf_field()}}
                                  <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_RECEIVE_LIST.xdo" />
                                  <input type="hidden" name="type" id="type" value="pdf" />
                                  <input type="hidden" name="p_equipment_no" id="p_equipment_no" />
                                  <input type="hidden" name="p_service_engineer_id" id="p_service_engineer_id" />
                                  <input type="hidden" name="p_start_date" id="p_start_date" />
                                  <input type="hidden" name="p_end_date" id="p_end_date" />
                                  @section('footer-script')
                                      @parent
                                      <script>
                                          $(document).ready(function() {
                                              $("#report_pdf_action").on('click',function() {
                                                  var report_form = $("#report_form");
                                                  var filter_form = $("#datatable_filter_form");
                                                  report_form.find('#type').val("pdf");
                                                  report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                                  report_form.find('#p_service_engineer_id').val(filter_form.find('select.service_engineer_id').val());
                                                  report_form.find('#p_start_date').val(filter_form.find('input.received_start_date').val());
                                                  report_form.find('#p_end_date').val(filter_form.find('input.received_end_date').val());
                                                  report_form.submit();
                                              });

                                              $("#report_xlsx_action").on('click',function() {
                                                  var report_form = $("#report_form");
                                                  var filter_form = $("#datatable_filter_form");
                                                  report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                                  report_form.find('#p_service_engineer_id').val(filter_form.find('select.service_engineer_id').val());
                                                  report_form.find('#p_start_date').val(filter_form.find('input.received_start_date').val());
                                                  report_form.find('#p_end_date').val(filter_form.find('input.received_end_date').val());
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
                              <button onclick="$('#datatable_filter_form').toggle('slow')" class="btn btn-secondary mb-1 mr-1 hvr-underline-reveal">
                                  <i class="bx bx-filter-alt"></i> Filter</button>
                              {{--<button id="show_form" class="btn btn-secondary mb-1">
                                  <i class="bx bx-plus"></i> Add New</button>--}}
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
                                      <label>Equipment NO</label>
                                      <select  name="equipment_no" class="form-control select2 equipment_no">
                                          <option value="">Select one</option>
                                          @foreach($getEquipmentNo as $equipmentNo)
                                              <option {{ ( old("equipment_no", ($data)?$data->equipment_no:'') == $equipmentNo->equipment_no) ? "selected" : ""  }}
                                                      value="{{$equipmentNo->equipment_no}}">{{$equipmentNo->equipment_name}}
                                              </option>
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
                                      <label>SERVICE ENGINEER ID</label>
                                      <select name="service_engineer_id" class="form-control select2 service_engineer_id">
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
                                      <label>RECEIVED Start Date</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="received_start_date" data-target-input="nearest">
                                          <input type="text" name="received_start_date"
                                                 value="" id="received_start_date_input"
                                                 class="form-control berthing_at received_start_date"
                                                 data-target="#received_start_date" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="RECEIVED START DATE">
                                          <div class="input-group-append" data-target="#received_start_date" data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("received_start_date"))
                                          <span class="help-block">{{$errors->first("received_start_date")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>RECEIVED End Date</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="received_end_date" data-target-input="nearest">
                                          <input type="text" value="" name="received_end_date" id="received_end_date_input"
                                                 class="form-control berthing_at received_end_date"
                                                 data-target="#received_end_date" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="RECEIVED END DATE">
                                          <div class="input-group-append" data-target="#received_end_date" data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("received_end_date"))
                                          <span class="help-block">{{$errors->first("received_end_date")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>

                          {{--  <div class="col-md-2 ml-1">
                               <div class="row">
                                   <div class="col-md-12" style="margin-top: 20px">
                                       <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                           <i class="bx bx-search"></i> SEARCH
                                       </button>
                                   </div>
                               </div>
                           </div> --}}

                      </div>
                      <div class="row">
                          <div class="col-md-12 mr-1">
                              <div class="row" style="margin-right: 2px">
                                  <div class="col-md-12 d-flex justify-content-end" style="margin-top: 20px">
                                      <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                          <i class="bx bx-search"></i> SEARCH
                                      </button>
                                      <button type="button"     class="btn btn btn-dark shadow reset-btn mr-1 mb-1">
                                          <i class="bx bx-reset" ></i> Reset
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </form>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('admin.equipment-receive.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="receipt_id" title="RECEIPT ID">RECEIPT ID</th>
                                    <th data-col="ticket_id" title="TICKET ID">TICKET ID</th>
                                    <th data-col="equipment_name" title="EQUIPMENT NO">EQUIPMENT</th>
{{--                                    <th data-col="service_engineer_name" title="SERVICE ENGINEER ID">SERV. ENGINEER</th>--}}
                                    <th data-col="received_note" title="RECEIVED NOTE">RECEIVED NOTE</th>
                                    <th data-col="received_date" title="RECEIVED DATE">RECEIVED DATE</th>
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
@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>

        $(document).ready(function () {
             //Date time picker
            hideNseek(document.getElementById("equipment_receive_form"), document.getElementById("show_form"))
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

             datePicker("#received_date");
             datePicker("#received_start_date");
             datePicker("#received_end_date");
            //dateTimePicker("#occurance_date");
            dateTimePicker("#meeting_end_time");
            dateTimePicker("#meeting_start_time");

            $('#received_date_input').val(getSysDate());
             // $('#received_end_date_input').val(getSysDate());
             // $('#received_start_date_input').val(getSysDate());

            $(".reset-btn").click(function () {
                $("#datatable_filter_form").trigger("reset");
                $(document).find('#datatable_filter_form select').val('').trigger('change');
                $("#datatable_filter_form").submit();
            });

            function getBase64(file) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    $(document).find('#received_doc').val(reader.result);
                    $(document).find('#delivery_doc').val(reader.result);
                    console.log(reader.result);
                };
                reader.onerror = function (error) {
                    console.log('Error: ', error);
                };
            }

            $("#file").on('change', function(){
                var file = document.querySelector('#file').files[0];
                getBase64(file); // prints the base64 string
            });

            $("#file1").on('change', function(){
                var file = document.querySelector('#file1').files[0];
                getBase64(file); // prints the base64 string
            });

        });
    </script>
@endsection
