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
			<h5>User Wise Equipment Report </h5>
		</div>
		<div class="card-body ">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-6">
						<input type="text" class="form-control" name="name" placeholder="User name">
					</div>
					<div class="col-lg-4">
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
	                                <th>Eqp Id</th>
	                                <th>Category</th>
	                                <th>Name</th>
	                                <th>Purchase Dt.</th>
	                                <th>In Warranty?</th>
	                                <th>Status</th>
	                                <th># of Service</th>
	                            </tr>
	                            </thead>
	                            <tbody>
	                            	<tr>
	                            		<td>01</td>
	                            		<td>CPA-PC-005</td>
	                            		<td>PC</td>
	                            		<td>HP PC</td>
	                            		<td>01 - 01 - 2020</td>
	                            		<td>Yes</td>
	                            		<td>Working</td>
	                            		<td>0</td>
	                            	</tr>
	                            	<tr>
	                            		<td>02</td>
	                            		<td>CPA-PRT-001</td>
	                            		<td>Printer</td>
	                            		<td>Cannon Laser Jet</td>
	                            		<td>01 - 02 - 2020</td>
	                            		<td>NO</td>
	                            		<td>Servicing</td>
	                            		<td>2</td>
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

{{-- <th>SL</th>
<th>Ticket Date</th>
<th>Eqp Id</th>
<th>Category</th>
<th>Problem</th>
<th>Service Engineer</th>
<th>Status</th> --}}