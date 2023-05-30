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
                          {{ $data && isset($data->receipt_no)?'Edit':'Add' }} Service Equipment Receive
                        </h4>
                        <form method="POST" action="@if ($data && $data->receipt_no) {{route('equipment_receive.update',['id' => $data->receipt_no])}} @else {{route('equipment_receive.store')}} @endif">
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
                                <div class="col-md-6">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <label class="input-required ">RECEIVED NOTE</label>
                                        <textarea style="height: 37px" name="received_note" id="received_note" placeholder="RECEIVED NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('received_note', ($data)?$data->received_note:'') }}</textarea>
                                        @if($errors->has("received_note"))
                                            <span class="help-block">{{$errors->first("received_note")}}</span>
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
                            </div>
                            <div class="row">
                                <div class="col-md-3">
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
                                </div>
                                <div class="col-md-9">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div class="d-flex justify-content-end" style="margin-top: 20px">
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
          <!--List-->
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title text-uppercase">Service Equipment Receive List</h4>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('equipment_receive.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="receipt_id" title="RECEIPT ID">RECEIPT ID</th>
                                    <th data-col="ticket_no" title="TICKET NO">TICKET NO</th>
                                    <th data-col="equipment_no" title="EQUIPMENT NO">EQUIPMENT NO</th>
                                    <th data-col="received_date" title="RECEIVED DATE">RECEIVED DATE</th>
                                    <th data-col="received_note" title="RECEIVED NOTE">RECEIVED NOTE</th>
                                    <th data-col="service_engineer_id" title="SERVICE ENGINEER ID">SERV. ENGINEER</th>
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
            //dateTimePicker("#occurance_date");
            dateTimePicker("#meeting_end_time");
            dateTimePicker("#meeting_start_time");


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
