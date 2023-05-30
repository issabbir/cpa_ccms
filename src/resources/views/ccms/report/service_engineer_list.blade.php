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
			<h5>Service Engineer List Report </h5>
		</div>
		<div class="card-body ">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-4">
						<label for="status" class="form-control-label">Status</label>
						<select name="status" class="form-control" id="status">
							<option value="">Select One</option>
							<option value="active">Active</option>
							<option value="inactive">Inactive</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label for="status" class="form-control-label">Expertise</label>
						<select name="expertise" class="form-control" id="expertise">
							<option value="">Choose Expertise</option>
							<option value="pc">Hardware & Software</option>
							<option value="printer">Internet</option>
							<option value="scanner">Hardware</option>
						</select>
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
	                                <th>Ticket Date</th>
	                                <th>Eqp Id</th>
	                                <th>Category</th>
	                                <th>Problem</th>
	                                <th>Service Engineer</th>
	                                <th>Status</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>10 - 12 - 2020</td>
	                            		<td>CPA-PC-005</td>
	                            		<td>PC</td>
	                            		<td>Software & Hardware</td>
	                            		<td>Shahinul Alam</td>
	                            		<td>In Progress</td>
	                            	</tr>
	                            	<tr>
	                            		<td>02</td>
	                            		<td>11 - 12 - 2020</td>
	                            		<td>CPA-PRT-001</td>
	                            		<td>Printer</td>
	                            		<td>Hardware</td>
	                            		<td>Nazrul Islam</td>
	                            		<td>Waiting For Parts</td>
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