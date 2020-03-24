@extends('layouts.master')
@section('content')
<div class="row">
    <h3>Crear Acta Nueva</h3>
</div>
<div class="row gutters-tiny">
    @forelse ($tipes as $item)
        <div class="col-6 col-md-4 col-xl-2">
            <a class="block block-link-shadow text-center" href="/act/create/{{$item->value}}">
                <div class="block-content">
                    <p class="mt-5">
                        <i class="si si-badge fa-4x"></i>
                    </p>
                    <p class="font-w600">{{$item->description}}</p>
                </div>
            </a>
        </div>
    @empty
        <div class="alert alert-warning" role="alert">
            <strong>Atención</strong> No hay Tipos de acta disponibles
        </div>
    @endforelse
</div>
@endsection