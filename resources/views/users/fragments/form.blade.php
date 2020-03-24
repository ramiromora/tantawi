<div class="form-group">
    {!! Form::label('name', 'Nombre de usuario:') !!}
    {!! Form::text('name', Auth::user()->username, ['class'=>'form-control', 'placeholder'=>'Nombre Completo', 'required','disabled']) !!}
</div>
<div class="form-group">
        {!! Form::label('email', 'Correo:') !!}
        {!! Form::text('email', Auth::user()->email, ['class'=>'form-control', 'placeholder'=>'Correo', 'required']) !!}
</div>
<div class="form-group">
    {!! Form::label('file', 'Imagen de perfil') !!}
    {!! Form::file('file') !!}
    <img src="{{ asset(Auth::user()->profile) }}" class="img-circle" alt="User Image" width="250px" height="250px" >
</div>



<!--lista de comites al cual partisipo-->
<!--primera pregunta nivel de usario para reasignar el tipo de busqueda-->
@if(Auth::user()->level==3)
    <!--solo consultamos por si requiere un remplazo de entre el comite-->
    <div class="callout callout-info">
    <h4>Seleccionar Remplazo</h4>
        <p>En el caso de que no tenga posibilidad de pertenecer a un comité  por favor seleccione su remplazante</p>
    </div>
    <div class="form- group">
        {{ Form::label('user_id2', 'Remplazante')}}
        {{ Form::select('user_id2', $responsables_3 ,null, ['class' => 'form-control', 'placeholder' => 'Dejar en Blanco Para remover el Remplazo actual de lo contrario seleccionar...']) }}
    </div>
    @if(!is_null($remplazo))
    <div class="bg-green color-palette">Su remplazo Actual es : <strong>{{ $remplazo }}</strong></div>
    @else
    <div class="bg-aqua disabled color-palette">No se designó un remplazo</div>
    @endif
@elseif(Auth::user()->level==2)
    <!--aqui consultar si hay mas de una asignacion de lo contrario solo ver si requiere de un remplazo-->

    @if(!is_null(conoser_responsable(Auth::user()->id)))
        <?php
            $remp=conoser_responsable(Auth::user()->id);
        ?>
        @if(is_null(Auth::user()->replace))
        <div class="callout callout-danger">
            <h4>Atencion!</h4><p>Usted fue asignado como remplazante de <strong>{{ $remp->name }} - {{ $remp->description }}</strong></p>
        </div>
        <div class="callout callout-warning">
        <h4>Seleccionar  Remplazo</h4>
            <p>Por favor seleccione un remplazo para usted dentro del comité</p>
        </div>
        <div class="form- group">
            {{ Form::label('user_id2', 'Remplazante')}}
            {{ Form::select('user_id2', $responsables ,null, ['class' => 'form-control', 'placeholder' => 'Dejar en Blanco Para remover el Remplazo actual de lo contrario selecionar...']) }}
        </div>
        @else 
            <div class="callout callout-info">
                <h4>Seleccionar Remplazo</h4>
                <p>Usted fue asignado como remplazante de <strong>{{ $remp->name }} - {{ $remp->description }}</strong></p>
            </div>
            <div class="form- group">
                {{ Form::label('user_id2', 'Remplazante')}}
                {{ Form::select('user_id2', $responsables ,null, ['class' => 'form-control', 'placeholder' => 'Dejar en Blanco Para remover el Remplazo actual de lo contrario selecionar...']) }}
            </div>
            @if(!is_null($remplazo))
            <div class="bg-green color-palette">Su remplazo Actual es: <strong>{{ $remplazo }}</strong></div>
            @else
            <div class="bg-aqua disabled color-palette">No se designó un remplazo</div>
            @endif
        @endif
    @else
        <div class="callout callout-info">
            <h4>Seleccionar Remplazo</h4>
            <p>En el caso de que no tenga posibilidad de asistir a una reunión por favor seleccione su remplazante</p>
        </div>
            <div class="form- group">
                {{ Form::label('user_id2', 'Remplazante')}}
                {{ Form::select('user_id2', $responsables ,null, ['class' => 'form-control', 'placeholder' => 'Dejar en Blanco Para remover el Remplazo actual de lo contrario selecionar...']) }}
            </div>
            @if(!is_null($remplazo))
            <div class="bg-green color-palette">Su remplazo actual es: <strong>{{ $remplazo }}</strong></div>
            @else
            <div class="bg-aqua disabled color-palette">No se designó un remplazo</div>
            @endif
    @endif
@endif
<!--fin de la consulta-->
@if(Auth::user()->level==1)
    @if(!is_null(conoser_responsable(Auth::user()->id)))
    <?php
            $remp=conoser_responsable(Auth::user()->id);
    ?>
    <div class="callout callout-warning">
        <h4>Atención!</h4><p>Usted fue asignado como remplazante de <strong>{{ $remp->name }} - {{ $remp->description }}</strong></p>
    </div>
    @endif
@endif
<br>
<div class="form-group">
	{!! Form::submit('Actualizar datos', ['class' =>'btn btn-sm btn-success'] )!!}
</div>