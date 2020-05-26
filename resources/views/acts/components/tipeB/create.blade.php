@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{asset('vendor/select2/css/select2.css')}}">
@endsection
@section('content')
<hr>
<section class="content-header">
    <h3> Crear Acta:<br>
        <small>Para generar la nueva acta por favor llene los todos los datos correspondientes a la reunión</small>
    </h3>
</section>
<div class="container">
    <div class="">
        {!! Form::open([ 'route' => 'act.store', 'name' => 'act_new']) !!}
            {{csrf_field()}}
            {{ Form::hidden('type','B')}}
            @include('acts.components.tipeB.fragments.header')
            <button type="submit" class="btn btn-danger" >Crear Acta</button>
        {!! Form::close() !!}
    </div>
</div>
<strong><small>Responsable: {{ Auth::user()->name }}</small></strong>
@endsection
@section('scripts')
<script src="{{ asset('js/moment.min.js') }}" defer></script>
<script src="{{ asset('js/custom.js') }}" defer></script>
<script src="{{ asset('vendor/select2/js/select2.js') }}" defer></script>
<script>
$(document).ready(function(){
    $('.select2-multiples').select2();
});
</script>
{{-- <script src="{{ asset('vendor/jquery-ui/ui/widgets/autocomplete.js') }}" defer></script> --}}
@endsection