@extends('layouts.default')

@section('title')
    Service Engineer Info
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    {{--    @dd($data)--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content" id="service_engineer_info" style="@if(\Request::get('id')) display: block @else display: none @endif">
                    <div class="card-body">
                        <h4 class="card-title"> {{ isset($data->service_engineer_info_id)?'Edit':'Add' }} Service
                            Engineer Info </h4>
                        <form method="POST"
                              action="@if ($data && $data->service_engineer_info_id) {{route('service-engineer-info.update',['id' => $data->service_engineer_info_id])}} @else {{route('service-engineer-info.create')}} @endif">
                            {!! csrf_field() !!}
                            @if ($data && $data->service_engineer_info_id)
                                {{method_field('PUT')}}
                                <input type="hidden" name="service_engineer_info_id"
                                       value="{{$data->service_engineer_info_id}}">
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">SERVICE ENGINEER ID <span
                                                    class="required"></span></label>
                                            <input type="text"
                                                   readonly
                                                   id="service_engineer_id"
                                                   name="service_engineer_id"
                                                   value="{{ old('service_engineer_id', ($data)?$data->service_engineer_id:$gen_se_gen_id) }}"
                                                   placeholder="SERVICE ENGINEER ID"
                                                   class="form-control text-uppercase"
                                            />
                                            @if($errors->has("service_engineer_id"))
                                                <span
                                                    class="help-block">{{$errors->first("service_engineer_id")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Service Engineer Name<span
                                                    class="required"></span></label>
                                            <input type="text" name="service_engineer_name"
                                                   placeholder="Service Engineer Name"
                                                   class="form-control"
                                                   value="{{ old('service_engineer_name', ($data)?$data->service_engineer_name:'') }}"
                                                   oninput="this.value = this.value.toUpperCase()"/>
                                            @if($errors->has("service_engineer_name"))
                                                <span
                                                    class="help-block">{{$errors->first("service_engineer_name")}}</span>
                                            @endif

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">NID Number <span
                                                    class="required"></span></label>
                                            <input type="number" name="nid_number"
                                                   maxlength="20"
                                                   placeholder="NID Number" class="form-control"
                                                   value="{{ old('nid_number', ($data)?$data->nid_number:'') }}"
                                            />
                                            @if($errors->has("nid_number"))
                                                <span class="help-block">{{$errors->first("nid_number")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Mobile No<span
                                                    class="required"></span></label>
                                            <input type="tel" name="mobile_no" id="mobile_no" required
                                                   maxlength="11" pattern="[0-9]{11}"
                                                   placeholder="Mobile No" class="form-control"
                                                   value="{{ old('mobile_no', ($data)?$data->mobile_no:'') }}"
                                            />
                                            @if($errors->has("mobile_no"))
                                                <span class="help-block">{{$errors->first("mobile_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Contract Start Date<span
                                                    class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                                 id="contract_start_date" data-target-input="nearest">
                                                <input type="text" name="contract_start_date"
                                                       value="{{ old('contract_start_date', ($data)?$data->contract_start_date:'') }}"
                                                       class="form-control berthing_at"
                                                       id="contract_start_date_input"
                                                       data-target="#contract_start_date"
                                                       data-toggle="datetimepicker"
                                                       placeholder="Contract Start Date">
                                                <div class="input-group-append" data-target="#contract_start_date"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("contract_start_date"))
                                                <span
                                                    class="help-block">{{$errors->first("contract_start_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Contract End Date<span
                                                    class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                                 id="contract_end_date" data-target-input="nearest">
                                                <input type="text" name="contract_end_date"
                                                       value="{{ old('contract_end_date', ($data)?$data->contract_end_date:'') }}"
                                                       class="form-control berthing_at"
                                                       id="contract_end_date_input"
                                                       data-target="#contract_end_date"
                                                       data-toggle="datetimepicker"
                                                       placeholder="Contract End Date">
                                                <div class="input-group-append" data-target="#contract_end_date"
                                                     data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("contract_end_date"))
                                                <span class="help-block">{{$errors->first("contract_end_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Preferred Work<span
                                                    class="required"></span></label>
                                            <input type="text"
                                                   id="preferred_work"
                                                   name="preferred_work"
                                                   value="{{ old('preferred_work', ($data)?$data->preferred_work:'') }}"
                                                   placeholder="Preferred Work"
                                                   class="form-control">
                                            @if($errors->has("preferred_work"))
                                                <span class="help-block">{{$errors->first("preferred_work")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="input-required">Active Status<span
                                                            class="required"></span></label></div>
                                                <div class="col-md-12">
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                           value="{{ old('active_yn','Y') }}"
                                                                           {{isset($data->active_yn) && $data->active_yn == 'Y' ? 'checked' : ''}}
                                                                           name="active_yn" id="customRadio1"
                                                                           checked="">
                                                                    <label class="custom-control-label"
                                                                           for="customRadio1">YES</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                        <li class="d-inline-block mr-2 mb-1">
                                                            <fieldset>
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                           value="{{ old('active_yn','N') }}"
                                                                           {{isset($data->active_yn) && $data->active_yn == 'N' ? 'checked' : ''}}
                                                                           name="active_yn" id="customRadio2">
                                                                    <label class="custom-control-label"
                                                                           for="customRadio2">NO</label>
                                                                </div>
                                                            </fieldset>
                                                        </li>
                                                    </ul>
                                                    @if ($errors->has('active_yn'))
                                                        <span
                                                            class="help-block">{{ $errors->first('active_yn') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">SkillS <span class="required"></span></label>
                                            <div class="form-group">
                                                <select data-placeholder="Select Skills..."
                                                        class="select2-icons form-control"
                                                        name="service_skill_id[]" id="multiple-select2-icons"
                                                        multiple="multiple">
                                                    <optgroup label="Skill">
                                                        {{--                                                        @foreach($engineerSkillList as $op)--}}
                                                        {{--                                                            <option {{ (old("service_skill_id", ($data)? trim($data->service_skill_id):'') == trim($op->service_skill_id)) ? "selected" : ""  }}--}}
                                                        {{--                                                                    value="{{trim($op->service_skill_id)}}">{{$op->service_skill_name}}  </option>--}}
                                                        {{--                                                        @endforeach--}}

                                                        @foreach($engineerSkillList as $value)
                                                            <option value="{{$value->service_skill_id}}"
                                                            @if(!empty($skills))
                                                                @foreach($skills as $prereq)
                                                                    @if($prereq->service_skill_id == $value->service_skill_id) {{'selected="selected"'}}
                                                                        @endif
                                                                    @endforeach
                                                                @endif >
                                                                {{$value->service_skill_name}}
                                                            </option>
                                                        @endforeach


                                                    </optgroup>
                                                </select>
                                                @if($errors->has("service_skill_id"))
                                                    <span
                                                        class="help-block">{{$errors->first("service_skill_id")}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Present Address
                                                <span class="required"></span>
                                                <span style="padding-left: 80px; cursor: pointer;"
                                                      title="If the two address are same click on">
                                                    <input type="checkbox" style="cursor: pointer;" id="same"
                                                           name="same" onchange="addressFunction()"/>
                                                </span>
                                            </label>
                                            <textarea type="text" name="present_address" id="present_address"
                                                      placeholder="Present Address" class="form-control"
                                                      style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('present_address', ($data)?$data->present_address:'') }}</textarea>
                                            @if ($errors->has('present_address'))
                                                <span class="help-block">{{ $errors->first('present_address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Premanent Address <span
                                                    class="required"></span></label>
                                            <textarea type="text" name="premanent_address" id="premanent_address"
                                                      placeholder="Premanent Address" class="form-control"
                                                      style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('premanent_address ', ($data)?$data->premanent_address :'') }}</textarea>
                                            @if ($errors->has('premanent_address '))
                                                <span
                                                    class="help-block">{{ $errors->first('premanent_address ') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">Authenticate User </label>
                                            <select id="user_name" name="username"
                                                    required class="form-control select2">

                                                @if ($data && $data->user_name)
                                                    <option value="{{$data->user_name}}">{{$data->user_name}}</option>
                                                @else
                                                    <option value="">Select one</option>
                                                @endif

                                                @foreach($users as $user)
                                                    <option
                                                        {{ ( old("user_name", ($data)?$data->user_name:'') == $user->user_name) ? "selected" : ""  }}
                                                        value="{{$user->user_name}}">{{$user->user_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has("username"))
                                                <span class="help-block">{{$errors->first("username")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <div class="row my-1">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-end col">
                                                        @if (\Request::get('id'))
                                                            <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                                <i class="bx bx-sync"></i> Update</button>
                                                            <a href="{{ route('service-engineer-info.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="font-weight: 900;">
                                                                <i class="bx bx-arrow-back"></i> Back</a>
                                                        @else
                                                            <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                                <i class="bx bx-save"></i> SAVE  </button>
                                                            <button type="button" onclick="$('#service_engineer_info').hide('slow')" class="btn btn btn-outline-dark  mb-1">
                                                                <i class="bx bx-window-close"></i> Cancel  </button>
                                                        @endif
                                                    </div>
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
            <!--List-->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title text-uppercase">Service Engineer Info List</h4>
                        </div>
                        <div class="col-md-6">
                            <div class="row float-right">
                                <button id="show_form" type="button"
                                        onclick="$('#service_engineer_info').toggle('slow')"
                                        class="btn btn-secondary mb-1 ml-1 hvr-underline-reveal">
                                    <i class="bx bx-plus"></i> Add New
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable"
                                   data-url="{{ route('service-engineer-info-datatable.data', isset($data->id)?$data->id:0 )}}"
                                   data-csrf="{{ csrf_token() }}" data-page="10">
                                <thead class="text-nowrap">
                                <tr>
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="service_engineer_name">NAME</th>
                                    <th data-col="mobile_no">MOBILE NO</th>
                                    <th data-col="nid_number">NID NUMBER</th>
                                    <th data-col="present_address">PRESENT ADDRESS</th>
                                    <th data-col="premanent_address">PERMANENT ADDRESS</th>
                                    <th data-col="contract_start_date">CONTRACT START DATE</th>
                                    <th data-col="contract_end_date">CONTRACT END DATE</th>
                                    <th data-col="preferred_work">PREFERRED WORK</th>
                                    <th data-col="active_yn">STATUS</th>

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

                    //Date time picker
                    function dateTimePicker(selector) {
                        var elem = $(selector);
                        elem.datetimepicker({
                            format: 'DD-MM-YYYY',
                            icons: {
                                time: 'bx bx-time',
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

                        let preDefinedDate = elem.attr('data-predefined-date');

                        if (preDefinedDate) {
                            let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD");
                            elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                        }
                    }

                    //dateTimePicker("#occurance_date");
                    dateTimePicker("#contract_start_date");
                    dateTimePicker("#contract_end_date");

                    $('#contract_end_date_input').val(getSysDate());
                    $('#contract_start_date_input').val(getSysDate());
                    // aDDRESS


                });


                function addressFunction() {
                    var checkBox = document.getElementById("same");
                    var premanent_address = document.getElementById("present_address").value;

                    if (checkBox.checked === true) {
                        document.getElementById("premanent_address").value = premanent_address;

                    } else {


                        document.getElementById("premanent_address").value = null;
                    }

                }


            </script>
@endsection

