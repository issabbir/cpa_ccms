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
			<h5>Equipment list Report </h5>
		</div>
		<div class="card-body ">
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
						<label for="vendor" class="form-control-label">Vendor</label>
						<select name="vendor" class="form-control" id="problem">
							<option value="">Choose Vendor Name</option>
							<option value="pc">Flora Limited</option>
							<option value="printer">Computer Source</option>
							<option value="scanner">Daffodil Pc</option>
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
										<th>Equipment ID</th>
										<th>Category</th>
										<th>Name</th>
										<th>Vendor</th>
										<th>Price</th>
										<th>Purchase Date</th>
										<th>Warranty Date</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>01</td>
										<td>CPA-PC-005</td>
										<td>PC</td>
										<td>HP PC</td>
										<td>Flora Limited</td>
										<td>50000.00</td>
										<td>01-01-2020</td>
										<td>31-08-2020</td>
										<td>Working</td>
									</tr>
									<tr>
										<td>02</td>
										<td>CPA-PRT-001</td>
										<td>Printer</td>
										<td>Canon Laser Jet</td>
										<td>Computer Source</td>
										<td>21500.00</td>
										<td>02-01-2020</td>
										<td>31-09-2020</td>
										<td>Working</td>
									</tr>
									<tr>
										<td>02</td>
										<td>CPA-SCR-001</td>
										<td>Scanner</td>
										<td>Promax 2100</td>
										<td>Daffodil PC</td>
										<td>9700.00</td>
										<td>03-01-2020</td>
										<td>31-10-2020</td>
										<td>Servicing</td>
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