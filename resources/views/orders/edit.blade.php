@extends('layouts.app')

@section('content')
<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Editar Ordenes</h3>
				</div>
				<div class="panel-body"> 
				<!--lista de orden del dia pertenecientes al Acta-->
                @include('orders.fragment.lista')
				<!--formularios agregar orden del dia-->
				{!! Form::open([ 'route' => 'order_upd' ]) !!}                
                {{  Form::hidden('id', $order->id) }}
				@include('orders.fragment.form4')
				{!! Form::close() !!}
				</div>
			</div>
		</div>
</div>
@endsection