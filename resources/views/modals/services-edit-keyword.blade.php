@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/edit-keyword/{{ $keyword->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Keyword</h4>
				</div>
				<div class="modal-body">
					<label>Keyword</label>
                    <input type="text" class="form-control" name="word" value="{{ old('word', $keyword->word) }}" autofocus>
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
	document.location = '/services/details/{{ $keyword->service_id }}';
@endsection
