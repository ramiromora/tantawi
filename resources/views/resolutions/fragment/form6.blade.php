{{ Form::hidden('id', $correlativo) }}
{{ Form::hidden('order_id', $order_id) }}
{{ Form::hidden('date', $date) }}
<div class="form-group">
	{!! Form::label('title', 'Resolucion:') !!}
	{!! Form::text('title', null, ['class' => 'form-control' ,'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('body', 'Tarea:') !!}
	{!! Form::textarea('body', null, ['class' => 'form-control' ,'id'=>'body','required']) !!}
	<span id="resultado"></span>
</div>
<div class="form-group">
    {{ Form::label('term', 'Plazo (Opcional)') }}
    {{ Form::date('term', null, ['class' => 'form-control pull-right', 'id' => 'datepicker']) }}
</div>
<br>
<br>
