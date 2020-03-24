
<?php
 if(!empty($resolutions)){?>
<div class="text text-center"><strong><h4>Resoluciones</h4></strong></div>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
		<tr>
			<th width="30px">Nro</th>		
            <th>Resolución</th>
            <th width="60px" colspan="2">Opciones</th>
            <th width="60px" colspan="2">Responsables</th>
		</tr>
	</thead>
    <tbody>	
        		
        @foreach($resolutions as $resolution)	
        <tr> 
            <td>{{ correlativo($resolution->id) }}</td>
            <td><strong>{{ $resolution->title  }}</strong></td>
            <td>            
            <a href="{{ route('reso_edi',['id' =>$resolution->id] ) }}" class="btn btn-sm btn-warning">Editar</a>
            </td>
            <td>
            <a href="{{ route('reso_del',['id' =>$resolution->id] ) }}" class="btn btn-sm btn-danger">Eliminar</a>				
            </td> 
            <td>

                {!! Form::open([ 'route' => 'respo_add','files'=>true]) !!}
                <div class="form- group">                    
                    {{ Form::hidden('order_id', $order_id) }}
                    {{ Form::hidden('resolution_id', correlativo($resolution->id)) }}
                    <div class="input-group input-group-sm">
                    {{ Form::select('user_id', $users ,null, ['class' => 'form-control', 'placeholder' => 'Selecione un responsable', 'required']) }}
                    <span class="input-group-btn">
                    {!! Form::submit('Añadir responsable', ['class' =>'btn btn-sm btn-primary'] )!!}
                    </span>
                    </div>
                </div>
                {!! Form::close() !!}
            </td> 
            <td>
            <?php
                if(count($respons)>0){
                    foreach ($respons as $respon) {
                        if($respon->resolution_id==$resolution->id){
                        ?>
                        {!! Form::open([ 'route' => 'respo_del','files'=>true]) !!}
                        <div class="form- group">
                        {{ Form::hidden('order_id', $respon->order_id) }}                             
                        {{ Form::hidden('user_id', $respon->user_id) }}
                        {{ Form::hidden('resolution_id', correlativo($respon->resolution_id)) }}
                        <div class="input-group input-group-sm">
                        {!! Form::label('x' , buscanombre($respon->user_id)) !!}
                        
                        <span class="input-group-btn">
                        {!! Form::submit('x', ['class' =>'btn btn-sm btn-danger'] )!!}
                        </span>
                        </div>
                        {!! Form::close() !!}
                        <br></div>
                        <?php

                        }
                    }
                }
            ?>    
            </td>          
        </tr>					
        @endforeach        
    </tbody>
</table>
</div>
<?php
}
?>	