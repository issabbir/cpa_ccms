@extends('layouts.default')

@section('title')
    Equipment List
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
                        <h4 class="card-title"> {{ isset($data->equipment_no)?'Edit':'Add' }} Equipment  Register List </h4>
                        <form method="POST" action="@if ($data && $data->equipment_no) {{route('equipment-list.update',['id' => $data->equipment_no])}} @else {{route('equipment-list.create')}} @endif">
                            {!! csrf_field() !!}
                            @if ($data && $data->equipment_no)
                                {{method_field('PUT')}}
                                <input type="hidden" name="equipment_no" value="{{$data->equipment_no}}">
                            @endif
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Equipment ID<span class="required"></span></label>
                                            <input type="text"
                                                   readonly
                                                   required
                                                   id="equipment_id"
                                                   name="equipment_id"
                                                   value="{{ old('equipment_id', ($data)?$data->equipment_id:$gen_equ_id) }}"
                                                   placeholder="Equipment ID"
                                                   class="form-control text-uppercase"
                                            />
                                            @if($errors->has("equipment_id"))
                                                   <span class="help-block">{{$errors->first("equipment_id")}}</span>
                                                   @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Equipment Name<span class="required"></span></label>
                                            <input type="text"
                                                   required
                                                   name="equipment_name"
                                                   placeholder="Equipment Name"
                                                   class="form-control"
                                                   value="{{ old('equipment_name', ($data)?$data->equipment_name:'') }}"
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
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Category<span class="required"></span></label>
                                            <select name="state" id="catagory_no"  required class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($CategoriesTypes as $categoriesName)
                                                    <option {{ ( old("catagory_no", ($data)?$data->catagory_no:'') == $categoriesName->catagory_no) ? "selected" : ""  }}
                                                            value="{{$categoriesName->catagory_no}}">{{$categoriesName->catagory_name}}</option>
                                                @endforeach

                                            </select>
                                            @if($errors->has("catagory_no"))
                                                <span class="help-block">{{$errors->first("catagory_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Sub Category<span class="required"></span></label>
                                            <select name="city" id="sub_catagory_no" required  class="form-control select2" disabled>
                                                <option value="">Select one</option>
                                                @foreach($SubCategoriesTypes as $subCategoriesName)
                                                    <option {{ ( old("sub_catagory_no", ($data)?$data->sub_catagory_no:'') == $subCategoriesName->sub_catagory_no) ? "selected" : ""  }} value="{{$subCategoriesName->sub_catagory_no}}">{{$subCategoriesName->sub_catagory_name}}</option>

                                                @endforeach
                                            </select>
                                            @if($errors->has("sub_catagory_no"))
                                                <span class="help-block">{{$errors->first("sub_catagory_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">{{ trans('Vendor')}}<span class="required"></span></label>
                                            <select name="vendor_no"  id="vendor_no" required class="form-control select2">
                                                <option value="" >Select one </option>
                                                @foreach($vendorTypes as $op)
                                                    <option {{ (old("vendor_no", ($data)? trim($data->vendor_no):'') == trim($op->vendor_no)) ? "selected" : ""  }}
                                                            value="{{trim($op->vendor_no)}}">{{$op->vendor_name}} -  #{{trim($op->vendor_no)}} </option>
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
                                            <label class="input-required">Manufacturer<span class="required"></span></label>
                                            <input type="text"
                                                   id="manufacturer"
                                                   required
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
                                            <label class="input-required">Model No <span class="required"></span></label>
                                            <input type="text"
                                                   required
                                                   maxlength="50"
                                                   id="model_no"
                                                   name="model_no"
                                                   value="{{ old('model_no', ($data)?$data->model_no:'') }}"
                                                   placeholder="Model no"
                                                   class="form-control"
                                                   />
                                               @if($errors->has("model_no"))
                                                   <span class="help-block">{{$errors->first("model_no")}}</span>
                                                     @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Serial No<span class="required"></span></label>
                                            <input type="text"
                                                   id="serial_no"
                                                   required
                                                   name="serial_no"
                                                   value="{{ old('serial_no', ($data)?$data->serial_no:'') }}"
                                                   placeholder="Serial No"
                                                   class="form-control"

                                            />
                                               @if($errors->has("serial_no"))
                                                   <span class="help-block">{{$errors->first("serial_no")}}</span>
                                                     @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Price<span class="required"></span></label>
                                            <input type="number"
                                                   required
                                                   id="price"
                                                   name="price"
                                                   value="{{ old('price', ($data)?$data->price:'') }}"
                                                   placeholder="Price"
                                                   class="form-control"
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

                                                <label>Invoice </label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="file" >
                                                    <input type="hidden"  name="invoice" id="invoice" />
                                                    <label class="custom-file-label" for="invoice">Choose file</label>
                                                </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Purchase Date<span class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="purchase_date" data-target-input="nearest">
                                                <input type="text" name="purchase_date"
                                                       required
                                                       value="{{ old('purchase_date', ($data)?$data->purchase_date:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#purchase_date"
                                                       data-toggle="datetimepicker"
                                                       placeholder="Purchase Date">
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
                            </div>
                            <div class="row">
                                   <div class="col-md-3">
                                       <div class="row ">
                                           <div class="col-md-12">
                                               <label class="input-required">Warranty Expiry Date<span class="required"></span></label>
                                               <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="warranty_expiry_date" data-target-input="nearest">
                                                   <input type="text" name="warranty_expiry_date"
                                                          required
                                                         value="{{ old('warranty_expiry_date', ($data)?$data->warranty_expiry_date:'') }}"
                                                          class="form-control berthing_at"
                                                          data-target="#warranty_expiry_date"
                                                          data-toggle="datetimepicker"
                                                          placeholder="Warranty Expiry Date"
                                                   />
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
                                   <div class="col-md-3">
                                       <div class="row ">
                                           <div class="col-md-12">
                                               <label class="input-required">Last Maintenance Date<span class="required"></span></label>
                                               <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="last_maintenance_date" data-target-input="nearest">
                                                   <input type="text" name="last_maintenance_date"
                                                          required
                                                          value="{{ old('last_maintenance_date', ($data)?$data->last_maintenance_date:'') }}"
                                                          class="form-control berthing_at"
                                                          data-target="#last_maintenance_date"
                                                          data-toggle="datetimepicker"
                                                          placeholder="Last Maintenance Date"
                                                   />
                                                   <div class="input-group-append" data-target="#last_maintenance_date" data-toggle="datetimepicker">
                                                       <div class="input-group-text">
                                                           <i class="bx bx-calendar"></i>
                                                       </div>
                                                   </div>
                                               </div>
                                               @if($errors->has("last_maintenance_date"))
                                                <span class="help-block">{{$errors->first("last_maintenance_date")}}</span>
                                                @endif
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-md-3">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Total Maintenance Cost<span class="required"></span></label>
                                            <input type="text"
                                                   id="total_maintenance_cost"
                                                   required
                                                   name="total_maintenance_cost"
                                                   value="{{ old('total_maintenance_cost', ($data)?$data->total_maintenance_cost:'') }}"
                                                   placeholder="Total Maintenance Cost"
                                                   class="form-control"

                                            />
                                            @if($errors->has("total_maintenance_cost"))
                                                <span class="help-block">{{$errors->first("total_maintenance_cost")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                   <div class="col-md-3">
                                        <div class="row ">
                                            <div class="col-md-12">
                                                <label class="input-required">Number of Maintenance <span class="required"></span></label>
                                                <input type="number"
                                                       minlength="1"
                                                       maxlength="20"
                                                       id="no_of_maintenance"
                                                       required
                                                       name="no_of_maintenance"
                                                       value="{{ old('no_of_maintenance', ($data)?$data->no_of_maintenance:'') }}"
                                                       placeholder="Number of Maintenance "
                                                       class="form-control"

                                                />
                                                @if($errors->has("no_of_maintenance"))
                                                    <span class="help-block">{{$errors->first("no_of_maintenance")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                               </div>
                            <div class="row">
                                <div class="col-md-4">
                                        <div class="row my-1 ">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="input-required required">Equipment In Use</label>
                                                    <div class="d-flex d-inline-block" style="margin-top: 10px">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   value="{{ old('equipment_in_use_yn','Y') }}" {{isset($data->equipment_in_use_yn) && $data->equipment_in_use_yn == 'Y' ? 'checked' : ''}}
                                                                   name="equipment_in_use_yn" id="customRadio1"
                                                                   checked="">
                                                            <label class="custom-control-label" for="customRadio1">YES</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   value="{{ old('equipment_in_use_yn','N') }}" {{isset($data->equipment_in_use_yn) && $data->equipment_in_use_yn == 'N' ? 'checked' : ''}}
                                                                   name="equipment_in_use_yn" id="customRadio2">
                                                            <label class="custom-control-label" for="customRadio2">NO</label>
                                                        </div>
                                                        @if ($errors->has('equipment_in_use_yn'))
                                                            <span class="help-block">{{ $errors->first('equipment_in_use_yn') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="input-required">Scrap status<span class="required"></span></label>
                                                    <div class="d-flex d-inline-block" style="margin-top: 10px">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   value="{{ old('scrap_yn','Y') }}" {{isset($data->scrap_yn) && $data->scrap_yn == 'Y' ? 'checked' : ''}}
                                                                   name="Scrap_yn" id="customRadio3"
                                                                   checked=""
                                                            >
                                                            <label class="custom-control-label" for="customRadio3">YES</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   value="{{ old('scrap_yn','N') }}" {{isset($data->scrap_yn) && $data->scrap_yn == 'N' ? 'checked' : ''}}
                                                                   name="Scrap_yn" id="customRadio4"
                                                            >
                                                            <label class="custom-control-label" for="customRadio4">NO</label>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('scrap_yn'))
                                                        <span class="help-block">{{ $errors->first('scrap_yn') }}</span>
                                                    @endif
                                                </div>
                                              </div>
                                            </div>

                                        </div>
                                    </div>

                                <div class="col-md-9">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <label class="input-required">Equipment Description</label>
                                            <textarea type="text" name="equipment_description"
                                                      placeholder="Equipment Description" class="form-control"
                                                      oninput="this.value = this.value.toUpperCase()" style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('equipment_description', ($data)?$data->equipment_description:'') }}</textarea>
                                            @if ($errors->has('equipment_description'))
                                                <span class="help-block">{{ $errors->first('equipment_description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end col">
                                                <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">SAVE  </button>
                                                <a  class="btn btn btn-outline-dark  mb-1"> Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!--List-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Equipment List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable"
                                   data-url="{{ route('equipment-list-datatable.data', isset($data->id)?$data->id:0 )}}"
                                   data-csrf="{{ csrf_token() }}" data-page="10">
                                <thead class="text-nowrap">
                                    <tr>
                                        <th data-col="DT_RowIndex">SL</th>
                                        <th data-col="equipment_name">Equipment Name</th>
                                        <th data-col="equipment_id">equipment_id</th>
                                        <th data-col="manufacturer">manufacturer</th>
                                        <th data-col="model_no">Model No </th>
                                        <th data-col="purchase_date">Purchase Date</th>
                                        <th data-col="action">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
                $('#purchase_date').datetimepicker(
                    {
                        format: 'DD-MM-YYYY',
                    }
                );
                $('#warranty_expiry_date').datetimepicker(
                    {
                        format: 'DD-MM-YYYY',
                    }
                );$('#last_maintenance_date').datetimepicker(
                    {
                        format: 'DD-MM-YYYY',
                    }
                );

            });
                // Initialize Select2


                // Set option selected onchange
                $('#catagory_no').change(function(){
                    var catId = $(this).val();
                    var select = $('#sub_catagory_no');
                        select.find('option').remove();

                    select.removeAttr('disabled');

                    $.get('/setup/ajax/sub-categories-data/'+catId, function(data) {
                        data.forEach(function(item,i) {
                            let op = '<option value='+item.sub_catagory_no+'>'+item.sub_catagory_name+'</option>';
                            select.append(op);
                        });
                    });
                    //$('#sub_catagory_no').select2();
                });

            function getBase64(file) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    $(document).find('#invoice').val(reader.result);
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
        });

    </script>
@endsection

