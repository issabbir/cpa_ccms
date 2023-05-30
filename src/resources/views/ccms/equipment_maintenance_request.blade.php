@extends('layouts.default')

@section('title')
    Maintenance Request
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
                        <h4 class="card-title"> {{ isset($data->id)?'Edit':'Add' }} Maintenance Request </h4>
                        <form method="POST" action="">
                            {{ isset($data->id)?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Employee Name<span class="required"></span></label>
                                            <input type="text"
                                                   id="employee"
                                                   name="employee"
                                                   {{--value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Employee Name"
                                                   class="form-control"
                                                   oninput="this.value=this.value.toUpperCase()" />
                                            {{-- @if($errors->has("local_agent"))--}}
                                            {{--  <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--  @endif--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Designation<span class="required"></span></label>
                                            <input type="text"
                                                      name="designation"
                                                      readonly
                                                      placeholder="Designation" class="form-control"
                                                      oninput="this.value = this.value.toUpperCase()"/>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Department<span class="required"></span></label>
                                            <input type="text" name="department"
                                                   readonly
                                                   placeholder="Department" class="form-control"
                                                   oninput="this.value = this.value.toUpperCase()"/>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Section<span class="required"></span></label>
                                            <input type="text"
                                                   id="section"
                                                   readonly
                                                   name="section"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Section"
                                                   class="form-control"
                                                   oninput="this.value=this.value.toUpperCase()" />
                                            {{--   @if($errors->has("local_agent"))--}}
                                            {{--       <span class="help-block">{{$errors->first("local_agent")}}</span>--}}
                                            {{--         @endif--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Location <span class="required"></span></label>
                                            <select name="location" id="location" class="form-control select2">
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

                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Room No<span class="required"></span></label>
                                            <input type="text"
                                                   id="roomNo"
                                                   name="room no"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Room No"
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Employee Type <span class="required"></span></label>
                                            <select name="employee" id="employee" class="form-control select2">
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
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="input-required">Equipment <span class="required"></span></label>
                                            <select name="Equipment" id="Equipment" class="form-control select2">
                                                <option value="">Select one</option>
                                                {{--                                                @foreach($vesselNames as $vesselName)--}}
                                                {{--                                                    <option {{ ( old("vessel_id", $data->vessel_id) == $vesselName->id) ? "selected" : ""  }} value="{{$vesselName->id}}">{{$vesselName->name.'('.$vesselName->reg_no.') '}}</option>--}}
                                                {{--                                                @endforeach--}}
                                            </select>
                                            {{--                                            @if($errors->has("vessel_id"))--}}
                                            {{--                                                <span class="help-block">{{$errors->first("vessel_id")}}</span>--}}
                                            {{--                                            @endif--}}
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <input type="text"
                                                   id=""
                                                   readonly
                                                   name=""
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="hp pc"
                                                   class="form-control"
                                                {{--                                                   oninput="this.value=this.value.toUpperCase()" --}}
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Details<span class="required"></span></label>
                                            <textarea type="text" name="details"
                                                      placeholder="Details" class="form-control"
                                                      oninput="this.value = this.value.toUpperCase()" style="margin-top: 0px; margin-bottom: 0px; height: 37px;">

                                            </textarea>
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
                    <h4 class="card-title">REQUEST LIST</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>EQUIPMENT</th>
                                    <th>RECEIVE DATE</th>
                                    <th>IN WARRANT</th>
                                    <th>NO OF MAINTENANCE</th>
                                    <th>MAINTENANCE COST</th>
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

@endsection
