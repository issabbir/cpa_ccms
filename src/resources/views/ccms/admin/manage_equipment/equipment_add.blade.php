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
                    <div class="card-body" style="@if(\Request::get('id')) display: block @else display: none @endif" id="equipment_add_form">
                        <h4 class="card-title text-uppercase">
                          {{ $data && isset($data->equipment_add_no)?'Edit':'Add' }} Equipment
                        </h4>
                        {{--<div class="bg-rgba-secondary p-1" style="border-radius: 5px">--}}
                        <div>
                            <form method="POST" action="@if ($data && $data->equipment_add_no) {{route('admin.equipment-add.update',['id' => $data->equipment_add_no])}} @else {{route('admin.equipment-add.store')}} @endif">
                                {{ ($data && isset($data->equipment_add_no))?method_field('PUT'):'' }}
                                {!! csrf_field() !!}
                                @if ($data && $data->equipment_add_no)
                                    <input type="hidden" name="equipment_add_no" value="{{$data->equipment_add_no}}">
                                @endif
                                <hr>
                                <div class="row mb-1">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">Equipment Add Id</label>
                                                <input type="text"
                                                       readonly
                                                       required
                                                       id="equipment_add_id"
                                                       name="equipment_add_id"
                                                       value="{{ old('equipment_add_id', ($data)?$data->equipment_add_id:$gen_equpment_add_id) }}"
                                                       placeholder="Equipment Add"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("equipment_add_id"))
                                                    <span class="help-block">{{$errors->first("equipment_add_id")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">EQUIPMENT ID </label>
                                                <select  id="equipment_id" name="equipment_id"  required class="form-control select2">
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
                                                <label class="input-required required">Equipment Name</label>
                                                <input type="text"
                                                       id="equipment_name"
                                                       required
                                                       name="equipment_name"
                                                       value="{{ old('equipment_name', ($data)?$data->equipment_name:'') }}"
                                                       placeholder="Equipment Name"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("equipment_name"))
                                                    <span class="help-block">{{$errors->first("equipment_name")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required ">Equipment Name Bangla</label>
                                                <input type="text"
                                                       id="equipment_name_bn"
                                                       name="equipment_name_bn"
                                                       value="{{ old('equipment_name_bn', ($data)?$data->equipment_name_bn:'') }}"
                                                       placeholder="Equipment Name Bangla"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("equipment_name_bn"))
                                                    <span class="help-block">{{$errors->first("equipment_name_bn")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">QUANTITY</label>
                                                <input type="number"
                                                       id="quantity"
                                                       required
                                                       name="quantity"
                                                       value="{{ old('quantity', ($data)?$data->quantity:'') }}"
                                                       placeholder="Equipment Add"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("quantity"))
                                                    <span class="help-block">{{$errors->first("quantity")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">VENDOR NO</label>
                                                <select id="vendor_no" required name="vendor_no" class="form-control select2">
                                                    <option value="">Select one</option>
                                                    @foreach($getVendorList as $vendorList)
                                                        <option {{ ( old("vendor_no", ($data)?$data->vendor_no:'') == $vendorList->vendor_id) ? "selected" : ""  }}
                                                                value="{{$vendorList->vendor_id}}">{{$vendorList->vendor_name}}
                                                        </option>
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
                                                <label class="input-required required">MANUFACTURER</label>
                                                <input type="text"
                                                       id="manufacturer"
                                                       required
                                                       name="manufacturer"
                                                       value="{{ old('manufacturer', ($data)?$data->manufacturer:'') }}"
                                                       placeholder="MANUFACTURER"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("manufacturer"))
                                                    <span class="help-block">{{$errors->first("manufacturer")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">MODEL NO</label>
                                                <input type="text"
                                                       id="model_no"
                                                       required
                                                       maxlength="50"
                                                       name="model_no"
                                                       value="{{old('model_no', ($data)?$data->model_no:'')}}"
                                                       placeholder="MODEL NO"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("model_no"))
                                                    <span class="help-block">{{$errors->first("model_no")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">SERIAL NO</label>
                                                <input type="text"
                                                       id="serial_no"
                                                       required
                                                       name="serial_no"
                                                       value="{{ old('serial_no', ($data)?$data->serial_no:'') }}"
                                                       placeholder="SERIAL NO"
                                                       class="form-control text-uppercase">
                                                @if($errors->has("serial_no"))
                                                    <span class="help-block">{{$errors->first("serial_no")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required required">PRICE</label>
                                                <input type="number"
                                                       id="price"
                                                       required
                                                       name="price"
                                                       value="{{ old('price', ($data)?$data->price:$gen_equpment_add_id) }}"
                                                       placeholder="PRICE"
                                                       class="form-control text-uppercase"
                                                />
                                                @if($errors->has("price"))
                                                    <span class="help-block">{{$errors->first("price")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <label class="input-required">PURCHASE DATE<span class="required"></span></label>
                                                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                                     id="purchase_date" data-target-input="nearest">
                                                    <input type="text" name="purchase_date"
                                                           required
                                                           value="{{ old('purchase_date', ($data)?$data->purchase_date:'') }}"
                                                           class="form-control berthing_at"
                                                           data-target="#purchase_date"
                                                           id="purchase_date_input"
                                                           data-toggle="datetimepicker"
                                                           placeholder="PURCHASE DATE">
                                                    <div class="input-group-append" data-target="#purchase_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text">
                                                            <i class="bx bx-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($errors->has("purchase_date"))
                                                    <span class="help-block">{{$errors->first("purchase_date")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <label class="input-required required">WARRANTY EXPIRY DATE<span class=""></span></label>
                                                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                                     id="warranty_expiry_date" data-target-input="nearest">
                                                    <input type="text" name="warranty_expiry_date"
                                                           required
                                                           value="{{ old('warranty_expiry_date',
                                                       ($data)?$data->warranty_expiry_date:'') }}"
                                                           class="form-control berthing_at"
                                                           id="warranty_expiry_date_input"
                                                           data-target="#warranty_expiry_date"
                                                           data-toggle="datetimepicker"
                                                           placeholder="WARRANTY EXPIRY DATE">
                                                    <div class="input-group-append" data-target="#warranty_expiry_date" data-toggle="datetimepicker">
                                                        <div class="input-group-text">
                                                            <i class="bx bx-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($errors->has("warranty_expiry_date"))
                                                    <span class="help-block">{{$errors->first("warranty_expiry_date")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="input-required ">EQUIPMENT DESCRIPTION </label>
                                                <textarea name="equipment_description" id="equipment_description" placeholder="EQUIPMENT DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('equipment_description', ($data)?$data->equipment_description:'') }}</textarea>
                                                @if($errors->has("equipment_description"))
                                                    <span class="help-block">{{$errors->first("equipment_description")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row my-1">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-end" style="margin-top: 26px">
                                                    @if (\Request::get('id'))
                                                        <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                            <i class="bx bx-edit-alt"></i> Update</button>
                                                        <a href="{{ route('admin.equipment-add.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="font-weight: 900;">
                                                            <i class="bx bx-arrow-back"></i> Back</a>
                                                    @else
                                                        <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                            <i class="bx bx-save"></i> SAVE  </button>
                                                        <button type="button" onclick="$('#equipment_add_form').hide('slow')" class="btn btn btn-outline-dark  mb-1">
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
          <!--List-->
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          <h4 class="card-title text-uppercase">Equipment Item List</h4>
                      </div>
                      <div class="col-md-6">
                          <div class="row float-right">
                              <form name="report_form" id="report_form" target="_blank" action="{{route('report', ['title' => 'Equipment-Add'])}}">
                                  {{csrf_field()}}
                                  <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_SERVICE_EQUIPMENT_ADD_LIST.xdo"/>
                                  <input type="hidden" name="type" id="type" value="pdf" />
                                  <input type="hidden" name="p_equipment_no" id="p_equipment_no" />
                                  <input type="hidden" name="p_vendor_no" id="p_vendor_no" />
                                  <input type="hidden" name="p_manufacturer" id="p_manufacturer" />
                                  <input type="hidden" name="p_start_date" id="p_start_date" />
                                  <input type="hidden" name="p_end_date" id="p_end_date" />
                                  <input type="hidden" name="p_warranty_expiry_date_start" id="p_warranty_expiry_date_start" />
                                  <input type="hidden" name="p_warranty_expiry_date_end" id="p_warranty_expiry_date_end" />
                                  <input type="hidden" name="p_equipment_id" id="p_equipment_id" />


                                  @section('footer-script')
                                      @parent
                                      <script>
                                          $(document).ready(function() {

                                              $("#report_pdf_action").on('click',function() {

                                                  var report_form = $("#report_form");
                                                  var filter_form = $("#datatable_filter_form");
                                                  report_form.find('#type').val("pdf");
                                                  report_form.find('#p_vendor_no').val(filter_form.find('select.vendor_no').val());
                                                  report_form.find('#p_manufacturer').val(filter_form.find('select.manufacturer').val());
                                                  report_form.find('#p_start_date').val(filter_form.find('input.purchase_start_date').val());
                                                  report_form.find('#p_end_date').val(filter_form.find('input.purchase_end_date').val());
                                                  report_form.find('#p_warranty_expiry_date_start').val(filter_form.find('input.warranty_expiry_date_start').val());
                                                  report_form.find('#p_warranty_expiry_date_end').val(filter_form.find('input.warranty_expiry_date_end').val());
                                                  report_form.find('#p_equipment_id').val(filter_form.find('select.equipment_id').val());
                                                  report_form.submit();
                                              });

                                              $("#report_xlsx_action").on('click',function() {
                                                  var report_form = $("#report_form");
                                                  var filter_form = $("#datatable_filter_form");
                                                  report_form.find('#type').val("xlsx");
                                                  report_form.find('#p_vendor_no').val(filter_form.find('select.vendor_no').val());
                                                  report_form.find('#p_manufacturer').val(filter_form.find('select.manufacturer').val());
                                                  report_form.find('#p_start_date').val(filter_form.find('input.purchase_start_date').val());
                                                  report_form.find('#p_end_date').val(filter_form.find('input.purchase_end_date').val());
                                                  report_form.find('#p_warranty_expiry_date_start').val(filter_form.find('input.warranty_expiry_date_start').val());
                                                  report_form.find('#p_warranty_expiry_date_end').val(filter_form.find('input.warranty_expiry_date_end').val());
                                                  report_form.find('#p_equipment_id').val(filter_form.find('select.equipment_id').val());
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
                              {{--<button id="show_form" class="btn btn-secondary mb-1 hvr-underline-reveal">
                                  <i class="bx bx-plus"></i> Add New</button>--}}
                          </div>
                      </div>
                  </div>
              </div>
              <div class="bg-rgba-secondary mr-2 ml-2" style="border-radius: 5px">
                  <form style="display: none;padding: 1rem 0" id="datatable_filter_form" method="POST">
                      <div class="row ml-1 mb-1 mr-1">
                          <div class="col-md-3">
                              <div class="row">
                                  <div class="col-md-12">
                                      <label>EQUIPMENT ID </label>
                                      <select  name="equipment_id" class="form-control select2 equipment_id">
                                          <option value="">Select one</option>
                                          @foreach($getEquipmentList as $equipmentList)
                                              <option value="{{$equipmentList->equipment_id}}">{{$equipmentList->equipment_name}}
                                              </option>
                                              {{--<option {{ ( old("equipment_id", ($data)?$data->equipment_id:'') == $equipmentList->equipment_id) ? "selected" : ""  }}
                                                      value="{{$equipmentList->equipment_id}}">{{$equipmentList->equipment_name}}
                                              </option>--}}
                                          @endforeach
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row">
                                  <div class="col-md-12">
                                      <label>VENDOR NO</label>
                                      <select name="vendor_no" class="form-control select2 vendor_no ">
                                          <option value="">Select one</option>
                                          @foreach($getVendorList as $vendorList)
                                              <option value="{{$vendorList->vendor_id}}">{{$vendorList->vendor_name}}
                                              </option>
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
                                      <label>MANUFACTURER</label>
                                      <select name="manufacturer" class="form-control select2 manufacturer">
                                          <option value="">Select one</option>
                                          @foreach($getManufacturerList as $manufacturerList)
                                              <option
                                                  value="{{$manufacturerList->manufacturer}}">{{$manufacturerList->manufacturer}}
                                              </option>
                                          @endforeach
                                      </select>
                                      @if($errors->has("manufacturer"))
                                          <span class="help-block">{{$errors->first("manufacturer")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>PURCHASE Start Date</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                           id="purchase_start_date" data-target-input="nearest">
                                          <input type="text" name="purchase_start_date"
                                                 value="" id="purchase_start_date_input"
                                                 class="form-control berthing_at purchase_start_date"
                                                 data-target="#purchase_start_date" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="PURCHASE START DATE">
                                          <div class="input-group-append" data-target="#purchase_start_date"
                                               data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("purchase_start_date"))
                                          <span class="help-block">{{$errors->first("purchase_start_date")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row ml-1 mb-1 mr-1">
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>PURCHASE End Date</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                           id="purchase_end_date" data-target-input="nearest">
                                          <input type="text" value="" name="purchase_end_date"
                                                 class="form-control berthing_at purchase_end_date" id="purchase_end_date_input"
                                                 data-target="#purchase_end_date" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="PURCHASE END DATE">
                                          <div class="input-group-append" data-target="#purchase_end_date"
                                               data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("purchase_end_date"))
                                          <span class="help-block">{{$errors->first("purchase_end_date")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>WARRANTY EXPIRY DATE START</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                           id="warranty_expiry_date_start" data-target-input="nearest">
                                          <input type="text" name="warranty_expiry_date_start"
                                                 value="" id="warranty_expiry_date_start_input"
                                                 class="form-control berthing_at warranty_expiry_date_start"
                                                 data-target="#warranty_expiry_date_start" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="WARRANTY EXPIRY DATE START">
                                          <div class="input-group-append" data-target="#warranty_expiry_date_start"
                                               data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("warranty_expiry_date_start"))
                                          <span class="help-block">{{$errors->first("warranty_expiry_date_start")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row ">
                                  <div class="col-md-12">
                                      <label>WARRANTY EXPIRY DATE END</label>
                                      <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                           id="warranty_expiry_date_end" data-target-input="nearest">
                                          <input type="text" value="" name="warranty_expiry_date_end"
                                                 class="form-control berthing_at warranty_expiry_date_end" id="warranty_expiry_date_end_input"
                                                 data-target="#warranty_expiry_date_end" autocomplete="off"
                                                 data-toggle="datetimepicker"
                                                 placeholder="WARRANTY EXPIRY DATE END">
                                          <div class="input-group-append" data-target="#warranty_expiry_date_end"
                                               data-toggle="datetimepicker">
                                              <div class="input-group-text">
                                                  <i class="bx bx-calendar"></i>
                                              </div>
                                          </div>
                                      </div>
                                      @if($errors->has("warranty_expiry_date_end"))
                                          <span class="help-block">{{$errors->first("warranty_expiry_date_end")}}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="row">
                                  <div class="col-md-12 d-flex justify-content-end" style="margin-top: 24px">
                                      <button type="submit" name="search" data-toggle="tooltip" data-placement="bottom" title="SEARCH" class="btn btn btn-dark shadow mr-1 mb-1">
                                          <i class="bx bx-search"></i>
                                      </button>
                                      <button type="button" data-toggle="tooltip" data-placement="bottom" title="RESET" class="btn btn btn-dark shadow reset-btn mr-1 mb-1">
                                          <i class="bx bx-reset" ></i>
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
                            data-url="{{ route('admin.equipment-add.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="equipment_add_id" title="EQUIPMENT ADD ID">EQUIPMENT ADD ID</th>
                                    <th data-col="equipment_id" title="EQUIPMENT ID">EQUIPMENT ID</th>
                                    <th data-col="equipment_name" title="EQUIPMENT NAME">EQUIPMENT ITEM NAME</th>
                                    {{--<th data-col="equipment_name_bn" title="EQUIPMENT NAME BANGLA">EQUIPMENT ITEM NAME BANGLA</th>--}}
                                    <th data-col="quantity" title="QUANTITY">QUANTITY</th>
                                    <th data-col="vendor_name" title="VENDOR NO">VENDOR NAME</th>
                                    <th data-col="manufacturer" title="MANUFACTURER">MANUFACTURER</th>
                                    <th data-col="model_no" title="MODEL NO">MODEL NO</th>
                                    <th data-col="serial_no" title="SERIAL NO">SERIAL NO</th>
                                    <th data-col="price" title="PRICE">PRICE</th>
                                    <th data-col="purchase_date" title="PURCHASE DATE">PURCHASE DATE</th>
                                    <th data-col="warranty_expiry_date" title="WARRANTY EXPIRY DATE">EXPIRY DATE</th>
                                    <th data-col="equipment_description" title="EQUIPMENT DESCRIPTION">EQUIP. DESC.</th>
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
    <!--Load custom script route('service_ticket.ticket_dtl', ['id' => $data['equipment_add_no']])-->
    <script>
          $(document).ready(function () {
              hideNseek(document.getElementById("equipment_add_form"), document.getElementById("show_form"))
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
              dateTimePicker("#purchase_date");
              dateTimePicker("#warranty_expiry_date");
              dateTimePicker("#purchase_end_date");
              dateTimePicker("#purchase_start_date");
              dateTimePicker("#warranty_expiry_date_start");
              dateTimePicker("#warranty_expiry_date_end");

              $('#purchase_date_input').val(getSysDate());
              $('#warranty_expiry_date_input').val(getSysDate());
              // $('#purchase_end_date_input').val(getSysDate());
              // $('#purchase_start_date_input').val(getSysDate());
              // $('#warranty_expiry_date_end_input').val(getSysDate());
              // $('#warranty_expiry_date_start_input').val(getSysDate());

              $(".reset-btn").click(function () {
                  $("#datatable_filter_form").trigger("reset");
                  $(document).find('#datatable_filter_form select').val('').trigger('change');
                  $("#datatable_filter_form").submit();
              });

          });
    </script>
@endsection
