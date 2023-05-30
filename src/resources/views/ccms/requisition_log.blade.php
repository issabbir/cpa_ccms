@extends('layouts.default')

@section('title')
	REQUISITION LOG
@endsection
@section('header-style')
	<style type="text/css">
		.bg-secondary tr>th{
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
			<h5>Requisition Log</h5>
		</div>
	    <div class="card-body ">
	        <div class="row">
	            <div class="col-12">
	                <div class="card-content">
	                    <div class="table-responsive">
	                        <table id="userwisereport" class="table table-sm table-bordered datatable mdl-data-table dataTable text-uppercase">
	                            <thead>
	                            <tr>
	                                <th>SL</th>
	                                <th>TASK ID</th>
	                                <th>EQUIPMENT</th>
	                                <th>REQUESTED ITEMS</th>
	                                <th>QTY</th>
	                                <th>PREVIOUS COST</th>
	                                <th>LAST MAINTAENANCE</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td><a href="#">T-001</a></td>
	                            		<td>CPA-PC-005</td>
	                            		<td>RAM 16GB</td>
	                            		<td>2</td>
	                            		<td>20000.00</td>
	                            		<td>10-10-20</td>
	                            	</tr>
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="card">
		<div class="card-header text-uppercase pb-0">
			<h5>Request Purchase Approval<hr></h5>
		</div>
		<div class="card-body pt-0">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-6">
						<label for="equipment" class="form-control-label">Equipment</label>
						<input type="text" name="equipment" disabled id="equipment" class="form-control">
					</div>
					<div class="col-lg-6">
						<label for="user" class="form-control-label">USER</label>
						<input type="text" name="user" disabled id="user" class="form-control">
					</div>
					<div class="col-lg-12">
						<label for="" class="form-control-label">ITEMS</label>
						<table class="table-sm table table-hover table-bordered text-center table-bordered">
							<thead class="bg-secondary">
								<tr>
									<th>SL</th>
									<th>ITEM</th>
									<th>QTY.</th>
									<th>ACTION</th>
									<th>REMARKS</th>
									<th>APPROX. VALUE</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>01</td>
									<td>RAM 16GB</td>
									<td>2</td>
									<td>Purchase Request</td>
									<td>Required ASAP</td>
									<td>5000</td>
								</tr>
								<tr>
									<td>02</td>
									<td>Head Phone</td>
									<td>01</td>
									<td>Not Approved</td>
									<td>No Need</td>
									<td>-</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-lg-auto ml-auto">
						<input type="submit" name="submit" value="Save" class="btn btn-secondary btn-sm ">
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
	                        <table id="userwisereport" class="table table-sm table-bordered datatable mdl-data-table dataTable text-uppercase">
	                            <thead>
	                            <tr>
	                                <th>SL</th>
	                                <th>TASK ID</th>
	                                <th>EQUIPMENT</th>
	                                <th>REQUESTED ITEMS</th>
	                                <th>QTY</th>
	                                <th>Request Date</th>
	                                <th>Status</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>T-001</td>
	                            		<td>CPA-PC-005</td>
	                            		<td>RAM 16GB</td>
	                            		<td>2</td>
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