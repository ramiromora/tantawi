@extends('layouts.app')
@section('content')
<!-- Aqui agregamos el resto del formulario ojo con titulos -->
<div class="col-md-6">
		<div >
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Personas presentes en la reunión</h3>
					<a href="{{ route('act_edit',['id' =>$act->id] ) }}" class="btn btn-primary pull-right">Volver</a><br> <br>
				</div>
			<div class="panel-body">
				{!! Form::open([ 'route' => 'user_add']) !!}
				@include('guests.fragment.form2')
				{!! Form::close() !!}
				<!--para los invitados internos-->
				{!! Form::open([ 'route' => 'guest_add', 'name' => 'guests_a']) !!}
				@include('guests.fragment.form2_1')
				{!! Form::close() !!}
				<!--para los invitados externos-->
			</div>
		</div>
		</div>
	</div>
<!--aqui una vista previa del formulario-->
	<div class="col-md-6">
    <div >
		<div class="panel panel-default">
			<div class="panel-heading">
			<strong>
			<h3 class="text-center">
				ACTA, {{ nombre_comite($act->committee_id) }} Nro. {{ correlativo(muestra_correlativo($act->id)) }}/{{date("Y", strtotime($act->date))}}<br>
				"{{ $act->title }}" , correspondiente al dia {{ obtenerFechaEnLetra($act->date) }} <br>
				</h3>
			</strong>
			<h4 class="text-justify">
			En la ciudad de La Paz, Estado Plurinacional de Bolivia,
			en dependencias de {{ $act->addres}}, el día {{ obtenerFechaEnLetra($act->date) }} a horas {{ $act->time }}
			se hicieron presentes los(as) señores(as):

			@foreach($principal as $princi)
			<strong> {{$princi->name}}, {{$princi->description}},</strong>
			@endforeach
			como miembros representantes de la {{ nombre_comite($act->committee_id) }}

			@if(!soy_miembro_principal($act->id,Auth()->user()->id,$act->committee_id))
			y a <strong> {{ Auth::user()->name }}
					@if(isset($act->user_id2))
					y a {{ buscanombre($act->user_id2) }}
					@endif
					</strong>
			en su condición como responsable (s) convocante (es)
			@elseif(isset($act->user_id2))
			y a <strong>{{ buscanombre($act->user_id2) }}</strong> en su condición como responsable convocante
			@endif.

			</h4>
				Redactado por: {{ Auth::user()->name }} <br>
            </div>
			<!--PERSONAL INTERNO PRESENTE EN LA REUNION  -->
			<div class="panel-body">
			<div class="panel-heading">
					<h3>Personal Interno Presente</h3>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Cargo</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(isset($users)){
					?>
					@foreach($users as $user)
					<tr>
						<td>
							<strong>{{ $user->name  }}</strong>
						</td>
						<td>
							{{ $user->description }}
						</td>
						<td>
						<!--opciones para borrar uno directo-->
						{!! Form::open([ 'route' => 'user_del']) !!}
						{{ 	Form::hidden('id', $user->id)  }}
						{{ 	Form::hidden('act_id', $act->id)  }}
						{!! Form::submit('Borrar', ['class' =>'btn btn-sm btn-danger'] )!!}
						{!! Form::close() !!}
						</td>
					</tr>
					@endforeach
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<!--fin invita personal interno  -->
			<!--INVITADOS EXTERNOS  -->
			<div class="panel-body">
			<div class="panel-heading">
					<h3>Invitados Presentes</h3>
				</div>
			<div class="table table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Cargo</th>
							<th>Institución</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(isset($guests)){
					?>
					@foreach($guests as $guest)
					<tr>
						<td>
							<strong>{{ $guest->name  }}</strong>
						</td>
						<td>
							{{ $guest->description }}
						</td>
						<?php
						if(!empty($guest->company_id)){
						?>
						<td>
							{{ company_name($act->company_id) }}
						</td>
						<?php
						}else{
						?>
						<td>
							{{ $guest->institution }}
						</td>
						<?php
						}
						?>
						<td>
						{!! Form::open([ 'route' => 'guest_del']) !!}
						{{ Form::hidden('id', $guest->id) }}
						{{ Form::hidden('act_id', $act->id) }}
						{!! Form::submit('Borrar', ['class' =>'btn btn-sm btn-danger'] )!!}
						{!! Form::close() !!}
						</td>
					</tr>
					@endforeach
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
				{!! Form::open([ 'route' => 'order_show']) !!}
				{{  Form::hidden('act_id', $act->id) }}
				{!! Form::submit('Siguiente', ['class' =>'btn btn-success btn-lg btn-block'] )!!}
				{!! Form::close() !!}
			</div>
        </div>
    </div>
</div>
@endsection
