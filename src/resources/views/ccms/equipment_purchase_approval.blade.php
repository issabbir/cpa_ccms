@extends('layouts.default')

@section('title')
	Equipment Purchase Request Approval
@endsection
@section('header-style')
	<style type="text/css">
		.bg-secondary tr>th {
			color: #fff;
		}
		div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_length {
		    margin: .40rem 0;
		}
	</style>
@endsection
@section('content')
<div class="container">

	<div class="card">
		<div class="card-header text-uppercase pb-0">
			<h5>Purchase Request Approval </h5>
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
						<label for="eqpvalue" class="form-control-label">Equipment Value</label>
						<input type="text" name="eqpvalue" disabled id="eqpvalue" class="form-control">
					</div>
					<div class="col-lg-4">
						<label for="purchasedate" class="form-control-label">Purchase Date</label>
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
						<label for="previouscost" class="form-control-label">Previous Cost</label>
						<input type="text" name="previouscost" disabled id="previouscost" class="form-control">
					</div>
					<div class="col-lg-12">
						<label for="investigation" class="form-control-label">Investigation Report</label>
						<input type="text" name="investigation" disabled id="investigation" class="form-control">
					</div>
					<div class="col-lg-12">
						<label for="verification" class="form-control-label">Verification Report</label>
						<input type="text" name="verification" disabled id="verification" class="form-control">
					</div>
					<div class="col-lg-12">
						<label for="requesteditems" class="form-control-label">Requested Items</label>
						<table class="table-sm table table-hover text-center table-bordered">
							<thead class="bg-secondary">
								<tr>
									<th>SL</th>
									<th>ITEM</th>
									<th>DESCRIPTION</th>
									<th>QUANTITY</th>
									<th>APPROX. COST</th>
									<th>ACTION</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>01</td>
									<td>RAM</td>
									<td>16 GB</td>
									<td>2</td>
									<td>5000</td>
									<td>
										<button type="button" class="btn btn-sm btn-outline-secondary">Approved</button>
									</td>
								</tr>
							</tbody>
						</table>
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
	                                <th>Requested Items</th>
	                                <th>Qty.</th>
	                                <th>Request Date</th>
	                                <th>Requested</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td><a href="#">T-001</a></td>
	                            		<td>CPA-PC-005</td>
	                            		<td>Ram 16GB</td>
	                            		<td>02</td>
	                            		<td>17-09-2020</td>
	                            		<td>Requested</td>
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