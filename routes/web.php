<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', 'HomeController@index');
Auth::routes();
Route::get('/salir', 'Auth\LoginController@salir')->name('salir');
Route::get('home', 'HomeController@index');
Route::get('ldap/{id?}', 'HomeController@ldap');
Route::get('act/index','ActController@index')->name('act.index')->middleware('permission:read.act');
Route::get('acts','ActController@list')->name('act.list')->middleware('permission:read.act');
Route::get('act/create/{type?}', 'ActController@create')->middleware('permission:create.act');
Route::post('act/store','ActController@store')->name('act.store')->middleware('permission:create.act');
Route::get('act/{id}/show','ActController@show')->name('act.show')->middleware('permission:read.act');
Route::get('act/{id}/edit/{type?}','ActController@edit')->name('act.edit')->middleware('permission:edit.act');
Route::put('act/update','ActController@update')->name('act.update')->middleware('permission:edit.act');
Route::get('act/{id}/delete','ActController@delete')->name('act.delete')->middleware('permission:edit.act');
Route::get('act/{id}/pdf','ActController@pdf')->name('act.pdf')->middleware('permission:read.act');
Route::get('act/{id}/check','ActController@check')->name('act.validate')->middleware('permission:validate.act');
Route::put('act/edit/content','ActController@autoSave')->middleware('permission:edit.act');
Route::get('act/{id}/notify','ActController@sendEmail')->middleware('permission:validate.act');

Route::post('guest/store','GuestController@store')->name('guest.store')->middleware('permission:create.guest');
Route::get('guest/index','GuestController@index')->name('guest.index')->middleware('permission:read.guest');
Route::get('guest/{id?}/delete','GuestController@delete')->name('guest.delete')->middleware('permission:edit.guest');
Route::get('guest/{id?}/edit','GuestController@edit')->name('guest.edit')->middleware('permission:edit.guest');
Route::put('guest/update','GuestController@update')->name('guest.update')->middleware('permission:edit.guest');

Route::get('department/users','Administrator\UserController@department');

Route::get('acta-nueva','ActController@newAct')->name('act_new')->middleware('auth');
Route::get('acta-archivo','ActController@archAct')->name('act_rel')->middleware('auth');
Route::get('acta-editar/{id}','ActController@editAct')->name('act_edit')->middleware('auth');
Route::post('acta-notifi/','ActController@editNoti')->name('act_notifi')->middleware('auth');
Route::post('acta-borrar','ActController@editDele')->name('act_delet')->middleware('auth');

Route::get('acta-ver_n/{id}','ActController@show_ne')->name('act_show_n')->middleware('auth');
Route::put('acta-actualizar','ActController@updAct')->name('act_upd')->middleware('auth');
Route::get('acta-archivar/{id}','ActController@archivar')->name('act_arch')->middleware('auth');

Route::post('acta-firmar/','SignatureController@firmar')->name('act_fir')->middleware('auth');
Route::post('acta-rechaza/','SignatureController@rechasar')->name('act_rech')->middleware('auth');

Route::post('agregar-usuario','UserController@add')->name('user_add')->middleware('auth');
Route::post('borrar-usuario','UserController@delete')->name('user_del')->middleware('auth');
Route::post('autoc-usuario','UserController@fetch')->name('autoc_user')->middleware('auth');
Route::get('editar-perfil','UserController@edit')->name('edit_user')->middleware('auth');
Route::post('actualizar-perfil','UserController@update')->name('updt_user')->middleware('auth');

Route::post('partisipes','GuestController@save')->name('guest_sto')->middleware('auth');
Route::post('agregar-persona','GuestController@add')->name('guest_add')->middleware('auth');
Route::post('borra-invitado','GuestController@delGuest')->name('guest_del')->middleware('auth');

Route::post('mostrar-ordenes','OrderController@show')->name('order_show')->middleware('auth');
Route::post('aniadir-orden','OrderController@add')->name('order_add')->middleware('auth');
Route::post('borrar-orden','OrderController@del')->name('order_del')->middleware('auth');
Route::post('ver-orden','OrderController@vist')->name('order_vp')->middleware('auth');
Route::post('editar-orden2','OrderController@edit2')->name('order_edi2')->middleware('auth');///
Route::put('actualiza-orden2','OrderController@update2')->name('order_upd2')->middleware('auth');
Route::get('acta-imprime/{id}','OrderController@pdf2')->name('act_pdf')->middleware('auth');
Route::get('acta-imprime_ne/{id}','OrderController@pdf1')->name('act_pdf1')->middleware('auth');
Route::get('acta-imprime_f/{id}','OrderController@pdf4')->name('act_pdf3')->middleware('auth');
Route::get('acta-imprime_ne_f/{id}','OrderController@pdf3')->name('act_pdf2')->middleware('auth');////aqui esta la ruta a agregar
Route::get('volvera/{id}','OrderController@back')->name('volver_o')->middleware('auth');

Route::get('resolucion-nueva/{id}','ResolutionController@new')->name('reso_new')->middleware('auth');
Route::post('resolucion-nueva','ResolutionController@store')->name('reso_add')->middleware('auth');
Route::get('resolucion-borra/{id}','ResolutionController@destroy')->name('reso_del')->middleware('auth');
Route::get('resolucion-edita/{id}','ResolutionController@edit')->name('reso_edi')->middleware('auth');
Route::put('resolucion-actualiza','ResolutionController@update')->name('reso_upd')->middleware('auth');
Route::get('resolucion-fin/{id}','ResolutionController@ending')->name('reso_end')->middleware('auth');
Route::get('volver/{id}','ResolutionController@volver_edi')->name('reso_e_v')->middleware('auth');
Route::post('responsable-crear','ResolutionController@respoAdd')->name('respo_add')->middleware('auth');
Route::post('responsable-borrar','ResolutionController@respoDel')->name('respo_del')->middleware('auth');
Route::get('resoluciones', 'ResolutionController@index')->name('reso_lista')->middleware('auth');
Route::get('resolucion-ver/{id}', 'ResolutionController@show')->name('reso_ver')->middleware('auth');


Route::get('comites', 'CommitteeController@index')->name('comites')->middleware('auth');
Route::post('comite-guarda', 'CommitteeController@store')->name('com_add')->middleware('auth');
Route::get('comite-edita/{id}', 'CommitteeController@edit')->name('com_edi')->middleware('auth');
Route::put('comite-actualiza', 'CommitteeController@update')->name('com_upd')->middleware('auth');
Route::get('comite-borra/{id}', 'CommitteeController@destroy')->name('com_del')->middleware('auth');
Route::post('comite-miembro', 'CommitteeController@member')->name('com_mem')->middleware('auth');
Route::post('comite-miembro-b', 'CommitteeController@member_del')->name('com_mem_b')->middleware('auth');

//Route::get('back', 'HomeController@back')->name('backin');
////poner en practica el soft delete

// route::get('main_t',function(){
//     return view('layouts.app2');
// })->name('main_t');

Route::get('notifi', 'ActController@list_notifi')->name('notifi')->middleware('auth');
Route::get('tantawi/{user}/{pass}','RecaptchaController@login2');

// PERMISSIONS
Route::resource('administrator/permission', 'Administrator\\PermissionController')->middleware('auth');
// ROLES
Route::resource('administrator/role', 'Administrator\\RoleController')->middleware('auth');