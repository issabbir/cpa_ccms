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
            @include('ccms/setup/partials/vendor_form', ['readonly' => true])
            <div class="card mt-0 mb-0">
                <div class="card-content">
                    <div class="card-body" id="vendor_register" style="@if(\Request::get('id')) display: block @else display: none @endif">
                        <h4 class="card-title">{{ $contactPerson && isset($contactPerson->contact_person_id)?'Edit':'Add' }} Contact Person Info </h4>
                        <form method="POST" action="@if ($contactPerson && $contactPerson->contact_person_id) {{route('contact-person.update',['vendor_no' => $data->vendor_no , 'id' => $contactPerson->contact_person_id])}}
                        @else {{route('contact-person.create', ['vendor_no' => $data->vendor_no])}} @endif">
                            {{ ($contactPerson && isset($contactPerson->contact_person_id))?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">Person Name</label>
                                            <input type="text" required
                                                   id="contact_person_name "
                                                   autofocus
                                                   name="contact_person_name"
                                                   value="{{ old('contact_person_name', ($contactPerson)?$contactPerson->contact_person_name:'') }}"
                                                   placeholder="Contact Person Name"
                                                   class="form-control">
                                            @if($errors->has("contact_person_name"))
                                               <span class="help-block">{{$errors->first("contact_person_name")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Person Name Bangla</label>
                                            <input type="text"
                                                   id="contact_person_name_bn "
                                                   autofocus
                                                   name="contact_person_name_bn"
                                                   value="{{ old('contact_person_name_bn', ($contactPerson)?$contactPerson->contact_person_name_bn:'') }}"
                                                   placeholder="Contact Person Name Bangla"
                                                   class="form-control"
                                                   oninput="this.value=this.value.toUpperCase()"/>
                                               @if($errors->has("contact_person_name_bn"))
                                                   <span class="help-block">{{$errors->first("contact_person_name_bn")}}</span>
                                               @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required required">Mobile</label>
                                            <input type="tel" required
                                                   pattern="[0-9]{11}"
                                                   id="mobile_no"
                                                   name="mobile_no"
                                                   value="{{ old('mobile_no', ($contactPerson)?$contactPerson->mobile_no:'') }}"
                                                   placeholder="Mobile No"
                                                   class="form-control">
                                            @if($errors->has("mobile_no"))
                                                <span class="help-block">{{$errors->first("mobile_no")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required">Email<span class="required"></span></label>
                                            <input type="email" required
                                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email', ($contactPerson)?$contactPerson->email:'') }}"
                                                   placeholder="Email"
                                                   class="form-control">
                                               @if($errors->has("email"))
                                                   <span class="help-block">{{$errors->first("email")}}</span>
                                               @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required">Remarks</label>
                                            <textarea type="text" name="remarks"
                                                      placeholder="Remarks" class="form-control"
                                                      style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('remarks', ($contactPerson)?$contactPerson->remarks:'') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                    <input type="hidden" name="vendor_id" value="{{$data->vendor_id}}" />
                            </div>
                            <div class="row">

                            <div class="col-md-12">
                                <div class="row my-1">
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <div class="d-flex justify-content-end col">
                                            @if (\Request::get('id'))
                                                <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                    <i class="bx bx-sync"></i> Update</button>
                                                <a href="{{ route('vendors.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="font-weight: 900;">
                                                    <i class="bx bx-arrow-back"></i> Back</a>
                                            @else
                                                <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                                    <i class="bx bx-save"></i> SAVE  </button>
                                                <a type="button" href="{{ route('vendors.index') }}" class="btn btn btn-outline-dark  mb-1">
                                                    <i class="bx bx-arrow-back"></i> Back  </a>
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

            <!--List-->
            <div class="card mt-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title text-uppercase">Contact Person List</h4>
                            <span><strong>Vendor -</strong> {{ $data->vendor_name }}</span>
                        </div>
                        <div class="col-md-6">
                            <div class="row float-right">
                                <button id="show_form" type="button" onclick="$('#vendor_register').toggle('slow')" class="btn btn-secondary mb-1 ml-1 hvr-underline-reveal">
                                    <i class="bx bx-plus"></i> Add New</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable"
                                   data-url="{{ route('contact-person.data', ['vendor_no' => $data->vendor_no])}}"
                                   data-csrf="{{ csrf_token() }}"
                                   data-page="20">
                                <thead >
                                <tr>
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="contact_person_name">Contact Person Name</th>
                                    <th data-col="email">EMAIL</th>
                                    <th data-col="mobile_no">MOBILE</th>
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
