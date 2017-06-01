<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-pills nav-justified">
				<li class="{{ Request::is('services/details*') ? 'active' : '' }}" role="presentation"><a href="/services/details/{{ $service->id }}">Details</a></li>
				<li class="{{ Request::is('services/requirements*') ? 'active' : '' }}" role="presentation"><a href="/services/requirements/{{ $service->id }}">Requirements & Relationships</a></li>
				<li class="{{ Request::is('services/delivery*') ? 'active' : '' }}" role="presentation"><a href="/services/delivery/{{ $service->id }}">Delivery Channels</a></li>
			</ul>
			<hr>
		</div>
	</div>
</div>