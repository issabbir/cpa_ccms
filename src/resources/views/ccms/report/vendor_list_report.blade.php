@extends('layouts.default')

@section('title')
	Vendor List Report
@endsection
@section('header-style')
	<style type="text/css">
		div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_length {
			    margin: .40rem 0;
			}
	</style>
@endsection
@section('content')
<div class="container">

	<div class="card">
		<div class="card-header text-uppercase pb-0">
			<h5>Vendor List Report </h5>
		</div>
		<div class="card-body ">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-4">
						<label for="status" class="form-control-label required">Status</label>
						<select name="status" class="form-control" id="status">
							<option value="">Select One</option>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
					<div class="col-lg-4 date">
						<div class="row ">
						    <div class="col-md-12">
						        <label class="input-required required">Enlistment From</label>
						        <div class="input-group date" onfocusout="$(this).datetimepicker('hide')" id="enlistmentdate" data-target-input="nearest">
						            <input type="text" name="berthing_at"
						                   class="form-control berthing_at"
						                   data-target="#enlistmentdate"
						                   data-toggle="datetimepicker"
						                   placeholder="Enlistment From"
						                   oninput="this.value = this.value.toUpperCase()"
						            />
						            <div class="input-group-append" data-target="#enlistmentdate" data-toggle="datetimepicker">
						                <div class="input-group-text">
						                    <i class="bx bx-calendar"></i>
						                </div>
						            </div>
						        </div>
						    </div>
						</div>
					</div>
					<div class="col-lg-4 mt-2">
						<input type="submit" name="submit" value="Report" class="btn btn-secondary">
						<input type="reset" value="Cancel" class="btn btn-outline-secondary ml-2">
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="card">
	    <div class="card-body">
	        <div class="row">
	            <div class="col-12">
	                <div class="card-content">
	                    <div class="table-responsive">
	                        <table id="userwisereport" class="table table-sm table-bordered datatable mdl-data-table dataTable text-uppercase">
	                            <thead>
	                            <tr>
	                                <th>SL</th>
	                                <th>Name</th>
	                                <th>Address</th>
	                                <th>Phone No.</th>
	                                <th>Contact Person</th>
	                                <th>Emlistment Date</th>
	                                <th>Status</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>Flora Limited</td>
	                            		<td>30 Agrabad Chittagong</td>
	                            		<td>031-715363</td>
	                            		<td>Shohel Ahmed</td>
	                            		<td>01-01-2019</td>
	                            		<td>Active</td>
	                            	</tr>
	                            	<tr>
	                            		<td>02</td>
	                            		<td>Computer Source</td>
	                            		<td>45 Kazir Deori</td>
	                            		<td>031-456521</td>
	                            		<td>Humayun Kabir</td>
	                            		<td>01-01-2018</td>
	                            		<td>Active</td>
	                            	</tr>
	                            	<tr>
	                            		<td>03</td>
	                            		<td>Narashibad PC</td>
	                            		<td>92 Hali Shahar</td>
	                            		<td>031-420420</td>
	                            		<td>Iqbal Hossain</td>
	                            		<td>01-01-2017</td>
	                            		<td>Inactive</td>
	                            	</tr>
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection

@section('footer-script')
<script type="text/javascript">
	$(function () {
	    $('#enlistmentdate').datetimepicker(
	        {
	            format: 'DD-MM-YYYY',
	        }
	    );

	});
</script>

@endsection