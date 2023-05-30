@extends('layouts.default')

@section('title')
	Service Engineer Visit Result
@endsection
@section('content')
<div class="container">

	<div class="card">
		<div class="card-header pb-0">
			<h5>Service Engineer Visit Result</h5>
		</div>
		<div class="card-body">
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
						<label for="visitdate" class="form-control-label">Visit Date</label>
						<input 	type="text" 
								autocomplete="off" 
								name="visitdate" 
								id="visitdate" 
								placeholder="yyyy-mm-dd" 
								class="form-control datetimepicker-input"
								data-toggle="datetimepicker"
								data-target="#visitdate"
								required
								disabled
								data-predefined-date="" 
						>
					</div>
					<div class="col-lg-8">
						<label for="probdetl" class="form-control-label">Problem Details</label>
						<textarea name="probdetl" style="height: 37px" disabled id="probdetl" class="form-control" cols="30"></textarea>
					</div>
					<div class="col-lg-4">
						<label for="servstatus" class="form-control-label">Service Status</label>
						<select name="servstatus" class="form-control" id="servstatus">
							<option value="">Select Status</option>
							<option value="pc">In Progress</option>
							<option value="printer">Resolved</option>
							<option value="scanner">Pending</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="nextstep" class="form-control-label">Next Step</label>
						<select name="nextstep" class="form-control" id="nextstep">
							<option value="">Select Step</option>
							<option value="pc">Service Room Diagnosis</option>
							<option value="printer">Purchase</option>
						</select>
					</div>
					<div class="col-lg-4 mt-2">
						<input type="submit" name="submit" value="Save" class="btn btn-sm btn-secondary" style="margin-left: 98px;">
						<input type="reset" value="Cancel" class="btn btn-sm btn-outline-secondary ml-2">
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
	                        <table id="userwisereport" class="table table-sm datatable table-bordered mdl-data-table dataTable text-uppercase">
	                            <thead>
	                            <tr>
	                                <th>SL</th>
	                                <th>Task ID</th>
	                                <th>Equipment</th>
	                                <th>Request Date</th>
	                                <th>Solved At</th>
	                                <th>Status</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>T-003</td>
	                            		<td>CPA-SC-01</td>
	                            		<td>10-08-2020</td>
	                            		<td>14-08-2020</td>
	                            		<td>Resolved</td>
	                            	</tr>
	                            	<tr>
	                            		<td>02</td>
	                            		<td>T-005</td>
	                            		<td>CPA-PC-10</td>
	                            		<td>11-09-2020</td>
	                            		<td> - </td>
	                            		<td>In Progress</td>
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
		datePicker('#visitdate');
	});
</script>

@endsection