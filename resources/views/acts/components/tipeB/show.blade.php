@extends('layouts.master')
@section('css')
@php
    $color = '#787878';
@endphp
<style>
    @media print {
        .print {
        display: none;
        }
    }  
    thead {
        border: {{$color}} 2px solid;
    }   }
    tbody {
        border: {{$color}} 2px solid;
    }
    table{
        border: {{$color}} 2px solid;
    }
    .celda{
        border: #aaa 1px solid;
    }
</style>
@endsection
@section('content')
<div class="col-8 offset-2">
    @if ($act->state_id == 1)
    <a href="/act/{{$act->id}}/check" class="btn btn-secondary" title="Validar" onclick="return confirmar()"><i class="fa fa-check"></i></a>
    

    <button type="button" title="Editar" class="btn btn-secondary pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right " x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-147px, 28px, 0px);">
        <a class="dropdown-item" href="/act/{{$act->id}}/edit/header">
            <i class="fa fa-gears"></i> Cabezera 
        </a>
        <a class="dropdown-item" href="/act/{{$act->id}}/edit/body">
            <i class="fa fa-edit"></i> Contenido
        </a>
        <a class="dropdown-item" href="/act/{{$act->id}}/edit/participants">
            <i class="fa fa-check-square mr-5"></i>Participantes
        </a>
    </div>
    @endif
    <a href="/act/{{$act->id}}/pdf" title="Imprimir" class="btn btn-secondary" target="_blank"></i> <i class="fa fa-print"></i></a>
    @if ($act->user_id == \Auth::user()->id)
    <a href="/act/{{$act->id}}/delete" title="Borrar" class="btn btn-secondary pull-right" onclick="return confirmar()"><i class="fa fa-trash"></i> </a>
    @endif
    @if ($act->state_id == 2)
        @if ($act->user_id == \Auth::user()->id)
        <a href="/act/{{$act->id}}/notify" class="btn btn-secondary pull-left" onclick="return confirmar()" title="Enviar correos con copia de acta"> <i class="fa fa-share"></i></a>
        @endif
    @endif
    <div class="row"><div class="mx-auto"> Ultima modificación ( {{dateTimeFormat($act->updated_at)}} ) </div></div>
<hr>
{{-- --}}

    <table width="100%">
        <thead>
            <tr>
                <td colspan="3">
                    <font face="Arial, serif" style="font-weight:bold;">
                        <span class="float-left">
                            {{\App\Parametric::where('value',$act->location)->first()->description }},
                            {{obtenerFechaEnLetra($act->date)}}
                            @if (!is_null($act->datef))
                                al {{obtenerFechaEnLetra($act->datef)}}
                            @endif
                        </span>
                    </font>
                </td>
                <td colspan="3">
                    <font face="Arial, serif" style="font-weight:bold;">
                        <span class="float-right">
                            ACTA DE REUNION N° {{($act->correlative>0)? correlativo($act->correlative) : 'Borrador ['.$act->id.']' }} / {{'2020'}}
                        </span>
                    </font>
                </td>
            </tr>
        </thead>
        <tr>
            <td colspan="6" class="text-white p-10 lead" style=" background: {{$color}}; ">
                <div class="row">
                    <div class="mx-auto">
                        <font face="Arial, serif" style="font-weight:bold;">
                            {{$act->title}}
                        </font>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="celda" width="120px">
                <font face="Arial, serif" style="font-weight:bold;">
                    <span class="float-left">
                        <strong>
                            Lugar:
                        </strong>
                    </span>
                </font>
            </td>
            <td>
                <font face="Arial, serif" >
                    <span class="float-left">
                        {{$act->addres}}
                    </span>
                </font>
            </td>
            <td class="celda">
                <font face="Arial, serif" style="font-weight:bold;">
                    <span class="float-left">
                        <strong>
                            Hora de Inicio
                        </strong>
                    </span>
                </font>
            </td>
            <td>
                <font face="Arial, serif">
                    <span class="float-left">
                        {{substr($act->time,0,5)}}
                    </span>
                </font>
            </td>
            <td class="celda">
                <font face="Arial, serif" style="font-weight:bold;">
                    <span class="float-left">
                        <strong>
                            Hora de Finalización
                        </strong>
                    </span>
                </font>
            </td>
            <td>
                <font face="Arial, serif" >
                    <span class="float-left">
                        {{substr($act->timef,0,5)}}
                    </span>
                </font>
            </td>
        </tr>
    <thead>
        <tr>
            <td class="celda">
                <font face="Arial, serif" >
                    <span class="float-left" style="font-weight:bold;">
                        {{($act->companys()->count() > 1 )? 'Instituciones: ': 'Institución: '}}
                    </span>
                </font>
            </td>
            <td class="celda" colspan="5">
                <font face="Arial, serif" >
                    <span class="float-left" style="font-weight:bold;">
                        @php
                            $co = 1;
                        @endphp
                        @forelse ($act->companys()->get() as $company)
                            {{$company->tradename}}{{(($co++ < $act->companys()->get()->count() ))? ',':null}}
                        @empty
                            NO HAY EMPRESAS REGISTRADAS
                        @endforelse
                    </span>
                </font>
            </td>
        </tr>
        <tr>
            <td colspan="6" class="text-white p-10 " style=" background: {{$color}}; ">
                <div class="row">
                    <div class="mx-auto">
                        <font face="Arial, serif" style="font-weight:bold; color:#fff font-size:40px;">
                            <span class="mx-auto p-10 ">
                                DESARROLLO DE LA REUNIÓN
                            </span>
                        </font>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <div class="content">
                    {!!$act->content!!}
                </div>
            </td>
        </tr>
    </thead>
