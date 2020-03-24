<html>
<head>
<title>Tantawi - Sistema de Actas</title>
<style>

@page {
            margin-top: 3em;
            margin-left: 3em;
			margin-right: 3em;
			margin-bottom: 3em;
    }
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; text-align: right; font-size :7 ; font-family :arial;}
    footer .page:after {
      content: counter(page);
    }
  </style>
</head>

<body lang=ES-BO>
<footer>
	<span lang=ES-BO style='font-size:7.0pt;font-family:"Arial",sans-serif'>ACTA REUNIÓN {{ nombre_comite($act->committee_id) }} N° {{ correlativo(muestra_correlativo($act->id)) }}/{{date("Y", strtotime($act->date))}}<br>
				La Paz, {{ obtenerFechaEnLetra($act->date) }} MOD {{ $act->mod }}<br>
				<span class="page">Página </span></span>
</footer>
<main>
  <p class=MsoNormal align=center style='text-align:center'>
  		<b>
  		<u>
  		<span lang=ES-CO style='font-size:12.0pt;font-family:"Tahoma",sans-serif'>ACTA {{ nombre_comite($act->committee_id) }} No<span style='background:windowtext'>. {{ correlativo(muestra_correlativo($act->id)) }}</span>/{{date("Y", strtotime($act->date))}} <br>
  		<span style='background:windowtext !msorm'>
  		<span style='background:windowtext'>”{{ $act->title }}”</span>
  		</span> , correspondiente
  		<span style='background:windowtext !msorm'><span style='background:windowtext'>al día {{ obtenerFechaEnLetra($act->date) }}</span>
  		</span>
  		</span>
  		</u>
  		</b>
  		</p>
<P ALIGN="justify">
<span lang=ES-CO style='font-family:"Tahoma",sans-serif'>En la ciudad de La Paz, Estado Plurinacional de Bolivia, en dependencias de {{ $act->addres}},</span>
<span lang=ES-CO style='font-family:"Tahoma",sans-serif'> el día </span>
<span lang=ES-CO style='font-family:"Tahoma",sans-serif;'>{{ obtenerFechaEnLetra($act->date) }}, a horas {{ $act->time }}
, se hicieron presentes los(as) señores(as):

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
						de "{{ company_name($act->company_id) }}"
						@endif
						@if($nee > $nuu)
						de "{{ $guest->institution }}"
						@endif,
					@endforeach
			<?php
				}
				if(count($users)>0){
			?>
			como invitado(s) Internos(s),
				@foreach($users as $user)
					<strong>{{ $user->name  }} - {{ $user->description }}</strong>,
				@endforeach
			<?php
				}
			?>
				@if(!soy_miembro_principal($act->id,Auth()->user()->id,$act->committee_id))
				y a <strong> {{ buscanombre($act->user_id) }}
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
  <p class=MsoNormal align=center style='text-align:center'><strong>Desarrollo de la Reunión</strong></p>
 <br>
 @foreach($orders as $order)
 <p lang=ES-CO style='font-family:"Tahoma",sans-serif'>
 <?php $nro++;?><b>
  {{ $nro }}. {{ $order->order }}</b>
  <br>
    <?php
    $texto= $order->body;
    echo $texto;
	if(cuenta_reso($order->id)>0){
		$resolutions=saca_reso($order->id);
		echo '<b><i>Resoluciones: ';
		foreach ($resolutions as $reso) {
			echo correlativo($reso->id).'|';
		}
		echo '</b></i><br><br>';
	}?>

@endforeach
<br>
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
	echo '<P><b>Resolución Nro. ',correlativo($res->id).'</b><br>';
	echo '<u>'.$res->title.'</u>';
	echo '<br>';
	echo '<b>Accion: </b> '.$res->body.'.';
	$responsables=buscaresponsables($res->id);
	if(count($responsables)>0){
		echo '<br><b>Responsable(s): </b>';
		foreach ($responsables as $re) {
		echo ''.buscanombre($re->user_id).', ';
	}
	}
	if(!is_null($res->term)){
		echo '<br><b>Plazo: </b>'.obtenerFechaEnLetra($res->term).'<br><br>';
	}
}
	echo '</b>';
}
?>
@endforeach
<?php
echo '</div>';
}
?></p>
<!--resoluciones--><br><P lang=ES-CO style='font-family:"Tahoma",sans-serif'>
Dándose por concluida la reunión a horas {{ $act->timef }}  de la fecha {{ obtenerFechaEnLetra($act->date) }}, suscriben al
pie de la presente Acta los miembros del {{ nombre_comite($act->committee_id) }} , {{ company_name($act->company_id) }} y demas instituciones participantes.</p>
<br>
<center>Firmas
<br>
<br>
</div>
</p>
</main>
</body>
