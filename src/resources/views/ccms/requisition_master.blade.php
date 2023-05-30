@extends('layouts.default')

@section('title')
    Requisition Master
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
        @include('ccms/requisition_master_form')

            <!--List-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Equipment Requisition  List</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable"
                                   data-url="{{ route('requisition-master-datatable.data')}}"
                                   data-csrf="{{csrf_token() }}" data-page="10">
                                <thead>
                                <tr>
                                    <th data-col="DT_RowIndex">SL</th>
                                    <th data-col="requisition_id">REQUISITION ID</th>
                                    <th data-col="ticket_yn">TICKET YN</th>
                                    <th data-col="ticket_no">TICKET NO</th>
                                    <th data-col="requisition_for">REQUISITION FOR</th>
                                    <th data-col="requisition_note">REQUISITION NOTE</th>
                                    <th data-col="requisition_date">REQUISITION DATE</th>
                                    <th data-col="requistion_by">REQUISITION BY</th>
                                    <th data-col="approved_yn">APPROVED YN</th>
                                    <th data-col="approved_by">APPROVED BY</th>
                                    <th data-col="approved_date">APPROVED DATE</th>

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

