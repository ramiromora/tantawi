@extends('layouts.app')
@section('content')
<section class="content-header">
        <h1> Comites<br>
          <small>Listado de comites</small>
        </h1>
        
  </section>
      <div class="container">
          <div class="col-md-12">
              <div class="panel panel-default">
                  <div class="panel-heading">
                     <h3>Datos del Comité</h3> 
                  </div>
              <div class="panel-body">
                    {!! Form::open([ 'route' => 'com_add']) !!}
                    @include('committee.fragment.form7')
                    {{ Form::submit('Agregar comité', ['class' => 'btn btn-success btn-flat']) }}
                                </span>
                            </div>
                            </div>
                            </div>
                    {!! Form::close() !!}
                    <div class="table-responsive">                            
                    <table class="table table-bordered">
                        <tr>
                            <th> ID </th> 
                            <th> Nombre </th> 
                            <th> Miembros </th>                                
                            <th> Opciones </th> 
                        </tr>
                        @foreach($committees as $committee)
                        <tr>                          
                        
                        <td>{{$committee->id}}</td>
                        <td>{{$committee->name}}</td>
                        <?php
                            $principal  = busca_comite($committee->id)
                        ?>
                        <td>
                            {!! Form::open([ 'route' => 'com_mem']) !!}
                            {{ Form::hidden('comte_id', $committee->id) }}
                                @include('committee.fragment.form8')
                                
                            {!! Form::close() !!}
                             <!--fin mini formulario-->
                              <!--listado de responsables por comite-->
                            @foreach($principal as $prin)

                                @include('committee.fragment.form9')                               
                                
                            @endforeach
                             <!--con opcion a borrado-->
                        </td>
                        <td>
                            <a href="{{ route('com_edi',['id' =>$committee->id] ) }}" class="btn btn-sm btn-warning">Editar</a>
                            <a href="{{ route('com_del',['id' =>$committee->id] ) }}" class="btn btn-sm btn-danger">Borrar</a>
                        </td>
                        </tr>
                        @endforeach
                  </table> 
                </div>                    
              </div>
          </div>
  
          </div>
      </div>
@endsection