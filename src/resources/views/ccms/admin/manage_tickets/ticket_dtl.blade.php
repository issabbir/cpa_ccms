@extends('layouts.default')

@section('title')
    Service Ticket Details
@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style type="text/css">
        .bg-success {
            padding: 6px 15px;
            border-radius: 5px;
            box-shadow: 6px 7px 10px rgba(0, 0, 0, 0.5);
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    @php
        $se = new \App\Entities\Ccms\ServiceEngineerInfoList();
        $se  = $se->where('user_name', Auth::user()->user_name)->first();
        $se_no = '';
            if ($se)
            $se_no = ($se->service_engineer_id);

    @endphp
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <span class="card-title font-weight-bold text-uppercase">
                      Service Ticket Details
                    </span>
                    {{--                    <a href="" class="btn btn-info btn-sm">Assign</a>--}}
                    <div class="row">
                        <ul class="nav nav-pills">
                            {{--@if($countTicketNo->count_data>0)
                                @if (!$se_no)
                                    <li class="nav-item">
                                        <a class="nav-link active bg-secondary" target="_blank"
                                           href='/setup/service-engineer-info?id={{$assignedTo->service_engineer_info_id}}'>Already
                                            Assigned To: {{ ($assignedTo)?$assignedTo->service_engineer_name:'' }}</a>
                                    </li>
                                @endif
                            @endif--}}
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal"
                                   data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="bx bx-navigation"></i> Action</a>
                                <div class="dropdown-menu" style="">
                                    @if (!$se_no)
                                        @if((auth()->user()->hasRole('CCMS_ADMIN')||auth()->user()->hasRole('CCMS_SYSTEM_ANALYST')))
                                            <a class="dropdown-item show-modal hvr-underline-reveal"
                                               href="javascript:void(0)">
                                                <i class="bx bx-task"></i> &nbsp;Re-assign
                                            </a>
                                        @endif
                                     @php
                                        $assigned_to = \DB::selectOne('SELECT SEI.SERVICE_ENGINEER_NAME
                                           FROM SERVICE_TICKET ST
                                            INNER JOIN  SERVICE_ENGINEER_INFO SEI ON (SEI.SERVICE_ENGINEER_ID = ST.ASSIGN_ENGINEER_ID)
                                            WHERE ST.TICKET_NO = :ticket_no', ['ticket_no' => $data['ticket_no']]);
                                     @endphp
                                        @if(!$assigned_to)
                                            <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                               href="{{ route('service_ticket.index', ['id' => $data['ticket_no']]) }}"
                                               class="">
                                                <i class="bx bx-edit cursor-pointer"></i> &nbsp;Edit Ticket
                                            </a>
                                            <div class="dropdown-divider"></div>
                                        @endif
                                    @endif
                                   @if($countEqpNo->count_data=='0')
                                        @if($getTicketDetls->equipment_no)
                                            @if(auth()->user()->hasRole('CCMS_SERVICE_ENGINEER') || auth()->user()->hasRole('CCMS_TICKET_MANAGER'))
                                                <a class="dropdown-item show-receive-modal hvr-underline-reveal"
                                                   href="javascript:void(0)">
                                                    <i class="bx bx-task"></i> &nbsp;Receive Equipment
                                                </a>
                                            @endif
                                       @endif
                                    @else
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right" class="dropdown-item bd-success">
                                    <i class="bx bxs-tag"></i>&nbsp; <span class="text-info">Already Received</span> </a>
                                    @endif
                                    @if($se_no)
                                        @if($getTicketDetls->equipment_no!=null)
{{--                                            @if($getTicketDetls->service_status_no != "1005")--}}
{{--                                                @if($getTicketDetls->service_status_no != "1008")--}}
                                                    <a class="dropdown-item hvr-underline-reveal"
                                                       href="{{route('admin.requisition-master.index','id='.'equipment_no='.\Request::get('id'))  }}">
                                                        <i class="bx bx-plus-circle"></i>&nbsp; Make A Requisition</a>
{{--                                                @endif--}}
{{--                                            @endif--}}
                                        @endif
{{--                                        @if(empty($countTpsNo->count_data) && $getTicketDetls->equipment_no!=null)--}}
                                        @if($getTicketDetls->equipment_no!=null && auth()->user()->hasRole('CCMS_SERVICE_ENGINEER'))
                                            <a class="dropdown-item show-third-party-modal hvr-underline-reveal"
                                               href="javascript:void(0)">
                                                <i class="bx bx-plus-circle"></i>&nbsp; Add 3rd Party service</a>
                                        @endif
                                    @endif
                                  @if(auth()->user()->hasRole('CCMS_ADMIN') || auth()->user()->hasRole('CCMS_SERVICE_ENGINEER'))
                                    <a class="dropdown-item show-action-modal hvr-underline-reveal"
                                       href="javascript:void(0)">
                                        <i class="bx bxs-comment-add"></i> &nbsp;Add Ticket Action
                                    </a>
                                 @endif
                                </div>
                            </li>
                        </ul> {{-- javascript:history.go(-1) --}}
{{--                        <a class="btn btn btn-outline-dark hvr-underline-reveal mb-1"--}}
{{--                           href="#" onclick="history.go(-1); return false">--}}
{{--                            <i class="bx bx-arrow-back"></i> Back--}}
{{--                        </a>--}}
                        <ul class="nav nav-pills">
                            <li class="nav-item dropdown nav-fill">
                                <a class="nav-link dropdown-toggle bg-secondary text-white hvr-underline-reveal"
                                   data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                                   aria-expanded="false">
                                    <i class="bx bx-down-arrow-circle"></i>
                                    Print
                                </a>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                       href="{{url('/report/render/RPT_SERVICE_TICKET_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_TICKET_DETAILS.xdo&p_ticket_no='.\Request::get('id').'&type=pdf&filename=RPT_SERVICE_TICKET_DETAILS')}}">
                                        <i class="bx bxs-file-pdf"></i> PDF
                                    </a>
                                    <a class="dropdown-item hvr-underline-reveal" target="_blank"
                                       href="{{url('/report/render/RPT_SERVICE_TICKET_DETAILS?xdo=/~weblogic/CCMS/RPT_SERVICE_TICKET_DETAILS.xdo&p_ticket_no='.\Request::get('id').'&type=xlsx&filename=RPT_SERVICE_TICKET_DETAILS')}}">
                                        <i class="bx bxs-file-pdf"></i> Excel
                                    </a>
                                </div>
                            </li>
                        </ul>
                        @if($se_no)
                            <a class="btn btn btn-outline-dark  mb-1" href="{{ route('service-engineer-tickets.index') }}">
                                <i class="bx bx-arrow-back"></i> Back
                            </a>
                        @else
                            <a class="btn btn btn-outline-dark  mb-1" href="{{ route('service_ticket.index') }}">
                                <i class="bx bx-arrow-back"></i> Back
                            </a>
                        @endif
                    </div>
                </div>
                <hr>
                @if(!empty($countTicketNo->count_data))
                    @if (!$se_no)
                        <div class="bs-component pl-1 pr-1">
                            <div class="alert alert-dismissible alert-static-success">
                                <h4 class="alert-heading">
                                        Assigned To: {{ ($assignedTo)?$assignedTo->service_engineer_name:'' }}</h4>
                                <h6><p class="mb-0 ml-1">{{ ($assignedTo)?$assignedTo->assignment_note:'' }}</p></h6>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="card-body">
                    <div class="row mb-1">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class="pl-5 text-nowrap" width="200"><strong>Ticket Id <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_id:''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket Type <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_type:''}}</td>
                            </tr>
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket Priority <span>:</span></strong></td>
                                <td>{{ ($getTicketDetls)?$getTicketDetls->ticket_priority:'' }}</td>
                            </tr>
                            @if($getTicketDetls->equipment_no!=null)
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Assigned Equipment <span>:</span></strong></td>
                                    <td>
                                        <a href="{{route('admin.equipment-list.detail',['id' => $getTicketDetls->equipment_no])}}" target="_blank"><span>{{$getTicketDetls->equipment_name}}</span></a>
                                    </td>
                                </tr>
                            @endif
                            @if($getTicketDetls->ticket_type_no=='1004')
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Occurance Date <span>:</span></strong></td>
                                    <td>{{($getTicketDetls)?date('d-m-Y', strtotime($getTicketDetls->occurance_date)):''}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Meeting Start Time <span>:</span></strong></td>
                                    <td>{{($getTicketDetls)?date('h:i A', strtotime($getTicketDetls->meeting_start_time)):''}}</td>
                                </tr>
                                <tr>
                                    <td class="pl-5 text-nowrap"><strong>Meeting End Time <span>:</span></strong></td>
                                    <td>{{($getTicketDetls)?date('h:i A', strtotime($getTicketDetls->meeting_end_time)):''}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="pl-5 text-nowrap"><strong>Ticket Description <span>:</span></strong></td>
                                <td>{!! strip_tags(($getTicketDetls)?$getTicketDetls->ticket_description:'') !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Service Ticket Action Modal --}}
    <div id="show-action" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">
                      <i class="fas fa-check"></i> Assign</a> --}}
                    <h4 class="modal-title text-uppercase text-left">
                        Service Ticket Action
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body bg-rgba-secondary">
                    <form method="POST" action="{{route('service-ticket.storeComment')}}">
                        {{ ($data && isset($data->ticket_no))?method_field('PUT'):'' }}
                        {!! csrf_field() !!}
                        @if ($data && $data->ticket_no)
                            <input type="hidden" name="ticket_no" value="{{$data->ticket_no}}">
                        @endif
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">SERVICE TICKET ACTION</label>
                                        <label for="equipment_id"></label>
                                        <select id="action_no" required name="action_no" class="form-control select2">
                                            <option value="">Select one</option>
                                            @foreach($getTicketAction as $ticketAction)
                                                <option
                                                    {{ ( old("action_no", ($data)?$data->action_no:'') == $ticketAction->action_no) ? "selected" : ""  }} value="{{$ticketAction->action_no}}">{{$ticketAction->action_description}}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="emp_id" value="{{auth()->user()->emp_id}}">
                                        @if($errors->has("action_no"))
                                            <span class="help-block">{{$errors->first("action_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">STATUS</label>
                                        <select id="status_no" required name="status_no" class="form-control select2">
                                            <option value="">Select one</option>
                                            @foreach($getServiceStatus as $serviceStatus)
                                                <option
                                                    {{ ( old("status_no", ($data)?$data->status_no:'') == $serviceStatus->status_no) ? "selected" : ""  }} value="{{$serviceStatus->status_no}}">{{$serviceStatus->status_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("status_no"))
                                            <span class="help-block">{{$errors->first("status_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">ACTION NOTE </label>
                                        <textarea name="action_note" required placeholder="ACTION NOTE"
                                                  cols="50" class="form-control"
                                                  oninput="this.value = this.value.toUpperCase()">{{ old('action_note', ($data)?$data->action_note:'') }}</textarea>
                                        @if($errors->has("action_note"))
                                            <span class="help-block">{{$errors->first("action_note")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="row my-1">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" name="save" class="btn btn-dark shadow mr-1 mb-1">
                                                <i class="bx bxs-save"></i> SAVE
                                            </button>
                                            <button type="reset" class="btn btn-outline-dark mb-1" data-dismiss="modal">
                                                <i class="bx bx-window-close"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Service Equipment Receive Modal --}}
    <div id="show-receive" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase text-left">
                        Service Equipment Receive
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('equip-receive.store') }}">
                        {{ ($eqReceivedata && isset($eqReceivedata->receipt_no))?method_field('PUT'):'' }}
                        {!! csrf_field() !!}
                        @if ($eqReceivedata && $eqReceivedata->receipt_no)
                            <input type="hidden" name="receipt_no" value="{{$eqReceivedata->receipt_no}}">
                        @endif
                        @if ($eqReceivedata && $eqReceivedata->ticket_id)
                            <input type="hidden" name="ticket_id" value="{{$eqReceivedata->ticket_id}}">
                        @endif
                        <hr>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">Receipt ID</label>
                                        <input type="text"
                                               readonly
                                               required
                                               id="receipt_id"
                                               name="receipt_id"
                                               value="{{ old('receipt_id', ($eqReceivedata)?$eqReceivedata->receipt_id:$gen_uniq_id) }}"
                                               placeholder="Receipt ID"
                                               class="form-control text-uppercase">
                                        @if($errors->has("receipt_id"))
                                            <span class="help-block">{{$errors->first("receipt_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required"> TICKET NO</label>
                                        <input type="text" class="form-control" name="ticket_no" readonly value="{{ \Request::get('id') }}">
                                        @if($errors->has("ticket_no"))
                                            <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="@if(empty($eqReceivedata->equipment_no)) display:block @else display:none @endif">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">Equipment NO</label>
                                        <input type="hidden" class="form-control" name="equipment_no"  value="{{ $getData->equipment_no }}">
                                        <input type="text" class="form-control" readonly value="{{ $getData->equipment_name }}">
                                        @if($errors->has("equipment_no"))
                                            <span class="help-block">{{$errors->first("equipment_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{$se_no}}" name="service_engineer_id" />
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label class="input-required">RECEIVED DATE<span class="required"></span></label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="received_date" data-target-input="nearest">
                                            <input type="text" name="received_date"
                                                   value="{{ old('received_date', ($eqReceivedata)?$eqReceivedata->received_date:'') }}"
                                                   required
                                                   class="form-control berthing_at"
                                                   id="received_date_input"
                                                   data-target="#received_date"
                                                   data-toggle="datetimepicker"
                                                   placeholder="RECEIVED DATE">
                                            <div class="input-group-append" data-target="#received_date" data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("received_date"))
                                            <span class="help-block">{{$errors->first("received_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label>RECEIVED DOC </label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" >
                                            <input type="hidden" name="received_doc" id="received_doc" />
                                            <label class="custom-file-label" for="received_doc">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-md-4">--}}
{{--                                <div class="row ">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <label>DELIVERY DOC </label>--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" class="custom-file-input" id="file1" >--}}
{{--                                            <input type="hidden" name="delivery_doc" id="delivery_doc" />--}}
{{--                                            <label class="custom-file-label" for="delivery_doc">Choose file</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required ">RECEIVED NOTE</label>
                                        <textarea name="received_note" id="received_note" placeholder="RECEIVED NOTE" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('received_note', ($eqReceivedata)?$eqReceivedata->received_note:'') }}</textarea>
                                        @if($errors->has("received_note"))
                                            <span class="help-block">{{$errors->first("received_note")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row mt-1">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-end" style="margin-top: 20px">
                                            <button type="submit" name="save"
                                                    class="btn btn-dark shadow mr-1 mb-1">SAVE
                                            </button>
                                            <button type="reset" class="btn btn-outline-dark mb-1"
                                                    data-dismiss="modal">Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{--{{dd($ticketNumber)}}--}}
    {{-- Third Party Service Modal --}}
    <div id="show-third-party" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase text-left">
                        Third Party Service
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body bg-rgba-secondary">
                    <form method="POST" action="{{route('third-party.store')}}">
                        {!! csrf_field() !!}
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Equipment Name</label>
                                        <input type="text" class="form-control" disabled value="{{$getTicketDetls->equipment_name}}">
                                        <input type="hidden" value="{{$getTicketDetls->equipment_no}}" name="equipment_no">
                                        {{--<select  id="equipment_no" name="equipment_no" class="form-control select2">
                                            <option value="">Select one</option>
                                            @foreach($getEquipmentID as $equipmentID)
                                                <option {{ ( old("equipment_no", ($thardPartyData)?$thardPartyData->equipment_no:'') == $equipmentID->equipment_no) ? "selected" : ""  }}
                                                        value="{{$equipmentID->equipment_no}}">
                                                    {{$equipmentID->equipment_name}}</option>
                                            @endforeach
                                        </select>--}}
                                        @if($errors->has("equipment_no"))
                                            <span class="help-block">{{$errors->first("equipment_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(!empty(\Request::get('id')) && empty($thardPartyData))
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Ticket</label>
                                            <input type="text" hidden class="form-control" name="ticket_no" value="{{ ($getData)?$getData->ticket_no:'' }}">
                                            <input type="text" readonly class="form-control" value="{{ ($getData)?$getData->ticket_id:'' }}">
                                            @if($errors->has("ticket_id"))
                                                <span class="help-block">{{$errors->first("ticket_id")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required required">SENDING DATE</label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="sending_date" data-target-input="nearest">
                                                <input type="text" name="sending_date"
                                                       value="{{ old('sending_date',
                                                       ($thardPartyData)?$thardPartyData->sending_date:'') }}"
                                                       class="form-control berthing_at"
                                                       data-target="#sending_date" required
                                                       id="sending_date_input" autocomplete="off"
                                                       data-toggle="datetimepicker"
                                                       placeholder="SENDING DATE">
                                                <div   class="input-group-append"
                                                       data-target="#sending_date"
                                                       data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("sending_date"))
                                                <span class="help-block">{{$errors->first("sending_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <label class="input-required required">RECEIVED DATE</label>
                                            <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="tp_received_date" data-target-input="nearest">
                                                <input type="text" name="received_date"
                                                       value="{{ old('received_date',
                                                       ($thardPartyData)?$thardPartyData->received_date:'') }}"
                                                       class="form-control berthing_at" required
                                                       data-target="#tp_received_date"
                                                       id="received_date_input" autocomplete="off"
                                                       data-toggle="datetimepicker"
                                                       placeholder="RECEIVED DATE">
                                                <div   class="input-group-append"
                                                       data-target="#tp_received_date"
                                                       data-toggle="datetimepicker">
                                                    <div class="input-group-text">
                                                        <i class="bx bx-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($errors->has("received_date"))
                                                <span class="help-block">{{$errors->first("received_date")}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif(!empty($thardPartyData->ticket_no))
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="input-required required">Ticket No</label>
                                            <select  id="ticket_no" name="ticket_no" class="form-control select2">
                                                <option value="">Select one</option>
                                                @foreach($ticketNumber as $ticketNo)
                                                    <option {{ ( old("ticket_no", ($thardPartyData)?$thardPartyData->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
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
                                                @foreach($ticketNumber as $ticketNo)
                                                    <option {{ ( old("ticket_no", ($thardPartyData)?$thardPartyData->ticket_no:'') == $ticketNo->ticket_no) ? "selected" : ""  }}
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
{{--                            @dd($getVendorNo)--}}
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="required">Vendor Name</label>
{{--                                        <input type="text" class="form-control" disabled value="{{$getTicketDetls->vendor_name}}">--}}
{{--                                        <input type="hidden" value="{{$getTicketDetls->vendor_no}}" name="vendor_no">--}}
                                        <select  id="vendor_no" name="vendor_no" class="form-control select2" required>
                                            <option value="">Select one</option>
                                            @foreach($getVendorNo as $vendorNo)
                                                <option {{ ( old("vendor_no", ($thardPartyData)?$thardPartyData->vendor_no:'') == $vendorNo->vendor_no) ? "selected" : ""  }}
                                                        value="{{$vendorNo->vendor_no}}">
                                                    {{$vendorNo->vendor_name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("vendor_no"))
                                            <span class="help-block">{{$errors->first("vendor_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                        <div class="row mb-1">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">Service Charge</label>
                                        <input type="number"
                                               id="service_charge"
                                               name="service_charge"
                                               required
                                               value="{{ old('service_charge', ($thardPartyData)?$thardPartyData->service_charge:'') }}"
                                               placeholder="Service Charge"
                                               class="form-control text-uppercase">
                                        @if($errors->has("service_charge"))
                                            <span class="help-block">{{$errors->first("service_charge")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label class="input-required required">SENDING DATE</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="sending_date" data-target-input="nearest">
                                            <input type="text" name="sending_date"
                                                   value="{{ old('sending_date',
                                                       ($thardPartyData)?$thardPartyData->sending_date:'') }}"
                                                   class="form-control berthing_at"
                                                   data-target="#sending_date" required
                                                   id="sending_date_input" autocomplete="off"
                                                   data-toggle="datetimepicker"
                                                   placeholder="SENDING DATE">
                                            <div   class="input-group-append"
                                                   data-target="#sending_date"
                                                   data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("sending_date"))
                                            <span class="help-block">{{$errors->first("sending_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label class="input-required required">RECEIVED DATE</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="tp_received_date" data-target-input="nearest">
                                            <input type="text" name="received_date"
                                                   value="{{ old('received_date',
                                                       ($thardPartyData)?$thardPartyData->received_date:'') }}"
                                                   class="form-control berthing_at" required
                                                   data-target="#tp_received_date"
                                                   id="received_date_input" autocomplete="off"
                                                   data-toggle="datetimepicker"
                                                   placeholder="RECEIVED DATE">
                                            <div   class="input-group-append"
                                                   data-target="#tp_received_date"
                                                   data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("received_date"))
                                            <span class="help-block">{{$errors->first("received_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            @if(!auth()->user()->hasRole('CCMS_SERVICE_ENGINEER'))
                                <input type="hidden" name="service_charge">
                                <input type="hidden" name="received_date">
                                <input type="hidden" name="sending_date">
                            @endif
                        @endif
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">PROBLEM DESCRIPTION </label>
                                        <textarea style="height: 37px" required name="problem_description" id="editor" placeholder="PROBLEM DESCRIPTION" cols="30" class="form-control" oninput="this.value = this.value.toUpperCase()">{{ old('problem_description', ($thardPartyData)?$thardPartyData->problem_description:'') }}</textarea>
                                        @if($errors->has("problem_description"))
                                            <span class="help-block">{{$errors->first("problem_description")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: 30px">
                                <div class="row my-1">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            <button type="submit" name="save" class="btn btn-dark shadow mb-1">
                                                <i class="bx bx-save"></i> SAVE  </button>
                                            <button type="reset" class="btn btn-outline-dark mb-1" data-dismiss="modal">
                                                <i class="bx bx-window-close"></i> Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="card-title">Ticket Action list</h4>
                </div>
                <div class="col-md-12">
                    <div class="card-body comment-widgets">
                        <!-- Comment Row -->
                        @if(!empty($commentsData))
                            @foreach($commentsData as $key=>$data)
                                <div class="d-flex flex-row comment-row m-t-0"
                                     style="border: 2px solid #475F7B; border-radius: 5px">
                                    <!-- Comment Row -->
                                    <div class="comment-text w-100">
                                        <div class="row d-flex justify-content-between">
                                          <span class="ml-1 font-medium">
                                            <h5>{{$data->action_taken}}</h5>
                                          </span>
                                            <span><strong>Status : </strong>{{$data->status}}</span>
                                            <span class="text-muted pr-1">
                                                <span><strong>Posted By : </strong>{{$data->created_by}}</span><br>
                                                 {{date('d M, Y h:i A', strtotime($data->insert_date))}} <br>
                                                 {{$data->designation}} <br>
                                                 {{$data->department_name}} <br>
                                                 {{$data->contract}}
                                            </span>
                                        </div>
                                        <hr style="margin-top: 0">
                                        <span class="m-b-15 d-block">{{strip_tags($data->action_note)}}</span>
                                    </div>
                                </div> <!-- Card -->
                            @endforeach
                        @else
                            <div class="text-center"><h3 class="text-danger">No Comments Available !!</h3></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Requisition List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">REQUISITION ID</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION FOR</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION NOTE</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION STATUS</th>
                                    <th class="text-center" style="padding: 10px">REQUISITION DATE</th>
                                    {{--<th class="text-center" style="padding: 10px">APPROVED DATE</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($requisitionData))
                                    @foreach($requisitionData as $key=>$value)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.requisition-master.detail-view',['id' => $value->requisition_mst_no])}}"
                                                   target="_blank"><span>{{$value->requisition_id}}</span></a></td>
                                            <td>{{$value->requisition_for}}</td>
                                            <td>{{strip_tags($value->requisition_note)}}</td>
                                            <td>{!! $value->status_name == 'DELIVER TO STORE OFFICER' ? "<span class='badge badge-success'>APPROVED</span>" : $value->status_name !!}</td>
                                            <td>{{($value->requisition_date)?date('d-m-Y', strtotime($value->requisition_date)):''}}</td>
                                            {{--<td>{{($value->approved_date)?date('d-m-Y', strtotime($value->approved_date)):''}}</td>--}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <div style="width: 100%;text-align: center"><span>No Data Found</span></div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!--List-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Third Party List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead class="text-nowrap">
                                <tr>
                                    <th class="text-center" style="padding: 10px">TICKET NO</th>
                                    <th class="text-center" style="padding: 10px">VENDOR NAME</th>
                                    <th class="text-center" style="padding: 10px">EQUIPMENT NAME</th>
                                    <th class="text-center" style="padding: 10px">PROBLEM DESCRIPTION</th>
                                    @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                        <th class="text-center" style="padding: 10px">SERVICE CHARGE</th>
                                    @endif
                                    <th class="text-center" style="padding: 10px">SENDING DATE</th>
                                    <th class="text-center" style="padding: 10px">RECEIVED DATE</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty(!empty($thirdPartyData)))
                                    @foreach($thirdPartyData as $key=>$value)
                                        <tr>
                                            <td>
                                                <a href="{{route('admin.third_party.detail-view',['id' => $value->third_party_service_id])}}"
                                                   target="_blank"><span>{{$value->ticket_no}}</span></a></td>
                                            <td>{{$value->vendor_name}}</td>
                                            <td>{{$value->equipment_name}}</td>
                                            <td>{{strip_tags($value->problem_description)}}</td>
                                            @if (auth()->user()->hasRole('CCMS_SYSTEM_ANALYST'))
                                                <td>{{$value->service_charge}}</td>
                                            @endif
                                            <td>{{date('d-m-Y', strtotime($value->sending_date))}}</td>
                                            <td>{{date('d-m-Y', strtotime($value->received_date))}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <div style="width: 100%;text-align: center"><span>No Data Found</span></div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Show POST --}}
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-left"></h4>
                    {{-- <a class="btn btn-sm btn-primary" href="{{ route('ticket_assign.index', ['id'=>$data['ticket_no']]) }}">
                      <i class="fas fa-check"></i> Assign</a> --}}
                    <button class="close" type="button" data-dismiss="modal" area-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action=" @if ($assigndata && $assigndata->assignment_no)
                    {{route('service-ticket-assign.store','id='.\Request::get('id'))}} @else
                    {{route('service-ticket-assign.store','id='.\Request::get('id'))}} @endif">
                        {{ ($assigndata && isset($assigndata->assignment_no))?method_field('PUT'):'' }}
                        {!! csrf_field() !!}
                        @if ($assigndata && $assigndata->assignment_no)
                            <input type="hidden" name="assignment_no" value="{{$assigndata->assignment_no}}">
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required">ASSIGNMENT ID<span
                                                class="required"></span></label>
                                        <input type="text"
                                               readonly
                                               id="assignment_id"
                                               name="assignment_id"
                                               value="{{ old('assignment_id', ($assigndata)?$assigndata->assignment_id:$gen_uniq_id) }}"
                                               placeholder="ASSIGNMENT ID"
                                               class="form-control text-uppercase">
                                        @if($errors->has("assignment_id"))
                                            <span class="help-block">{{$errors->first("assignment_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">Ticket No</label>
                                        <input type="text"
                                               readonly
                                               id="ticket_no"
                                               name="ticket_no"
                                               value="{{ old('ticket_no', ($assigndata)?$assigndata->ticket_no:\Request::get('id')) }}"
                                               class="form-control text-uppercase">
                                        @if($errors->has("ticket_no"))
                                            <span class="help-block">{{$errors->first("ticket_no")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">SERVICE ENGINEER ID</label>
                                        <select id="service_engineer_id" name="service_engineer_id"
                                                class="form-control select2">
                                            <option value="">Select one</option>
                                            @foreach($getServiceEngineerId as $ServiceEngineerId)
                                                <option
                                                    {{ ( old("service_engineer_id", ($assigndata)?$assigndata->service_engineer_id:'') == $ServiceEngineerId->service_engineer_id) ? "selected" : ""  }}
                                                    value="{{$ServiceEngineerId->service_engineer_id}}" data-issue-status="{{isset($ServiceEngineerId->ticket_status)?$ServiceEngineerId->ticket_status:''}}">{{$ServiceEngineerId->service_engineer_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has("service_engineer_id"))
                                            <span class="help-block">{{$errors->first("service_engineer_id")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Assigned Issues</label>
                                        <input type="hidden" name="user_name" id="user_name" value=""/>
                                        <input type="text" id="assigned_issue" class="form-control" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Resolved Issues</label>
                                        <input type="text" id="resolved_issue" class="form-control" value="" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <label class="input-required required">ASSIGNMENT DATE</label>
                                        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')"
                                             id="assignment_date" data-target-input="nearest">
                                            <input type="text" name="assignment_date"
                                                   value="{{ old('assignment_date',
                                             ($assigndata)?$assigndata->assignment_date:'') }}"
                                                   class="form-control berthing_at"
                                                   data-target="#assignment_date"
                                                   data-toggle="datetimepicker"
                                                   id="assignment_date_input"
                                                   autocomplete="off"
                                                   placeholder="ASSIGNMENT DATE">
                                            <div class="input-group-append"
                                                 data-target="#assignment_date"
                                                 data-toggle="datetimepicker">
                                                <div class="input-group-text">
                                                    <i class="bx bx-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @if($errors->has("assignment_date"))
                                            <span class="help-block">{{$errors->first("assignment_date")}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--                    <div class="col-md-6">--}}
                            {{--                        <div class="row ">--}}
                            {{--                          <div class="col-md-12">--}}
                            {{--                            <label class="input-required">ASSIGN BY<span class="required"></span></label>--}}
                            {{--                            <input type="text"--}}
                            {{--                            id="assign_by"--}}
                            {{--                            name="assign_by"--}}
                            {{--                            value="{{ old('assign_by', ($assigndata)?$assigndata->assign_by:'') }}"--}}
                            {{--                            placeholder="ASSIGN BY"--}}
                            {{--                            class="form-control"--}}
                            {{--                            />--}}
                            {{--                            @if($errors->has("assign_by"))--}}
                            {{--                            <span class="help-block">{{$errors->first("assign_by")}}</span>--}}
                            {{--                            @endif--}}
                            {{--                          </div>--}}
                            {{--                        </div>--}}
                            {{--                      </div>--}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="input-required required">ASSIGNMENT NOTE </label>
                                        <textarea name="assignment_note" id="assignment_note"
                                                  placeholder="ASSIGNMENT NOTE" cols="30" class="form-control"
                                                  oninput="this.value = this.value.toUpperCase()">{{ old('assignment_note', ($assigndata)?$assigndata->assignment_note:'') }}</textarea>
                                        @if($errors->has("assignment_note"))
                                            <span class="help-block">{{$errors->first("assignment_note")}}</span>
                                        @endif
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
                                                            class="btn btn-dark shadow mr-1 mb-1">SAVE
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
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer-script')
    <!--Load custom script-->
    <script>
        var userRoles = '@php echo json_encode(Auth::user()->roles->pluck('role_key')); @endphp';
        //alert(userRoles);
        $('body').on('mouseenter mouseleave', '.dropdown', function (e) {
            var _d = $(e.target).closest('.dropdown');
            if (e.type === 'mouseenter') _d.addClass('show');
            setTimeout(function () {
                _d.toggleClass('show', _d.is(':hover'));
                $('[data-toggle="dropdown"]', _d).attr('aria-expanded', _d.is(':hover'));
            }, 300);
        });
        $('[data-dismiss=modal]').on('click', function (e) {
            var $t = $(this),
                target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
            $(target)
                .find("#assignment_date,#assignment_note,#assign_by,#service_engineer_id,select")
                .val('').end();
        })
        $(document).on('click', '.show-modal', function (id) {
            $('#show').modal('show');
            $('.modal-title').text('Service Ticket Re-Assign');
        });
        $(document).on('click', '.show-receive-modal', function (id) {
            $('#show-receive').modal('show');
            // $('.modal-title').text('Service Ticket Assign');
        });
        $(document).on('click', '.show-third-party-modal', function (id) {
            $('#show-third-party').modal('show');
            // $('.modal-title').text('Service Ticket Assign');
        });

        $(document).on('click', '.show-action-modal', function (id) {
            $('#show-action').modal('show');
        });

        $("#service_engineer_id").bind().on("change", function () {
            let issue_status = $(this).find(":selected").attr('data-issue-status');
            if(issue_status){
                let parseObj = JSON.parse(issue_status);
                setIssueStatus(parseObj);
            }else{
                $("#assigned_issue").val(0);
                $("#resolved_issue").val(0);
            }
        });


        function setIssueStatus(parseObj) {
            if(parseObj){
                $("#assigned_issue").val(parseObj.total_assigned_issues);
                $("#resolved_issue").val(parseObj.total_resolved_issues);
                $("#user_name").val(parseObj.user_name);
            }
        }

        $(document).ready(function () {
            //Date time picker
            function dateTimePicker(selector) {
                var elem = $(selector);
                elem.datetimepicker({
                    format: 'DD-MM-YYYY HH:mm A',
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
                    let preDefinedDateMomentFormat = moment(preDefinedDate, "YYYY-MM-DD HH:mm").format("YYYY-MM-DD HH:mm A");
                    elem.datetimepicker('defaultDate', preDefinedDateMomentFormat);
                }
            }

            //dateTimePicker("#occurance_date");
            dateTimePicker("#meeting_end_time");

            // timePicker("#meeting_start_time");
            // timePicker("#meeting_end_time");
            datePicker("#occurance_date");
            datePicker("#received_date");
            datePicker("#assignment_date");
            dateTimePicker("#meeting_start_time");
            minDateOff("#sending_date");
            // datePicker("#tp_received_date");
            dateRangePicker('#sending_date','#tp_received_date');

            $('#assignment_date_input').val(getSysDate());
            $('#received_date_input').val(getSysDate());

            function getBase64(file) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    $(document).find('#received_doc').val(reader.result);
                    $(document).find('#delivery_doc').val(reader.result);
                    console.log(reader.result);
                };
                reader.onerror = function (error) {
                    console.log('Error: ', error);
                };
            }

            $("#file").on('change', function(){
                var file = document.querySelector('#file').files[0];
                getBase64(file); // prints the base64 string
            });

            $("#file1").on('change', function(){
                var file = document.querySelector('#file1').files[0];
                getBase64(file); // prints the base64 string
            });

        });
    </script>
@endsection

{{-- onClick="window.location.href='{{ route('ticket_assign.index', ['id' => $data['ticket_no']]) }}'" --}}
