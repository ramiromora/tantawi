<!DOCTYPE html>
<html lang="es">
@php
    $color='#787878';
@endphp
<head>
    <meta charset="UTF-8">
    <style>
        body{
            margin: 26mm 0mm 2mm -1mm;
        }
        .margen {
            border-style:  solid;
            margin: 70px 0px 0px -8px;
            border-top-color: #787878;  /* red;*/
            border-right-color: #787878;  /* blue;*/
            border-bottom-color: #787878;  /* green;*/
            border-left-color: #787878;  /* orange;*/
            height: 645px;
            width: 975px;
            position: absolute;
        }
        .margen2 {
            border-style:  solid;
            margin: -7px 0px 0px -8px;
            border-top-color: #fff;  /* red;*/
            border-right-color: #00000000;  /* blue;*/
            border-bottom-color: #787878;  /* green;*/
            border-left-color: #00000000;  /* orange;*/
            height: 99px;
            width: 975px;
            position: absolute;
        }
        .wather_marc{
            color: #78787850;
            font-size: 160;
            margin: -7px 0px 0px -8px;
            height: 99px;
            width: 975px;
            position: absolute;
        }
        .rotar1 { 
        -webkit-transform: rotate(-45deg); 
        -moz-transform: rotate(-45deg); 
        -ms-transform: rotate(-45deg); 
        -o-transform: rotate(-45deg); 
        transform: rotate(-45deg); 
        
        -webkit-transform-origin: 50% 50%; 
        -moz-transform-origin: 50% 50%; 
        -ms-transform-origin: 50% 50%; 
        -o-transform-origin: 50% 50%; 
        transform-origin: 50% 50%; 
        width: 1300px;
        top: 50px;
        }
        .qr_img{
            width: 100%;
            margin: -5%;
            width: 170px;
            height: 170px;
            position: relative;
            bottom: 50px;
        }
        header { position: fixed; bottom: 670px; left: 1px; right: 0px; height: 54px;}
    </style>
</head>

