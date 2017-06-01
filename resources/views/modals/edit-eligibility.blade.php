@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog modal-lg">
			<form action="/services/edit-eligibility/{{ $description->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Eligibility</h4>
				</div>
				<div class="modal-body">
					<label class="control-label">Content</label>
					<div class="summernote">
						{!! old('description', $description->description) !!}
					</div>
					<input type="hidden" name="description" value="{{ old('description', $description->description) }}">
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
	document.location = '/services/details/{{ $description->service_id }}';
@endsection
