@extends('layouts.default')

@section('title')
	Service Engineer Assignment Maintenance
@endsection
@section('content')
<div class="container">

	<div class="card">
		<div class="card-header pb-0">
			<h5>Service Engineer Assignment Maintenance</h5>
		</div>
		<div class="card-body ">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-4">
						<label for="taskid" class="form-control-label">Task ID</label>
						<input type="text" name="task_id" id="task_id" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="equipment" class="form-control-label">Equipment</label>
						<input type="text" name="equipment" disabled id="equipment" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="user" class="form-control-label">User</label>
						<input type="text" name="user" disabled id="user" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="location" class="form-control-label">Location</label>
						<input type="text" name="location" disabled id="location" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="requestdate" class="form-control-label">Request Date</label>
						<input 	type="text" 
								autocomplete="off" 
								name="requestdate" 
								id="requestdate" 
								placeholder="yyyy-mm-dd" 
								class="form-control datetimepicker-input"
								data-toggle="datetimepicker"
								data-target="#requestdate"
								required
								disabled
								data-predefined-date="" 
						>
					</div>
					<div class="col-lg-4">
						<label for="warrantydate" class="form-control-label">Warranty Date</label>
						<input 	type="text" 
								autocomplete="off" 
								name="warrantydate" 
								id="warrantydate" 
								placeholder="yyyy-mm-dd" 
								class="form-control datetimepicker-input"
								data-toggle="datetimepicker"
								data-target="#warrantydate"
								required
								disabled
								data-predefined-date="" 
						>
					</div>
					<div class="col-lg-4">
						<label for="lastmainten" class="form-control-label">Last Maintenance Date</label>
						<input 	type="text" 
								autocomplete="off" 
								name="lastmainten" 
								id="lastmainten" 
								placeholder="yyyy-mm-dd" 
								class="form-control datetimepicker-input"
								data-toggle="datetimepicker"
								data-target="#lastmainten"
								required
								disabled
								data-predefined-date="" 
						>
					</div>
					<div class="col-lg-4">
						<label for="maintenval" class="form-control-label">Maintenance Value</label>
						<input type="text" name="maintenval" disabled id="maintenval" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="vendor" class="form-control-label">Vendor</label>
						<input type="text" name="vendor" disabled id="vendor" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="probtype" class="form-control-label">Problem Type</label>
						<select name="probtype" class="form-control" id="probtype">
							<option value="">Choose Problem</option>
							<option value="pc">Hardware & Software</option>
							<option value="printer">Hardware</option>
							<option value="scanner">Software</option>
						</select>
					</div>
					<div class="col-lg-8">
						<label for="problem" class="form-control-label">Problem</label>
						<textarea name="problem" style="height: 37px" id="problem" class="form-control" cols="30"></textarea>
					</div>
					<div class="col-lg-4">
						<label for="assignto" class="form-control-label">Assign To</label>
						<select name="assignto" class="form-control" id="assignto">
							<option value="">Select One</option>
							<option value="pc">Jhon Doy</option>
							<option value="printer">Mark Jukerbarg</option>
							<option value="printer">Tim Cook</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="step" class="form-control-label">Step</label>
						<select name="step" class="form-control" id="step">
							<option value="">Select One</option>
							<option value="pc">Visit</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="remarks" class="form-control-label">Remarks</label>
						<textarea name="remarks" style="height: 37px" id="remarks" class="form-control" cols="30"></textarea>
					</div>
					<div class="col-lg-4 ml-auto mt-2">
						<input type="submit" name="submit" value="Save" class="btn btn-secondary" style="margin-left: 98px;">
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
	                <h5 class="card-title">Service Engineer Work Log</h5>
	                <div class="card-content">
	                    <div class="table-responsive">
	                        <table id="userwisereport" class="table table-sm table-bordered table-striped datatable mdl-data-table dataTable text-uppercase">
	                            <thead>
	                            <tr>
	                                <th>SL</th>
	                                <th>Task ID</th>
	                                <th>Assign Date</th>
	                                <th>Status</th>
	                                <th>Step</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>T-001</td>
	                            		<td>01-01-2020</td>
	                            		<td>In Progress</td>
	                            		<td>Visit</td>
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
	$(document).ready(function () {
		$('#userwisereport').DataTable({
			searching: true,
		});
		datePicker('#requestdate');
		datePicker('#warrantydate');
		datePicker('#lastmainten');
	});
</script>

@endsection