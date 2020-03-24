@extends('layouts.app')
@section('content')

<section class="content-header">
      <h1>
        Actas Firmadas
      </h1>
      
</section>

		<div >
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Lista de actas Concluidas</h4>
				</div>
			<div class="panel-body">             
            @if(!is_null($notifiations))
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Convocante</th>
                <th colspan="2">Estados</th>
                <th>Histórico de cambios</th>
            </tr>
            </thead>
            <tbody>
            @if(4 == Auth::user()->departament_id) 
            @foreach($notifiations as $notifiC)                               
                <tr>  
                    <td>{{ $notifiC->id }}</td>
                    <td>{{ $notifiC->title }}</td>
                    <td>{{ $notifiC->name }}</td>             
                                   
                    @if($notifiC->state_id==4)
                    <td class="bg-green color-palette">Firmado Completo</td>
                    @elseif($notifiC->state_id==5)
                    <td class="bg-green disabled color-palette">Archivado por: {{ buscanombre($notifiC->id_rech)}}</td>
                    @endif
                    <?php  $lvl=Auth::user()->level; ?>
                    <td>
                    <a href="{{ route('act_show',['id' =>$notifiC->id] ) }}" class="btn btn-info">Ver</a>
                    <a href="{{ asset($notifiC->pdf) }}" class="btn btn btn-primary" target="_blank" >PDF</a>                   
                    @if($notifiC->state_id==4 & $lvl>=2)
                    <a href="{{ route('act_arch',['id' =>$notifiC->id] ) }}" class="btn btn-success" >Archivar</a>
                    @endif
                    </td>
                    <td>                           
                    @for($i = 0; $i <= $notifiC->mod; $i++)
                        <?php $parche = 'actas/acta_'.$notifiC->id.'-2019_mod-'.$i.'.pdf'; ?>
                        <a href="{{ $parche }}" class="btn btn-block btn-default btn-xs" target="_blank"> <i class="fa fa-file-pdf-o" target="_blank"></i> Modificación {{ $i}} </a>
                    @endfor
                    </td>
                </tr>
            @endforeach
            @else
            @foreach($notifiations as $notifiC)    
            @if($notifiC->departament_id==Auth::user()->departament_id)
                <tr>  
                    <td>{{ $notifiC->id }}</td>
                    <td>{{ $notifiC->title }}</td>
                    <td>{{ $notifiC->name }}</td>
                    @if($notifiC->state_id==4)
                    <td class="bg-green color-palette">Firmado Completo</td>
                    @elseif($notifiC->state_id==5)
                    <td class="bg-green disabled color-palette">Archivado por: {{ buscanombre($notifiC->id_rech)}}</td>
                    @endif
                    <?php  $lvl=Auth::user()->level; ?>
                    <td><a href="{{ route('act_show',['id' =>$notifiC->id] ) }}" class="btn btn-info">Ver Acta</a></td>
                    <td><a href="{{ route('act_pdf',['id' =>$notifiC->id] ) }}" class="btn btn-sm btn-primary"><i class="fa fa-file-pdf-o"></i>Descargar PDF</a></td>
                    @if($notifiC->state_id==4 & $lvl>=2)
                    <a href="{{ route('act_arch',['id' =>$notifiC->id] ) }}" class="btn btn-success">Archivar</a>
                    @endif
                    </td>
                    <td>                        
                        @if (date("Y", strtotime($notifiC->date))==2019)
                            
                        @for($i = 0; $i <= $notifiC->mod; $i++)
                            <?php $parche = 'actas/acta_'.$notifiC->id.'-2019_mod-'.$i.'.pdf'; ?>
                        <a href="{{  $parche }}" class="btn btn-block btn-danger btn-xs" target="_blank"> <i class="fa fa-file-pdf-o" target="_blank"></i> Modificación {{ $i}} </a>
                        @endfor
                            
                        @endif

                        @if (date("Y", strtotime($notifiC->date))==2018)
                            
                        @for($i = 0; $i <= $notifiC->mod; $i++)
                            <?php $parche = 'actas/acta_'.$notifiC->id.'-2018_mod-'.$i.'.pdf'; ?>
                        <a href="{{  $parche }}" class="btn btn-block btn-danger btn-xs" target="_blank"> <i class="fa fa-file-pdf-o" target="_blank"></i> Modificación {{ $i}} </a>
                        @endfor
                            
                        @endif
                        
                    </td>
                    
                </tr>
            @endif
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
        {{ $notifiations->render() }}
        @endif
			</div>
		</div>

		</div>
        @endsection