<body>
    <header>
        <div class="wather_marc rotar1 ">
            COPIA
        </div>
        <div class="margen">
        </div>
        <div class="margen2">
            <table width="100%">
                <tr>
                    <td>
                        <img src="img/logoxl.png" height="70px" />
                    </td>
                    <td>
                        @php
                        if ($act->correlative==0) {
                            $stt = 'BORRADOR';
                        } else {
                            $stt = "Acta Nro. ".correlativo($act->correlative)."/".date("Y", strtotime($act->date)). ' "'.$act->title.'" Del '.obtenerFechaEnLetra($act->date); 	
                        }
                        @endphp
                        <img class="" height="70px" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->margin(0)->generate($stt)) !!}" align="right" />	
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <font style="font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                                {{\App\Parametric::where('value',$act->location)->first()->description }},
                                {{obtenerFechaEnLetra($act->date)}}
                        </font>
                    </td>
                    <td align="right">
                        <font style="font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                                ACTA DE REUNIÓN ERP N° {{($act->correlative>0)? correlativo($act->correlative) : 'Borrador['.$act->id.']' }} / {{'2020'}}
                        </font>
                    </td>
                </tr>
            </table>
        </div>
    </header>
    <table width="100%" border="1" cellpadding="1" cellspacing="0" style="border-color: {{$color}};">
        <tr>
            <td colspan="6" style="border-color: {{$color}}; background: {{$color}}; " align="center">
                <font style="font-weight:bold; color:#fff; font-size:30px; font-family: Arial, Helvetica, sans-serif;">
                    {{$act->title}}
                </font>
            </td>
        </tr>
        <tr>
            <td class="celda" align="left" width="100px" style="border-color: {{$color}};">
                <font style=" font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left">
                        <strong>
                            Lugar:
                        </strong>
                    </span>
                </font>
            </td>
            <td  align="left" style="border-color: {{$color}};">
                <font style="font-weight:light; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left">
                        {{$act->addres}}
                    </span>
                </font>
            </td>
            <td align="right" style="border-color: {{$color}};">
                <font style="font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left">
                        <strong>
                            Hora de Inicio:
                        </strong>
                    </span>
                </font>
            </td>
            <td width="50px" style="border-color: {{$color}};">
                <font style="font-weight:light; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left">
                        {{substr($act->time,0,5)}}
                    </span>
                </font>
            </td>
            <td align="right" style="border-color: {{$color}};">
                <font style="font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left">
                        <strong>
                            Hora de Finalización
                        </strong>
                    </span>
                </font>
            </td>
            <td width="50px" style="border-color: {{$color}};">
                <font style="font-weight:light; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left">
                        {{substr($act->timef,0,5)}}
                    </span>
                </font>
            </td>
        </tr>
        <tr>
            <td style="border-color: {{$color}};">
                <font style="font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
                    <span class="float-left" style="font-weight:bold;">
                        {{($act->companys()->count() > 1 )? 'Instituciones: ': 'Institución: '}}
                    </span>
                </font>
            </td>
            <td colspan="5" style="border-color: {{$color}};">
                <font style="font-weight:light; font-family: Arial, Helvetica, sans-serif;">
                    <span  style="font-weight:bold;">
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
            <td colspan="6" align="center" style=" border-style : solid; border-color: {{$color}}; background: {{$color}}; font-weight:bold; color:#fff; font-size:20px; font-family: Arial, Helvetica, sans-serif;">
                <div>
                    <span>
                        DESARROLLO DE LA REUNION
                    </span>
                </div>
            </td>
        </tr>
    </table>
    <p>
        <font style="font-family: Arial, Helvetica, sans-serif;">
        {!!$act->content!!}
        </font>
    </p>

    @if($act->agreements != null)
        <table width="100%" cellpadding="1" cellspacing="0" border="1">
            <tr>
                <td align="center" style=" border-style : solid; border-color: {{$color}}; background: {{$color}}; font-weight:bold; color:#fff; font-size:20px; font-family: Arial, Helvetica, sans-serif;">
                    <font style="font-weight:bold; color:#fff; font-size:20px;">
                        CONCLUSIONES Y/O ACUERDOS DE LA REUNIÓN 
                    </font>
                </td>
            </tr>
        </table>
        <p>
            <font style="font-family: Arial, Helvetica, sans-serif;">
            {!!$act->agreements !!}
            </font>
        </p>
    @endif
    <div style="page-break-after:always;"></div>
    <table width="99.3%" cellpadding="1" cellspacing="0" border="1">
        <tr>
            <td colspan="6" align="center" style=" border-style : solid; border-color: {{$color}}; background: {{$color}}; font-weight:bold; color:#fff; font-size:20px; font-family: Arial, Helvetica, sans-serif;">
                <font style="font-weight:bold; color:#fff; font-size:20px;">
                        PARTICIPANTES
                </font>
            </td>
        </tr>
        <thead style="font-weight:bold; font-family: Arial, Helvetica, sans-serif;">
            
            <tr>
                <th align="center">Nº</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Institución</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>
        </thead>
        @php
            $num = 1;
        @endphp
        <tbody style="font-weight:light; font-family: Arial, Helvetica, sans-serif;">
            @forelse ($act->users()->get() as $user)
            <tr>
                <td align="center" style="font-size:12px" width="10">{{$num++}})</td>
                <td style="font-size:12px" width="150" height="30" >{{ $user->name }}</td>
                <td style="font-size:12px">{{$user->description}}</td>
                <td align="center" style="font-size:12px">{{'OFEP'}}</td>
                <td align="center" style="font-size:12px">{{$user->number}}</td>
                <td style="font-size:12px">
                    {{substr($user->email,0,30)}}
                </td>
            </tr>
            @empty
            @endforelse
            @forelse ($act->guests()->get() as $user)
            <tr>
                <td align="center" style="font-size:12px">{{$num++}})</td>
                <td style="font-size:12px"  width="150" height="30">{{$user->name}}</td>
                <td style="font-size:12px">{{$user->description}}</td>
                <td align="center" style="font-size:12px">{{$user->company()->first()->tradename}}</td>
                <td align="center" style="font-size:12px">{{$user->phone}}</td>
                <td style="font-size:12px">{{  substr($user->email,0 ,20)."\n".
                    substr($user->email,20,20)."\n".
                    substr($user->email,40,20)."\n".
                    substr($user->email,60,20)."\n".
                    substr($user->email,80,20)."\n".
                    substr($user->email,100,20)."\n".
                    substr($user->email,120,20)."\n".
                    substr($user->email,140,20)}}</td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
</body>
</html>

