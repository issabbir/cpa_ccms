<form method="POST" action="{{route('admin.third_party.update',['id' => $data->third_party_service_id])}}">
                    {{method_field('PUT')}}
                    {!! csrf_field() !!}
                    <input type="hidden" name="third_party_service_id" value="{{$data->third_party_service_id}}">
                    <input type="hidden" name="equipment_no" value="{{$data->equipment_no}}">
                    <input type="hidden" name="ticket_no" value="{{$data->ticket_no}}">
                    <input type="hidden" name="vendor_no" value="{{$data->vendor_no}}">
                    <input type="hidden" name="problem_description" value="{{$data->problem_description}}">
                    <input type="hidden" name="sending_date" value="{{$data->sending_date}}">
                    <input type="hidden" name="received_date" value="{{$data->received_date}}">
                    <input type="hidden" name="approve_yn" value="Y">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="input-required required" style="color: black">Service Cost</label>
                                    <input type="text" class="form-control" name="service_charge" required value="{{$data->service_charge}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 10px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" name="save"
                                                        class="btn btn-dark shadow mr-1 mb-1">Approve
                                                </button>
                                                <button type="reset" class="btn btn-outline-dark mb-1"
                                                        data-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
