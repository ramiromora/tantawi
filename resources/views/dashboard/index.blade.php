@extends('layouts.app')

@section('content')

<h2>Actividad <small>Firmas Pendientes</small></h2>
<div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Actas Pendientes <small>Por favor lea las actas antes de firmarlas</small> </h4>
		</div>
        <div class="panel-body">
        @if(count($notifiationsC)>0)
        <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
								<th>Fecha</th>
                <th>Convocante</th>
                <th colspan="2">Estados</th>
                <th colspan="2">Opciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($notifiationsC as $notifiC)
                <tr>
                    <td>{{ $notifiC->act_id }}</td>
                    <td>{{ $notifiC->title }}</td>
										<td>{{ obtenerFechaEnLetra($notifiC->date) }}</td>
                    <td>{{ $notifiC->name }}</td>
                    @if($notifiC->state_id==2)
                    <td class="info">En espera de revisión</td>
                    @elseif($notifiC->state_id==3)
                    <td class="danger">Observado</td>
                    @elseif($notifiC->state_id==4)
                    <td class="success">Firmado Completo</td>
                    @elseif($notifiC->state_id==5)
                    <td class="bg-green disabled color-palette">Archivado por: {{ buscanombre($notifiC->id_rech)}}</td>
                    @endif

                    @if($notifiC->state==0)
                        @if($notifiC->state_id==2)
                        <td class="warning">En espera de Firma</td>
                        @elseif($notifiC->state_id==3)
                        <td class="danger">Requiere Modificacion</td>
                        @endif
                    @elseif($notifiC->state==1)
                    <td class="bg-green color-palette">Firmado</td>
                    @endif

                    @if($notifiC->state_id==2 & $notifiC->state==0)
                    <td>
					{!! Form::open([ 'route' => 'act_fir', 'onSubmit' => 'if(!confirm("¿Confirmar Aprobación?")){return false;}']) !!}
                    {{ Form::hidden('id',$notifiC->act_id) }}
                    <input type="submit" value="Firmar" class="btn btn-success">
                    {!! Form::close() !!}
                    </td>
                    @if($notifiC->state_id==2 & $notifiC->state==0)
                    <td>
                    {!! Form::open([ 'route' => 'act_rech', 'onSubmit' => 'if(!confirm("¿Rechazar Acta?")){return false;}']) !!}
                    {{ Form::hidden('id',$notifiC->act_id) }}
                    <input type="submit" value="Rechazar" class="btn btn-danger">
                    {!! Form::close() !!}
                    </td>
                    @endif
                    @endif
                    <td>
					<a href="{{ route('act_show',['id' =>$notifiC->act_id] ) }}" class="btn btn-info">Ver Acta</a></td>
                    <td>
					<a href="{{ route('act_pdf',['id' =>$notifiC->act_id] ) }}" class="btn btn btn-primary"> <i class="fa fa-file-pdf-o"></i> Descargar PDF</a></td>
                    <td>
					</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        {{ $notifiationsC->render() }}
        @else
        <div class="alert alert-warning" role="alert">
            <strong>Vacío</strong>
        </div>
        @endif
        <!--Realizamos las consultas por  back-->
        <?php
        $menciones=buscaordenes(Auth()->user()->id);?>
        @if(count($menciones)>0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Responsabilidad en actas</h4>
            </div>
            <div class="panel-body">
            <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Convocante</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
						<?php $no=0;?>
            @foreach($menciones as $mencion)

            <?php
            $act_id = sacaacta($mencion->order_id);
            $acta   = datosacta($act_id);
            if($acta->state_id>1){
            ?>
						@if($no<>$act_id)
            <tr>
                <td>{{ $acta->id }}</td>
                <td>{{ $acta->title }}</td>
                <td>{{ buscanombre($acta->user_id) }}</td>
								<?php $no = $act_id;?>
                @if($acta->state_id==2)
                <td class="warning">En revisión</td>
                @elseif($acta->state_id==3)
                <td class="danger">Obserbado</td>
                @elseif($acta->state_id==4)
                <td class="success">Firmado</td>
                @elseif($acta->state_id==5)
                <td class="bg-green disabled color-palette">Archivado</td>
                @endif

                <td><a href="{{ route('act_show',['id' =>$act_id] ) }}" class="btn btn-info">Ver</a>
                <a href="{{ route('act_pdf', ['id' =>$act_id] ) }}" class="btn btn btn-primary">PDF</a></td>
						@endif
            <?php
            }
            ?>
            @endforeach
                </tbody>
            </table>
            </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
