@extends('layouts.modal')
@section('modal')
<div class="modal">
	<div class="modal-dialog">
		<form action="/services/add-category/{{ $service->id }}" method="post" class="modal-content" autocomplete="off">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Category</h4>
			</div>
			<div class="modal-body">
				<label>Name</label>
				<input type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>
				<label>Type</label>
				<select name="type" class="form-control">
					@foreach ($types as $type)
						<option value="{{ $type }}" {{ $type == old('type') ? 'selected' : '' }}>{{ $type }}</option>
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
