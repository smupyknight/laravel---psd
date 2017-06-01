@extends('layouts.minimal')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Services for {{ session('email') }}</h5>
					<div class="ibox-tools">
					</li>
				</ul>
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="ibox-content">
			<div class="row">
				<div class="col-lg-12">
					@if (!$services->count())
						<p>No services found.</p>
					@else
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>QGS Service Name</th>
										<th>Delivery Organisation Agency</th>
										<th>Owner</th>
										<th>Parent Service</th>
										<th>URL</th>
										<th>Approved</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($services as $service)
										<tr>
											<td>{{ $service->qgs_service_id }}</td>
											<td>{{ $service->getServiceName() ? $service->getServiceName() : 'None' }}</td>
											<td>{{ $service->deliveryOrganisationAgency ? $service->deliveryOrganisationAgency->business_unit_name : 'None' }}</td>
											<td>{{ $service->getServiceOwner() ? $service->getServiceOwner()->person_name : 'None' }} <a href="javascript:show_modal('/services/edit-owner/{{ $service->id }}')" class="btn btn-xs btn-info">Change Owner</a></td>
											<td>{{ $service->parentService ? $service->parentService->getServiceName() : 'None' }}</td>
											<td>{{ $service->url ? $service->url : 'None' }}</td>
											<td><label class="label label-info">Yes</label></td>
											<td><a href="/services/details/{{ $service->id }}" class="btn btn-xs btn-default">Manage</a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection