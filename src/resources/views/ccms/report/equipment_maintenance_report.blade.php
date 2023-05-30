@extends('layouts.default')

@section('title')
	User Wise Equipment Report
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
			<h5>Equipment wise maintenance Report </h5>
		</div>
		<div class="card-body">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-4">
						<label for="category" class="form-control-label">Category</label>
						<select name="category" class="form-control" id="category">
							<option value="">Select Category</option>
							<option value="pc">PC</option>
							<option value="printer">Printer</option>
							<option value="scanner">Scanner</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="equipment" class="form-control-label">Equipment</label>
						<select name="equipment" class="form-control" id="problem">
							<option value="">Choose Equipment ID</option>
							<option value="pc">CPA-PC-005</option>
							<option value="printer">CPA-PRT-001</option>
							<option value="scanner">CPA-PRT-002</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="status" class="form-control-label">Status</label>
						<select name="status" class="form-control" id="status">
							<option value="">All</option>
							<option value="inprogress">In Progress</option>
							<option value="waiting">Waiting for parts</option>
							<option value="resolved">Resolved</option>
						</select>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-lg-auto ml-auto">
						<input type="submit" name="submit" value="Report" class="btn btn-secondary btn-sm">
						<input type="reset" value="Cancel" class="btn btn-outline-secondary btn-sm ml-2">
					</div>
				</div>
			</form>
		</div>
		<div class="card-body pt-0">
			<div class="row">
				<div class="col-lg-4">
					<label for="eqpid" class="form-control-label">Equipment ID</label>
					<input type="text" class="form-control" name="eqpid" id="eqpid">
				</div>
				<div class="col-lg-4">
					<label for="category" class="form-control-label">Category</label>
					<input type="text" class="form-control" name="category" id="category">
				</div>
				<div class="col-lg-4">
					<label for="equipmentname" class="form-control-label">Equipment Name</label>
					<input type="text" class="form-control" name="equipmentname" id="equipmentname">
				</div>
				<div class="col-lg-4">
					<label for="vendor" class="form-control-label">Vendor</label>
					<input type="text" class="form-control" name="vendor" id="vendor">
				</div>
				<div class="col-lg-4">
					<label for="purchasedate" class="form-control-label">Purchase Date</label>
					<input type="text" class="form-control" name="purchasedate" id="purchasedate">
				</div>
				<div class="col-lg-4">
					<label for="warrantydate" class="form-control-label">Warranty Date</label>
					<input type="text" class="form-control" name="warrantydate" id="warrantydate">
				</div>
				<div class="col-lg-4">
					<label for="value" class="form-control-label">Value</label>
					<input type="text" class="form-control" name="value" id="value">
				</div>
				<div class="col-lg-4">
					<label for="nofmaintenance" class="form-control-label">No Of Maintenance</label>
					<input type="text" class="form-control" name="nofmaintenance" id="nofmaintenance">
				</div>
				<div class="col-lg-4">
					<label for="user" class="form-control-label">User</label>
					<input type="text" class="form-control" name="user" id="user">
				</div>
				<div class="col-lg-4">
					<label for="maintenancecost" class="form-control-label">Maintenance Cost</label>
					<input type="text" class="form-control" name="maintenancecost" id="maintenancecost">
				</div>
			</div>
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
	                                <th>Ticket Date</th>
	                                <th>Problem</th>
	                                <th>Resolved Date</th>
	                                <th>Parts</th>
	                                <th>Parts Value</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>10-08-2020</td>
	                            		<td>Software & Hardware</td>
	                            		<td>14-08-2020</td>
	                            		<td>Cooler Fan</td>
	                            		<td>1500</td>
	                            	</tr>
	                            	<tr>
	                            		<td>02</td>
	                            		<td>01-06-2020</td>
	                            		<td>Hardware</td>
	                            		<td>10-06-2020</td>
	                            		<td>Ram</td>
	                            		<td>6000</td>
	                            	</tr>
	                            	<tr>
	                            		<td>03</td>
	                            		<td>01-06-2020</td>
	                            		<td>Hardware</td>
	                            		<td>10-06-2020</td>
	                            		<td>HDD</td>
	                            		<td>6250</td>
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
	});
</script>

@endsection