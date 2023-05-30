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
                        <h4 class="card-title">
                          {{ $data && isset($data->third_party_service_id)?'Edit':'Add' }} Third Party Service
                        </h4>
                        <form method="POST" action="
                        @if ($data && $data->third_party_service_id)
                        {{route('third_party.update',['id' => $data->third_party_service_id])}}
                        @else {{route('third_party.store')}} @endif">
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
                                          <label class="input-required required">Equipment ID</label>
                                          <select  id="equipment_id" name="equipment_id" class="form-control select2">
                                              <option value="">Select one</option>
                                              @foreach($getEquipmentID as $equipmentID)
                                                <option {{ ( old("equipment_id", ($data)?$data->equipment_id:'') == $equipmentID->equipment_id) ? "selected" : ""  }}
                                                  value="{{$equipmentID->equipment_id}}">
                                                  {{$equipmentID->equipment_name}}</option>
                                              @endforeach
                                          </select>
                                          @if($errors->has("equipment_id"))
                                              <span class="help-block">{{$errors->first("equipment_id")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>

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
                                <div class="col-md-6">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <label class="input-required required">PROBLEM DESCRIPTION </label>
                                          <textarea style="height: 37px" name="problem_description" id="problem_description" placeholder="PROBLEM DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('problem_description', ($data)?$data->problem_description:'') }}</textarea>
                                          @if($errors->has("problem_description"))
                                              <span class="help-block">{{$errors->first("problem_description")}}</span>
                                          @endif
                                      </div>
                                  </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="input-required required">PROBLEM SOLVED YN</label>
                                    <div class="d-flex d-inline-block">
                                      <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input"
                                                value="{{ old('problem_solved_yn','Y') }}" {{isset($data->problem_solved_yn) && $data->problem_solved_yn == 'Y' ? 'checked' : ''}} name="problem_solved_yn" id="customRadio1" checked>
                                          <label class="custom-control-label" for="customRadio1">YES</label>
                                      </div>&nbsp;&nbsp;
                                      <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input"
                                                  value="{{ old('problem_solved_yn','N') }}" {{isset($data->problem_solved_yn) && $data->problem_solved_yn == 'N' ? 'checked' : ''}} name="problem_solved_yn" id="customRadio2">
                                          <label class="custom-control-label" for="customRadio2">NO</label>
                                      </div>
                                    </div>
                                    @if($errors->has("problem_solved_yn"))
                                        <span class="help-block">{{$errors->first("problem_solved_yn")}}</span>
                                    @endif
                                </div>
                                <div class="col-md-9" style="margin-top: 10px">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                @if (\Request::get('id'))
                                                  <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">Update</button>
                                                  <a href="{{ route('third_party.index') }}" class="btn btn-outline-secondary mb-1" style="padding-top: 10px; font-weight: 900;">Back</a>
                                                @else
                                                  <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">SAVE  </button>
                                                  <button type="reset" class="btn btn-outline-dark  mb-1">Cancel  </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

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
                  <h4 class="card-title text-uppercase">Third Party Service List</h4>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('third_party.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="equipment_id" title="EQUIPMENT ID">EQUIPMENT</th>
                                    <th data-col="ticket_no" title="TICKET NO">TICKET</th>
                                    <th data-col="vendor_no" title="VENDOR NO">VENDOR</th>
                                    <th data-col="service_charge" title="SERVICE CHARGE">SERV. CHARGE</th>
                                    <th data-col="sending_date" title="SENDING DATE">SEND. DATE</th>
                                    <th data-col="received_date" title="RECEIVED DATE">RECE. DATE</th>
                                    <th data-col="problem_description" title="PROBLEM DESCRIPTION">PROB. DES.</th>
                                    <th data-col="problem_solved_yn" title="PROBLEM SOLVED YN">PROB. SOLVED?</th>
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
            $(function () {
                $('#sending_date').datetimepicker(
                    {
                        format: 'DD-MM-YYYY',
                    }
                );
                $('#received_date').datetimepicker(
                    {
                        format: 'DD-MM-YYYY',
                    }
                );

                $.extend(true, $.fn.datetimepicker.defaults, {
                  icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                  }
                });

            });
        });
    </script>
@endsection
