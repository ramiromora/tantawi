
{{ Form::hidden('act_id', $act->id) }}    
<h4><strong>Selecionar Personal Interno</strong></h4>
<br>
<div class="form-group">
    {{ Form::label('user', 'Nombre del personal') }}
    {{ Form::select('user', $nousers ,null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::submit('Añadir miembro interno', ['class' => 'btn btn-sm btn-primary']) }}
</div>




