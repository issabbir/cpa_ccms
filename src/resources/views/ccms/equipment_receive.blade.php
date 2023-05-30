@extends('layouts.default')

@section('title')
	Equipment Receive
@endsection
@section('content')
<div class="container">

	<div class="card">
		<div class="card-header text-uppercase pb-0">
			<h5>Equipment Receive</h5>
		</div>
		<div class="card-body">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-4">
						<label for="taskid" class="form-control-label">Task ID</label>
						<input type="text" name="task_id" id="task_id" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="equipmentid" class="form-control-label">Equipment ID</label>
						<input type="text" name="equipmentid" disabled id="equipmentid" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="equipment" class="form-control-label">Equipment</label>
						<input type="text" name="equipment" disabled id="equipment" class="form-control">
					</div>
					<div class="col-lg-12">
						<label for="engstatement" class="form-control-label">Enginner Statement</label>
						<textarea name="engstatement" style="height: 37px" disabled id="engstatement" class="form-control" cols="30"></textarea>
					</div>
					<div class="col-lg-4">
						<label for="purchasedate" class="form-control-label">Investigation Date</label>
						<input 	type="text" 
								autocomplete="off" 
								name="purchasedate" 
								id="purchasedate" 
								placeholder="yyyy-mm-dd" 
								class="form-control datetimepicker-input"
								data-toggle="datetimepicker"
								data-target="#purchasedate"
								required
								disabled
								data-predefined-date="" 
						>
					</div>
					<div class="col-lg-4">
						<label for="warrantydate" class="form-control-label">Receive Date</label>
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
						<label for="receivedby" class="form-control-label">Received By</label>
						<select name="receivedby" class="form-control" id="receivedby">
							<option value="">Select Category</option>
							<option value="pc">PC</option>
							<option value="printer">Printer</option>
							<option value="scanner">Scanner</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="receivefrom" class="form-control-label">Receive From</label>
						<input type="text" name="receivefrom" id="receivefrom" class="form-control">
					</div>
					<div class="col-lg-8">
						<label for="eqpreceive" class="form-control-label">Equipment Receive</label>
						<textarea name="eqpreceive" style="height: 37px" id="eqpreceive" class="form-control" cols="30"></textarea>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-lg-auto ml-auto">
						<input type="submit" name="submit" value="Save" class="btn btn-secondary btn-sm">
						<input type="reset" value="Cancel" class="btn btn-outline-secondary btn-sm ml-2">
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
	                                <th>Receive Date</th>
	                                <th>Received By</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>T-003</td>
	                            		<td>CPA-SC-01</td>
	                            		<td>08-11-2020</td>
	                            		<td>Habib</td>
	                            	</tr>
	                            	<tr>
	                            		<td>02</td>
	                            		<td>T-005</td>
	                            		<td>CPA-PC-10</td>
	                            		<td>08-09-2020</td>
	                            		<td>Shihab</td>
	                            	</tr>
	                            	<tr>
	                            		<td>03</td>
	                            		<td>T-007</td>
	                            		<td>IPhone-X</td>
	                            		<td>09-08-2020</td>
	                            		<td>Rakibul</td>
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
		datePicker('#purchasedate');
		datePicker('#warrantydate');
	});
</script>

@endsection