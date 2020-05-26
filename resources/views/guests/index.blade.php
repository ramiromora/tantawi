@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('datatables/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div>
<h3>Directorio de Contactos</h3>
@can('create.act')
    <a href="create" class="btn btn-danger btn-sm"> <i class="fa fa-plus"></i> Agregar Contacto</a>
@endcan
<hr>
<div class="table-responsive">
    <table class="table table-condensed table-striped" id="table1">
        <thead>
            <tr>
                <th>#</th>
                <th>Nro de Actas</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Empresa</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>{{$contact->id}}</td>
                    <td>{{$contact->acts()->get()->count()}}</td>
                    <td>{{$contact->name}}</td>
                    <td>{{$contact->description}}</td>
                    <td>{{(!is_null($contact->company_id)? $contact->company()->first()->name:'')}}</td>
                    <td>{{$contact->phone}}</td>
                    <td>{{$contact->email}}</td>
                    <td>
                        <a href="{{$contact->id}}/edit" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i></a>
                        <a href="{{$contact->id}}/delete" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Nro de Actas</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Empresa</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Opciones</th>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
@section('scripts')
<script src="{{asset('datatables/js/jquery.dataTables.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    } );
</script>
@endsection