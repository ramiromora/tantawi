@extends('layouts.master')
@section('content')

<div class="container">
	<div class="col-md-9 col-md-offset-2">
		<div class="panel panel-default">
		<div class="panel-heading">
			
			
			<strong>
			<h3 class="text-center">
				ACTA {{ nombre_comite($act->committee_id) }} Nro {{ correlativo(muestra_correlativo($act->id)) }}/{{date("Y", strtotime($act->date))}}<br>
				"{{ $act->title }}" , correspondiente al dia {{ obtenerFechaEnLetra($act->date) }} <br>
				</h3>
			</strong>
			
			<h4 class="text-justify">
			En la ciudad de La Paz, Estado Plurinacional de Bolivia,
			en dependencias de {{ $act->addres}}, el día {{ obtenerFechaEnLetra($act->date) }} a horas {{ $act->time }}
			se hicieron presentes los(as) señores(as):

			@foreach($firmados as $princi)
			@if($princi->tipe==1)
			<strong> {{$princi->name}}, {{$princi->description}},</strong>
			@endif
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
						de la Institución "{{ $guest->institution }}"
						@endif,
					@endforeach
			<?php
				}
			$b1=true;
			?>
				@foreach($firmados as $user)

					@if($user->tipe==2&&$b1)
					como invitado(s) internos(s),
					<?php $b1=false;?>
					@endif

					@if($user->tipe==2)
					<strong>{{ $user->name  }} - {{ $user->description }},</strong>
					@endif
				@endforeach
			@if(ver_firma_3($act->id)>0)
			y a
			<strong>
			@foreach($firmados as $convo)
				@if($convo->tipe==3)
					<strong>{{ $convo->name  }} - {{ $convo->description }}</strong>
					,
				@endif
			@endforeach
			</strong>
			en su condición como responsable (s) convocante (es),
			@endif
			a fin de tratar el siguiente Orden del Día:
			<br>
            <br>
<table style=" border: 1px solid #000; width: 100%;">
    <tr>
        <td colspan="2" style="width: 150px; text-align: left; vertical-align: top; border: 1px solid #000;">
			<p class=MsoNormal align=center style='text-align:center'>
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
  <p class=MsoNormal align=center style='text-align:center'><b>Desarrollo de la reunión</b></p>

 @foreach($orders as $order)
 <?php $nro++;?>
 <h3> {{ $nro }}. {{ $order->order }} </h3>
    <?php
    $texto= $order->body;
	echo '<div class="text-justify">'.$texto;
	if(cuenta_reso($order->id)>0){
		$resolutions=saca_reso($order->id);
		echo '<b>Resoluciones: ';
		foreach ($resolutions as $reso) {
			echo correlativo($reso->id).'|';
		}
		echo '</b><br></div>';
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
Dándose por concluida la reunión de la fecha {{ obtenerFechaEnLetra($act->date) }}, suscriben al
pie de la presente Acta los miembros del {{ nombre_comite($act->committee_id) }} – OFEP, {{ company_name($act->company_id) }}.
<br>
<center>Firmas</center>

@php
		$pos=0;
@endphp
<table width="100" class="table text-center" >
	<tbody>
		@foreach($firmados as $firmado)
			@if($firmado->state==1)
				@php
				$pos++;		
				@endphp
				@if ($pos==1)
						<tr>
							<td>
									@php
										$stt = $firmado->name." |Acta ".nombre_comite($act->committee_id)." | Nro. ".correlativo(muestra_correlativo($act->id))." / ".date("Y", strtotime($act->date)); 	
									@endphp	
									<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->backgroundColor(245, 245, 245)->size(200)->margin(10)->generate($stt) )!!} ">	
									<p lang=ES-CO style='font-family:"Tahoma",sans-serif; font-size: 9pt; '>{{$firmado->name}}</p>
							</td>
				@endif	
				@if ($pos==2)
							<td>
									
									@php
										$stt = $firmado->name." |Acta ".nombre_comite($act->committee_id)." | Nro. ".correlativo(muestra_correlativo($act->id))." / ".date("Y", strtotime($act->date)); 	
									@endphp	
									<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->backgroundColor(245, 245, 245)->size(200)->margin(10)->generate($stt)) !!} ">	
									<p lang=ES-CO style='font-family:"Tahoma",sans-serif; font-size: 9pt;'>{{$firmado->name}}</p>
							</td>
				@endif		
				@if ($pos==3)
							<td>
									
									@php
										$stt = $firmado->name." |Acta ".nombre_comite($act->committee_id)." | Nro. ".correlativo(muestra_correlativo($act->id))." / ".date("Y", strtotime($act->date)); 	
										$pos=0;
									@endphp	
									<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->backgroundColor(245, 245, 245)->size(200)->margin(10)->generate($stt)) !!} ">	
									<p lang=ES-CO style='font-family:"Tahoma",sans-serif; font-size: 9pt;'>{{$firmado->name}}</p>
							</td>
						</tr>
						
				@endif
			@endif
		@endforeach
	</tbody>
</table>

<br>
</div>
<b>--- MOD {{ $act->mod }} ---- </b>
@endsection
