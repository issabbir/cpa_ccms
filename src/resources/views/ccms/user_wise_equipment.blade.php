@extends('layouts.default')

@section('title')
    User Wise Equipment
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
                        <h4 class="card-title"> {{ isset($data->id)?'Edit':'Add' }} User Wise Equipment </h4>
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
                                            <input type="text" name="designation"
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
                    <h4 class="card-title">Equipment Details</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>EMP ID</th>
                                    <th>NAME</th>
                                    <th>RECEIVED DATE</th>
                                    <th>WARRANTY DATE</th>
                                    <th>WARRANTY ?</th>
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
