@extends('layouts.default')

@section('title')
    Service Engineer
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
                        <h4 class="card-title"> {{ isset($data->id)?'Edit':'Add' }} Service Engineer  </h4>
                        <form method="POST" action="">
                            {{ isset($data->id)?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Name<span class="required"></span></label>
                                            <input type="text"
                                                   id="name"
                                                   name="name"
{{--                                                   value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Name"
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
                                                <label class="input-required">Address<span class="required"></span></label>
                                                <textarea type="text" name="owner_address"
                                                          placeholder="Owner Address" class="form-control"
                                                          oninput="this.value = this.value.toUpperCase()" style="margin-top: 0px; margin-bottom: 0px; height: 37px;">

                                            </textarea>
                                            </div>
                                        </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Mobile No<span class="required"></span></label>
                                            <input type="text"
                                                   id="mobile"
                                                   name="mobile"
                                                   {{--     value="{{ old('local_agent', $data->local_agent) }}"--}}
                                                   placeholder="Mobile No"
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
                                            <label class="input-required">Contract start<span class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="contract_start" data-target-input="nearest">
                                                <input type="text" name="contract_start"
                                                       {{--                                                       value="{{ old('berthing_at', $data->berthing_at) }}"--}}
                                                       class="form-control berthing_at"
                                                       data-target="#contract_start"
                                                       data-toggle="datetimepicker"
                                                       placeholder="Contract Start"
                                                       oninput="this.value = this.value.toUpperCase()"
                                                />
                                                <div class="input-group-append" data-target="#contract_start" data-toggle="datetimepicker">
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
                                            <label class="input-required">Contract End<span class="required"></span></label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="contract_end" data-target-input="nearest">
                                                <input type="text" name="contract_end"
                                                       {{--                                                       value="{{ old('berthing_at', $data->berthing_at) }}"--}}
                                                       class="form-control berthing_at"
                                                       data-target="#contract_end"
                                                       data-toggle="datetimepicker"
                                                       placeholder="Contract End"
                                                       oninput="this.value = this.value.toUpperCase()"
                                                />
                                                <div class="input-group-append" data-target="#contract_end" data-toggle="datetimepicker">
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
                                            <label class="input-required">Preferred Work<span class="required"></span></label>
                                            <div class="form-group">
                                                <select data-placeholder="Select a state..." class="select2-icons form-control"
                                                        id="multiple-select2-icons" multiple="multiple">
                                                    <optgroup label="Services">
                                                        <option value="wordpress2" data-icon="fa fa-wordpress" selected>WordPress</option>
                                                        <option value="codepen" data-icon="fa fa-codepen">Codepen</option>
                                                        <option value="drupal" data-icon="fa fa-drupal">Drupal</option>
                                                        <option value="pinterest2" data-icon="fa fa-css3">CSS3</option>
                                                        <option value="html5" data-icon="fa fa-html5">HTML5</option>
                                                    </optgroup>
                                                    <optgroup label="File types">
                                                        <option value="pdf" data-icon="fa fa-file-pdf-o">PDF</option>
                                                        <option value="word" data-icon="fa fa-file-word-o">Word</option>
                                                        <option value="excel" data-icon="fa fa-file-excel-o">Excel</option>
                                                        <option value="facebook" data-icon="fa fa-facebook-official">Facebook</option>
                                                    </optgroup>
                                                    <optgroup label="Browsers">
                                                        <option value="chrome" data-icon="fa fa-chrome">Chrome</option>
                                                        <option value="firefox" data-icon="fa fa-firefox">Firefox</option>
                                                        <option value="safari" data-icon="fa fa-safari">Safari</option>
                                                        <option value="opera" data-icon="fa fa-opera">Opera</option>
                                                        <option value="IE" data-icon="fa fa-internet-explorer">IE</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-4">
                                    <div class="row my-1">
                                        <div class="col-md-2">
                                            <label class="input-required">Status<span class="required"></span></label></div>
                                        <div class="col-md-10 ">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   {{--                                                                   value="{{ old('status','A') }}" {{isset($data->status) && $data->status == 'A' ? 'checked' : ''}} --}}
                                                                   name="status" id="customRadio1"
                                                                   checked=""
                                                            >
                                                            <label class="custom-control-label" for="customRadio1">Active</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" class="custom-control-input"
                                                                   {{--                                                                   value="{{ old('status','I') }}" {{isset($data->status) && $data->status == 'I' ? 'checked' : ''}} --}}
                                                                   name="status" id="customRadio2"
                                                            >
                                                            <label class="custom-control-label" for="customRadio2">Inactive</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                            {{--                                            @if ($errors->has('status'))--}}
                                            {{--                                                <span class="help-block">{{ $errors->first('status') }}</span>--}}
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
                    <h4 class="card-title"> </h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>NAME</th>
                                    <th>MOBILE</th>
                                    <th>CONTRACT</th>
                                    <th>STATUS</th>
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
            $('#contract_start').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );
            $('#contract_end').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );

        });


    </script>
@endsection
