@extends('layouts.default')

@section('title')
    Equipment Add
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
                          {{ $data && isset($data->equipment_assign_id)?'Edit':'Add' }} Equipment Assigne
                        </h4>
                        <form method="POST" action="@if ($data && $data->equipment_assign_id) {{route('equipment_assigne.update',['id' => $data->equipment_assign_id])}} @else {{route('equipment_assigne.store')}} @endif">
                            {{ ($data && isset($data->equipment_assign_id))?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            @if ($data && $data->equipment_assign_id)
                                <input type="hidden" name="equipment_assign_id" value="{{$data->equipment_assign_id}}">
                            @endif
                            <hr>
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">EQUIPMENT ID </label>
                                            <select  id="equipment_id" name="equipment_id"
                                                     required class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($getEquipmentList as $equipmentList)
                                                  <option {{ ( old("equipment_id", ($data)?$data->equipment_id:'') == $equipmentList->equipment_id) ? "selected" : ""  }}
                                                    value="{{$equipmentList->equipment_id}}">{{$equipmentList->equipment_name}}
                                                  </option>
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
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">Department ID </label>
                                            <select  id="department_id" required name="department_id" class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($departments as $department)
                                                  <option {{ ( old("department_id", ($data)?$data->department_id:'') == $department->department_id) ? "selected" : ""  }}
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
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">SECTION ID </label>
                                            <select  id="dpt_section_id" required name="dpt_section_id" class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($sections as $section)
                                                  <option {{ ( old("dpt_section_id", ($data)?$data->section_id:'') == $section->dpt_section_id) ? "selected" : ""  }}
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
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">BUILDING NO</label>
                                            <input type="text"
                                                   id="building_no"
                                                   required
                                                   name="building_no"
                                                   value="{{ old('building_no', ($data)?$data->building_no:'') }}"
                                                   placeholder="BUILDING NO"
                                                   class="form-control text-uppercase">
                                            @if($errors->has("building_no"))
                                              <span class="help-block">{{$errors->first("building_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">ROOM NO</label>
                                            <input type="text"
                                                   id="room_no"
                                                   name="room_no"
                                                   required
                                                   value="{{ old('room_no', ($data)?$data->room_no:'') }}"
                                                   placeholder="ROOM NO"
                                                   class="form-control text-uppercase">
                                            @if($errors->has("room_no"))
                                              <span class="help-block">{{$errors->first("room_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">ASSIGN DATE<span class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                                 id="assign_date" data-target-input="nearest">
                                                <input type="text" name="assign_date"
                                                       required
                                                       value="{{ old('assign_date', ($data)?$data->assign_date:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#assign_date"
                                                       data-toggle="datetimepicker"
                                                       placeholder="PURCHASE DATE">
                                                <div class="input-group-append" data-target="#assign_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("assign_date"))
                                                <span class="help-block">{{$errors->first("assign_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="input-required required">PERSON WISE USE YN</label>
                                    <div class="d-flex d-inline-block" style="margin-top: 10px">
                                      <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input"
                                                value="{{ old('person_wise_use_yn','Y') }}" {{isset($data->person_wise_use_yn) && $data->person_wise_use_yn == 'Y' ? 'checked' : ''}} name="person_wise_use_yn" id="customRadio1" checked>
                                          <label class="custom-control-label" for="customRadio1">YES</label>
                                      </div>&nbsp;&nbsp;
                                      <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input"
                                                  value="{{ old('person_wise_use_yn','N') }}" {{isset($data->person_wise_use_yn) && $data->person_wise_use_yn == 'N' ? 'checked' : ''}} name="person_wise_use_yn" id="customRadio2">
                                          <label class="custom-control-label" for="customRadio2">NO</label>
                                      </div>
                                    </div>
                                    @if($errors->has("person_wise_use_yn"))
                                        <span class="help-block">{{$errors->first("person_wise_use_yn")}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="input-required required">ACTIVE YN</label>
                                    <div class="d-flex d-inline-block" style="margin-top: 10px">
                                      <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input"
                                                value="{{ old('active_yn','Y') }}" {{isset($data->active_yn) && $data->active_yn == 'Y' ? 'checked' : ''}} name="active_yn" id="customRadio3" checked>
                                          <label class="custom-control-label" for="customRadio3">YES</label>
                                      </div>&nbsp;&nbsp;
                                      <div class="custom-control custom-radio">
                                          <input type="radio" class="custom-control-input"
                                                  value="{{ old('active_yn','N') }}" {{isset($data->active_yn) && $data->active_yn == 'N' ? 'checked' : ''}} name="active_yn" id="customRadio4">
                                          <label class="custom-control-label" for="customRadio4">NO</label>
                                      </div>
                                    </div>
                                    @if($errors->has("active_yn"))
                                        <span class="help-block">{{$errors->first("active_yn")}}</span>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                @if (\Request::get('id'))
                                                  <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">Update</button>
                                                  <a href="{{ route('equipment_assigne.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="padding-top: 10px; font-weight: 900;">Back</a>
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
                  <h4 class="card-title text-uppercase">Service ticket List</h4>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('equipment_assigne.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="equipment_id" title="EQUIPMENT ID">EQUIPMENT ID</th>
                                    <th data-col="emp_id" title="EMP ID">EMP ID</th>
                                    <th data-col="department_id" title="DEPARTMENT ID">DEPARTMENT ID</th>
                                    <th data-col="section_id" title="SECTION ID">SECTION ID</th>
                                    <th data-col="building_no" title="BUILDING NO">BUILDING NO</th>
                                    <th data-col="room_no" title="ROOM NO">ROOM NO</th>
                                    <th data-col="assign_date" title="ASSIGN DATE">ASSIGN DATE</th>
                                    <th data-col="person_wise_use_yn" title="PERSON WISE USE YN">PERSON WISE USE YN</th>
                                    <th data-col="active_yn" title="ACTIVE YN">ACTIVE YN</th>
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
    <!--Load custom script route('service_ticket.ticket_dtl', ['id' => $data['equipment_assign_id']])-->
    <script>
          $(document).ready(function () {
              //Date time picker
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
               dateTimePicker("#assign_date");
               // dateTimePicker("#warranty_expiry_date");


          });
    </script>
@endsection
