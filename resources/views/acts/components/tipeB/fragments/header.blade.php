<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Datos de la reunión</h3>
        <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i class="si si-arrow-up"></i></button>
        </div>
    </div>
    <div class="block-content">
    {{ Form::hidden('user_id',auth()->user()->id)}}
    <div class="form-group">
        {{ Form::label('companys', 'Empresas Participes del Acta')}}
        {{ Form::select('companys[]', $companys ,null, ['class' => 'form-control select2-multiples', 'id'=>"companys" ,'required', 'multiple'=>'multiple']) }}
    </div>
    <div class="form-group">
        {{ Form::label('departaments', 'Unidad o departamento que llevo la reunión') }}
        {{ Form::select('departaments[]', $departments ,null, ['class'=>'form-control select2-multiples','id'=>"departaments",'onchange'=>"mF4()",'required', 'multiple'=>'multiple']) }}
    </div>
    
    <div id="miembros">
        <div class="form-group">
            {{ Form::label('users', 'Participantes de la OFEP') }}
            {{ Form::select('users[]', $users ,null, ['class'=>'form-control select2-multiples','id'=>"users",'multiple'=>'multiple']) }}
        </div>
    </div>
    
    <div class="form-group">
        {{ Form::label('title', 'Tema de reunión') }}
        {{ Form::text('title', null, ['class' => 'form-control','required']) }}
    </div>
    @if (isset($act->date))
    <div class="form-group">
        {{ Form::label('date', 'Fecha de reunión') }}
        {{ Form::date('date',null, ['class' => 'form-control pull-right', 'id' => 'datepicker', 'required' ]) }}
    </div>
    @else
    <?php
    $dat = date('Y-m-d');
    ?>
    <div class="form-group">
        {{ Form::label('date', 'Fecha de reunión') }}
        {{ Form::date('date', $dat, ['class' => 'form-control pull-right', 'id' => 'datepicker', 'required' ]) }}
    </div>
    @endif
    <br>
    <div class="form-group">
        {{ Form::label('datef', 'Fecha de finalización de la reunión (dejar en blanco si la reunion concluye el mismo día)') }}
        {{ Form::date('datef', null, ['class' => 'form-control pull-right', 'id' => 'datepicker' ]) }}
    </div>
    <br>
    {{ Form::label('time', 'Hora de inicio') }}
    <div class="input-group">
        {{ Form::time('time', (!isset($act))?date('H:m'):null, ['class' => 'form-control timepicker', 'required']) }}
    </div>
    <br>
    {{ Form::label('timef', 'Hora de final') }}
    <div class="input-group">
        {{ Form::time('timef',(!isset($act))?date('H:m'):null, ['class' => 'form-control timepicker', 'required', 'onblur' => 'val_hr()']) }}
    </div>
    <br>
    @if (isset($act))
        @if ($act->addres== "Oficina Técnica para el Fortalecimiento de la Empresa Pública - OFEP")
            <div class="form-group">
                {!! Form::label('addres1', '¿La reunión se realizó en la oficina de la OFEP?') !!}
                {!! Form::label('addres1', 'si') !!}
                {!! Form::radio('addres1', 'def' , true ,['id' => 'compan_0' , 'onclick' => 'mostrarReferencia2();'] ) !!}
                {!! Form::label('addres1', 'no') !!}
                {!! Form::radio('addres1', 'nue', false ,['id' => 'compan_1', 'onclick' => 'mostrarReferencia2();']) !!}
            </div>
            <div id="direccion" style="display:none;" class="form-group">
                {!! Form::label('addres', 'Lugar de Reunion ') !!}
                {!! Form::text('addres', null, ['class' => 'form-control' , 'placeholder' => 'Por favor incluya el pronombre del lugar, ejemplo ‘La Casa grande del pueblo’']) !!}
            </div>
        @else
        <div class="form-group">
            {!! Form::label('addres1', '¿La reunión se realizó en la oficina de la OFEP?') !!}
            {!! Form::label('addres1', 'si') !!}
            {!! Form::radio('addres1', 'def' , false ,['id' => 'compan_0' , 'onclick' => 'mostrarReferencia2();'] ) !!}
            {!! Form::label('addres1', 'no') !!}
            {!! Form::radio('addres1', 'nue', true ,['id' => 'compan_1', 'onclick' => 'mostrarReferencia2();']) !!}
        </div>
        <div id="direccion" style="display:block;" class="form-group">
            {!! Form::label('addres', 'Lugar de Reunion ') !!}
            {!! Form::text('addres', null, ['class' => 'form-control' , 'placeholder' => 'Por favor incluya el pronombre del lugar, ejemplo ‘La Casa grande del pueblo’']) !!}
        </div>
        @endif    
        
    @else
        <div class="form-group">
            {!! Form::label('addres1', '¿La reunión se realizó en la oficina de la OFEP?') !!}
            {!! Form::label('addres1', 'si') !!}
            {!! Form::radio('addres1', 'def' , true ,['id' => 'compan_0' , 'onclick' => 'mostrarReferencia2();'] ) !!}
            {!! Form::label('addres1', 'no') !!}
            {!! Form::radio('addres1', 'nue', false ,['id' => 'compan_1', 'onclick' => 'mostrarReferencia2();']) !!}
        </div>
        <div id="direccion" style="display:none;" class="form-group">
            {!! Form::label('addres', 'Lugar de Reunion ') !!}
            {!! Form::text('addres', null, ['class' => 'form-control' , 'placeholder' => 'Por favor incluya el pronombre del lugar, ejemplo ‘La Casa grande del pueblo’']) !!}
        </div>
    @endif
    <div class="form-group">
        {{ Form::label('location', 'Departamento')}}
        {{ Form::select('location', $departamentos ,null, ['class' => 'form-control', 'id'=>"location" ,'required',]) }}
    </div>
</div>
</div>








