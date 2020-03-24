@extends('layouts.master')
@section('content')
<div>
<h3>Mis Actas</h3>
@can('create.act')
    <a href="create" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Crear Acta</a>
@endcan
<hr>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <th> ID </th>
            <th> Título </th>
            <th> Tipo</th>
            <th> Grupo </th>
            <th> Institución </th>
            <th> Fecha </th>
            <th> Hora </th>
            <th> Estado </th>
            <th colspan="6"> Opciones</th>
        </tr>
        @forelse($acts as $act)
        <?php
            $id= $act->id;
            $meta=contar_met($id);
            $curre=contar_act($id);
        ?>
        <tr>
            <td> {{ $act->id }} </td>
            <td> {{ $act->title }} </td>
            <td> {{ \App\Parametric::where('value',$act->type)->first()->description }} </td>
            <td> {{ groupByType($act) }} </td>
            <td> {{ \App\Company::find($act->company_id)->tradename }} </td>
            <td> {{ obtenerFechaEnLetra($act->date) }} </td>
            <td> {{ substr($act->time,0,5) }} </td>
            @if($act->state_id==1)
            <td class="active">Borrador</td>
            @elseif($act->state_id==2)
                @switch($act->type)
                    @case('A')
                    <td class="bg-aqua color-palette">En Revisión Firmas({{ $curre }}/{{ $meta }})</td>
                        @break
                    @case('B')
                    <td class="bg-aqua color-palette">Acta Validada</td>
                        @break
                    @default
                @endswitch
            @elseif($act->state_id==3)
            <td class="bg-red color-palette">Observado por: <strong>{{ buscanombrerech($act->id) }}</strong></td>
            @elseif($act->state_id==4)
            <td class="bg-green color-palette">Firmado Completo</td>
            @elseif($act->state_id==5)
            <td class="bg-green disabled color-palette">Archivado</td>
            @endif
            <td>
                <a href="{{ route('act.show',['id' =>$id] ) }}" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i></a>
            </td>
            
        </tr>
        @empty
        <tr>
            <td colspan="13" class="text-center">
                <div class="alert alert-warning" role="alert">
                    <strong>Atención</strong> usted no tiene Actas.
                </div>
            </td>
        </tr>
        @endforelse

    </table>
</div>

<h3>Actas como convocante alterno</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <th> ID </th>
            <th> Título </th>
            <th> Responsable </th>
            <th> Comité </th>
            <th> Institución </th>
            <th> Fecha </th>
            <th> Hora </th>
            <th> Estado </th>
            <th> Opciones </th>
        </tr>

        @forelse($acts_co as $act2)
        <?php
        $id= $act2->id;
        $meta=contar_met($id);
        $curre=contar_act($id);
        ?>
        <tr>
            <td> {{ $act2->id }} </td>
            <td> {{ $act2->title }} </td>
            <td> {{ buscanombre($act2->user_id) }} </td>
            <td> {{ $act2->name }} </td>
            <td> {{ $act2->tradename }} </td>
            <td> {{ obtenerFechaEnLetra($act2->date) }} </td>
            <td> {{ $act2->time }} </td>

            @if($act2->state_id==2)
            @switch($act2->type)
                @case('A')
                <td class="bg-aqua color-palette">En Revisión Firmas({{ $curre }}/{{ $meta }})</td>
                    @break
                @case('B')
                <td class="bg-aqua color-palette">Acta Validada</td>
                    @break
                @default
            @endswitch
            @elseif($act2->state_id==3)
            <td class="bg-red color-palette">Observado por: <strong>{{ buscanombrerech($act2->id) }}</strong></td>
            @elseif($act2->state_id==4)
            <td class="bg-green color-palette">Firmado Completo</td>
            @elseif($act2->state_id==5)
            <td class="bg-green disabled color-palette">Archivado</td>
            @endif
            <!--opciones de Acta -->

            @if($act2->state_id==2)
            <td colspan="4"><a href="{{ route('act_show',['id' =>$id] ) }}" class="btn btn-sm btn-info">Ver</a>
            <a href="{{ route('act_pdf',['id' =>$id] ) }}" class="btn btn-sm btn-primary">PDF</a></td>
            @elseif($act2->state_id==3)
            <td><a href="{{ route('act_show_n',['id' =>$id] ) }}" class="btn btn-sm btn-info">Ver</a></td>
            @elseif($act2->state_id==4)
            <td><a href="{{ route('act_show',['id' =>$id] ) }}" class="btn btn-sm btn-info">Ver</a>
            <a href="{{ route('act_pdf',['id' =>$id] ) }}" class="btn btn-sm btn-primary">PDF</a></td>
            @elseif($act2->state_id==5)
            <td><a href="{{ route('act_pdf',['id' =>$id] ) }}" class="btn btn-sm btn-primary">PDF</a></td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="13" class="text-center">
                <div class="alert alert-warning" role="alert">
                    <strong>Atención</strong> usted no tiene Actas como invitado interno.
                </div>
            </td>
        </tr>
        @endforelse
    </table>
    </div>


</div>
@endsection
