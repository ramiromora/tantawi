@section('script')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}" defer></script>
<script src="{{ asset('js/custom.js') }}" defer></script>
<script src="{{ asset('js/ckeditor5.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.3.1.js') }}" defer></script>
<!-- no borrar el defer por q inhabilita el JS-->
@endsection
{{ Form::hidden('act_id', $act->id) }}
<div class="form-group">
	<label for="order">Tema: </label>
	<input type="text" class="form-control" name="order" id="order_o" value="{{ $order->order }}">
	
</div>

<div class="form-group"><!--aqui metemos el CKEditor-->
	<label for="body">Desarrollo: </label>
	<!--aqui nesesitamos llamar al CKEditor-->
	<textarea name="body" id="body_o" class="form-control">{{ $order->body }}</textarea>
</div>

<div class="form-group">
	{!! Form::submit('Actualizar Orden', ['class' =>'btn btn-sm btn-primary'] )!!}
</div>