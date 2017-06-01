@extends('layouts.modal')
@section('modal')
<div class="modal">
	<div class="modal-dialog">
		<form action="/services/change-parent-service/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Change Parent Service</h4>
			</div>
			<div class="modal-body">
				<label>Services</label>
				<select name="parent_service" class="form-control">
					@foreach ($services as $service)
						<option value="{{ $service->id }}" {{ $service == old('parent_service') ? 'selected' : '' }}>{{ $service->getServiceName() }}</option>
					@endforeach
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
			{{ csrf_field() }}
		</form>
	</div>
</div>
@endsection
@section('onsuccess')
modal.modal('hide');
document.location = '/services/requirements/{{ $service->id }}';
@endsection
