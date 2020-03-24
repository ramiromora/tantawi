@extends('layouts.app')

@section('content')
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
                    <h3>Editando Resolución numero {{ $correlativo }} en fecha {{ obtenerFechaEnLetra($date) }}</h3>
                </div>                
				<div class="panel-body">               
                {!! Form::model($reso, ['route' => ['reso_upd'],'method' => 'PUT'] )!!}
                @include('resolutions.fragment.form6')
                <div class="form-group">
                {!! Form::submit('Editar Resolucion', ['class' =>'btn btn-sm btn-success'] )!!}
                </div>
                {!! Form::close() !!}
                <a href="{{ route('reso_e_v',['id' =>$order_id] ) }}" class="btn btn-warning">Volver</a>
				</div>
			</div>
        </div>


<div class="col-md-6">
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
    </div>
</div>

@endsection