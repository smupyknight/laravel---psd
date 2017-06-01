@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog modal-lg">
			<form action="/services/add-description/{{ $service->id }}" method="post" class="modal-content" autocomplete="off" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Description</h4>
				</div>
				<div class="modal-body">
					<label>Description</label>
					<div class="summernote">
						{!! old('description') !!}
					</div>
					<input type="hidden" name="description" value="{{ old('description') }}">
					<label class="control-label">Context</label>
					<input type="text" name="context" class="form-control" value="{{ old('context') }}">
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
modal.find('.summernote').summernote({
	height: 300,
	callbacks: {
		onBlur: function() {
			$('[name="description"]').val($('.summernote').summernote('code'));
		}
	}
});
@endsection

@section('onsuccess')
	modal.modal('hide');
	document.location = '/services/details/{{ $service->id }}';
@endsection
