@extends('layouts.master')
@section('content')
<div>
<h3>Editar Contacto</h3>
<div class="row">
    <div class="col-8 offset-2">
        <a href="/guest/index" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a>
        <hr>
        <div class="box box-default">
            <div class=" box-header">
                <h4>Datos del contacto</h4>
            </div>
            <div class="box-body">
                {!! Form::model($guest, ['route' => ['guest.update'],'method' => 'PUT'] )!!}
                {{ Form::hidden('id', $guest->id )}}
                @include('guests.fragment.form1')
                <button type="submit" class="btn btn-danger">Modificar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
