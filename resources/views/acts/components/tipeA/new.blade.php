@extends('layouts.app')

@section('content')
<section class="content-header">
      <h1> Crear Acta:<br>
        <small>Para declarar la nueva acta por favor llene los todos los datos correspondientes a la reunión realizada</small>
      </h1>
      
</section>
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					Datos de la reunión
				</div>
			<div class="panel-body">             

					{!! Form::open([ 'route' => 'act_sto', 'name' => 'act_new']) !!}

					@include('acts.fragment.form1')

					{!! Form::close() !!}

			</div>
		</div>

		</div>
	</div>
	<strong><small>Convocante: {{ Auth::user()->name }}</small></strong>
@endsection
