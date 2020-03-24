@extends('layouts.master')
@section('content')
<div>
<h3>Actas UGI</h3>
<hr>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <th> ID </th>
            <th> Título </th>
            <th> Responsable</th>
            <th> Tipo</th>
            <th> Grupo </th>
            <th> Institución </th>
            <th> Fecha </th>
            <th> Hora </th>
            <th colspan="6"> Ver</th>
        </tr>
        @forelse($acts as $act)
        <?php
        $id= $act->id;
        $meta=contar_met($id);
        $curre=contar_act($id);
        ?>
        <tr>
            <td> {{ $act->correlative }} </td>
            <td> {{ $act->title }} </td>
            <td> {{ $act->user()->first()->name }} </td>
            <td> {{ \App\Parametric::where('value',$act->type)->first()->description }} </td>
            <td> {{  groupByType($act) }} </td>
            <td> {{ \App\Company::find($act->company_id)->tradename }} </td>
            <td> {{ obtenerFechaEnLetra($act->date) }} </td>
            <td> {{substr($act->time,0,5)}} </td>
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

</div>
@endsection
