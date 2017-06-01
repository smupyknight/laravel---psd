@extends('layouts.master')

@section('content')
	<div class="wrapper wrapper-content">
		<div class="ibox">
			<div class="ibox-title">
				<h5>{{ $title or '' }}</h5>
				<div class="ibox-tools">
					<a href="/services/create" class="btn btn-primary btn-xs">Create Service</a>
				</div>
			</div>
			<div class="ibox-content">
				@if (Request::session()->has('message'))
					<div class="alert alert-success">
						{{ Request::session()->get('message') }}
					</div>
				@endif
				<div class="row">
					<form method="GET" action="/admin/services">
						<div class="col-sm-12">
							<div class="input-group">
								<input type="text" placeholder="Search Services" class="input form-control" name="phrase">
								<span class="input-group-btn">
									<button type="submit" class="btn btn btn-primary "> <i class="fa fa-search"></i> Search</button>
								</span>
							</div>
						</div>
					</form>
				</div>
				@if(count($services)>0)
					<table class="table">
						<thead>
							<tr>
								<th>ID</th>
								<th>Parent Service</th>
								<th>Name</th>
								<th>URL</th>
								<th>Owner</th>
								<th>Approved</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($services as $service)
								<tr>
									<td><a href="#">{{ $service->id }}</a></td>
									<td><a href="#">{{ $service->parent_service_id }}</a></td>
									<td>
										{{ $service->names->first()->name }}
									</td>
									<td>
										@if ($service->url)
											<a href="#">{{ $service->url }}</a>
										@else
											None
										@endif
									<td>N/A</td>
									<td><label class="label label-info">Yes</label></td>
									<td>
										<div class="btn-group">
											<button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle">Actions <span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><a href="#">View</a></li>
												<li><a href="#">Edit</a></li>
												<li class="divider"></li>
												<li><a href="#" class="btn-delete-user">Delete</a></li>
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<div class="text-center">
						@if($services->currentPage() > 1)
					         <a href="{{ $services->previousPageUrl() }}" class="btn btn-default">Previous</a>
					    @endif

					   	@if($services->hasMorePages())
					        <a href="{{ $services->nextPageUrl() }}" class="btn btn-default">Next</a>
					    @endif
					</div>
				@else
					<div class="text-center">
						<p>No Services found in the system.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
@endsection
