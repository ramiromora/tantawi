{!! Form::open([ 'route' => 'com_mem_b','files'=>true]) !!}
<div class="form- group">
{{ Form::hidden('committee_id', $committee->id) }}                             
{{ Form::hidden('user_id', $prin->id) }}
    <div class="input-group input-group-sm">
    {!! Form::label('x' , $prin->name) !!}
        <span class="input-group-btn">
        {!! Form::submit('x', ['class' =>'btn btn-sm btn-danger'] )!!}
        </span>
    </div>
{!! Form::close() !!}