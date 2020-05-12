@extends('layouts.master')
@section('content')
<div class="row invisible" data-toggle="appear">
    <div class="col-md-12">
        <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Participacion en Actas</h3>
        </div>
            <div class="box-body">                
                {{-- Por favor lea las actas antes de firmarlas --}}
            </div>
        </div>
    </div>

    <div class="block block-themed table-responsive">
        <div class="block-content">
            <div class=" table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Convocante</th>
                        <th>Estado</th>
                        <th>Ver</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($acts as $act)
                        <tr>
                            
                            <td>{{ $act->title }}</td>
                            <td>{{ obtenerFechaEnLetra($act->date) }}</td>
                            <td>{{ buscanombre($act->user_id) }}</td>
                            @if($act->state_id==2)
                            <td class="table-success">Validada</td>
                            @endif                            
                            <td>
                                <a href="act/{{ $act->id }}/show" class="btn btn-info">Ver Acta</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center"> Sin Regitros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @php
        
 /*
    <div class="block block-themed table-responsive">
        <div class="block-content">
            <div class=" table-responsive">
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
                    @forelse($notifiationsC as $notifiC)
                        <tr>
                            <td>{{ $notifiC->act_id }}</td>
                            <td>{{ $notifiC->title }}</td>
                                                <td>{{ obtenerFechaEnLetra($notifiC->date) }}</td>
                            <td>{{ $notifiC->name }}</td>
                            @if($notifiC->state_id==2)
                            <td class="table-info">En espera de revisión</td>
                            @elseif($notifiC->state_id==3)
                            <td class="table-danger">Observado</td>
                            @elseif($notifiC->state_id==4)
                            <td class="table-success">Firmado Completo</td>
                            @elseif($notifiC->state_id==5)
                            <td class="table-success">Archivado por: {{ buscanombre($notifiC->id_rech)}}</td>
                            @endif
                            @if($notifiC->state==0)
                                @if($notifiC->state_id==2)
                                <td class="table-warning">En espera de Firma</td>
                                @elseif($notifiC->state_id==3)
                                <td class="table-danger ">Requiere Modificacion</td>
                                @endif
                            @elseif($notifiC->state==1)
                            <td class="table-success">Firmado</td>
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
                                <a href="{{ route('act.show',['id' =>$notifiC->act_id] ) }}" class="btn btn-info">Ver Acta</a></td>
                            <td>
                                <a href="{{ route('act_pdf',['id' =>$notifiC->act_id] ) }}" class="btn btn btn-primary"> <i class="fa fa-file-pdf-o"></i> Descargar PDF</a></td>
                            <td>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center"> Sin Regitros</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    */
    @endphp
    <!-- END Row #1 -->
</div>
@endsection
