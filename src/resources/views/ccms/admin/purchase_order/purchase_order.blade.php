@extends('layouts.default')

@section('title')
    Purchase Order List
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
          <!--List-->
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header d-flex justify-content-between">
                      <h4 class="card-title">Requisition Order List</h4>
                      <div class="row">
                          <form name="report_form" id="report_form" target="_blank" action="{{route('report', ['title' => 'Requisitions'])}}">
                              {{csrf_field()}}
                              <input type="hidden" name="xdo" value="/~weblogic/CCMS/RPT_REQUISITION_ORDER_LIST.xdo"/>
                              <input type="hidden" name="type" id="type" value="pdf" />
                              <input type="hidden" name="p_requisition_mst_no" id="p_requisition_mst_no" />
                              <input type="hidden" name="p_equipment_no" id="p_equipment_no" />
                              <input type="hidden" name="p_start_date" id="p_start_date" />
                              <input type="hidden" name="p_end_date" id="p_end_date" />
                              <input type="hidden" name="p_received_yn" id="p_received_yn" />

                              @section('footer-script')
                                  @parent
                                  <script>
                                      $(document).ready(function() {

                                          $("#report_pdf_action").on('click',function() {

                                              var report_form = $("#report_form");
                                              var filter_form = $("#datatable_filter_form");
                                              report_form.find('#type').val("pdf");
                                              report_form.find('#p_requisition_mst_no').val(filter_form.find('select.requisition_mst_no').val());
                                              report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                              report_form.find('#p_start_date').val(filter_form.find('input.insert_start_date').val());
                                              report_form.find('#p_end_date').val(filter_form.find('input.insert_end_date').val());

                                              var selected = $("input[type='radio'][name='received_yn']:checked");
                                              if (selected.length > 0) {
                                                  report_form.find('#p_received_yn').val(selected.val());
                                              }
                                              report_form.submit();
                                          });

                                          $("#report_xlsx_action").on('click',function() {
                                              var report_form = $("#report_form");
                                              var filter_form = $("#datatable_filter_form");
                                              report_form.find('#type').val("xlsx");
                                              report_form.find('#p_requisition_mst_no',).val(filter_form.find('select.requisition_mst_no').val());
                                              report_form.find('#p_equipment_no').val(filter_form.find('select.equipment_no').val());
                                              report_form.find('#p_start_date').val(filter_form.find('input.insert_start_date').val());
                                              report_form.find('#p_end_date').val(filter_form.find('input.insert_end_date').val());

                                              var selected = $("input[type='radio'][name='ticket_internal_external']:checked");
                                              if (selected.length > 0) {
                                                  report_form.find('#p_ticket_internal_external_yn').val(selected.val());
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
                          <button onclick="$('#datatable_filter_form').toggle('slow')" class="btn btn-secondary mb-1 hvr-underline-reveal">
                              <i class="bx bx-filter-alt"></i> Filter</button>
                          {{--<button id="show_form" onclick="$('#equip_req_form').toggle('slow')" class="btn btn-secondary mb-1 ml-1 hvr-underline-reveal">
                          <i class="bx bx-plus"></i> Add New</button>--}}
                      </div>
                  </div>
                  <div class="bg-rgba-secondary mr-2 ml-2" style="border-radius: 5px">
                      <form style="display: none;padding: 1rem 0" id="datatable_filter_form" method="POST">
                          <div class="row ml-1" style="margin-right: 10px">

                              <div class="col-md-3">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <label>Requisition Mst No</label>
                                          <select id="requisition_mst_no_filter" name="requisition_mst_no" class="form-control select2 requisition_mst_no">
                                              <option value="">Select one</option>
                                              @foreach($getRequisitionMasterNo1 as $requisitionMasterNo)
                                                  <option value="{{$requisitionMasterNo->requisition_mst_no}}">{{$requisitionMasterNo->requisition_mst_no}}</option>
                                              @endforeach
                                          </select>
                                          @if($errors->has("requisition_mst_no"))
                                              <span class="help-block">{{$errors->first("requisition_mst_no")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <label>Equipment Name</label>
                                          <select id="equipment_id_filter" name="equipment_no" class="form-control select2 equipment_no">
                                              <option value="">Select one</option>
                                              @foreach($getEquipmentID as $equipmentID)
                                                  <option value="{{$equipmentID->equipment_no}}">{{$equipmentID->equipment_name}}</option>
                                              @endforeach
                                          </select>
                                          @if($errors->has("equipment_id"))
                                              <span class="help-block">{{$errors->first("equipment_id")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="row ">
                                      <div class="col-md-12">
                                          <label>From Date</label>
                                          <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                               id="insert_start_date" data-target-input="nearest">
                                              <input type="text" name="insert_start_date"
                                                     value=""
                                                     class="form-control insert_start_date"
                                                     data-target="#insert_start_date" id="insert_start_date_input"
                                                     data-toggle="datetimepicker" autocomplete="off"
                                                     placeholder="From Date">
                                              <div class="input-group-append" data-target="#insert_start_date"
                                                   data-toggle="datetimepicker">
                                                  <div class="input-group-text">
                                                      <i class="bx bx-calendar"></i>
                                                  </div>
                                              </div>
                                          </div>
                                          @if($errors->has("insert_start_date"))
                                              <span class="help-block">{{$errors->first("insert_start_date")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-3">
                                  <div class="row ">
                                      <div class="col-md-12">
                                          <label>To Date</label>
                                          <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                               id="insert_end_date" data-target-input="nearest">
                                              <input type="text" name="insert_end_date"
                                                     value=""
                                                     class="form-control requisition_end_date"
                                                     data-target="#insert_end_date" id="insert_end_date_input"
                                                     data-toggle="datetimepicker" autocomplete="off"
                                                     placeholder="To Date">
                                              <div class="input-group-append" data-target="#insert_end_date"
                                                   data-toggle="datetimepicker">
                                                  <div class="input-group-text">
                                                      <i class="bx bx-calendar"></i>
                                                  </div>
                                              </div>
                                          </div>
                                          @if($errors->has("insert_end_date"))
                                              <span class="help-block">{{$errors->first("insert_end_date")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>

                          </div>
                          <div class="row ml-1" style="margin-right: 10px">
                              <div class="col-md-3">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <label>Received Status</label>
                                          <div class="d-flex d-inline-block" style="margin-top: 10px">
                                              <div class="custom-control custom-radio mr-1">
                                                  <input type="radio" class="custom-control-input " value="Y" name="received_yn" id="customRadio3"/>
                                                  <label class="custom-control-label cursor-pointer" for="customRadio3">YES</label>
                                              </div>&nbsp;&nbsp;
                                              <div class="custom-control custom-radio">
                                                  <input type="radio" class="custom-control-input" value="N" name="received_yn" id="customRadio4"/>
                                                  <label class="custom-control-label cursor-pointer" for="customRadio4">NO</label>
                                              </div>
                                          </div>
                                          @if($errors->has("received_yn"))
                                              <span class="help-block">{{$errors->first("received_yn")}}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-9" style="margin-top: 20px">
                                  <div class="d-flex justify-content-end">
                                      <button type="submit" name="search" class="btn btn btn-dark shadow mr-1 mb-1">
                                          <i class="bx bx-search"></i> SEARCH
                                      </button>
                                      <button type="button" class="btn btn text-uppercase  reset-btn btn-dark shadow mr-1 mb-1">
                                          <i class="bx bx-reset"></i> Reset
                                      </button>
                                  </div>
                              </div>
                          </div>


                      </form>
                  </div>

                  <div class="card-content">
                      <div class="card-body card-dashboard">
                          <div class="table-responsive">
                              <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase" id="po_table"
                                     data-url="{{ route('admin.purchase-order.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                                  <thead >
                                  <tr class="text-nowrap">
                                      <th data-col="DT_RowIndex">SL</th>
                                      <th data-col="requisition_mst_no" title="REQUISITION MST NO">REQUISITION MST NO</th>
                                      <th data-col="requisition_dtl_no" title="REQUISITION DTL NO">REQUISITION DTL NO</th>
                                      <th data-col="equipment_name" title="equipment name">equipment name</th>
                                      <th data-col="item" title="ITEM">ITEM Name</th>
                                      <th data-col="description" title="DESCRIPTION">DESCRIPTION</th>
                                      @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                        <th data-col="appx_price" title="APPX PRICE">APPX PRICE</th>
                                      @endif
                                      <th data-col="approve_mf_qty" title="APPROVE MF QTY">APPROVE MF QTY</th>
                                      <th data-col="action" >action</th>
                                      <th data-col="equipment_name" >action</th>
                                      <th data-col="equipment_id" >action</th>
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
    </div>

    {{-- Start Modal Form For Equipment Assign --}}
    <div id="show-receive" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">
                      <i class="fas fa-check"></i> Assign</a> --}}
                    <h4 class="modal-title text-uppercase text-left">
                        Item Receive
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('admin.purchase-order-item.store')}}">
                        {!! csrf_field() !!}

                        <div class="purchase-order">
                            <div class="row mb-1">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" class="store_ids" name="store_id" value="">
                                            <label class="input-required ">Equipment Add Id</label>
                                            <input type="text"
                                                   readonly
                                                   required
                                                   id="equipment_add_id"
                                                   name="equipment_add_id"
                                                   placeholder="Equipment Add"
                                                   value="{{ old('equipment_add_id', ($data)?$data->equipment_add_id:$gen_equpment_add_id) }}"
                                                   class="form-control text-uppercase">
                                            @if($errors->has("equipment_add_id"))
                                                <span class="help-block">{{$errors->first("equipment_add_id")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required ">EQUIPMENT Name</label>
                                            <input type="text"
                                                   readonly
                                                   required
                                                   id="equipment_name"
                                                   name="equipment_name"
                                                   class="form-control text-uppercase">
                                            <input type="hidden" id="equipment_id" name="equipment_id">
                                            <input type="hidden" id="req_mst_id" name="req_mst_id">
                                            <input type="hidden" id="req_dtl_id" name="req_dtl_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Item Name</label>
                                            <input type="text"
                                                   id="item_name"
                                                   readonly
                                                   name="item_name"
                                                   class="form-control text-uppercase">
                                            <input type="hidden" name="item_id" id="item_id" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Variant Name</label>
                                            <input type="text"
                                                   id="variants"
                                                   readonly
                                                   name="variants"
                                                   class="form-control text-uppercase" readonly>
                                        </div>
                                    </div>
                                </div>
                                @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                <div class="col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class=""> Price</label>
                                            <input type="text"
                                                   id="appx_price"
                                                   name="appx_price"
                                                   required
                                                   class="form-control text-uppercase" readonly>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{--<div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required ">Equipment Name Bangla</label>
                                            <input type="text"
                                                   id="equipment_name_bn"
                                                   name="equipment_name_bn"
                                                   disabled
                                                   value="{{ $purchaseOrderData->equipment_name_bn }}"
                                                   placeholder="Equipment Name Bangla"
                                                   class="form-control text-uppercase">
                                            @if($errors->has("equipment_name_bn"))
                                                <span class="help-block">{{$errors->first("equipment_name_bn")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>--}}


                            </div>
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="">QUANTITY</label>
                                            <input type="number"
                                                   id="quantity"
                                                   required
                                                   name="quantity"
                                                   placeholder="Equipment Add"
                                                   class="form-control text-uppercase" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="">VENDOR NO</label>
                                            <input type="hidden" id="vendor_no"  name="vendor_no">
                                            <input class="form-control" type="text" id="vendor_name"  name="vendor_name" readonly>
    {{--                                        <select id="vendor_no" required name="vendor_no" class="form-control select2">--}}
    {{--                                            <option value="">Select one</option>--}}
    {{--                                            @foreach($getVendorList as $vendorList)--}}
    {{--                                                <option {{ ( old("vendor_no", ($data)?$data->vendor_no:'') == $vendorList->vendor_no) ? "selected" : ""  }}--}}
    {{--                                                        value="{{$vendorList->vendor_no}}">{{$vendorList->vendor_name}}--}}
    {{--                                                </option>--}}
    {{--                                            @endforeach--}}
    {{--                                        </select>--}}
                                            @if($errors->has("vendor_no"))
                                                <span class="help-block">{{$errors->first("vendor_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">MANUFACTURER</label>
                                            <input type="text"
                                                   id="manufacturer"
                                                   required
                                                   name="manufacturer"
                                                   placeholder="MANUFACTURER"
                                                   class="form-control text-uppercase" readonly>
                                            <input type="hidden" name="brand_id" id="brand_id" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">MODEL NO</label>
                                            <input type="text"
                                                   id="model_no"
                                                   required
                                                   maxlength="50"
                                                   name="model_no"
                                                   placeholder="MODEL NO"
                                                   class="form-control text-uppercase" readonly>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">SERIAL NO</label>
                                            <input type="text"
                                                   id="item_serial_no"
                                                   required
                                                   name="serial_no"
                                                   placeholder="SERIAL NO"
                                                   class="form-control text-uppercase" readonly>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="col-md-3">
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
                                </div>--}}
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">PURCHASE DATE<span class=""></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"  data-target-input="nearest">
                                                <input type="text" name="purchase_date"
                                                       required
                                                       autocomplete="off"
                                                       class="form-control berthing_at"
                                                       id="purchase_date"
                                                       placeholder="PURCHASE DATE" readonly>
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
                                            <label class="input-required">WARRANTY EXPIRY DATE<span class=""></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                                   data-target-input="nearest">
                                                <input type="text" name="warranty_expiry_date"
                                                       required
                                                       autocomplete="off"
                                                       class="form-control berthing_at"
                                                       id="warranty_expiry_date"
                                                       placeholder="WARRANTY EXPIRY DATE" readonly>
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
                                {{--<div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required ">EQUIPMENT DESCRIPTION </label>
                                            <textarea name="equipment_description" id="equipment_description" placeholder="EQUIPMENT DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('equipment_description', ($data)?$data->equipment_description:'') }}</textarea>
                                            @if($errors->has("equipment_description"))
                                                <span class="help-block">{{$errors->first("equipment_description")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                                                    <button type="button" data-dismiss="modal" class="btn btn btn-outline-dark  mb-1">
                                                        <i class="bx bx-window-close"></i> Cancel  </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="purchase-order-no-found" style="display: none">
                            <h3 style="color:#A95E06">No available stock</h3>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!--Modal End -->
@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>
        $('#po_table tbody').on('click', '.editButton', function () {
            var data_row = $('#po_table').DataTable().row( $(this).parents('tr') ).data();
            console.log(data_row,'data_row');
            var myModal = $('#show-receive');
            inventoryDetails(data_row.item_id,data_row.brand_id,data_row.variants);
            $('#item_name', myModal).val(data_row.item);
            $('#model_no', myModal).val(data_row.item);
            $('#manufacturer', myModal).val(data_row.brand_name);
            $('#brand_id', myModal).val(data_row.brand_id);
            $('#variants', myModal).val(data_row.variants);
            $('#item_id', myModal).val(data_row.item_id);
            $('#equipment_name', myModal).val($(data_row.equipment_name).text());
            $('#equipment_id', myModal).val(data_row.equipment_id);
            $('#quantity', myModal).val(data_row.approve_mf_qty);
            $('#equipment_description', myModal).val(data_row.description);
            $('#req_mst_id', myModal).val(data_row.requisition_mst_no);
            $('#req_dtl_id', myModal).val(data_row.requisition_dtl_no);
            // $('#vendor_name', myModal).val(data_row.vendor_name);

            myModal.modal({show: true});
            return false;
        });

        function inventoryDetails(item_id,brand_id=0,variants=0){
            if (variants == null){
                variants = '';
            }
            $.ajax({
                type: "GET",
                url: "{{route('get-inventory-details')}}?item_id="+item_id + "&brand_id="+brand_id + "&variants="+variants,
                cache: false,
                success: function(result){
                    if (result.status){
                        //$('#inventoryData').html(data.html);
                        if (result.data){
                            $('.purchase-order').show()
                            $('.purchase-order-no-found').hide()
                            $('#appx_price').val(result.data.purchase_price);
                            $('#purchase_date').val(result.data.purchase_date);
                            $('#warranty_expiry_date').val(result.data.warranty_expiry_date);
                            $('#vendor_name').val(result.data.supplier_name);
                            $('#vendor_no').val(result.data.supplier_id);
                            $('#item_serial_no').val(result.data.item_serial_no);
                            $('.store_ids').val(result.data.store_id);
                        }else{
                            $('.purchase-order').hide()
                            $('.purchase-order-no-found').show()
                        }
                    }else{
                        $.notify(data.message,'error');
                    }

                }
            });
        }
        $(".reset-btn").click(function () {
            $("#datatable_filter_form").trigger("reset");
            $(document).find('#datatable_filter_form select').val('').trigger('change');
            $("#datatable_filter_form").submit();
        });
        $(document).ready(function () {
            $('#po_table').DataTable().columns( [10,9] ).visible( false );
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
                dateTimePicker("#warranty_expiry_date");
                dateTimePicker("#purchase_date");
                dateRangePicker('#insert_start_date', '#insert_end_date');

            });
        });
    </script>
@endsection
