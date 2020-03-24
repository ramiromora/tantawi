@extends('layouts.app')

@section('content')
<section class="content-header">
        <h1>
        Editar Acta
        </h1>      
</section>
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					Editando Acta
				</div>
                <div class="panel-body">  
                    {!! Form::model($act, ['route' => ['act_upd'],'method' => 'PUT','name' => 'act_new'] )!!}
                    {{ Form::hidden('act_id', $act->id ) }}
                    {{ Form::hidden('members', $members ,['id'=>'members']) }}
                    @include('acts.fragment.form1')
                    {!! Form::close() !!}
                </div>
		    </div>
        </div>

@endsection