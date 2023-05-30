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
                        <h4 class="card-title">{{ $data && isset($data->requisition_dtl_no)?'Edit':'Add' }} Equipment Requisition Details </h4>
                        <form method="POST"  action="@if ($data && $data->requisition_dtl_no) {{route('requisition-details.update',['requisition_mst_no'=>$requisitionMaster->requisition_mst_no,'id' => $data->requisition_dtl_no])}}
                        @else {{route('requisition-details.create',['requisition_mst_no'=>$requisitionMaster->requisition_mst_no])}} @endif">
                            {{ ($data && isset($data->requisition_dtl_no))?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Requisition Mst No</label>
                                            <input type="text"
                                                   id="requisition_mst_no "
                                                   name="requisition_mst_no"
                                                   value="{{ old('requisition_mst_no', ($requisitionMaster)?$requisitionMaster->requisition_mst_no:'') }}"
                                                   placeholder="Requisition Mst No"
                                                   class="form-control"
                                                  />
                                               @if($errors->has("requisition_mst_no"))
                                                   <span class="help-block">{{$errors->first("requisition_mst_no")}}</span>
                                                     @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="input-required">Replacement yn<span class="required"></span></label></div>
                                        <div class="col-md-8">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   value="{{ old('replacement_yn','Y') }}" {{isset($data->replacement_yn) && $data->replacement_yn == 'Y' ? 'checked' : ''}}
                                                                   name="replacement_yn" id="customRadio1"
                                                                   checked=""
                                                            />
                                                            <label class="custom-control-label" for="customRadio1">YES</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   value="{{ old('replacement_yn','N') }}" {{isset($data->replacement_yn) && $data->replacement_yn == 'N' ? 'checked' : ''}}
                                                                   name="replacement_yn" id="customRadio2"
                                                            />
                                                            <label class="custom-control-label" for="customRadio2">NO</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                            @if ($errors->has('replacement_yn'))
                                                <span class="help-block">{{ $errors->first('replacement_yn') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                {{--<div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Equipment no<span class="required"></span></label>
                                            <input type="text" required
                                                   id="equipment_no"
                                                   name="equipment_no"
                                                   value="{{ old('email', ($data)?$data->equipment_no:'') }}"
                                                   placeholder="Equipment No"
                                                   class="form-control"
                                            />
                                               @if($errors->has("equipment_no"))
                                                   <span class="help-block">{{$errors->first("equipment_no")}}</span>
                                                     @endif
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Item Name<span class="required"></span></label>
                                            <input type="text" required
                                                   id="item"
                                                   name="item"
                                                   value="{{ old('item', ($data)?$data->item:'') }}"
                                                   placeholder="Item"
                                                   class="form-control"
                                            />
                                            @if($errors->has("Item"))
                                                <span class="help-block">{{$errors->first("Item")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Description</label>
                                            <textarea type="text" name="description"
                                                      placeholder="Description" class="form-control"
                                                      style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('description', ($data)?$data->description:'') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Appx Price<span class="required"></span></label>
                                            <input type="text" required
                                                   id="appx_price"
                                                   name="appx_price"
                                                   value="{{ old('appx_price', ($data)?$data->appx_price:'') }}"
                                                   placeholder="Appx Price"
                                                   class="form-control"
                                            />
                                            @if($errors->has("appx_price"))
                                                <span class="help-block">{{$errors->first("appx_price")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Quantity<span class="required"></span></label>
                                            <input type="text" required
                                                   id="quantity"
                                                   name="quantity"
                                                   value="{{ old('quantity', ($data)?$data->quantity:'') }}"
                                                   placeholder="Quantity"
                                                   class="form-control"
                                            />
                                            @if($errors->has("quantity"))
                                                <span class="help-block">{{$errors->first("quantity")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Remarks</label>
                                            <textarea type="text" name="remarks"
                                                      placeholder="Remarks" class="form-control"
                                                      style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('remarks',($data)?$data->remarks:'') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
{{--                            <div class="row">--}}
{{--                                    <input type="hidden" name="requisition_mst_no" value="{{$data->requisition_mst_no}}" />--}}
{{--                            </div>--}}
                            <div class="row">

                            <div class="col-md-12">
                                <div class="row my-1">
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <div class="d-flex justify-content-end col">
                                            <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                SAVE
                                            </button>
                                            <a class="btn btn btn-outline-dark  mb-1 " href="javascript:history.go(-1)"> Cancel</a>
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
                    <h4 class="card-title">Equipment Requisition  List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable"
                             data-url="{{ route('requisition-details-datatable.data',['requisition_mst_no'=>$requisitionMaster->requisition_mst_no])}}"
                             data-csrf="{{ csrf_token() }}"
                             data-page="20"
                            >
                                <thead>
                                <tr>
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="requisition_dtl_no">REQUISITION DTL NO </th>
                                    <th data-col="requisition_mst_no">REQUISITION MST NO  </th>
                                    <th data-col="replacement_yn">REPLACEMENT YN</th>
                                    <th data-col="item">ITEM</th>
                                    <th data-col="description">DESCRIPTION</th>
                                    <th data-col="appx_price">APPX PRICE</th>
                                    <th data-col="quantity">QUANTITY</th>
                                    <th data-col="remarks">REMARKS</th>
                                    <th data-col="action">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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

            $('#enlistment_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );
        });
    </script>
@endsection
