<style type="text/css">
    #table-equip-req.dataTable thead .sorting:after,
    #table-equip-req.dataTable thead .sorting_asc:after,
    #table-equip-req.dataTable thead .sorting_desc:after,
    #table-equip-req.dataTable thead .sorting_desc_disabled:after {
        padding-top: 1em;
    }

    table#table-equip-req tbody tr td,
    table#table-equip-req thead tr th,
    table#table-equip-req thead {
        border: 1px solid #DFE3E7;
        padding: 10px;
    }
</style>

<div class="card">
    <div class="card-content">
        <div class="card-body" style="@if(\Request::get('id')) display: block; @else display: none @endif" id="equip_req_form">
            <h4 class="card-title">{{ $data && isset($data->requisition_mst_no)?'Edit':'Add' }} Requisition</h4>

            <form method="POST" id="equip-req"
                  action="@if ($data && $data->requisition_mst_no) {{route('admin.requisition-master.update',['id' => $data->requisition_mst_no])}} @else {{route('admin.requisition-master.create')}} @endif">
                {!! csrf_field() !!}
                @if ($data && $data->requisition_mst_no)
                    {{method_field('PUT')}}
                    <input type="hidden" name="requisition_mst_no" value="{{$data->requisition_mst_no}}">
                @endif
                <hr>
                <div class="row ">
                    @if(isset($data->requisition_id))
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">Requisition ID<span class="required"></span></label>
                                    <input type="text"
                                           readonly
                                           id="requisition_id"
                                           name="requisition_id"
                                           value="{{ old('requisition_id', ($data)?$data->requisition_id: '') }}"
                                           placeholder="Requisition ID"
                                           class="form-control text-uppercase">
                                    @if($errors->has("requisition_id"))
                                        <span class="help-block">{{$errors->first("requisition_id")}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required">Requisition ID<span class="required"></span></label>
                                    <input type="text"
                                           readonly
                                           id="requisition_id"
                                           name="requisition_id"
                                           value="{{ old('requisition_id', ($gen_req_id)?$gen_req_id: '') }}"
                                           placeholder="Requisition ID"
                                           class="form-control text-uppercase">
                                    @if($errors->has("requisition_id"))
                                        <span class="help-block">{{$errors->first("requisition_id")}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Requisition For</label>
                                <input type="text"
                                       disabled
                                       id="requisition_name"
                                       value="{{ old('requisition_name', ($data)?$data->req_for_name: '') }}"
                                       class="form-control text-uppercase">
                                <input type="hidden" name="requisition_for" value="{{($data)?$data->requisition_for: ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Ticket Id</label>
                                <input type="text"
                                       disabled
                                       id="ticket_id"
                                       value="{{ old('ticket_id', ($data)?$data->ticket_id: '') }}"
                                       class="form-control text-uppercase">
                                <input type="hidden" name="ticket_no" value="{{($data)?$data->ticket_no: ''}}">
                                <input type="hidden" name="requisition_date" value="{{($data)?$data->requisition_date: ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Equipment Name</label>
                                <input type="text"
                                       disabled
                                       id="equipment_name"
                                       value="{{ old('equipment_name', ($data)?$data->equipment_name: '') }}"
                                       class="form-control text-uppercase">
                                <input type="hidden" name="equipment_no" value="{{($data)?$data->equipment_no: ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="input-required">Requisition Note</label>
                                <textarea type="text" name="requisition_note" cols="30" rows="3"
                                          placeholder="Description" class="form-control"
                                          style="margin-top: 0px; margin-bottom: 0px; height: 80px">{{ old('requisition_note', ($data)?$data->requisition_note:'') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <fieldset class="border w-auto mt-1" style="font-size: 18px; padding: 20px">
                    <legend  class="w-auto required">Add Requisition Item</legend>
                    <div class="row pt-1">
{{--                        <div class="col-sm-3">--}}
{{--                            <div class="form-group">--}}
{{--                                <label class="required">Item </label>--}}
{{--                                <select name="tab_item_id" id="tab_item_id" class="form-control select2">--}}
{{--                                    @foreach($items as $item)--}}
{{--                                        <option data-item_name="{{$item->item_name}}" value="{{$item->item_id}}" >{{$item->item_name}}-{{$item->item_code}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-4">--}}
{{--                            <label class="required">Equipment Item</label>--}}
{{--                            --}}{{--                                    <input type="hidden" name="item_id" value="{{$data->item_id}}">--}}
{{--                            <select class="form-control select2" name="item_id" id="item_id" >--}}
{{--                                <option value="">Select One</option>--}}
{{--                                @if(filled($items))--}}
{{--                                    @foreach($items as $item)--}}
{{--                                        <option {{old('item_id') == $item->item_id ? 'selected' : ''}} value="{{$item->item_id}}">{{$item->item_name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="col-md-12">
                            <div id="inventoryDataView">
                                @include('ccms.common.requisition-item')
                            </div>
                        </div>
                        <div class="col-sm-12 text-right" align="right">
                            <div id="start-no-field">
                                <label for="seat_to1">&nbsp;</label><br/>
                                <button type="button" id="append"
                                        data-variants_url="{{ route('item-variant-process') }}"
                                        class="btn btn-secondary mb-1 add-row-equip-req hvr-underline-reveal">
                                    <i class="bx bx-plus"></i> ADD
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-2">
                            <div class="table-responsive">
                                <table class="table  table-striped table-bordered" id="table-equip-req">
                                    <thead class="text-nowrap">
                                    <tr>
                                        <th class="text-center" style="padding: 10px">Action</th>
                                        <th class="text-center" style="padding: 10px">Item Name</th>
                                        <th class="text-center" style="padding: 10px">Brand</th>
                                        <th class="text-center" style="padding: 10px">Variants</th>
                                        <th class="text-center" style="padding: 10px">Description</th>
{{--                                        <th class="text-center" style="padding: 10px">APPX PRICE</th>--}}
                                        <th class="text-center" style="padding: 10px">QUANTITY</th>
                                        <th class="text-center" style="padding: 10px">REMARKS</th>
                                        <th class="text-center" style="padding: 10px">REPLACEMENT YN</th>
                                    </tr>
                                    </thead>

                                    <tbody id="equip-req-body">
                                    @if(!empty($reqDtlData))
                                        @foreach($reqDtlData as $key=>$value)
                                            <tr>
                                                <td><input type='checkbox' name='record'>
                                                    <input type="hidden" name="requisition_dtl_no[]"
                                                           value="{{$value->requisition_dtl_no}}" class="delete_requisition_dtl_no">
                                                    <input type="hidden" name="tab_item_name[]" value="{{$value->item}}">
                                                    <input type="hidden" name="tab_item_id[]" value="{{$value->item_id}}">
                                                    <input type="hidden" name="brands_id[]" value="{{$value->brand_id}}">
                                                    <input type="hidden" name="brand_name[]" value="{{$value->brand_name}}">
                                                    <input type="hidden" name="variants_string[]" value="{{$value->variants}}">
                                                    <input type="hidden" name="tab_description[]" value="{{$value->description}}">
{{--                                                    <input type="hidden" name="tab_appx_price[]" value="{{$value->appx_price}}">--}}
                                                    <input type="hidden" name="tab_quantity[]" value="{{$value->quantity}}">
                                                    <input type="hidden" name="tab_remarks[]" value="{{$value->remarks}}">
                                                    <input type="hidden" name="tab_replacement_yn[]" value="{{$value->replacement_yn}}">
                                                </td>
                                                <td>{{$value->item}}</td>
                                                <td>{{$value->brand_name}}</td>
                                                <td>{{$value->variants}}</td>
                                                <td>{{$value->description}}</td>
{{--                                                <td>{{$value->appx_price}}</td>--}}
                                                <td>{{$value->quantity}}</td>
                                                <td>{{$value->remarks}}</td>
                                                <td>
                                                    @if($value->replacement_yn=='Y')
                                                        YES
                                                    @else
                                                        NO
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-start">

                            <button type="button"
                                    class="btn btn-outline-danger mb-1 delete-row-equip-req">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </fieldset>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row my-1">
                            <div class="col-md-12" style="margin-top: 20px">
                                <div class="d-flex justify-content-end col">
                                    @if (is_numeric(\Request::get('id')))
                                        <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1"> <i class="bx bx-edit-alt"></i> Update</button>
                                        <a href="{{ route('admin.requisition-master.index') }}" class="btn btn-sm btn-outline-secondary mb-1" style="font-weight: 900;">
                                        <i class="bx bx-arrow-back"></i> Back</a>
                                    @else
                                        <button type="submit" name="save" class="btn btn btn-dark shadow mr-1 mb-1">
                                            <i class="bx bx-save"></i> SAVE
                                        </button>
                                        <button type="button" onclick="$('#equip_req_form').hide('slow')" class="btn btn btn-outline-dark  mb-1"><i class="bx bx-window-close"></i> Cancel  </button>
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



@section('footer-script')
    @parent
    <!--Load custom script-->
    <script>
        $(document).on('change','#item_id',function (e) {
            let item_id = $(this).val();
            inventoryData(item_id);
        })
        function inventoryData(item_id) {
            $.ajax({
                type: "GET",
                url: "{{route('requisition-inventory')}}?item_id="+item_id,
                cache: false,
                success: function(data){
                    if (data.status){
                        $('#inventoryData').html(data.html);
                    }else{
                        $.notify(data.message,'error');
                    }

                }
            });
        }
        $(document).on('click','.view-inventory',function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $(document).find('.view-inventory i').addClass("bx-plus-circle").removeClass('bx-check');
            $(this).find('i').removeClass("bx-plus-circle").addClass('bx-check');
            inventoryViewData(url);
        })
        function inventoryViewData(url) {
            $.ajax({
                type: "GET",
                url: url,
                cache: false,
                success: function(data){
                    if (data.status){
                        $('#inventoryDataView').html(data.html);
                    }else{
                        $.notify(data.message,'error');
                    }
                }
            });
        }



        $("#tab_item_id").bind().on("change", function () {
            let selected_item_name=$(this).find(":selected").attr('data-item_name');
            $("#tab_item_name").val(selected_item_name);
        });

        $(".reset-btn").click(function () {
            $("#datatable_filter_form").trigger("reset");
            $(document).find('#datatable_filter_form select').val('').trigger('change');
            $("#datatable_filter_form").submit();
        });
        $(".delete-row-equip-req").click(function () {
            $("#table-equip-req tbody").find('input[name="record"]').each(function () {
                let removeItemEl = $(this);
                if ($(this).is(":checked")) {
                    let requisition_dtl_no = $(this).closest('tr').find('.delete_requisition_dtl_no').val();
                    if (requisition_dtl_no) {
                        Swal.fire({
                            title: 'Are you sure?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.value) {
                                $(this).parents("tr").remove();
                                $.ajax({
                                    type: 'GET',
                                    url: 'detail-data-remove',
                                    data: {requisition_dtl_no: requisition_dtl_no},
                                    success: function (msg) {
                                        Swal.fire({
                                            title: 'Entry Successfully Deleted!',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(function () {
                                            removeItemEl.closest("tr").remove();
                                        });
                                    }
                                });
                            }
                        });
                    } else {
                        $(this).parents("tr").remove();
                    }
                }
            });
        });

        $(document).ready(function () {
                @if((!empty(\Request::get('id')) && empty($data)))
            let ticket_no = $('#select_ticket :selected').val();
            $('#ticket_no').val(ticket_no);
            @endif

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
                let full_data = $(this).attr('href');

                let parts = full_data.split('+', 2);
                let requisition_mst_no = parts[0];
                let status  = parts[1];
                e.preventDefault();
                if(status=='Y'){
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, disapprove it!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: 'GET',
                                url: 'requisition-master-data-approved',
                                data: {requisition_mst_no: requisition_mst_no, APPROVED_YN: 'N'},
                                success: function (msg) {
                                    if (msg == "1") {
                                        Swal.fire({
                                            title: 'Requisition Disapprove!',
                                            type: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(function () {
                                            $('#req_datatable').DataTable().ajax.reload();
                                        });
                                    } else {
                                        swal("Error!", results.message, "error");
                                    }
                                }
                            });
                        }
                    });
                }else{
                    Swal.fire({
                        title: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, approve it!'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: 'GET',
                                url: 'requisition-master-data-approved',
                                data: {requisition_mst_no: requisition_mst_no, APPROVED_YN: 'Y'},
                                success: function (msg) {
                                    if (msg == "1") {
                                        Swal.fire({
                                            title: 'Requisition Approved!',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(function () {
                                            $('#req_datatable').DataTable().ajax.reload();
                                        });
                                    } else {
                                        swal("Error!", results.message, "error");
                                    }
                                }
                            });
                        }
                    });
                }
            });

            $(document).on("click", '.confirm-delete', function (e) {
                let requisition_mst_no = $(this).attr('href');
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#dd3333",
                    confirmButtonText: "Yes, delete it!",
                    confirmButtonClass: "btn btn-primary",
                    cancelButtonClass: "btn btn-danger ml-1",
                    buttonsStyling: !1
                }).then(function (e) {
                    if (e.value === true) {
                        $.ajax({
                            type: 'GET',
                            url: 'requisition-master-remove',
                            data: {requisition_mst_no: requisition_mst_no},
                            success: function (results) {
                                if (results == "1") {
                                    Swal.fire({
                                        title: 'REQUISITION IS DELETED SUCCESSFULLY.',
                                        confirmButtonText: 'OK',
                                        type: 'success'
                                    }).then(function () {
                                        $('#req_datatable').DataTable().ajax.reload();
                                    });
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
                        let preDefinedDateMomentFormat = moment(preDefinedDate, "DD-MM-YYYY").format("DD-MM-YYYY");
                        elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                    }
                }
                dateTimePicker("#requisition_date");
                dateTimePicker("#approved_date");
                dateRangePicker('#requisition_start_date', '#requisition_end_date');
                $('#requisition_date_input').val(getSysDate());
            });

        });
    </script>
@endsection
