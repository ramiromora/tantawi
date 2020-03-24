@extends('layouts.app')

@section('content')

<div class="col-md-5">
    <div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Añadir Resoluciones</h2>
				</div>
				<div class="panel-body"> 
				<h3>Resolución numero {{ $correlativo }} en fecha {{ obtenerFechaEnLetra($date) }}</h3>
				{!! Form::open([ 'route' => 'reso_add','files'=>true]) !!}
                    @include('resolutions.fragment.form6')
                <div class="form-group">
                {!! Form::submit('Añadir Resolucion', ['class' =>'btn btn-sm btn-primary'] )!!}
                </div>
                {!! Form::close() !!}
                <a href="{{ route('reso_end',['id' =>$order_id] ) }}" class="btn btn-success">Terminar</a>
				</div>
			</div>
		</div>
</div>

<div class="col-md-7">
  
		<div class="panel panel-default">
		<div class="panel-heading">
			<h2>
			{{ $tema}}
        </h2>
        </div>
            <div class="panel-body">
			<div class="text-justify"> 	
            <?php
            echo $desa;    
            ?>
            </div>

</div>
@include('resolutions.fragment.list')
</div>
</div>
@endsection
