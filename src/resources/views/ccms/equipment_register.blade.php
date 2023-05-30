@extends('layouts.default')

@section('title')
    Equipment Register
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
                        <h4 class="card-title"> {{ isset($data->id)?'Edit':'Add' }} Equipment  Register </h4>
                        <form method="POST" action="">
                            {{ isset($data->id)?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Equipment ID<span class="required"></span></label>
                                            <input type="text"
                                                   id="equipment_id"
                                                   name="description"
                                                   {{--                                                   value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Equipment ID"
                                                   class="form-control"
                                                   oninput="this.value=this.value.toUpperCase()" />
                                            {{--                                            @if($errors->has("local_agent"))--}}
                                            {{--                                                <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--                                            @endif--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Order No<span class="required"></span></label>
                                            <input type="text" name=""
                                                      placeholder="Order No" class="form-control"
                                                      oninput="this.value = this.value.toUpperCase()"/>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Category<span class="required"></span></label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select one</option>
                                                {{--                                                @foreach($vesselNames as $vesselName)--}}
                                                {{--                                                    <option {{ ( old("vessel_id", $data->vessel_id) == $vesselName->id) ? "selected" : ""  }} value="{{$vesselName->id}}">{{$vesselName->name.'('.$vesselName->reg_no.') '}}</option>--}}
                                                {{--                                                @endforeach--}}
                                            </select>
                                            {{--                                            @if($errors->has("vessel_id"))--}}
                                            {{--                                                <span class="help-block">{{$errors->first("vessel_id")}}</span>--}}
                                            {{--                                            @endif--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Order By<span class="required"></span></label>
                                            <input type="text"
                                                   id="order_by"
                                                   name="order_by"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Order By"
                                                   class="form-control"
                                                {{--                                                   oninput="this.value=this.value.toUpperCase()" --}}
                                            />
                                            {{--   @if($errors->has("local_agent"))--}}
                                            {{--       <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--         @endif--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Equipment Name <span class="required"></span></label>
                                            <input type="text"
                                                   id="equipment_name"
                                                   name="equipment_name"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Equipment Name"
                                                   class="form-control"
                                                   oninput="this.value=this.value.toUpperCase()" />
                                            {{--   @if($errors->has("local_agent"))--}}
                                            {{--       <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--         @endif--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Vendor<span class="required"></span></label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select one</option>
                                                {{--                                                @foreach($vesselNames as $vesselName)--}}
                                                {{--                                                    <option {{ ( old("vessel_id", $data->vessel_id) == $vesselName->id) ? "selected" : ""  }} value="{{$vesselName->id}}">{{$vesselName->name.'('.$vesselName->reg_no.') '}}</option>--}}
                                                {{--                                                @endforeach--}}
                                            </select>
                                            {{--                                            @if($errors->has("vessel_id"))--}}
                                            {{--                                                <span class="help-block">{{$errors->first("vessel_id")}}</span>--}}
                                            {{--                                            @endif--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Vendor<span class="required"></span></label>
                                            <input type="text"
                                                   id="mobile"
                                                   name="mobile"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="vendor"
                                                   class="form-control"
                                                {{--                                                   oninput="this.value=this.value.toUpperCase()" --}}
                                            />
                                            {{--   @if($errors->has("local_agent"))--}}
                                            {{--       <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--         @endif--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Remarks<span class="required"></span></label>
                                            <textarea type="text" name="remarks"
                                                      placeholder="Remarks" class="form-control"
                                                      oninput="this.value = this.value.toUpperCase()" style="margin-top: 0px; margin-bottom: 0px; height: 37px;">

                                            </textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Value<span class="required"></span></label>
                                            <input type="text"
                                                   id="value"
                                                   name="value"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Value"
                                                   class="form-control"
                                                {{--                                                   oninput="this.value=this.value.toUpperCase()" --}}
                                            />
                                            {{--   @if($errors->has("local_agent"))--}}
                                            {{--       <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--         @endif--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                   <div class="col-md-4">
                                       <div class="row ">
                                           <div class="col-md-12">
                                               <label class="input-required">Received By<span class="required"></span></label>
                                               <input type="text"
                                                      id="receivedBy"
                                                      name="receivedBy"
                                                      {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                      placeholder="Received By"
                                                      class="form-control"
                                                   {{--                                                   oninput="this.value=this.value.toUpperCase()" --}}
                                               />
                                               {{--   @if($errors->has("local_agent"))--}}
                                               {{--       <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                               {{--         @endif--}}
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="row ">
                                           <div class="col-md-12">
                                               <label class="input-required">Purchase Date<span class="required"></span></label>
                                               <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="purchase_date" data-target-input="nearest">
                                                   <input type="text" name="purchase_dt"
                                                          {{--                                                       value="{{ old('berthing_at', $data->berthing_at) }}"--}}
                                                          class="form-control berthing_at"
                                                          data-target="#purchase_date"
                                                          data-toggle="datetimepicker"
                                                          placeholder="Purchase Date"
                                                          oninput="this.value = this.value.toUpperCase()"
                                                   />
                                                   <div class="input-group-append" data-target="#purchase_date" data-toggle="datetimepicker">
                                                       <div class="input-group-text">
                                                           <i class="bx bx-calendar"></i>
                                                       </div>
                                                   </div>
                                               </div>
                                               {{--                                            @if($errors->has("berthing_at"))--}}
                                               {{--                                                <span class="help-block">{{$errors->first("berthing_at")}}</span>--}}
                                               {{--                                            @endif--}}
                                           </div>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="row ">
                                           <div class="col-md-12">
                                               <label class="input-required">Warranty Date<span class="required"></span></label>
                                               <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="warranty_date" data-target-input="nearest">
                                                   <input type="text" name="purchase_dt"
                                                          {{--                                                       value="{{ old('berthing_at', $data->berthing_at) }}"--}}
                                                          class="form-control berthing_at"
                                                          data-target="#warranty_date"
                                                          data-toggle="datetimepicker"
                                                          placeholder="Warranty Date"
                                                          oninput="this.value = this.value.toUpperCase()"
                                                   />
                                                   <div class="input-group-append" data-target="#warranty_date" data-toggle="datetimepicker">
                                                       <div class="input-group-text">
                                                           <i class="bx bx-calendar"></i>
                                                       </div>
                                                   </div>
                                               </div>
                                               {{--                                            @if($errors->has("berthing_at"))--}}
                                               {{--                                                <span class="help-block">{{$errors->first("berthing_at")}}</span>--}}
                                               {{--                                            @endif--}}
                                           </div>
                                       </div>
                                   </div>
                               </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row my-1">
                                        <div class="col-md-12" style="margin-top: 20px">
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
                    <h4 class="card-title"> Equipment  Register List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
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
        $(function () {
            $('#purchase_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );
            $('#warranty_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );

        });


    </script>
@endsection
