@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/edit-owner/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Name</h4>
				</div>
				<div class="modal-body">
					<label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $service->getServiceOwner() ? $service->getServiceOwner()->person_name : '') }}" autofocus>

                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $service->getServiceOwner() ? $service->getServiceOwner()->email : '') }}" autofocus>
                    <p class="help-block">Once you change the owner email address, you will no longer be able to administer/update this service. The new owner will be emailed a link which will allow them to administer this service.</p>
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
	document.location = '/services';
@endsection
