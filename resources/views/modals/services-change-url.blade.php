@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/change-url/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Import form URL</h4>
				</div>
				<div class="modal-body">
					<label>URL</label>
                    <input type="text" class="form-control" name="url" value="{{ old('url', $service->url) }}" autofocus>
                    <p class="help-block">When you change the service URL the body of this will automatically be scraped and loaded into the descriptions table for your approval. If available, keywords will also be automatically added from this URL.</p>
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
