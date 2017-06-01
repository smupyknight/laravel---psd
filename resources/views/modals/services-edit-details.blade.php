@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/edit-details/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Service Details</h4>
				</div>
				<div class="modal-body">
					<label>QGS Service ID</label>
                    <input type="text" class="form-control" name="qgs_id" value="{{ old('qgs_id', $service->qgs_service_id) }}" autofocus>

                    <label>Interaction ID</label>
                    <input type="text" class="form-control" name="interaction_id" value="{{ old('interaction_id', $service->interaction_id) }}">

                    <label>Group ID</label>
                    <input type="text" class="form-control" name="group_id" value="{{ old('group_id', $service->group_id) }}">

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
	document.location = '/services/details/{{ $service->id }}';
@endsection
