@extends('layouts.modal')

@section('modal')
	<div class="modal animated fadeIn">
		<div class="modal-dialog">
			<form action="/services/add-name/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Name</h4>
				</div>
				<div class="modal-body">
					<label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                    <label>Context</label>
                    <select name="context" class="form-control">
						@foreach ($contexts as $context)
							<option value="{{ $context->context }}" {{ $context == old('context') ? 'selected' : '' }}>{{ $context->context }}</option>
						@endforeach
					</select>
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
