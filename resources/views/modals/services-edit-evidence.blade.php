@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog modal-lg">
			<form action="/services/edit-evidence/{{ $evidence->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Evidence</h4>
				</div>
				<div class="modal-body">
                    <label class="control-label" for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $evidence->name) }}">
                    <label class="control-label" for="displayed_for">Displayed For</label>
                    <input type="text" name="displayed_for" id="displayed_for" class="form-control" value="{{ old('displayed_for', $evidence->displayed_for) }}">
                    <label>Meta Data</label>
                    <div class="summernote">
                        {!! old('meta_data', $evidence->meta_data) !!}
                    </div>
                    <input type="hidden" name="meta_data" value="{{ old('meta_data', $evidence->meta_data) }}">
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
			$('[name="meta_data"]').val($('.summernote').summernote('code'));
		}
	}
});
@endsection

@section('onsuccess')
	modal.modal('hide');
	document.location = '/services/requirements/{{ $evidence->service_id }}';
@endsection
