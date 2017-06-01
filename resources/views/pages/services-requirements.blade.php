@extends('layouts.minimal')
@section('content')
@include('partials.services-nav')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Parent Service</h5>
				</div>
				<div class="ibox-content">
					<strong>Parent Service Name: </strong> <a href="javascript:show_modal('/services/change-parent-service/{{ $service->id }}')" class="btn btn-xs btn-primary">Change</a>
				</div>
			</div>
			<div class="ibox">
				<div class="ibox-title">
					<h5>Eligibility</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/edit-eligibility/{{ $service->id }}')" class="btn btn-xs btn-primary">Edit</a>
					</div>
				</div>
				<div class="ibox-content">
					{!! $service->eligibility !!}
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Events</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/add-event/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>

				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Sequence</th>
                                <th>Cost</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->events as $event)
								<tr>
									<td >{{ $event->name }}</td>
									<td width="10%">{{ $event->sequence }}</td>
                                    <td width="10%">{{ $event->cost }}</td>
									<td width="20%">
										<a href="javascript:show_modal('/services/edit-event/{{ $event->id }}')" class="btn btn-xs btn-default">Edit</a>
										<a href="javascript:show_modal('/services/delete-event/{{ $event->id }}')" class="btn btn-xs btn-default">Delete</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Evidence</h5>
					<div class="ibox-tools">
                        <a href="javascript:show_modal('/services/add-evidence/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Displayed For</th>
								<th>Meta Data</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->evidence as $evidence)
								<tr>
									<td>{{ $evidence->name }}</td>
									<td>{{ $evidence->displayed_for }}</td>
									<td>{{ strip_tags($evidence->meta_data) }}</td>
									<td>
										<a href="javascript:show_modal('/services/edit-evidence/{{ $evidence->id }}')" class="btn btn-xs btn-default">Edit</a>
										<a href="javascript:show_modal('/services/delete-evidence/{{ $evidence->id }}')" class="btn btn-xs btn-default">Delete</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Prerequisites</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/add-prerequisite/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Prerequisite</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->prerequisites as $prerequisite)
								<tr>
									<td>{{ $prerequisite->content }}</td>
									<td>
										<a href="javascript:show_modal('/services/delete-prerequisite/{{ $prerequisite->id }}')" class="btn btn-xs btn-default">Delete</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Related Services</h5>
					<div class="ibox-tools">
						<a href="#" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>QGS ID</th>
								<th>QGS Service Name</th>
								<th>Relationship</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Service ID</td>
								<td>Service Name</td>
								<td>Service Name</td>
								<td>
									<a href="#" class="btn btn-xs btn-default">Edit</a>
									<a href="#" class="btn btn-xs btn-default">Delete</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection