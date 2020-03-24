@extends('layouts.app')
@section('content')

<div class="container">
	<div class="col-md-9 col-md-offset-2">
		<div class="panel panel-default">
		<div class="panel-heading">
			<a href="{{ route('act_list') }}" class="btn btn-primary">Volver</a>
			<strong>
			<center>===================================== <br>BORRADOR  --- MOD {{ $act->mod }} ---- <br> =====================================</center> <br>
			<h3 class="text-center">
			ACTA {{ nombre_comite($act->committee_id) }} Nro {{ correlativo(muestra_correlativo($act->id)) }}/{{date("Y", strtotime($act->date))}}<br>
				"{{ $act->title }}" , correspondiente al dia {{ obtenerFechaEnLetra($act->date) }} <br>
				</h3>
			</strong>
			<h4 class="text-justify">
			En la ciudad de La Paz, Estado Plurinacional de Bolivia,
			en dependencias de {{ $act->addres}}, el día {{ obtenerFechaEnLetra($act->date) }} a horas {{ $act->time }}
			se hicieron presentes los(as) señores(as):

			@foreach($principal as $princi)
			<strong> {{$princi->name}} - {{$princi->description}},</strong>
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
			como invitado(s) internos(s),

				@foreach($users as $user)

					<strong>{{ $user->name  }} - {{ $user->description }}</strong>
					,
				@endforeach
			<?php
				}
			?>

			@if(!estoy_en_miembros($act->id,Auth()->user()->id))
			y a <strong> {{ Auth()->user()->name }} - {{ Auth()->user()->description }}
				@if(isset($act->user_id2))
					y {{ buscanombre($act->user_id2) }} - {{ buscacargo($act->user_id2) }},
				@endif
				</strong>
			en su condición como responsable (s) convocante (es),
			@elseif(isset($act->user_id2))
				y a <strong>{{ buscanombre($act->user_id2) }}</strong> en su condición como responsable convocante,
			@endif
			a fin de tratar el siguiente orden del día:
			<br><br>

<table style=" border: 1px solid #000; width: 100%;">
    <tr>
        <td colspan="2" style="width: 50px; text-align: left; vertical-align: top; border: 1px solid #000;">
			<p align=center style='text-align:center'>
				<b>
					Orden del Día
				</b>
			</p>
        </td>
    </tr>
<?php
$nro=0;
?>
@foreach($orders as $order)
<?php $nro++;?>
    <tr>
        <td style="width:10; text-align: left; vertical-align: top; border: 1px solid #000"><?php echo $nro; ?></td>
        <td style="width:600px; text-align: left; vertical-align: top; border: 1px solid #000">{{ $order->order }}</td>
    </tr>
@endforeach
</table>
<?php
$nro=0;
?>
<br>

  <p class=MsoNormal align=center style='text-align:center'><strong>  Desarrollo de la reunión</strong></p>
 <br>
 @foreach($orders as $order)
 <?php $nro++;?>
 <b>
 <h3> {{ $nro }}. {{ $order->order }} </h3></b>
  <br>
    <?php
    $texto= $order->body;
	echo '<div class="text-justify">'.$texto.'</div>';
	if(cuenta_reso($order->id)>0){
		$resolutions=saca_reso($order->id);
		echo '<b>Resoluciones: ';
		foreach ($resolutions as $reso) {
			echo correlativo($reso->id).'|';
		}
		echo '</b><br>';
	}
    ?>
@endforeach

<!--resoluciones-->
<?php
if(cuenta_reso_t($act->id)>0){
echo '<div class="text-justify"><h3>Resoluciones</h3>';
?>
@foreach($orders as $order)
<?php

if(cuenta_reso($order->id)>0){
	$resolutio=saca_reso($order->id);
	foreach ($resolutio as $res) {
	echo '<br><b>Resolucion Nro. ',correlativo($res->id).'</b><br>';
	echo '<u>'.$res->title.'</u><br>';
	echo '<b>Accion: </b> '.$res->body.'.';
	$responsables=buscaresponsables($res->id);
	if(count($responsables)>0){
		echo '<br><b>Responsable(s): </b>';
		foreach ($responsables as $re) {
		echo ''.buscanombre($re->user_id).', ';
		}
	}
	echo '<br>';
	if(!is_null($res->term)){
		echo '<b>Plazo: </b>'.obtenerFechaEnLetra($res->term);
	}
	echo '<br>';


}
	echo '<br></b>';
}
?>
@endforeach
<?php
echo '</div>';
}
?>
<!--resoluciones-->
<br>
Dándose por concluida la reunión de la fecha {{ obtenerFechaEnLetra($act->date) }}, suscriben al
pie de la presente Acta los miembros del {{ nombre_comite($act->committee_id) }} – OFEP, {{ company_name($act->company_id) }} .
<br>
<center>Firmas
<br><br>
ESPACIO PARA FIRMAS
<br>
</div>
</p>
</div>
</div>
</div>
@endsection
