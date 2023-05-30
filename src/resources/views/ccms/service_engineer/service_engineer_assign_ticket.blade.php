@extends('layouts.default')

@section('title')
    Manage vendors
@endsection

@section('header-style')
    <!--Load custom style link or css-->
    <style type="text/css">
        .table td:nth-last-child(1), th:nth-last-child(1) {
            text-align: center;
        }
    </style>
@endsection

@section('content')
<div class="row">      <!--List-->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-uppercase">Assigned Service ticket List</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="col-lg-12">
                        {{--<table class="table table-sm table-striped table-hover datatable text-uppercase"
                               data-url="{{ route('service-engineer-tickets.data')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                            <thead >
                            <tr class="text-nowrap">
                                <th data-col="DT_RowIndex">SL</th>
                                <th data-col="ticket_no">TICKET NO</th>
                                <th data-col="assigned_by_emp_name">Assigned By</th>
                                <th data-col="assignment_date">Assignment Date</th>
                                <th data-col="assignment_note">Assignment Note</th>
                                <th data-col="emp_name">Ticket For</th>
                                <th data-col="action">action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>--}}
                        <table class="table table-sm table-bordered datatable text-uppercase" id="service-ticket"
                               data-url="{{ route('service-engineer-tickets.data')}}" data-csrf="{{ csrf_token() }}" data-page="10">
                            <thead >
                            <tr class="text-nowrap">
                                <th data-col="DT_RowIndex">SL</th>
                                <th data-col="ticket_id">TICKET ID</th>
                                <th data-col="ticket_type_no" title="TICKET TYPE NO">TICKET TYPE</th>
                                <th data-col="equipment_name">equipment name</th>
                                <th data-col="description" title="TICKET DESCRIPTION">DESCRIPTION</th>
                                <th data-col="emp_id" title="EMPLOYEE ID">Employee/Department</th>
                                <th data-col="ticket_priority" title="TICKET PRIORITY NO">priority</th>
                                <th data-col="ticket_internal_external_yn" title="Ticket Internal External YN">
                                    Is Internal
                                </th>
                                <th data-col="ticket_status" title="Ticket Status">
                                    Ticket Status
                                </th>
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
</div>
<a href="" data-></a>
@endsection


@section('footer-script')
    <!--Load custom script route('service_ticket.ticket_dtl', ['id' => $data['ticket_no']])-->
    <script>
        // $(document).on('click', '.show-modal', function(id){
        //   $('#show').modal('show');
        //   $('#tn').text($(this).data('ticket_no'));
        //   $('#tid').text($(this).data('ticket_id'));
        //   $('#ttn').text($(this).data('ticket_type_no'));
        //   $('#td').text($(this).data('ticket_description'));
        //   $('#tpn').text($(this).data('ticket_priority_no'));
        //   $('#ei').text($(this).data('emp_id'));
        //   $('#ocd').text($(this).data('occurance_date'));
        //   $('#mst').text($(this).data('meeting_start_time'));
        //   $('#met').text($(this).data('meeting_end_time'));
        //   $('#mrn').text($(this).data('meeting_room_no'));
        //   $('.modal-title').text('Show Ticket Detail');
        // });
          // $('#exampleModal').modal('show');

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
            // timePicker("#meeting_start_time");
            // timePicker("#meeting_end_time");
             datePicker("#occurance_date");
            //dateTimePicker("#occurance_date");
            dateTimePicker("#meeting_end_time");
            dateTimePicker("#meeting_start_time");

        });
    </script>
@endsection
