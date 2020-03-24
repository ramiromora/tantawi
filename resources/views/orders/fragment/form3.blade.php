@section('script')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}" defer></script>
<script src="{{ asset('js/custom.js') }}" defer></script>
<script src="{{ asset('js/jquery-3.3.1.js') }}" defer></script>
<!-- no borrar el defer por q inhabilita el JS-->
@endsection
{{ Form::hidden('act_id', $act->id,['id' => 'id_act']) }}
<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
	{!! Form::label('order', 'Tema:') !!}
	{!! Form::text('order', null, ['class' => 'form-control', 'id' => 'titulo_o']) !!}
</div>
<div class="form-group"><!--aqui metemos el CKEditor-->
	{!! Form::label('body', 'Desarrollo:') !!}<!--aqui nesesitamos llamar al CKEditor-->
	{!! Form::textarea('body', null, ['class' => 'form-control' ,'id'=>'body_o']) !!}
	<span id="resultado"></span>
</div>

<div class="form-group">
	{!! Form::submit('Guardar esta orden', ['class' =>'btn btn-sm btn-primary'] )!!}
</div>