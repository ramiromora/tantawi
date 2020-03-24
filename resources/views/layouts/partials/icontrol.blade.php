@php
  $path = explode("/",$url1);
  $user = Auth::user();

if(!isset($addtop))
  $addtop = true;

if(!isset($search))
  $search = true;

if(!isset($editenable))
  $editenable = App\Configuration::Select('edit')->Where('status',true)->pluck('edit')->first();

// EXPORT CONTROLS

@endphp

<div class="col-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><b>{{ $title }}</b></h3>
    </div>
    <div class="card-body">
      <div>
        <div class="row">
          <div class="col-sm-12 col-md-5">
            <div>
              {!! Form::button('<i class="fa fa-plus"></i> <b>Nuevo</b>',
                  array('title' => 'Nuevo',
                          'type' => 'button',
                          'class' => 'btn btn-success btn-round btn-sm',
                          'disabled' => !($addtop)?null:
                          ($user->hasPermissionTo('create.'.end($path))&&$editenable) ? null :
                          'disabled',
                          'onclick'=>'window.location.href="'. $url1 .'/create"', ))
              !!}
            </div>
          </div>
          <hr>
        </div>
      </div>
    </div>
  </div>
</div>

