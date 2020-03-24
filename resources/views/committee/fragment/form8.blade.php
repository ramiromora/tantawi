<div class="form-group">
    <div class="input-group input-group-sm">
    {{   Form::select('user_id', $users ,null, ['class' => 'form-control', 'placeholder'=>'Selecionar miembro' , 'required'])    }}
    <span class="input-group-btn">
            {{ Form::submit('Nuevo miembro', ['class' => 'btn btn-info btn-flat']) }}
        </span>
    </div>
</div>

        