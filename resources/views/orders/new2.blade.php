@extends('layouts.app')
@section('content')

<div class="col-md-6">
    	<div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Orden del Dia</h3>
				</div>
				<div class="panel-body">
				{!! Form::model($orde, ['route' => ['order_upd2'],'method' => 'PUT'] )!!}
				{{  Form::hidden('id', $orde->id, ['id'=> 'id_order']) }}
				@include('orders.fragment.form3')
				{!! Form::close() !!}
				</div>
			</div>
		</div>
</div>

<div class="col-md-6">
    <div>
		<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
			<h3 class="text-center">
        ACTA {{ nombre_comite($act->committee_id) }} Nro {{ correlativo(muestra_correlativo($act->id)) }}/{{date("Y", strtotime($act->date))}}<br>
				"{{ $act->title }}" , correspondiente al dia {{ obtenerFechaEnLetra($act->date) }}<br>
				</h3>
			</strong>
			<h4 class="text-justify">
			En la ciudad de La Paz, Estado Plurinacional de Bolivia,
			en dependencias de {{ $act->addres}}, el día {{ obtenerFechaEnLetra($act->date) }} a horas {{ $act->time }}
			se hicieron presentes los(as) señores(as):
			@foreach($principal as $princi)
			<strong> {{$princi->name}}, {{$princi->description}},</strong>
			@endforeach
			como miembros principales del {{ nombre_comite($act->committee_id) }},
			<?php

				if(count($guests)>0){
					$nuu = contador_guest_ins($act->id);///3
					$nee = 0;
			?>
			 como invitado(s) Externo(s) a
					@foreach($guests as $guest)
						<strong>{{ $guest->name  }} - {{ $guest->description }} </strong>
						<?php $nee++;?>
						@if($nuu == $nee)
						de la Institución "{{ company_name($act->company_id) }}"
						@endif
						@if($nee > $nuu)
						de la Institucion "{{ $guest->institution }}"
						@endif,
					@endforeach
			<?php
				}
				if(count($users)>0){
			?>
			 como invitado(s) Interno(s) a
					@foreach($users as $user)
						<strong>{{ $user->name  }} - {{ $user->description }} </strong>
					,
					@endforeach
			<?php
			}
			?>
			@if(!soy_miembro_principal($act->id,Auth()->user()->id,$act->committee_id))
			y a <strong> {{ Auth::user()->name }}
					@if(isset($act->user_id2))
					y {{ buscanombre($act->user_id2) }}
					@endif
					</strong>
			en su condición como responsable (s) convocante (es),
			@elseif(isset($act->user_id2))
			y a <strong>{{ buscanombre($act->user_id2) }}</strong> en su condición como responsable convocante,
			@endif
			</strong>
			a fin de tratar el siguiente orden del día:
			</div>
<!-- ORDENES DEL DIA -->
<div class="panel-body">
@include('orders.fragment.lista')
@include('orders.fragment.opcion')
</div>
@endsection
