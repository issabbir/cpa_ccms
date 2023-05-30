<div class="card">
    <div class="card-content">
        <div class="card-body">
            <h4 class="card-title">{{ $data && isset($data->requisition_mst_no)?'Edit':'Add' }} Requisition Master </h4>

            <form method="POST"  action="@if ($data && $data->requisition_mst_no) {{route('requisition-master.update',['id' => $data->requisition_mst_no])}} @else {{route('requisition-master.create')}} @endif">

                {!! csrf_field() !!}
                @if ($data && $data->requisition_mst_no)
                    {{method_field('PUT')}}
                    <input type="hidden" name="requisition_mst_no" value="{{$data->requisition_mst_no}}">
                @endif
                <hr>
                <div class="row ">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="input-required">Requisition ID<span class="required"></span></label>
                                <input type="text"
                                       readonly
                                       id="requisition_id"
                                       name="requisition_id"
                                       value="{{ old('requisition_id', ($data)?$data->requisition_id:$gen_req_id ?? '') }}"
                                       placeholder="Requisition ID"
                                       class="form-control text-uppercase">
                                @if($errors->has("requisition_id"))
                                    <span class="help-block">{{$errors->first("requisition_id")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row ">
                            <div class="col-md-12">
                                @include('ccms/common/requisition_select_box',
                                    [
                                        'select_name' => 'requisition_for',
                                        'label_name' => 'Requisition For',
                                        'required' => true
                                        ]
                                 )
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row ">
                            <div class="col-md-12">
                                <label class="input-required">Requisition Date<span class="required"></span></label>
                                <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="requisition_date" data-target-input="nearest">
                                    <input type="text" name="requisition_date"
                                           value="{{ old('requisition_date', ($data)?$data->requisition_date:'') }}"
                                           class="form-control requisition_date"
                                           data-target="#requisition_date"
                                           data-toggle="datetimepicker"
                                           placeholder="Requisition Date"
                                    />
                                    <div class="input-group-append" data-target="#requisition_date" data-toggle="datetimepicker">
                                        <div class="input-group-text">
                                            <i class="bx bx-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                @if($errors->has("requisition_date"))
                                    <span class="help-block">{{$errors->first("requisition_date")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row ">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="input-required">Ticket<span class="required"></span></label></div>
                            <div class="col-md-12">
                                <ul class="list-unstyled mb-0">
                                    <li class="d-inline-block mr-2 mb-1">
                                        <fieldset>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"
                                                       value="{{ old('ticket_yn','Y') }}" {{isset($data->ticket_yn) && $data->ticket_yn == 'Y' ? 'checked' : ''}}
                                                       name="ticket_yn" id="customRadio1"
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
                                                       value="{{ old('ticket_yn','N') }}" {{isset($data->ticket_yn) && $data->ticket_yn == 'N' ? 'checked' : ''}}
                                                       name="ticket_yn" id="customRadio2"
                                                />
                                                <label class="custom-control-label" for="customRadio2">NO</label>
                                            </div>
                                        </fieldset>
                                    </li>
                                </ul>
                                @if ($errors->has('ticket_yn'))
                                    <span class="help-block">{{ $errors->first('ticket_yn') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(!empty(\Request::get('id')) && empty($data))
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required required">Ticket No</label>
                                    <select class="form-control select2" id="select_ticket" disabled>
                                        <option value="">Select one</option>
                                        @foreach($getTicketNo as $ticketNo)
                                            <option {{ ( old("ticket_no", (\Request::get('id'))?\Request::get('id'):'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                    value="{{$ticketNo->ticket_no}}">
                                                {{$ticketNo->ticket_no}}</option>
                                        @endforeach
                                        <input type="hidden" id="ticket_no" name="ticket_no">
                                    </select>
                                    @if($errors->has("ticket_no"))
                                        <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif(!empty($data->ticket_no))
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required required">Ticket No</label>
                                    <select  id="ticket_no" name="ticket_no" class="form-control select2">
                                        <option value="">Select one</option>
                                        @foreach($getTicketNo as $ticketNo)
                                            <option {{ ( old("ticket_no", ($data)?$data->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                    value="{{$ticketNo->ticket_no}}">
                                                {{$ticketNo->ticket_no}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has("ticket_no"))
                                        <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required required">Ticket No</label>
                                    <select  id="ticket_no" name="ticket_no" class="form-control select2">
                                        <option value="">Select one</option>
                                        @foreach($getTicketNo as $ticketNo)
                                            <option {{ ( old("ticket_no", ($data)?$data->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
                                                    value="{{$ticketNo->ticket_no}}">
                                                {{$ticketNo->ticket_no}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has("ticket_no"))
                                        <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="input-required required">Equipment ID</label>
                                <select  id="equipment_id" name="equipment_id" class="form-control select2">
                                    <option value="">Select one</option>
                                    @foreach($getEquipmentID as $equipmentID)
                                        <option {{ ( old("equipment_id", ($data)?$data->equipment_id:'') == $equipmentID->equipment_id) ? "selected" : ""  }}
                                                value="{{$equipmentID->equipment_id}}">
                                            {{$equipmentID->equipment_name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has("equipment_id"))
                                    <span class="help-block">{{$errors->first("equipment_id")}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="input-required">Requisition Note</label>
                                <textarea type="text" name="requisition_note"
                                          placeholder="Description" class="form-control"
                                          style="margin-top: 0px; margin-bottom: 0px; height: 37px;">{{ old('requisition_note', ($data)?$data->requisition_note:'') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
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



@section('footer-script')
    <!--Load custom script-->
    <script>

        $(document).ready(function () {

            $("#emp_id").select2({
                minimumInputLength: 1,
                dropdownPosition: 'below',
                allowClear: true,
                ajax: {
                    url: '{{route('employee-list-by-code')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.results, function (obj) {
                                return {
                                    id: obj.emp_id,
                                    text: obj.name,
                                };
                            })
                        };
                    },
                    cache: false
                },
            });
        });


        $(document).ready(function () {
            $(document).on("click", '.confirm-approved', function (e) {
                e.preventDefault();
                let that = $(this);
                let link = that.attr("href");
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                swal({
                    title: "Are you sure?",
                    text: "",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#dd3333",
                    confirmButtonText: "Yes, approve it!",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    buttonsStyling: !1
                }).then(function (e) {
                    if (e.value === true) {
                        $.ajax({
                            type: '',
                            url: link,
                            data: {_token: CSRF_TOKEN},
                            dataType: 'JSON',
                            success: function (results) {
                                if (results.success === true) {
                                    let table = that.closest('div').find('.datatable').DataTable();
                                    table.ajax.reload(null, false); // user paging is not reset on reload
                                    swal("Done!", results.message, "success");
                                } else {
                                    swal("Error!", results.message, "error");
                                }
                            }
                        });

                    } else {
                        e.dismiss;
                    }

                }, function (dismiss) {
                    return false;
                })
            });





            $('#requisition_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );
            $('#approved_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY',
                }
            );

        });

    </script>
@endsection
