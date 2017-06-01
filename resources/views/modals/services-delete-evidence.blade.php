@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/delete-evidence/{{ $evidence->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Evidence</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this Evidence?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Delete Evidence</button>
				</div>
				{{ csrf_field() }}
			</form>
		</div>
	</div>
@endsection

@section('onsuccess')
	modal.modal('hide');
	document.location = '/services/requirements/{{ $evidence->service_id }}';
@endsection
