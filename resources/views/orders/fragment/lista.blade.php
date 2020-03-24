<div class="text text-center"><strong>Orden del Dia </strong></div>
<?php
$nro=0;
?>
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
		<tr>
			<th width="30px">Nro</th>		
            <th>Orden</th>
            <th width="60px" colspan="2">Opciones</th>
		</tr>
	</thead>
    <tbody>	
        <?php if(isset($orders)){?>			
        @foreach($orders as $order)	
        <?php $nro++;?>			
        <tr> 
            <td>{{ $nro }}</td>
            <td><strong>{{ $order->order  }}</strong></td>
            	
            <td>
                {!! Form::open([ 'route' => 'order_edi2']) !!}
                {{ Form::hidden('id', $order->id) }}
                {!! Form::submit('Ver y Editar', ['class' =>'btn btn-sm btn-info'] )!!}
                {!! Form::close() !!}						
                </td>	
            <td> 
                <a href="{{ route('reso_new',['id' =>$order->id] ) }}" class="btn btn-sm btn-success">Agregar Resolución <b>cant({{ cuenta_reso($order->id) }})</b></a> 					
            </td>	
            <td>
            {!! Form::open([ 'route' => 'order_del']) !!}
            {{  Form::hidden('id', $order->id) }}
            {{  Form::hidden('act_id', $act->id) }}
            {!! Form::submit('Borrar', ['class' =>'btn btn-sm btn-danger'] )!!}
            {!! Form::close() !!}						
            </td>            
        </tr>					
        @endforeach	
        <?php
        }
    ?>
    </tbody>
</table>
</div>

