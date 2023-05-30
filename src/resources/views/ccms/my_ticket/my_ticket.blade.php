@extends('layouts.default')

@section('title')
    My Ticket
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body" style="@if(\Request::get('id')) display: block @else display: none @endif" id="my_ticket">
                        <h4 class="card-title text-uppercase">
                          {{ $data && isset($data->ticket_no)?'Edit':'Add' }} Service Ticket
                        </h4>
                        <form method="POST" action="@if ($data && $data->ticket_no) {{route('my-service-ticket.update',['id' => $data->ticket_no])}} @else {{route('my-service-ticket.store')}} @endif">
                            {{ ($data && isset($data->ticket_no))?method_field('PUT'):'' }}
                            {!! csrf_field() !!}
                            @if ($data && $data->ticket_no)
                                <input type="hidden" name="ticket_no" value="{{$data->ticket_no}}">
                            @endif
                            <hr>
                            <input type="hidden" name="emp_id" value="{{auth()->user()->emp_id}}">
                            @include('ccms/my_ticket/my_ticket_form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>

          <!--List-->
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-md-6">
                          <h4 class="card-title text-uppercase">Service ticket List</h4>
                      </div>
                      <div class="col-md-6">
                          <div class="row float-right">
                              <button id="show_form" type="button" onclick="$('#my_ticket').toggle('slow')" class="btn btn-secondary mb-1 ml-1 hvr-underline-reveal">
                                  <i class="bx bx-plus"></i> Add New</button>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="card-content">
                  <div class="card-body card-dashboard">
                      <div class="table-responsive">
                          <table class="table table-sm table-striped table-hover table-bordered datatable text-uppercase"
                            data-url="{{ route('my_ticket.list')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                              <thead >
                                <tr class="text-nowrap">
                                    {{--<th data-col="DT_RowIndex">SL</th>--}}
                                    <th data-col="ticket_id">TICKET ID</th>
                                    <th data-col="ticket_internal_external_yn" title="Ticket Internal External YN">
                                      Ticket YN
                                    </th>
                                    <th data-col="ticket_type_no" title="TICKET TYPE NO">TYPE NO</th>
                                    <th data-col="ticket_description" title="TICKET DESCRIPTION">DESCRIPTION</th>
                                    <th data-col="ticket_priority_no" title="TICKET PRIORITY NO">PRIOR. NO</th>
                                    <th data-col="occurance_date" title="OCCURANCE DATE">OCCUR. DATE</th>
                                    <th data-col="meeting_start_time" title="MEETING START TIME">START TIME</th>
                                    <th data-col="meeting_end_time" title="MEETING END TIME">END TIME</th>
                                    <th data-col="meeting_room_no" title="MEETING ROOM NO">ROOM NO</th>
                                    <th data-col="action">action</th>
                                </tr>
                              </thead>
                              <tbody class="text-center">
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
    </div>
    <a href="" data-></a>
@endsection
