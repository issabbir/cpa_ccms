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
                          {{ $data && isset($data->equipment_add_no)?'Edit':'Add' }} Equipment
                        </h4>
                        <form method="POST" action="@if ($data && $data->equipment_add_no) {{route('equipment_add.update',['id' => $data->equipment_add_no])}} @else {{route('equipment_add.store')}} @endif">
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
                                                   value="{{ old('equipment_add_id', ($data)?$data->equipment_add_id:$gen_cat_id) }}"
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
                                                  <option {{ ( old("vendor_no", ($data)?$data->vendor_no:'') == $vendorList->vendor_no) ? "selected" : ""  }}
                                                    value="{{$vendorList->vendor_no}}">{{$vendorList->vendor_name}}
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
                                                   value="{{ old('price', ($data)?$data->price:$gen_cat_id) }}"
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
                                <div class="col-md-9">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <label class="input-required ">EQUIPMENT DESCRIPTION </label>
                                        <textarea style="height: 37px" name="equipment_description" id="equipment_description" placeholder="EQUIPMENT DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('equipment_description', ($data)?$data->equipment_description:'') }}</textarea>
                                        @if($errors->has("equipment_description"))
                                            <span class="help-block">{{$errors->first("equipment_description")}}</span>
                                        @endif
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row my-1">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end">
                                            @if (\Request::get('id'))
                                              <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">Update</button>
                                              <a href="{{ route('equipment_add.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="padding-top: 10px; font-weight: 900;">Back</a>
                                            @else
                                              <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">SAVE  </button>
                                              <button type="reset" class="btn btn btn-outline-dark  mb-1">Cancel  </button>
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
          <!--List-->
          <div class="card">
              <div class="card-header">
                  <h4 class="card-title text-uppercase">Service ticket List</h4>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('equipment_add.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="equipment_add_id" title="EQUIPMENT ADD ID">EQUIPMENT ADD ID</th>
                                    <th data-col="equipment_id" title="EQUIPMENT ID">EQUIPMENT ID</th>
                                    <th data-col="equipment_name" title="EQUIPMENT NAME">EQUIPMENT NAME</th>
                                    <th data-col="equipment_name_bn" title="EQUIPMENT NAME BANGLA">EQUIP. NAME BANGLA</th>
                                    <th data-col="quantity" title="QUANTITY">QUANTITY</th>
                                    <th data-col="vendor_no" title="VENDOR NO">VENDOR NO</th>
                                    <th data-col="manufacturer" title="MANUFACTURER">MANUFACTURER</th>
                                    <th data-col="model_no" title="MODEL NO">MODEL NO</th>
                                    <th data-col="serial_no" title="SERIAL NO">Emp. Id</th>
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


          });
    </script>
@endsection
