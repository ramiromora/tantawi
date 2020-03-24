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
    footer {
		position: fixed;
		bottom: -50px;
		left: 0px;
		right: 0px;
		height: 50px;
		text-align: right;
		font-size :7;
		font-family :arial;
		}
    footer .page:after {
      content: counter(page);
    }
</style>
</head>
<body lang=ES-BO>

<footer>
	<span lang=ES-BO style='font-size:7.0pt;font-family:"Arial",sans-serif'>ACTA REUNIÓN {{ nombre_comite($act->committee_id) }} N° {{ correlativo(muestra_correlativo($act->id)) }}/{{date("Y", strtotime($act->date))}}
		<br>La Paz,{{ obtenerFechaEnLetra($act->date) }} MOD {{ $act->mod }}<br>
		<span class="page">Página </span>
	</span>
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

<P aling="justify">
<span lang=ES-CO style='font-family:"Tahoma",sans-serif'>En la ciudad de La Paz, Estado Plurinacional de Bolivia, en dependencias de de {{ $act->addres}},</span>
<span lang=ES-CO style='font-family:"Tahoma",sans-serif'> el día </span>
<span lang=ES-CO style='font-family:"Tahoma",sans-serif;'>{{ obtenerFechaEnLetra($act->date) }}, a horas {{ $act->time }}, se hicieron presentes los(as) señores(as):
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
		de "{{ company_name($act->company_id) }}"
		@endif
		@if($nee > $nuu)
		de "{{ $guest->institution }}"
		@endif,
	@endforeach
		<?php
			}
		$b1=true;
		$b2=true;
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
			@foreach($firmados as $convo)
				@if($convo->tipe==3)
					@if($b2)
					y a<?php $b2=false;?>
					@endif
					<strong>{{ $convo->name  }} - {{ $convo->description }}</strong>,
				@endif
			@endforeach
			</strong>
			en su condicion como responsable(es) convocantes,
		@endif
		a fin de tratar el siguiente Orden del Día:
</span>
</P>
<br><br>
		<table style=" border: 1px solid #000; width: 100%;">
			<tr>
				<td colspan="2" style="width: 50px; text-align: left; vertical-align: top; border: 1px solid #000;">
					<p style='text-align:center'>
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
			<?php 
				$nro++;
			?>
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
 	<p lang=ES-CO style='font-family:"Tahoma"'>
 	<?php 
	$nro++;
	?>
 	<b>{{ $nro }}. {{ $order->order }}</b>
  <br>
  <?php
    $texto= $order->body;
		echo $texto;
		if(cuenta_reso($order->id)>0){
			$resolutions=saca_reso($order->id);
			echo '<small><i><b>Resoluciones: ';
			foreach ($resolutions as $reso) {
				echo correlativo($reso->id).'|';
			}
			echo '</b></i></small><br><br>';
		}
	?>
 	</p>
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
	echo '<p><b>Resolución Nro. ',correlativo($res->id).'</b><br>';
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
?>
<!--resoluciones-->
<br>
<p lang=ES-CO style='font-family:"Tahoma",sans-serif'>
Dándose por concluida la reunión a horas {{ $act->timef }} de la fecha {{ obtenerFechaEnLetra($act->date) }}, suscriben al
pie de la presente Acta los miembros del {{ nombre_comite($act->committee_id) }},  {{ company_name($act->company_id) }} y demas instituciones participantes.</p>
<br>
<center>
Firmado Por: 
</center>
<br>
@php
		$pos=0;
@endphp
<table width="100%" >
	<tbody>
		@foreach($firmados as $firmado)
			@if($firmado->state==1)
				@php
				$pos++;		
				@endphp
				@if ($pos==1)
						<tr>
							<td>
									<p lang=ES-CO style='font-family:"Tahoma",sans-serif; font-size: 9pt; text-align: center;  '>{{$firmado->name}}</p>
									@php
										$stt = $firmado->name." |Acta ".nombre_comite($act->committee_id)." | Nro. ".correlativo(muestra_correlativo($act->id))." / ".date("Y", strtotime($act->date)); 	
									@endphp	
									<center>
									<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->margin(10)->generate($stt)) !!} ">	
									</center>
							</td>
				@endif	
				@if ($pos==2)
							<td>
									<p lang=ES-CO style='font-family:"Tahoma",sans-serif; font-size: 9pt; text-align: center;  '>{{$firmado->name}}</p>
									@php
										$stt = $firmado->name." |Acta ".nombre_comite($act->committee_id)." | Nro. ".correlativo(muestra_correlativo($act->id))." / ".date("Y", strtotime($act->date)); 	
									@endphp	
								 	<center>
									<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->margin(10)->generate($stt)) !!} ">	
								 	</center>
							</td>
				@endif		
				@if ($pos==3)
							<td>
									<p lang=ES-CO style='font-family:"Tahoma",sans-serif; font-size: 9pt; text-align: center;  '>{{$firmado->name}}</p>
									@php
										$stt = $firmado->name." |Acta ".nombre_comite($act->committee_id)." | Nro. ".correlativo(muestra_correlativo($act->id))." / ".date("Y", strtotime($act->date)); 	
										$pos=0;
									@endphp	
									<center>
									<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->margin(10)->generate($stt)) !!} ">	
									</center>
							</td>
						</tr>
						
				@endif
			@endif
		@endforeach
	</tbody>
</table>



<br>
</div>
</p>
</main>
</body>
