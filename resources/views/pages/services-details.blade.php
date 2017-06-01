@extends('layouts.minimal')
@section('content')
@include('partials.services-nav')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Details</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/edit-details/{{ $service->id }}')" class="btn btn-xs btn-primary">Edit</a>
					</div>
				</div>
				<div class="ibox-content">
					<p><strong>QGS Service ID: </strong> {{ $service->qgs_service_id }}</p>
					<p><strong>Reference URL: </strong> {{ $service->url }} <a href="javascript:show_modal('/services/change-url/{{ $service->id }}')" class="btn btn-xs btn-primary">Change Url</a></p>
					<p><strong>Interaction ID: </strong> {{ $service->interaction_id }}</p>
					<p><strong>Group ID: </strong> {{ $service->group_id }}</p>
				</div>
			</div>
			<div class="ibox">
				<div class="ibox-title">
					<h5>Names</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/add-name/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Context</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->names as $name)
								<tr>
									<td>{{ $name->name }}</td>
									<td>{{ $name->context }}</td>
									<td>
										<a href="javascript:show_modal('/services/edit-name/{{ $name->id }}')" class="btn btn-xs btn-default">Edit</a>
										<a href="javascript:show_modal('/services/delete-name/{{ $name->id }}')" class="btn btn-xs btn-default">Delete</a>
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
					<h5>Descriptions</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/change-url/{{ $service->id }}')" class="btn btn-xs btn-primary">Import from Url</a>
					<a href="javascript:show_modal('/services/add-description/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>

				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Description</th>
								<th>Context</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->descriptions as $description)
								<tr>
									<td>{{ strip_tags($description->description) }}</td>
									<td>{{ $description->context }}</td>
									<td>
										<a href="javascript:show_modal('/services/edit-description/{{ $description->id }}')" class="btn btn-xs btn-default">Edit</a>
										<a href="javascript:show_modal('/services/delete-description/{{ $description->id }}')" class="btn btn-xs btn-default">Delete</a>
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
					<h5>Categories</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/add-category/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Description</th>
								<th>Context</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->serviceCategories as $service_category)
								<tr>
									<td>{{ $service_category->category->name }}</td>
									<td>{{ $service_category->category->type }}</td>
									<td>
										<a href="javascript:show_modal('/services/delete-category/{{ $service_category->id }}')" class="btn btn-xs btn-default">Delete</a>
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
					<h5>Keywords</h5>
					<div class="ibox-tools">
						<a href="javascript:show_modal('/services/add-keyword/{{ $service->id }}')" class="btn btn-xs btn-primary">Add</a>
					</div>
				</div>
				<div class="ibox-content">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Keyword</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($service->keywords()->orderBy('score', 'DESC')->get() as $keyword)
								<tr>
									<td>{{ $keyword->word }}</td>
									<td>
										<a href="javascript:show_modal('/services/edit-keyword/{{ $keyword->id }}')" class="btn btn-xs btn-default">Edit</a>
										<a href="javascript:show_modal('/services/delete-keyword/{{ $keyword->id }}')" class="btn btn-xs btn-default">Delete</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection