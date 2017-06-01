@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog modal-lg">
			<form action="/services/add-prerequisite/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add prerequisite</h4>
				</div>
				<div class="modal-body">
					<label class="control-label">Content</label>
					<input type="text" class="form-control"  name="content" value="{{ old('content') }}">
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

@section('onload')

@endsection

@section('onsuccess')
	modal.modal('hide');
	document.location = '/services/requirements/{{ $service->id }}';
@endsection
