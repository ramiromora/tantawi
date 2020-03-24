@extends('layouts.app')
@section('content')


<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
				    <h2 class="text text-center">Editar perfil</h2>
				</div>
				<div class="panel-body"> 
			
				{!! Form::open([ 'route' => 'updt_user' ,'files'=>true]) !!}
				@include('users.fragments.form')
				{!! Form::close() !!}
				</div>
			</div>
		</div>
</div>

@endsection