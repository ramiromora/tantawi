@extends('layouts.master')
@section('content')
<div>
<h3>Actas Borradas</h3>
<hr>
<div class="table-responsive">
    <table class="table table-striped">
        <tr>
            <th> Título </th>
            <th> Tipo</th>
            <th> Institución </th>
            <th> Fecha </th>
            <th> Hora </th>
        </tr>
        @forelse($acts as $act)
        <?php
        $id= $act->id;
        ?>
        <tr>
            <td> {{ $act->title }} </td>
            <td> {{ \App\Parametric::where('value',$act->type)->first()->description }} </td>
            <td> {{ \App\Company::find($act->company_id)->tradename }} </td>
            <td> {{ obtenerFechaEnLetra($act->date) }} </td>
            <td> {{substr($act->time,0,5)}} </td>
            
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
