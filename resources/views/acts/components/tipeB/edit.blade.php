@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{asset('vendor/select2/css/select2.css')}}">
@endsection
@section('content')
<hr>
<section class="content-header">
    <h3> Modificar Acta:</h3>
</section>
<div class="container">
    <div class="">
        {!! Form::model($act, ['route' => ['act.update'],'method' => 'PUT','name' => 'act_new'] )!!}
        {{ Form::hidden('id', $act->id ) }}
        {{ Form::hidden('type', $type ) }}
            {{csrf_field()}}
            @switch($type)
                @case('header')
                    @include('acts.components.tipeB.fragments.header')
                    @break
                @case('body')
                    @include('acts.components.tipeB.fragments.body')
                    @break
                @case('participants')
                    @include('acts.components.tipeB.fragments.participants')
                    @break
                @default
                @break
            @endswitch
            <button type="submit" class="btn btn-success">Aceptar</button>
        {!! Form::close() !!}
    </div>
</div>
<strong>
    <small>Responsable: {{ Auth::user()->name }}</small>
</strong>
@if ('participants')
<div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Agregando Participante al Acta</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <h4>Datos del Contacto</h4>
                        {{csrf_field()}}
                        {{ Form::hidden('d','',['id'=>'d'])}}
                        <div class="form-group">
                            {{ Form::label('name', 'Nombre Completo') }}
                            {{ Form::text('name', null, ['class' => 'form-control','required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('description', 'Cargo') }}
                            {{ Form::text('description', null, ['class' => 'form-control','required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('phone', 'Telefono') }}
                            {{ Form::text('phone', null, ['class' => 'form-control','required']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('email', 'Correo Electronico') }}
                            {{ Form::text('email', null, ['class' => 'form-control','required']) }}
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-alt-success" id="add-guest" onclick="AddGuest()"><i class="fa fa-check"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@switch($type)
    @case('header')
        @section('scripts')
        <script src="{{ asset('js/custom.js') }}" defer></script>
        <script src="{{ asset('vendor/select2/js/select2.js') }}" defer></script>
        
        <script>
        $(document).ready(function(){
            $('.select2-multiples').select2();
        });
        </script>
        @endsection
        @break
    @case('body')
        @section('scripts')
        <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}" defer></script>
        <script defer>
            function ocultar(){
                document.getElementById('smsg').style.display = 'none';
            }
            function mostrar(){
                document.getElementById('smsg').style.display = 'inline';
            }
            function sv_da(edi1){
                setTimeout(
                    function(){
                        var body = CKEDITOR.instances[edi1].getData();
                        var bod2 = sessionStorage.getItem("bod2");
                        bod2 = parseInt(bod2);
                        if(body.length>bod2+30||body.length<bod2){
                            sessionStorage.setItem('bod2', body.length);
                            var token = $('input[name=_token]').val();
                            var id = $('input[name=id]').val();
                            $.ajax({
                                url:"/act/edit/content",
                                type:'PUT',
                                data:{
                                    "id"  : id,
                                    "content"   : body,
                                    "_token" : token
                                },
                                success:function(){
                                    mostrar();
                                    setTimeout(function(){
                                        ocultar()
                                    },2500);
                                }            
                            })
                        }
                    },
                    3000); 
            }
            $(document).ready(function(){
                sessionStorage.setItem("bod2", 0);
                CKEDITOR.replace( 'editor1', {
                    language: 'es-mx',
                    uiColor: '#9AB8F3'
                });
                CKEDITOR.replace( 'editor2', {
                    language: 'es-mx',
                    uiColor: '#9AB8F3'
                });
                ///para el Auto guardado
                var edi1 = 'editor1';
                CKEDITOR.instances[edi1].on('change', function(e) { 
                    sv_da(edi1);
                });
                CKEDITOR.instances['editor2'].on('change', function(e) {
                    //toastr.success('hhhhhh');
                });
            });
       
        </script>
        @endsection
        @break
    @case('participants')
        @section('scripts')
            <script defer>
                //$('input[name=indicator]').val('');
                function AddGuest(){
                    var token = $('input[name=_token]').val();
                    var company_id = $('#d').val();
                    var name = $('#name').val();
                    var description = $('#description').val();
                    var phone = $('#phone').val();
                    var email = $('#email').val();
                    $.ajax({
                        type: 'post',
                        url: '/guest/store',
                        data: {
                            '_token': token,
                            'company_id' : company_id,
                            'name' : name,
                            'description' : description,
                            'phone' : phone,
                            'email' : email,
                        },
                        success: function(data){
                            if(data){
                                location.reload();
                            }else{
                                toastr.error('Error al agregar Invitado');
                            }
                        }
                    });

                }
                function opfrm(d){
                    $('#d').val(d);
                }
            </script>
        @endsection
    @break
    @default
@endswitch


