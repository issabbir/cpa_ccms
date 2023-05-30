@extends('layouts.default')

@section('title')
    Maintenance Log
@endsection

@section('header-style')
    <!--Load custom style link or css-->
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
{{--            <div class="card">--}}
{{--                <div class="card-content">--}}
{{--                    <div class="card-body">--}}
{{--                        <h4 class="card-title"> {{ isset($data->id)?'Edit':'Add' }}Maintenance Log </h4>--}}
{{--                        <form method="POST" action="">--}}
{{--                            {{ isset($data->id)?method_field('PUT'):'' }}--}}
{{--                            {!! csrf_field() !!}--}}

{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <!--List-->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Maintenance Log</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table table-sm datatable">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>DATE</th>
                                    <th>EQP NO</th>
                                    <th>EMP</th>
                                    <th>LOCATION</th>
                                    <th>PROBLEM TYPE</th>
                                    <th>STATUS</th>
                                    <th>ASSIGNMENT PERSON</th>
                                    <th>REMARKS</th>
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


@endsection
