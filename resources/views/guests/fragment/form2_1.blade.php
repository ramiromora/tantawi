@section('script')
<script src="{{ asset('js/custom.js') }}" defer></script>
<!-- no borrar el defer por q inhabilita el JS-->
@endsection
{{ Form::hidden('act_id', $act->id) }}
<h4><strong>Agregar a Invitado Externo</strong></h4>
<br>
<div class="form-group">
	{!! Form::label('name', 'Nombre Completo') !!}
	{!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="form-group">
	{!! Form::label('description', 'Cargo') !!}
	{!! Form::text('description', null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="form-group">
	{!! Form::label('company', '¿Pertenece a la institución visitante?') !!}
	{!! Form::label('company', 'si') !!}
	{!! Form::radio('company', $act->company_id , true ,['id' => 'company_0' , 'onclick' => 'mostrarReferencia();'] ) !!}
	{!! Form::label('company', 'no') !!}
	{!! Form::radio('company', '', false ,['id' => 'company_1', 'onclick' => 'mostrarReferencia();']) !!}

</div>
<!---->
	<div id="otro" style="display:none;" class="form-group">
		{!! Form::label('institution', 'Institución') !!}
		{!! Form::text('institution', null, ['class' => 'form-control' , 'placeholder' => 'Institución a la que pertenece el invitado externo...']) !!}
	</div>
<!---->
<div class="form-group">
	{!! Form::submit('Añadir miembro externo', ['class' =>'btn btn-sm btn-primary'] )!!}
</div>
