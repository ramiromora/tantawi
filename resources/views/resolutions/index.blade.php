@extends('layouts.app')
@section('content')

<ul class="timeline">
        <?php
        $resos = reso_list();
        ?>
        @foreach($resos as $reso)
        <li class="time-label">
            <span class="bg-red">
                Resolución {{$reso->id}}/{{date("Y", strtotime($act->date))}}
            </span>
            <div class="timeline-item">
                <div class="timeline-body">
                    <h3 class="timeline-header">{{$reso->title}}</h3>
                    {{$reso->body}}
                    <br>
                    <small>Fecha: {{$reso->date}}</small>
                    @if(!is_null($reso->term))
                    {{$reso->term}}
                    @endif
                    
                </div>
                <?php
                $act_id = sacaacta($reso->order_id);
                $est    = estado_acta($act_id);
                ?>
                @if($est==1)
                <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('act_show_n',['id' =>$act_id] ) }}">Ver Acta</a>
                </div>
                @elseif($est==2)
                <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('act_show',['id' =>$act_id] ) }}">Ver Acta</a>
                </div>
                @elseif($est==3)
                <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('act_show_n',['id' =>$act_id] ) }}">Ver Acta</a>
                </div>
                @elseif($est==4)
                <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('act_show',['id' =>$act_id] ) }}">Ver Acta</a>
                </div>
                @elseif($est==5)
                <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs" href="{{ route('act_show',['id' =>$act_id] ) }}">Ver Acta</a>
                </div>
                @endif
                
            </div>
        </li>
        @endforeach
        {{ $resos->render() }}
        
@endsection