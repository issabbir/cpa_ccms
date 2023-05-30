  <input type="hidden" value="{{isset($stockView->stock_quantity) ? $stockView->stock_quantity : ''}}" name="stock_quantity">
    <input type="hidden" value="{{isset($stock->warranty_yn) ? $stock->warranty_yn : ''}}" id="stock_warranty_yn" name="stock_warranty_yn">
    <input type="hidden" value="{{isset($stockView->store_id) ? $stockView->store_id : ''}}" name="store_id">
    <input type="hidden" value="{{isset($stockView->department_id) ? $stockView->department_id : ''}}" name="department_id">
    <input type="hidden" value="{{isset($stockView->variants_string) ? $stockView->variants_string : ''}}" name="variants">
    <input type="hidden" value="{{isset($stockView->brand_id) ? $stockView->brand_id : ''}}" name="brand_id">
    <input type="hidden" value="{{isset($stockView->item_id) ? $stockView->item_id : ''}}" name="item_id">

    <div class="row mt-2">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <label class="input-required">Equipment ID<span
                            class="required"></span></label>
                    <input type="text"
                           readonly
                           required
                           id="equipment_id"
                           name="equipment_id"
                           value="{{ old('equipment_id', ($data)?$data->equipment_id:$gen_equ_id) }}"
                           placeholder="Equipment ID"
                           class="form-control text-uppercase">
                    @if($errors->has("equipment_id"))
                        <span class="help-block">{{$errors->first("equipment_id")}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <label class="input-required">Equipment Name<span
                            class="required"></span></label>
                    @php $equipment_name = $data ? $data->equipment_name : ''; @endphp
                    <input type="text"
                           required
                           readonly
                           name="equipment_name"
                           placeholder="Equipment Name"
                           class="form-control"
                           value="{{ old('equipment_name', isset($stockView->item_name) ? $stockView->item_name : $equipment_name ) }}"
                           oninput="this.value = this.value.toUpperCase()"/>
                    @if($errors->has("equipment_name"))
                        <span class="help-block">{{$errors->first("equipment_name")}}</span>
                    @endif

                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <label class="input-required">Equipment Name Bangla </label>
                    <input type="text" name="equipment_name_bn"
                           placeholder="Equipment Name Bangla " class="form-control"
                           value="{{ old('equipment_name_bn', ($data)?$data->equipment_name_bn:'') }}"
                           oninput="this.value = this.value.toUpperCase()"/>
                    @if($errors->has("equipment_name"))
                        <span class="help-block">{{$errors->first("equipment_name")}}</span>
                    @endif
                </div>
            </div>

        </div>
        {{--<div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <label class="input-required">Category<span class="required"></span></label>
                    <select id="catagory_no" name="catagory_no" required
                            class="form-control select2">
                        <option value="">Select one</option>
                        @foreach ($categories as $category)
                            @include('ccms.setup.category.equipment_option', ['category' => $category,"space" => ''])
                        @endforeach
                    </select>
                    @if($errors->has("catagory_no"))
                        <span class="help-block">{{$errors->first("catagory_no")}}</span>
                    @endif
                </div>
            </div>
        </div>--}}
    {{--</div>
    <div class="row">--}}
{{--        <div class="col-md-3">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <label class="input-required">{{ trans('Vendor')}}<span--}}
{{--                            class="required"></span></label>--}}
{{--                    <select name="vendor_no" id="vendor_no" required--}}
{{--                            class="form-control select2">--}}
{{--                        <option value="">Select one</option>--}}
{{--                        @foreach($vendorTypes as $op)--}}
{{--                            <option--}}
{{--                                {{ (old("vendor_no", ($data)? trim($data->vendor_no):'') == trim($op->vendor_no)) ? "selected" : ""  }}--}}
{{--                                value="{{trim($op->vendor_no)}}">{{$op->vendor_name}} ---}}
{{--                                #{{trim($op->vendor_no)}} </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    @if($errors->has("vendor_no"))--}}
{{--                        <span class="help-block">{{$errors->first("vendor_no")}}</span>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-md-3">
            <div class="form-group">
                <label class="">Supplier Name</label>
                @php $vendor_no = $data ? $data->vendor_no : ''; @endphp
                <input type="hidden" value="{{isset($stock->supplier_id) ? $stock->supplier_id : $vendor_no}}" name="vendor_no">
                @php $supplier_name = isset($data->vendor) ? $data->vendor->vendor_name : ''; @endphp
                <input type="text" maxlength="100"
                       name="vendor_no" class="form-control"  value="{{old('supplier_name',isset($stock->supplier_name) ? $stock->supplier_name : $supplier_name)}}"
                       id="vendor_no" disabled>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label class="input-required">Manufacturer</label>
                    <input type="text"
                           id="manufacturer"
                           name="manufacturer"
                           value="{{ old('manufacturer', ($data)?$data->manufacturer:'') }}"
                           placeholder="Manufacturer"
                           class="form-control"/>
                    @if($errors->has("manufacturer"))
                        <span class="help-block">{{$errors->first("manufacturer")}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label class="input-required">SL NO <span
                            class="required"></span></label>
                    <input type="text"
                           required
                           maxlength="50"
                           id="model_no"
                           name="model_no"
                           value="{{ old('model_no', ($data)?$data->inventory_sl_no:'') }}"
                           placeholder="Model no"
                           class="form-control">
                    @if($errors->has("model_no"))
                        <span class="help-block">{{$errors->first("model_no")}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label class="input-required">Serial No/Part No<span
                            class="required"></span></label>
                    <input type="text"
                           id="serial_no"
                           required
                           name="serial_no"
                           value="{{ old('serial_no', ($data)?$data->serial_no:'') }}"
                           placeholder="Serial No"
                           class="form-control">
                    @if($errors->has("serial_no"))
                        <span class="help-block">{{$errors->first("serial_no")}}</span>
                    @endif
                </div>
            </div>
        </div>
    {{--</div>
    <div class="row">--}}
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label class="input-required">Price<span class="required"></span></label>
                    @php $price = $data ? $data->price : ''; @endphp
                    <input type="number"
                           required
                           readonly
                           id="price"
                           name="price"
                           value="{{ old('price', isset($stock->purchase_price) ? trim($stock->purchase_price) : $price) }}"
                           placeholder="Price"
                           class="form-control">
                    @if($errors->has("price"))
                        <span class="help-block">{{$errors->first("price")}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label>Invoice </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file">
                        <input type="hidden" name="invoice" id="invoice"/>
                        <label class="custom-file-label" for="invoice">Choose file</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label class="input-required">Purchase Date<span
                            class="required"></span></label>
                    @php $purchase_date = $data ? date('d-m-Y',strtotime($data->purchase_date)) : ''; @endphp
                    <div class="input-group date"
                         id="purchase_date" >
                        <input type="text" name="purchase_date"
                               required autocomplete="off"
                               readonly
                               value="{{ old('purchase_date', isset($stock->purchase_date_db) ? date('d-m-Y',strtotime($stock->purchase_date_db)) : $purchase_date) }}"
                               class="form-control"
                               placeholder="Purchase Date">
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
                    <label class="input-required">Warranty Expiry Date<span
                            class=""></span></label>
                    @php
                        if(isset($stock->warranty_expiry_date_db)){
                            $warranty_expiry_date = isset($stock->warranty_expiry_date_db) ? date('d-m-Y',strtotime($stock->warranty_expiry_date_db)) : '';
                        }elseif(isset($stock->purchase_date_db)){
                            $warranty_expiry_date = isset($stock->purchase_date_db) ? date('d-m-Y',strtotime($stock->purchase_date_db)) : '';
                        }else{
                            $warranty_expiry_date = isset($data->warranty_expiry_date) ? date('d-m-Y',strtotime($data->warranty_expiry_date)) : $purchase_date;
                        }
                   @endphp
                    <div class="input-group date"
                         id="warranty_expiry_date" data-target-input="nearest">
                        <input type="text" name="warranty_expiry_date"
                                 autocomplete="off"
                               readonly
                               value="{{ old('warranty_expiry_date', $warranty_expiry_date)}}"
                               class="form-control"
                               id="warranty_expiry_date_input"
                               placeholder="Warranty Expiry Date">
                        <input type="hidden" name="last_maintenance_date" value="">
                    </div>
                    @if($errors->has("warranty_expiry_date"))
                        <span
                            class="help-block">{{$errors->first("warranty_expiry_date")}}</span>
                    @endif
                </div>
            </div>
        </div>
    {{--</div>
    <div class="row">--}}
        {{--<div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label>Last Maintenance Date</label>
                    <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                         id="last_maintenance_date" data-target-input="nearest">
                        <input type="text" name="last_maintenance_date"
                               value="{{ old('last_maintenance_date', ($data)?$data->last_maintenance_date:'') }}"
                               class="form-control berthing_at"
                               data-target="#last_maintenance_date"
                               id="last_maintenance_date_input"
                               data-toggle="datetimepicker"
                               placeholder="Last Maintenance Date">
                        <div class="input-group-append" data-target="#last_maintenance_date"
                             data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="bx bx-calendar"></i>
                            </div>
                        </div>
                    </div>
                    @if($errors->has("last_maintenance_date"))
                        <span
                            class="help-block">{{$errors->first("last_maintenance_date")}}</span>
                    @endif
                </div>
            </div>
        </div>--}}
        {{--<div class="col-md-3">
            <div class="form-group">
                <label class="input-required">Warehouse1<span class="required"></span></label>
                <select id="warehouse_ids" name="warehouse_id" required
                        class="form-control">
                    <option value="">Select one</option>
                    @foreach ($getWarehouse as $warehouse)
                        <option value="{{$warehouse->warehouse_id}}">{{$warehouse->warehouse_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>--}}
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label>Total Maintenance Cost</label>
                    <input type="number"
                           id="total_maintenance_cost"
                           name="total_maintenance_cost"
                           value="{{ old('total_maintenance_cost', ($data)?$data->total_maintenance_cost:'') }}"
                           placeholder="Total Maintenance Cost"
                           class="form-control">
                    @if($errors->has("total_maintenance_cost"))
                        <span
                            class="help-block">{{$errors->first("total_maintenance_cost")}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row ">
                <div class="col-md-12">
                    <label>Number of Maintenance</label>
                    <input type="number"
                           minlength="1"
                           maxlength="20"
                           id="no_of_maintenance"
                           name="no_of_maintenance"
                           value="{{ old('no_of_maintenance', ($data)?$data->no_of_maintenance:'') }}"
                           placeholder="Number of Maintenance "
                           class="form-control">
                    @if($errors->has("no_of_maintenance"))
                        <span class="help-block">{{$errors->first("no_of_maintenance")}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <label class="input-required">Equipment Description</label>
            <textarea type="text" name="equipment_description" id="editor"
                      placeholder="Equipment Description" class="form-control"
                      oninput="this.value = this.value.toUpperCase()"
            >{{ old('equipment_description', ($data)?$data->equipment_description:'') }}</textarea>
            @if ($errors->has('equipment_description'))
                <span class="help-block">{{ $errors->first('equipment_description') }}</span>
            @endif
        </div>

    </div>
<script>
    if ($('#stock_warranty_yn').val() == 'YES'){
        $('#warranty_yn').attr('checked', true)
        $('.show_warrant').show();
    }else{
        $('.show_warrant').hide();
    }
</script>
