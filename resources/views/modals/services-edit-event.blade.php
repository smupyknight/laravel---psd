@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/edit-event/{{ $event->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Event</h4>
				</div>
				<div class="modal-body">
                    <label class="control-label" for="name">Name</label>
                    <input type="text" class="form-control"  name="name" id="name" value="{{ old('name', $event->name) }}">
                    <label class="control-label" for="sequence">Sequence</label>
                    <input type="number" class="form-control"  name="sequence" id="sequence" value="{{ old('sequence', $event->sequence) }}">
                    <label class="control-label" for="cost">Cost</label>
                    <input type="number" class="form-control"  name="cost" id="cost" value="{{ old('cost', $event->cost) }}">
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
	document.location = '/services/requirements/{{ $event->service_id }}';
@endsection
