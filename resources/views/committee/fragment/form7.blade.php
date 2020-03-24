<div class="form-group">
    <div class="text text-left">
    {{ Form::label('name', 'Nombre del Comité') }}
        <div class="input-group input-group-sm">
                {{ Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Ingrese nombre del comité que desea agregar', 'required', 'maxlength'=>'250']) }}
            <span class="input-group-btn">
