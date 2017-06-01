@extends('layouts.minimal')
@section('content')
@include('partials.services-nav')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Delivery Organisation</h5>
					<div class="ibox-tools">
						<a href="#" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>

				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Agency</th>
								<th>Unit Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Support Roles</h5>
					<div class="ibox-tools">
						<a href="#" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Person Name</th>
								<th>Role</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Context</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Service Delivery</h5>
					<div class="ibox-tools">
						<a href="#" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Channel</th>
								<th>Yes/No</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Service Delivery Form</h5>
					<div class="ibox-tools">
						<a href="#" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Form Name</th>
								<th>URL</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection