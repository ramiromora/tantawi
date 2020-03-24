
{{ Form::hidden('user_id',auth()->user()->id) }}

<div class="form-group">
    {{ Form::label('company_id', 'Institución para el Acta') }}
    {{ Form::select('company_id', $companys ,null, ['class' => 'form-control', 'placeholder' => 'Institución para el acta, en caso no existir dentro de la lista seleccione otra institución', 'id'=>"compani" ,'required']) }}
</div>
<!--agregar tambien estas estiquetas nuevas-->
<div class="form-group">
    <input type="checkbox" name="new_institution" id="newinstitution" onClick="if(this.checked == true){mifuncion4()} else{mifuncion5()}"><b>Otra Institución</b>
    <div id="nueva"></div>
</div>
<!--agregar tambien estas estiquetas nuevas-->
<div class="form-group">
    {{ Form::label('committee_id', 'Entidad que llevo a cabo la reunión') }}
    {{ Form::select('committee_id', $committees ,null, ['class' => 'form-control','onchange'=>"myFunction3()",'required']) }}
</div>
<div class="form-group">
        <div id="miembros"></div>
</div>
<div class="form-group">
    {{ Form::label('title', 'Tema de reunión') }}
    {{ Form::text('title', null, ['class' => 'form-control','required']) }}
</div>

@if (isset($act->date))
<div class="form-group">
    {{ Form::label('date', 'Fecha de reunión') }}
    {{ Form::date('date',null, ['class' => 'form-control pull-right', 'id' => 'datepicker', 'required' ]) }}
</div>
@else
<?php
$dat = date('Y-m-d');
?>
<div class="form-group">
    {{ Form::label('date', 'Fecha de reunión') }}
    {{ Form::date('date', $dat, ['class' => 'form-control pull-right', 'id' => 'datepicker', 'required' ]) }}
</div>
@endif

{{ Form::label('time', 'Hora de inicio') }}
<div class="input-group">
    {{ Form::time('time', null, ['class' => 'form-control timepicker', 'required']) }}
    <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
    </div>
</div>
<br>
{{ Form::label('timef', 'Hora de final') }}
<div class="input-group">
    {{ Form::time('timef', null, ['class' => 'form-control timepicker', 'required']) }}
    <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
    </div>
</div>
<br>
<div class="form-group">
	{!! Form::label('addres1', '¿La reunión se realizó en la oficina de la OFEP?') !!}
	{!! Form::label('addres1', 'si') !!}
	{!! Form::radio('addres1', 'def' , true ,['id' => 'compan_0' , 'onclick' => 'mostrarReferencia2();'] ) !!}
	{!! Form::label('addres1', 'no') !!}
	{!! Form::radio('addres1', 'nue', false ,['id' => 'compan_1', 'onclick' => 'mostrarReferencia2();']) !!}
</div>
<!---->
	<div id="direccion" style="display:none;" class="form-group">
		{!! Form::label('addres', 'Lugar de Reunion ') !!}
		{!! Form::text('addres', null, ['class' => 'form-control' , 'placeholder' => 'Por favor incluya el pronombre del lugar, ejemplo ‘La Casa grande del pueblo’']) !!}
	</div>
<!---->

<div class="form- group">
    {{ Form::label('user_id2', 'Convocante alterno')}}
    {{ Form::select('user_id2', $users ,null, ['class' => 'form-control', 'placeholder' => 'Seleccione un convocante alterno, en caso de no existir dejar en blanco', 'onchange'=>"myFunction()"]) }}
    <div id="cargo"></div>

</div>

{{csrf_field()}}
<br>
<div class="form-group">
    {{ Form::submit('Siguiente', ['class' => 'btn btn-success btn-block']) }}
</div>

@section('script')
<!-- no borrar el defer por q inhabilita el JS-->
<script src="{{ asset('js/custom.js') }}" defer></script>

<script src="{{ asset('vendor/jquery-ui/ui/widgets/autocomplete.js') }}" defer></script>
@endsection