</table>
    @if($act->agreements != null)
    <table width="100%" cellpadding="1" cellspacing="0" >
        <tr>
            <td colspan="6" class="text-white p-10 " style=" background: {{$color}}; ">
                <div class="row">
                    <div class="mx-auto">
                        <font face="Arial, serif" style="font-weight:bold; color:#fff font-size:40px;">
                            <span class="mx-auto p-10 ">
                                CONCLUSIONES Y/O ACUERDOS DE LA REUNIÓN
                            </span>
                        </font>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="6" >
                <div class="content">
                    {!!$act->agreements !!}
                </div>
            </td>
        </tr>
    </table>
    @endif
    <div>
    </div>
    <table width="100%" cellpadding="1" cellspacing="0" >
        <tr>
            <td colspan="6" class="text-white p-10 " style=" background: {{$color}};">
                <div class="row">
                    <div class="mx-auto">
                        <font face="Arial, serif" style="font-weight:bold; color:#fff font-size:40px;">
                            <span class="mx-auto p-10 ">
                                PARTICIPANTES
                            </span>
                        </font>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <table class="table table-bordered"  width="100%" cellpadding="1" cellspacing="0" >
        <thead>
            <tr>
                <th width="2">Nº</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Institución</th>
                <th width="2">Teléfono</th>
                <th>Email</th>
                <th>Firma</th>
            </tr>
        </thead>
        @php
            $num = 1;
        @endphp
        <tbody>
            @forelse ($act->users()->get() as $user)
            <tr>
                <td style="font-size:12px;">{{$num++}})</td>
                <td style="font-size:12px;">{{$user->name}}</td>
                <td style="font-size:12px;">{{$user->description}}</td>
                <td style="font-size:12px;">{{'OFEP'}}</td>
                <td style="font-size:12px;">{{$user->number}}</td>
                <td style="font-size:12px;">{{$user->email}}</td>
                <td style="font-size:12px;">___________</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="row">
                            <div class="mx-auto">-- NO HAY PARTICIPANTES INTERNOS REGISTRADOS --</div>
                        </div>
                    </td>
                </tr>
            @endforelse
            @forelse ($act->guests()->get() as $user)
            
            <tr>
                <td style="font-size:12px;">{{$num++}})</td>
                <td style="font-size:12px;">{{$user->name}}</td>
                <td style="font-size:12px;">{{$user->description}}</td>
                <td style="font-size:12px;">{{$user->company()->first()->tradename}}</td>
                <td style="font-size:12px;">{{$user->phone}}</td>
                <td style="font-size:12px;">{{  substr($user->email,0 ,20)."\n".
                                                substr($user->email,20,20)."\n".
                                                substr($user->email,40,20)."\n".
                                                substr($user->email,60,20)."\n".
                                                substr($user->email,80,20)."\n".
                                                substr($user->email,100,20)."\n".
                                                substr($user->email,120,20)."\n".
                                                substr($user->email,140,20)}} </td>
                <td style="font-size:12px;">___________</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" >
                        <div class="row">
                            <div class="mx-auto">-- . --</div>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
@section('scripts')
<script>
function confirmar()
{
    if(confirm("¿Esta seguro que desea continuar?"))
    {
        return true;
    }
    return false;
}
</script>
@endsection